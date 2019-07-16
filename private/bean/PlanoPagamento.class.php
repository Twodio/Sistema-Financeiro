<?php

class PlanoPagamento{
    private $cod;
    private $desc;
    private $cartao;
    private $banco;
    private $baixa_auto;
    private $baixa_direto_dt_emissao;
    
    function getCod() {
        return $this->cod;
    }

    function getDesc() {
        return $this->desc;
    }

    function getCartao() {
        return $this->cartao;
    }

    function getBanco() {
        return $this->banco;
    }

    function getBaixa_auto() {
        return $this->baixa_auto;
    }

    function getBaixa_direto_dt_emissao() {
        return $this->baixa_direto_dt_emissao;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setDesc($desc) {
        $this->desc = $desc;
    }

    function setCartao($cartao) {
        $this->cartao = $cartao;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setBaixa_auto($baixa_auto) {
        $this->baixa_auto = $baixa_auto;
    }

    function setBaixa_direto_dt_emissao($baixa_direto_dt_emissao) {
        $this->baixa_direto_dt_emissao = $baixa_direto_dt_emissao;
    }


}