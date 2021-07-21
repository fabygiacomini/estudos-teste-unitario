<?php

namespace Fabianagiacomini\EstudosTesteUnitario\exercise;


use Prophecy\Exception\InvalidArgumentException;

class Avaliador
{
    private $maiorValor = -INF;
    private $menorValor = INF;
    private $maiores;

    public function avalia(Leilao $leilao)
    {
        if (count($leilao->getLances()) == 0) {
            throw new InvalidArgumentException("Um leilão precisa ter pelo menos um lance.");
        }

        foreach ($leilao->getLances() as $lance) {
            if ($lance->getValor() > $this->maiorValor) {
                $this->maiorValor = $lance->getValor();
            }
            if ($lance->getValor() < $this->menorValor) {
                $this->menorValor = $lance->getValor();
            }
        }

        $this->pegaOsMaioresDoLeilao($leilao);
    }

    public function getValorMedioLances($leilao)
    {
        $valorTotal = 0;

        $lances = $leilao->getLances();
        $quantidadeLances = sizeof($lances);

        foreach ($leilao->getLances() as $lance) {
            $valorTotal += $lance->getValor();
        }

        return $valorTotal / $quantidadeLances;
    }

    public function pegaOsMaioresDoLeilao($leilao)
    {
        $lances = $leilao->getLances();

        usort($lances, function ($a, $b) {
            if ($a->getValor() == $b->getValor()) {
                return 0;
            }
            return $a->getValor() < $b->getValor() ? 1 : -1;
        });

        $this->maiores = array_slice($lances, 0, 3);
    }

    public function getMaiorValor()
    {
        return $this->maiorValor;
    }

    public function getMenorValor()
    {
        return $this->menorValor;
    }

    public function getMaiores()
    {
        return $this->maiores;
    }
}

?>