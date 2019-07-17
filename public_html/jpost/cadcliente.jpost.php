<?php
    if($_POST['cod'] || $_POST['id_usr'] || $_POST['doc']){
        
        require_once '../../private/Init.php';
        
        #if $_SESSION
        
        switch($_POST['op']){
            case 'load':
                $bd = new Banco_De_Dados();
                
                $cod = filter_var($_POST['doc'], FILTER_SANITIZE_STRING);
                
                if(isset($cod)){
                    $user = $bd->select("*", TB_CLIENTE, "WHERE doc=?;", array($cod));
                    
                    if($user == null){
                        echo "{\"status\": \"ERROR\"}";
                    } else {
                        echo json_encode($user->fetchObject());
                    }
                } 
                break;
            case 'del':
                $bd = new Banco_De_Dados();
                
                $cod = filter_var($_POST['cod'], FILTER_SANITIZE_NUMBER_INT);
                
                if(isset($cod) && $bd->delete(TB_ENDERECO, " id=?;", array($cod)) == 1){
                    if(DEBUG && Config::$log_lvl > 1) logMsg("Endereço de id(". $_POST['cod'] .") foi deletado");
                    echo "Endereço de id(". $_POST['cod'] .") foi deletado!";
                } 
                break;
            case 'edit':
                $bd = new Banco_De_Dados();
                
                $cod = filter_var($_POST['cod'], FILTER_SANITIZE_NUMBER_INT);
                $cep = filter_var($_POST['cep'], FILTER_SANITIZE_STRING);
                $cod_mun = filter_var($_POST['cod_mun'], FILTER_SANITIZE_NUMBER_INT);
                $endereco = filter_var($_POST['endereco'], FILTER_SANITIZE_STRING);
                $nro = filter_var($_POST['nro'], FILTER_SANITIZE_STRING);
                $complemento = filter_var($_POST['complemento'], FILTER_SANITIZE_STRING);
                $bairro = filter_var($_POST['bairro'], FILTER_SANITIZE_STRING);
                $cidade = filter_var($_POST['cidade'], FILTER_SANITIZE_STRING);
                $uf = filter_var($_POST['uf'], FILTER_SANITIZE_STRING);
                
                if(isset($cod) && isset($cep) && isset($cod_mun) && isset($endereco) && isset($nro) && isset($complemento) && isset($bairro) && isset($cidade) && isset($uf)){
                    if($bd->update(TB_ENDERECO, "cep=?, codmun=?, endereco=?, nro=?, complemento=?, bairro=?, cidade=?, uf=? WHERE id=?;", array($cep, $cod_mun, $endereco, $nro, $complemento, $bairro, $cidade, $uf, $cod)) == 1){
                        if(DEBUG && Config::$log_lvl > 1) logMsg("Endereço de id(". $_POST['cod'] .") foi alterado");
                        echo "Endereço de id(". $_POST['cod'] .") foi alterado!";
                    } 
                }
                break;
            case 'addEnd':
                $bd = new Banco_De_Dados();
                $id_usr = filter_var($_POST['id_usr'], FILTER_SANITIZE_NUMBER_INT);
                $cep = filter_var($_POST['cep'], FILTER_SANITIZE_STRING);
                $cod_mun = filter_var($_POST['cod_mun'], FILTER_SANITIZE_NUMBER_INT);
                $endereco = filter_var($_POST['endereco'], FILTER_SANITIZE_STRING);
                $nro = filter_var($_POST['nro'], FILTER_SANITIZE_STRING);
                $complemento = filter_var($_POST['complemento'], FILTER_SANITIZE_STRING);
                $bairro = filter_var($_POST['bairro'], FILTER_SANITIZE_STRING);
                $cidade = filter_var($_POST['cidade'], FILTER_SANITIZE_STRING);
                $uf = filter_var($_POST['uf'], FILTER_SANITIZE_STRING);

                if(isset($id_usr) && isset($cep) && isset($cod_mun) && isset($endereco) && isset($nro) && isset($complemento) && isset($bairro) && isset($cidade) && isset($uf)){
                    $result = $bd->insert(TB_ENDERECO, "id_usr=?, cep=?, codmun=?, endereco=?, nro=?, complemento=?, bairro=?, cidade=?, uf=?;", array($id_usr, $cep, $cod_mun, $endereco, $nro, $complemento, $bairro, $cidade, $uf));
                    if($result > 0){
                        if(DEBUG) logMsg("Endereço de id($result) foi adicionado");
                        echo "Endereço de id($result) foi adicionado ao usuário id($id_usr)!";
                    } 
                }
                break;
            case 'delUser':
                $bd = new Banco_De_Dados();
                $id = filter_var($_POST['cod'], FILTER_SANITIZE_NUMBER_INT);
                
                if(isset($id)){
                    if(DEBUG) logMsg("Deletado user de id($id)");
                    if($bd->delete(TB_CLIENTE, "id=?;", array($id)))
                        echo "Deletado com sucesso! Id($id)";
                    else
                        echo "Problema ao deletar o id($id)";
                }
                break;
            default: echo "Opção não encontrada!"; break;
        }
    }