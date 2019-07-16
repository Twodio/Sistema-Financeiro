<?php

class Endereco{
    private $bd;
    private $id;
    private $idFor;
    private $cep;
    private $codmun;
    private $endereco;
    private $nro;
    private $complemento;
    private $bairro;
    private $cidade;
    private $uf;
    
    public function __construct($cep=null, $codmun=null, $endereco=null, $nro=null, $complemento=null, $bairro=null, $cidade=null, $uf=null, $id=null){
        $this->bd = new Banco_De_Dados();
        $this->id = $id;
        $this->cep = $cep;
        $this->codmun = $codmun;
        $this->endereco = $endereco;
        $this->nro = $nro;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cidade = $cidade; 
        $this->uf = $uf;
    }
    
    public function deletar($idclasse){
        $id = filter_var($this->idFor, FILTER_SANITIZE_NUMBER_INT);

        if(isset($id) && $this->bd->delete(TB_ENDERECO, " $idclasse=?;", array($id)) == 1){
            if(Config::$log_lvl > 1) logMsg("Endereço de id($id) foi deletado");
            return true;
        }  else
            return false;
    }
    
    public function editar($idclasse){
        if(isset($this->id)){
            
            $result = $this->bd->update(TB_ENDERECO, "cep=?, codmun=?, endereco=?, nro=?, complemento=?, bairro=?, cidade=?, uf=?, id_usr=null WHERE $idclasse=?;", array($this->cep, $this->codmun, $this->endereco, $this->nro, $this->complemento, $this->bairro, $this->cidade, $this->uf, $this->idFor));
            if(Config::$log_lvl > 1) logMsg("Editado o endereço id:". $result);
            
            return $result;
        } else {
            logMsg("Tentativa de cadastrar, sem inicializar o id classe: endereço");
            return false;
        }
    }
    
    
    public function buscar($id, $idclasse){
        if(Config::$log_lvl > 1) logMsg("Tentativa de busca por endereço: $idclasse='$id'");
        
        $result = $this->bd->select("*", TB_ENDERECO, " WHERE $idclasse=? LIMIT 1;", array($id));
        
        if(!is_array($result) && $result->rowCount() > 0){
            $result = $result->fetchObject();
            $this->__construct($result->cep, $result->codmun, $result->endereco, $result->nro, $result->complemento, $result->bairro, $result->cidade, $result->uf, $result->id);
            return true;
        } else
            return false;
    }
   
    public function cadastrar($idclasse){
        if(isset($this->endereco)){
            $result = $this->bd->insert(TB_ENDERECO, "id=default, cep=?, codmun=?, endereco=?, nro=?, complemento=?, bairro=?, cidade=?, uf=?, $idclasse=?", array($this->cep, $this->codmun, $this->endereco, $this->nro, $this->complemento, $this->bairro, $this->cidade, $this->uf, $this->idFor));
            if(DEBUG) logMsg("Cadastrado um novo endereço id:". $result);
            
            return $result;
            
        } else {
            logMsg("Tentativa de cadastrar, sem inicializar a classe: Endereço");
            return false;
        }
    }
    
    public function validaDados(){
        $erros=null;
        
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $this->cep = filter_var($this->cep, FILTER_SANITIZE_STRING);
        $this->codmun = filter_var($this->codmun, FILTER_SANITIZE_NUMBER_INT);
        $this->endereco = filter_var($this->endereco, FILTER_SANITIZE_STRING);
        $this->nro = filter_var($this->nro, FILTER_SANITIZE_STRING);
        $this->complemento = filter_var($this->complemento, FILTER_SANITIZE_STRING);
        $this->bairro = filter_var($this->bairro, FILTER_SANITIZE_STRING);
        $this->cidade = filter_var($this->cidade, FILTER_SANITIZE_STRING);
        $this->uf = filter_var($this->uf, FILTER_SANITIZE_STRING);
        
        return $erros;
    }
   
    function getIdFor() {
        return $this->idFor;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function setIdFor($idFor) {
        $this->idFor = $idFor;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }
    
    function getId() {
        return $this->id;
    }

    function getCep() {
        return $this->cep;
    }

    function getCodmun() {
        return $this->codmun;
    }

    function getEnd() {
        return $this->end;
    }

    function getNro() {
        return $this->nro;
    }

    function getComplemento() {
        return $this->complemento;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getUf() {
        return $this->uf;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function setCodmun($codmun) {
        $this->codmun = $codmun;
    }

    function setEnd($end) {
        $this->end = $end;
    }

    function setNro($nro) {
        $this->nro = $nro;
    }

    function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }


}