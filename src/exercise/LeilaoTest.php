<?php


namespace Fabianagiacomini\EstudosTesteUnitario\exercise;

use Fabianagiacomini\EstudosTesteUnitario\exercise\ConstrutorDeLeilao;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testDeveProporUmLance()
    {
        $leilao = new Leilao("Macbook");

        $this->assertCount(0, $leilao->getLances());

        $fabiana = new Usuario("Fabiana");

        $leilao->propoe(new Lance($fabiana, 2000));

        $this->assertCount(1, $leilao->getLances());
        $this->assertEquals(2000, $leilao->getLances()[0]->getValor());
    }

    public function testDeveBarrarDoisLancesSeguidos()
    {
        $leilao = new Leilao("Macbook");

        $fabiana = new Usuario("Fabiana");

        $leilao->propoe(new Lance($fabiana, 2000));
        $leilao->propoe(new Lance($fabiana, 2500)); // tem q ignorar esse

        $this->assertCount(1, $leilao->getLances());
        $this->assertEquals(2000, $leilao->getLances()[0]->getValor());
    }

    public function testDeveDarNoMaximo5Lances()
    {
        $leilao = new Leilao("Macbook");

        $jobs = new Usuario("Jobs");
        $gates = new Usuario("Gates");

        $leilao->propoe(new Lance($jobs, 2000));
        $leilao->propoe(new Lance($gates, 3000));

        $leilao->propoe(new Lance($jobs, 4000));
        $leilao->propoe(new Lance($gates, 5000));

        $leilao->propoe(new Lance($jobs, 6000));
        $leilao->propoe(new Lance($gates, 7000));

        $leilao->propoe(new Lance($jobs, 8000));
        $leilao->propoe(new Lance($gates, 9000));

        $leilao->propoe(new Lance($jobs, 10000));
        $leilao->propoe(new Lance($gates, 11000));

        // deve ser ignorado
        $leilao->propoe(new Lance($jobs, 12000));

        $this->assertCount(10, $leilao->getLances());
        $this->assertEquals(11000, $leilao->getLances()[9]->getValor());
    }
}