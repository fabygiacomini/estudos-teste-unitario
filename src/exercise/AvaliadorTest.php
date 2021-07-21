<?php

namespace Fabianagiacomini\EstudosTesteUnitario\exercise;
use Fabianagiacomini\EstudosTesteUnitario\exercise\Avaliador;
use Fabianagiacomini\EstudosTesteUnitario\exercise\Lance;
use Fabianagiacomini\EstudosTesteUnitario\exercise\Leilao;
use Fabianagiacomini\EstudosTesteUnitario\exercise\Usuario;
use Fabianagiacomini\EstudosTesteUnitario\exercise\ConstrutorDeLeilao;
use PHPUnit\Framework\TestCase;
use Prophecy\Exception\InvalidArgumentException;


class AvaliadorTest extends TestCase
    {
        private $leiloeiro;
        public function setUp(): void
        {
            $this->leiloeiro = new Avaliador();
        }

        public function testDeveAceitarLancesOrdemDecrescente()
        {
            $renan = new Usuario("Renan");
            $caio = new Usuario("Caio");
            $felipe = new Usuario("Felipe");

            $construtor = new ConstrutorDeLeilao();
            $leilao = $construtor->para("Playstation 4")
                ->lance($renan, 400)
                ->lance($caio, 350)
                ->lance($felipe, 250)
                ->constroi();

            $this->leiloeiro->avalia($leilao);

            $maiorEsperado = 400;
            $menorEsperado = 250;

            $this->assertEquals($maiorEsperado, $this->leiloeiro->getMaiorValor());
            $this->assertEquals($menorEsperado, $this->leiloeiro->getMenorValor());
        }

        public function testCalculaMediaLances()
        {
            $renan = new Usuario("Renan");
            $caio = new Usuario("Caio");
            $felipe = new Usuario("Felipe");

            $construtor = new ConstrutorDeLeilao();
            $leilao = $construtor->para("Playstation 4")
                ->lance($renan, 400)
                ->lance($caio, 350)
                ->lance($felipe, 250)
                ->constroi();

            $valorMedioEncontrado = $this->leiloeiro->getValorMedioLances($leilao);
            $valorMedioEsperado = 333.3333333333333;

            $this->assertEquals($valorMedioEsperado, $valorMedioEncontrado);
        }

        public function testDeveAceitarLancesEmOrdemCrescente()
        {
            $renan = new Usuario("Renan");
            $caio = new Usuario("Caio");
            $felipe = new Usuario("Felipe");

            $construtor = new ConstrutorDeLeilao();
            $leilao = $construtor->para("Playstation 4")
                ->lance($renan, 250)
                ->lance($caio, 350)
                ->lance($felipe, 400)
                ->constroi();

            $this->leiloeiro->avalia($leilao);

            $maiorEsperado = 400;
            $menorEsperado = 250;

            $this->assertEquals($maiorEsperado, $this->leiloeiro->getMaiorValor());
            $this->assertEquals($menorEsperado, $this->leiloeiro->getMenorValor());
        }

        public function testDeveAceitarApenasUmLance()
        {
            $fabiana = new Usuario("Fabiana");

            $construtor = new ConstrutorDeLeilao();
            $leilao = $construtor->para("Playstation 4")
                ->lance($fabiana, 2000)
                ->constroi();

            $this->leiloeiro->avalia($leilao);

            $maiorEsperado = 2000;
            $menorEsperado = 2000;

            $this->assertEquals($maiorEsperado, $this->leiloeiro->getMaiorValor());
            $this->assertEquals($menorEsperado, $this->leiloeiro->getMenorValor());
        }

        public function testPegaOsTresMaiores()
        {
            $fabiana = new Usuario("Fabiana");
            $leo = new Usuario("Leo");

            $construtor = new ConstrutorDeLeilao();
            $leilao = $construtor->para("Playstation 4")
                ->lance($fabiana,200)
                ->lance($leo, 300)
                ->lance($fabiana, 400)
                ->lance($leo, 500)
                ->constroi();

            $this->leiloeiro->avalia($leilao);

            // quando testamos um array, precisamos testar o tamanho esperado bem como seu conteúdo
            $this->assertCount(3, $this->leiloeiro->getMaiores());
            $this->assertEquals(500, $this->leiloeiro->getMaiores()[0]->getValor());
            $this->assertEquals(400, $this->leiloeiro->getMaiores()[1]->getValor());
            $this->assertEquals(300, $this->leiloeiro->getMaiores()[2]->getValor());
        }

        public function testDeveRecusarLeilaoSemLances()
        {
            $this->expectException(InvalidArgumentException::class); // espera exceções desse tipo
            $construtor = new ConstrutorDeLeilao();

            $leilao = $construtor->para("Playstation 4")->constroi();

            $this->leiloeiro->avalia($leilao); // realmente provoca a exceção, pois sem lances
        }
    }