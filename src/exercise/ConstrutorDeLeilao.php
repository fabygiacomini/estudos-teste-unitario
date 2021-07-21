<?php

namespace Fabianagiacomini\EstudosTesteUnitario\exercise;
use Fabianagiacomini\EstudosTesteUnitario\exercise\Usuario;
use Fabianagiacomini\EstudosTesteUnitario\exercise\Lance;
use Fabianagiacomini\EstudosTesteUnitario\exercise\Leilao;

class ConstrutorDeLeilao
{
    // test data builder
    private $leilao;
    public function para($descricao)
    {
        $this->leilao = new Leilao($descricao);
        return $this;
    }

    public function lance(Usuario $usuario, $valor)
    {
        $this->leilao->propoe(new Lance($usuario, $valor));
        return $this;
    }

    public function constroi()
    {
        return $this->leilao;
    }
}