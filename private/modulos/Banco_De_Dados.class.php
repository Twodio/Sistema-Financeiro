<?php

class Banco_De_Dados
{	
    private $link = null;
    private $config;
    private $query;

    public function __construct()
    {		
        if(is_null($this->link)){
            try{
                $this->config = new Config();
                $this->link=new PDO("mysql:host=".$this->config->DB_LINK.";dbname=".$this->config->DB_NOME.";", $this->config->DB_USR, $this->config->DB_SEN);
                
                $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                logMsg("Conexão [". $this->link->errorCode(). "]");
                
                return $this->link;

            } 
            catch (PDOException $e){
                if(DEBUG)
                    echo $e->getMessage();
                if(Config::$log_lvl > 0 )
                    logMsg($e->getMessage());
            }
        } else 
            return $this->link;
    }
		
    public function getCon(){
        return $this->link;
    }

    private function prepExec($prepare, $execute){
        $this->query = $this->getCon()->prepare($prepare);
        return $this->query->execute($execute);		
    }


    public function insert($tabela, $condicao, $exec){
        $this->prepExec("INSERT INTO ".$tabela." SET $condicao;", $exec);

        if(Config::$log_lvl > 0) logMsg("Inserido id: ". $this->getCon()->lastInsertId(). " no BD na ". $tabela);

        return $this->getCon()->lastInsertId();
    }


    public function select($campos, $tabela, $condicao, $exec){
        $this->prepExec("SELECT $campos FROM $tabela $condicao", $exec);

        if($this->query->rowCount() > 0){
            if(Config::$log_lvl > 0)logMsg("Selecionado : ". $this->query->rowCount(). " rows do BD na ". $tabela);
            return $this->query;
        }else{
            if(Config::$log_lvl > 0) logMsg("Selecionado : ". $this->query->rowCount(). " rows do BD na ". $tabela);
            return array();
        }
    }

    public function update($tabela, $condicao, $exec){
        if(Config::$log_lvl > 0) logMsg("Update no BD, tabela: ". $tabela, 1);
        
        return $this->prepExec("UPDATE $tabela SET $condicao",$exec);
    }

    public function delete($tabela, $condicao, $exec){
        if(Config::$log_lvl > 0) logMsg("Deletado do DB: $tabela onde: $condicao");
        
        return $this->prepExec("DELETE FROM $tabela WHERE $condicao",$exec);
    }
    
    public function callProcedure($nome, $parametros){
        return $this->link->query("CALL $nome($parametros);");
    }
	
}

?>