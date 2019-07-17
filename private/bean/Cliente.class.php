<?php

class Cliente{
    private $id;
    private $tipoPessoa; #TODO: Tipo pessoa
    private $doc;
    private $nome;
    private $rg;
    private $telefone;
    private $celular;
    private $fax;
    private $observacao;
    private $contato;
    private $email;
    private $inscricao_estadual;
    private $inscricao_municipal;
    private $mala_direta;
    private $bd;
     
    public function __construct($tipoPessoa=null, $doc=null, $nome=null, $rg=null, $telefone=null, $celular=null, $fax=null, $obs=null, $contato=null, $email=null, $inscest=null, $inscmun=null, $mala=null, $id=null){
        #TODO: Endereço
        $this->bd = new Banco_De_Dados();
        $this->tipoPessoa = $tipoPessoa;
        $this->doc = $doc;
        $this->nome = $nome;
        $this->rg = $rg;
        $this->telefone = $telefone;
        $this->celular = $celular;
        $this->fax = $fax;
        $this->observacao = $obs;
        $this->contato = $contato;
        $this->email = $email;
        $this->inscricao_estadual = $inscest;
        $this->inscricao_municipal = $inscmun;
        $this->mala_direta = $mala;
        $this->id = $id;
    }
    
    public function buscarEndereco(){
        if($this->id > 0){
            if(DEBUG && Config::$log_lvl > 1) logMsg("Tentativa de buscar endereço do cliente: '".$this->id."'");
            
            $result = $this->bd->select("*", TB_ENDERECO, " WHERE id_usr=?", array($this->id));
            
            if(!empty($result) && $result->rowCount() > 0){
                return $result->fetchAll();
            } else {
                return false;
            }
        }
    }
    
    public function buscar($busca, $tipo=1){
        if(DEBUG && Config::$log_lvl > 1) logMsg("Tentativa de busca por cliente: '$busca'");
        
        if($tipo == 1)
            $result = $this->bd->select("*", TB_CLIENTE, " WHERE id=? LIMIT 1;", array($busca));
        else 
            $result = $this->bd->select("*", TB_CLIENTE, " WHERE nome LIKE '%$busca%' ORDER BY id ASC LIMIT 1;", array());

        if(!is_array($result) && $result->rowCount() > 0){
            $result = $result->fetchObject();
            $this->__construct($result->tipo_pessoa, $result->doc, $result->nome, $result->rg, $result->telefone, $result->celular, $result->fax, $result->observacao, $result->contato, $result->email, $result->insc_est, $result->insc_mun, $result->mala_direta, $result->id);
            return true;
        } else
            return false;
    }
    
    public function consultar(){
        if(isset($this->nome)){            
            $erros['doc'] = $this->bd->select("doc", TB_CLIENTE, " WHERE doc=?;", array($this->doc));
            $erros['email'] = null;
            return $erros;
        } else {
            logMsg("Tentativa de consultar, sem inicializar a classe: Cliente");
            return false;
        }
    }
    
    public function cadastrar(){
        if(isset($this->nome)){
            $erros = $this->consultar();
            if(!empty($erros['doc']) || !empty($erros['email'])){
                if(DEBUG && Config::$log_lvl > 1) logMsg("Tentativa de cadastrar um cliente com falha");
                return $erros;
            }
               
            $result = $this->bd->insert(TB_CLIENTE, "id=default, tipo_pessoa=?, doc=?, nome=?, rg=?, telefone=?, celular=?, fax=?, observacao=?, contato=?, email=?, insc_est=?, insc_mun=?, mala_direta=?", array($this->tipoPessoa, $this->doc, $this->nome, $this->rg, $this->telefone, $this->celular, $this->fax, $this->observacao, $this->contato, $this->email, $this->inscricao_estadual, $this->inscricao_municipal, $this->mala_direta));
            if(DEBUG) logMsg("Cadastrado um novo cliente id:". $result);
            
            return $result;
            
        } else {
            logMsg("Tentativa de cadastrar, sem inicializar a classe: Cliente");
            return false;
        }
    }
    
    public function editar(){
        if(isset($this->id)){
            
            $result = $this->bd->update(TB_CLIENTE, "tipo_pessoa=?, doc=?, nome=?, rg=?, telefone=?, celular=?, fax=?, observacao=?, contato=?, email=?, insc_est=?, insc_mun=?, mala_direta=? WHERE id=?;", array($this->tipoPessoa, $this->doc, $this->nome, $this->rg, $this->telefone, $this->celular, $this->fax, $this->observacao, $this->contato, $this->email, $this->inscricao_estadual, $this->inscricao_municipal, $this->mala_direta, $this->id));
            if(Config::$log_lvl > 1) logMsg("Editado o cliente id:". $result);
            
            return $result;
        } else {
            logMsg("Tentativa de cadastrar, sem inicializar o id classe: Cliente");
            return false;
        }
    }
    
    public function validaDados(){
        $erros=null;
        
        $this->doc = filter_var($this->doc, FILTER_SANITIZE_STRING);
            if(empty($this->doc))
                $erros[] = "Não foi possível certificar o documento.";
            
        $this->nome = filter_var($this->nome, FILTER_SANITIZE_STRING);
            if(empty($this->nome))
                $erros[] = "Não foi possível certificar o nome.";
            
        $this->rg = filter_var($this->rg, FILTER_SANITIZE_STRING);
            if(empty($this->rg))
                $this->rg = "INDEFINIDO";
            
        $this->telefone = filter_var($this->telefone, FILTER_SANITIZE_STRING);       
        $this->celular = filter_var($this->celular, FILTER_SANITIZE_STRING);
            if(empty($this->celular) && empty($this->telefone))
                $erros[] = "Digite ao menos um celular ou telefone.";
            
        $this->fax = filter_var($this->fax, FILTER_SANITIZE_STRING);
            if(empty($this->fax))
                $this->fax = "SEM FAX";
            
        $this->inscricao_estadual = filter_var($this->inscricao_estadual, FILTER_SANITIZE_STRING);
        $this->inscricao_municipal = filter_var($this->inscricao_municipal, FILTER_SANITIZE_STRING);
        if(empty($this->inscricao_estadual) && empty($this->inscricao_municipal))
            $erros[] = "Obrigatório mencionar pelo menos um tipo de inscrição para empresas.";
        else{
            if(empty($this->inscricao_estadual))
                $this->inscricao_estadual = "ISENTO";
            if(empty($this->inscricao_municipal))
                $this->inscricao_municipal = "ISENTO";
        }
            
        $this->contato = filter_var($this->contato, FILTER_SANITIZE_STRING);
            if(empty($this->contato))
                $this->contato = "INDEFINIDO";
            
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
            if(empty($this->email))
                $erros[] = "Digite um e-mail válido.";
            
        $this->observacao = filter_var($this->observacao, FILTER_SANITIZE_STRING);
            if(empty($this->observacao))
                $this->observacao = "SEM OBSERVAÇÕES";
            
        if($this->mala_direta === "on")
            $this->mala_direta = 1;
        else 
            $this->mala_direta = 0;
            
        if($this->tipoPessoa === "on")
            $this->tipoPessoa = 1;
        else 
            $this->tipoPessoa = 0;
        
        return $erros;
    }
   
    function getInscricao_estadual() {
        return $this->inscricao_estadual;
    }

    function getInscricao_municipal() {
        return $this->inscricao_municipal;
    }

    function setInscricao_estadual($inscricao_estadual) {
        $this->inscricao_estadual = $inscricao_estadual;
    }

    function setInscricao_municipal($inscricao_municipal) {
        $this->inscricao_municipal = $inscricao_municipal;
    }
    
    function getCelular() {
        return $this->celular;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }
  
    function getId() {
        return $this->id;
    }

    function getTipoPessoa() {
        return $this->tipoPessoa;
    }

    function getDoc() {
        return $this->doc;
    }

    function getNome() {
        return $this->nome;
    }

    function getRg() {
        return $this->rg;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getFax() {
        return $this->fax;
    }

    function getObservacao() {
        return $this->observacao;
    }

    function getContato() {
        return $this->contato;
    }

    function getEmail() {
        return $this->email;
    }

    function getMala_direta() {
        return $this->mala_direta;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipoPessoa($tipoPessoa) {
        $this->tipoPessoa = $tipoPessoa;
    }

    function setDoc($doc) {
        $this->cpf = $doc;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setRg($rg) {
        $this->rg = $rg;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setFax($fax) {
        $this->fax = $fax;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    function setContato($contato) {
        $this->contato = $contato;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setMala_direta($mala_direta) {
        $this->mala_direta = $mala_direta;
    }

}