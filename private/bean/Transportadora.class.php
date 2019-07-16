<?php

class Transportadora{
    private $cod;
    private $nome;
    private $endereco;
    private $tipo;
    private $cpfcnpj;
    private $insc_estadual;
    
    function getCod() {
        return $this->cod;
    }

    function getNome() {
        return $this->nome;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getCpfcnpj() {
        return $this->cpfcnpj;
    }

    function getInsc_estadual() {
        return $this->insc_estadual;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setCpfcnpj($cpfcnpj) {
        $this->cpfcnpj = $cpfcnpj;
    }

    function setInsc_estadual($insc_estadual) {
        $this->insc_estadual = $insc_estadual;
    }


}
