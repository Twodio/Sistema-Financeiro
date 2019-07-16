<?php

class Banco{
    private $nome;
    private $conta;
    private $agencia;
    private $titular;
    
    function getNome() {
        return $this->nome;
    }

    function getConta() {
        return $this->conta;
    }

    function getAgencia() {
        return $this->agencia;
    }

    function getTitular() {
        return $this->titular;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setConta($conta) {
        $this->conta = $conta;
    }

    function setAgencia($agencia) {
        $this->agencia = $agencia;
    }

    function setTitular($titular) {
        $this->titular = $titular;
    }


}