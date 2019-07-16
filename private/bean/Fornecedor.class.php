<?php

class Fornecedor{
    private $id;
    private $cnpj;
    private $nome;
    private $insc_est;
    private $insc_mun;
    private $telefone;
    private $celular;
    private $fax;
    private $contato;
    private $email;
    private $bd;
    
    public function __construct($cnpj=null, $nome=null, $insc_est=null, $insc_mun=null, $telefone=null, $celular=null, $fax=null, $contato=null, $email=null, $id=null){
        $this->bd = new Banco_De_Dados();
        $this->id = $id;
        $this->cnpj = $cnpj;
        $this->nome = $nome;
        $this->insc_est = $insc_est;
        $this->insc_mun = $insc_mun;
        $this->telefone = $telefone;
        $this->celular = $celular;
        $this->fax = $fax;
        $this->contato = $contato;
        $this->email = $email;
    }
    
    public function deletar(){
        $id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);

        if(isset($id) && $this->bd->delete(TB_FORNECEDOR, " id=?;", array($id)) == 1){
            if(Config::$log_lvl > 1) logMsg("Fornecedor de id($id) foi deletado");
            return true;
        }  else
            return false;
    }
    
    public function consultar(){
        if(isset($this->nome)){      
            $erros['cnpj'] = $this->bd->select("cnpj", TB_FORNECEDOR, " WHERE cnpj=?;", array($this->cnpj));
            return $erros;
        } else {
            logMsg("Tentativa de consultar, sem inicializar a classe: Fornecedor");
            return false;
        }
    }
    
    public function cadastrar(){
        if(isset($this->nome)){
            $erros = $this->consultar();
            if(!empty($erros['cnpj'])){
                if(DEBUG && Config::$log_lvl > 1) logMsg("Tentativa de cadastrar um cliente com falha");
                return $erros;
            }
            
            $result = $this->bd->insert(TB_FORNECEDOR, "id=default, cnpj=?, nome=?, insc_est=?, insc_mun=?, telefone=?, celular=?, fax=?, contato=?, email=?", array($this->cnpj, $this->nome, $this->insc_est, $this->insc_mun, $this->telefone, $this->celular, $this->fax, $this->contato, $this->email));
            if(DEBUG) logMsg("Cadastrado um novo fornecedor id:". $result);
            
            return $result;
            
        } else {
            logMsg("Tentativa de cadastrar, sem inicializar a classe: Fornecedor");
            return false;
        }
    }
    
    public function editar(){
        if(isset($this->id)){
            
            $result = $this->bd->update(TB_FORNECEDOR, "cnpj=?, nome=?, insc_est=?, insc_mun=?, telefone=?, celular=?, fax=?, contato=?, email=? WHERE id=?;", array($this->cnpj, $this->nome, $this->insc_est, $this->insc_mun, $this->telefone, $this->celular, $this->fax, $this->contato, $this->email, $this->id));
            if(Config::$log_lvl > 1) logMsg("Editado o fornecedor id:". $result);
            
            return $result;
        } else {
            logMsg("Tentativa de cadastrar, sem inicializar o id classe: Fornecedor");
            return false;
        }
    }
    
    
    public function buscar($busca, $tipo=1){
        if(Config::$log_lvl > 1) logMsg("Tentativa de busca por fornecedor: '$busca'");
        
        if($tipo == 1)
            $result = $this->bd->select("*", TB_FORNECEDOR, " WHERE id=? LIMIT 1;", array($busca));
        else 
            $result = $this->bd->select("*", TB_FORNECEDOR, " WHERE nome LIKE '%$busca%' ORDER BY id ASC LIMIT 1;", array());

        if(!is_array($result) && $result->rowCount() > 0){
            $result = $result->fetchObject();
            $this->__construct($result->cnpj, $result->nome, $result->insc_est, $result->insc_mun, $result->telefone, $result->celular, $result->fax, $result->contato, $result->email, $result->id);
            return true;
        } else
            return false;
    }
    
    
    public function validaDados(){
        $erros=null;
        
        $this->cnpj = filter_var($this->cnpj, FILTER_SANITIZE_STRING);
            if(empty($this->cnpj))
                $erros[] = "Não foi possível certificar o cnpj.";
            
        $this->nome = filter_var($this->nome, FILTER_SANITIZE_STRING);
            if(empty($this->nome))
                $erros[] = "Não foi possível certificar o nome.";
            
        $this->telefone = filter_var($this->telefone, FILTER_SANITIZE_STRING);       
        $this->celular = filter_var($this->celular, FILTER_SANITIZE_STRING);
            if(empty($this->celular) && empty($this->telefone))
                $erros[] = "Digite ao menos um celular ou telefone.";
            
        $this->fax = filter_var($this->fax, FILTER_SANITIZE_STRING);
            if(empty($this->fax))
                $this->fax = "SEM FAX";
            
        $this->insc_est = filter_var($this->insc_est, FILTER_SANITIZE_STRING);
        $this->insc_mun = filter_var($this->insc_mun, FILTER_SANITIZE_STRING);
        if(empty($this->insc_est))
            $this->insc_est = "ISENTO";
        if(empty($this->insc_mun))
            $this->insc_mun = "ISENTO";
            
        $this->contato = filter_var($this->contato, FILTER_SANITIZE_STRING);
            if(empty($this->contato))
                $this->contato = "INDEFINIDO";
            
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
            if(empty($this->email))
                $erros[] = "Digite um e-mail válido.";
  
        return $erros;
    }
    
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }
    
    function getInsc_est() {
        return $this->insc_est;
    }

    function getInsc_mun() {
        return $this->insc_mun;
    }

    function getCelular() {
        return $this->celular;
    }

    function setInsc_est($insc_est) {
        $this->insc_est = $insc_est;
    }

    function setInsc_mun($insc_mun) {
        $this->insc_mun = $insc_mun;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getNome() {
        return $this->nome;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getFax() {
        return $this->fax;
    }

    function getContato() {
        return $this->contato;
    }

    function getEmail() {
        return $this->email;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }
    
    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setFax($fax) {
        $this->fax = $fax;
    }

    function setContato($contato) {
        $this->contato = $contato;
    }

    function setEmail($email) {
        $this->email = $email;
    }


}