<?php

    $edit=null;
    $cadastro=false;
    
    if($_GET['op'] === "form" && isset($_POST['salvar'])){ 
        #formulário de cadastro enviado
        $edit = new Editora($_POST['nome'], $_POST['cnpj'], $_POST['nome_reduzido'], $_POST['margem']);
        $end = new Endereco(null, null, $_POST['endereco'], $_POST['nro'], null, null, $_POST['cidade'], $_POST['uf']);
        $erros = $edit->validaDados();
        $erros2 = $end->validaDados();
        
        if(!isset($erros) && !isset($erros2)){
            $result = $edit->cadastrar();
                       
            if(is_numeric($result) && $result > 0){
                $end->setIdFor($result);
                $end->cadastrar("id_edit");
                
                echo "<p class=\"text-center cd-erro\">Editora $nome cadastrada no banco de dados!<br></p>";
                  
                $cadastro = true;
                $_POST['busca'] = $result;
                $_POST['editId'] = $result;
                $edit->setId($result);
                
            } 
            
        } else {
            foreach($erros2 as $erro)
                echo "<p class=\"text-center cd-erro\">$erro<br></p>";
        }
        
    }
    
    
   #------------- FIM DO CADASTRAR -----------
    
    if(isset($_POST['editar']) && $_GET['op'] === "form"){
        #formulário foi enviado
        $edit = new Editora($_POST['nome'], $_POST['cnpj'], $_POST['nome_reduzido'], $_POST['margem']);
        $end = new Endereco(null, null, $_POST['endereco'], $_POST['nro'], null, null, $_POST['cidade'], $_POST['uf']);
        $erros = $edit->validaDados();
        $erros2 = $end->validaDados();
                
        $id = filter_var($_POST['editId'], FILTER_SANITIZE_NUMBER_INT);
       
        if(!isset($erros) && !empty($id) && !isset($erros2)){
            $edit->setId($id);
            $end->setIdFor($id);
            
            $result = $edit->editar();
            
            if($result == true){
                $end->editar("id_edit");
                
                echo "<p class=\"text-center cd-erro\">Editora $nome alterado no banco de dados!<br></p>";
                  
                $cadastro = true;
                $_POST['busca'] = $edit->getId();
                $_POST['editId'] = $edit->getId();
                
            } else {
                echo "<p class=\"text-center cd-erro\">Problema desconhecido ao alterar a Editora!<br></p>";
            }
            
        } else {
            if(isset($erros)){
                foreach($erros as $erro)
                    echo "<p class=\"text-center cd-erro\">$erro<br></p>";
            } else {
                foreach($erros2 as $erro)
                    echo "<p class=\"text-center cd-erro\">$erro<br></p>";
            }
        }
    }
    
    #------------- FIM DO EDITAR -------------
    
    if($_GET['op'] === "pesquisa" && isset($_POST['enviar'])){
        #enviado formulário de pesquisa
        $edit = new Editora();
        $end = new Endereco();
        $tipo;
        
        if(is_numeric($_POST['busca'])){
            $busca = filter_var($_POST['busca'], FILTER_SANITIZE_NUMBER_INT);
            $tipo=1;
        } else {
            $busca = filter_var($_POST['busca'], FILTER_SANITIZE_STRING);
            $tipo=2;
        }
        
        if($edit->buscar($busca, $tipo) == true){
            $end->buscar($edit->getId(), "id_edit");
            
            $_POST['editId'] = $edit->getId();
            $_POST['cnpj'] = $edit->getCnpj();
            $_POST['nome'] = $edit->getNome();
            $_POST['nome_reduzido'] = $edit->getNome_reduzido();
            $_POST['margem'] = $edit->getMargem();
            $_POST['endereco'] = $end->getEndereco();
            $_POST['nro'] = $end->getNro();
            $_POST['cidade'] = $end->getCidade();
            $_POST['uf'] = $end->getUf();
        } else
            echo "<p class=\"text-center cd-erro\">Não foi encontrado nenhuma editora com a busca: $busca<br></p>";
    }
    
   if($_GET['op'] === "form" && isset($_POST['excluir'])){
        #enviado formulário de pesquisa
        $edit = new Editora();
        $end = new Endereco();
        
        $id = filter_var($_POST['editId'], FILTER_SANITIZE_NUMBER_INT);
        
        $edit->setId($id);
        $end->setIdFor($id);
        
        if($end->deletar("id_edit") == true){
            if($edit->deletar() == true)
                echo "<p class=\"text-center cd-erro\">Deletado com sucesso!<br></p>";
            else
                echo "<p class=\"text-center cd-erro\">Problema ao deletar o fornecedor!<br></p>";
        }
    }

?>

<div class="container">
    <h3 class="mt-3 text-center">Cadastro de editoras</h3>
    <div class="row">
        <div class="col-12">
            <form class="form-inline mt-4 mb-2" method="post" action="?page=cadeditoras&op=pesquisa">
                <label for="busca" class="mr-2">Buscar: </label>
                <input type="text" placeholder="Nome ou código da editora" name="busca" id="busca" class="form-control mr-2">
                <input type="submit" value="Buscar" class="btn btn-warning" name="enviar">
            </form>
        </div>
    </div>
    <hr> 
    <div class="row">
        <div class="col-12">
            <form class="form-group mt-3" method="post" action="?page=cadeditoras&op=form">
                <input type="text" name="editId" value="<?=$_POST['editId'];?>" id="editId" hidden="true">
                <h5>Informações Básicas</h5>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="cnpj">CNPJ (opcional)</label>
                        <input type="text" class="form-control" value="<?=$_POST['cnpj'];?>" maxlength="16" id="cnpj" name="cnpj">
                    </div>
                    <div class="form-group col-md-7">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" value="<?=$_POST['nome'];?>" maxlength="90" id="nome" name="nome">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="nome_reduzido">Nome Reduzido</label>
                        <input type="text" class="form-control" value="<?=$_POST['nome_reduzido'];?>" maxlength="15" id="nome_reduzido" name="nome_reduzido">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-1">
                        <label for="margem">Margem</label>
                        <input type="text" class="form-control" value="<?=$_POST['margem'];?>" maxlength="5" id="margem" name="margem">
                    </div>
                </div>
                
                <h5 class="mt-5">Endereço empresarial</h5>
                <div class="form-row mt-2">
                    <div class="form-group col-md-9">
                        <label for="endereco">Endereço</label>
                        <input type="text" class="form-control" value="<?=$_POST['endereco'];?>" maxlength="40" id="endereco" name="endereco">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="nro">Nro</label>
                        <input type="text" class="form-control" value="<?=$_POST['nro'];?>" maxlength="5" id="nro" name="nro">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" value="<?=$_POST['cidade'];?>" maxlength="20" id="cidade" name="cidade">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="uf">UF</label>
                        <input type="text" class="form-control" value="<?=$_POST['uf'];?>" maxlength="2" id="uf" name="uf">
                    </div>
                </div>
                
                <div class="form-row">
                    <input type="submit" class="btn btn-warning mr-3" name="salvar" value="Salvar">
                    <input type="submit" class="btn btn-warning mr-3" name="editar" value="Editar">
                    <input type="submit" class="btn btn-warning mr-3" name="excluir" value="Excluir">
                </div>
            </form>
            
        </div>
    </div>
</div>
