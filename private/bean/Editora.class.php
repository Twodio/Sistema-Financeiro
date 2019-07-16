<?php

class Editora{
    private $bd;
    private $id;
    private $nome;
    private $cnpj;
    private $nome_reduzido;
    private $margem;
    
    

    public function __construct($nome=null, $cnpj=null, $nome_reduzido=null, $margem=null, $id=null) {
        $this->bd = new Banco_De_Dados();
        $this->id = $id;
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->nome_reduzido = $nome_reduzido;
        $this->margem = $margem;
    }
    
    
    public function deletar(){
        $id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);

        if(isset($id) && $this->bd->delete(TB_EDITORA, " id=?;", array($id)) == 1){
            if(Config::$log_lvl > 1) logMsg("Editora de id($id) foi deletado");
            return true;
        }  else
            return false;
    }
    
    public function editar(){
        if(isset($this->id)){
            
            $result = $this->bd->update(TB_EDITORA, "nome=?, cnpj=?, nome_reduzido=?, margem=? WHERE id=?;", array($this->nome, $this->cnpj, $this->nome_reduzido, $this->margem, $this->id));
            if(Config::$log_lvl > 1) logMsg("Editado o endereço id:". $result);
            
            return $result;
        } else {
            logMsg("Tentativa de cadastrar, sem inicializar o id classe: editora");
            return false;
        }
    }
    
    
    public function buscar($busca, $tipo=1){
        if(Config::$log_lvl > 1) logMsg("Tentativa de busca por editora: '$busca'");
        
        if($tipo == 1)
            $result = $this->bd->select("*", TB_EDITORA, " WHERE id=? LIMIT 1;", array($busca));
        else 
            $result = $this->bd->select("*", TB_EDITORA, " WHERE nome LIKE '%$busca%' ORDER BY id ASC LIMIT 1;", array());
        
        if(!is_array($result) && $result->rowCount() > 0){
            $result = $result->fetchObject();
            $this->__construct($result->nome, $result->cnpj, $result->nome_reduzido, $result->margem, $result->id);
            return true;
        } else
            return false;
    }
   
    public function cadastrar(){
        if(isset($this->nome)){
            $result = $this->bd->insert(TB_EDITORA, "id=default, cnpj=?, nome=?, nome_reduzido=?, margem=?", array($this->cnpj, $this->nome, $this->nome_reduzido, $this->margem));
            if(DEBUG) logMsg("Cadastrado uma nova editora id:". $result);
            return $result;
            
        } else {
            logMsg("Tentativa de cadastrar, sem inicializar a classe: Editora");
            return false;
        }
    }
    
    public function validaDados(){
        $erros=null;
        
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $this->nome = filter_var($this->nome, FILTER_SANITIZE_STRING);
        $this->cnpj = filter_var($this->cnpj, FILTER_SANITIZE_STRING);
        $this->nome_reduzido = filter_var($this->nome_reduzido, FILTER_SANITIZE_STRING);
        $this->margem = filter_var($this->margem, FILTER_SANITIZE_STRING);
        
        return $erros;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }
    
    function getNome() {
        return $this->nome;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }
    
    function getNome_reduzido() {
        return $this->nome_reduzido;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getMargem() {
        return $this->margem;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setNome_reduzido($nome_reduzido) {
        $this->nome_reduzido = $nome_reduzido;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setMargem($margem) {
        $this->margem = $margem;
    }


}