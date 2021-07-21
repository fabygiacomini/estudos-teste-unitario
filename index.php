<?php

    require __DIR__."/vendor/autoload.php";

    use Fabianagiacomini\EstudosTesteUnitario\exercise\Avaliador;
    use Fabianagiacomini\EstudosTesteUnitario\exercise\AvaliadorTest;

    $test = new AvaliadorTest();

    $test->testDeveAceitarLancesOrdemDecrescente();
    $test->testCalculaMediaLances();
