<?php

class Operacoes{
    private $natureza;
    private $descicao;
    private $tipo;
    
    function getNatureza() {
        return $this->natureza;
    }

    function getDescicao() {
        return $this->descicao;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setNatureza($natureza) {
        $this->natureza = $natureza;
    }

    function setDescicao($descicao) {
        $this->descicao = $descicao;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }


}