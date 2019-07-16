<?php

class Vendedor{
    private $cod;
    private $nome;
    private $comissao;
    private $placa;
    private $carro;
    
    function getCod() {
        return $this->cod;
    }

    function getNome() {
        return $this->nome;
    }

    function getComissao() {
        return $this->comissao;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getCarro() {
        return $this->carro;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setComissao($comissao) {
        $this->comissao = $comissao;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

    function setCarro($carro) {
        $this->carro = $carro;
    }


}