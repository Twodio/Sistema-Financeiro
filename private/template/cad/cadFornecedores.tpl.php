<?php
    $for=null;
    $cadastro=false;
    
    if($_GET['op'] === "form" && isset($_POST['salvar'])){ 
        #formulário de cadastro enviado
        
        $for = new Fornecedor($_POST['cnpj'], $_POST['nome'], $_POST['insc_est'], $_POST['insc_mun'], $_POST['telefone'], $_POST['celular'], $_POST['fax'], $_POST['contato'], $_POST['email']);
        $end = new Endereco($_POST['cep'], $_POST['codmun'], $_POST['endereco'], $_POST['nro'], $_POST['complemento'], $_POST['bairro'], $_POST['cidade'], $_POST['uf']);
        $erros = $for->validaDados();
        $erros2 = $end->validaDados();
        
        if(!isset($erros) && !isset($erros2)){
            $result = $for->cadastrar();
                       
            if(is_numeric($result) && $result > 0){
                $end->setIdFor($result);
                $end->cadastrar("id_for");
                
                echo "<p class=\"text-center cd-erro\">Fornecedor $nome cadastrado no banco de dados!<br></p>";
                  
                $cadastro = true;
                $_POST['busca'] = $result;
                $_POST['forId'] = $result;
                $for->setId($result);
                
            } else {
                if($result['cnpj'] != false)
                    echo "<p class=\"text-center cd-erro\">Já existe um fornecedor com o cnpj: $doc cadastrado!<br></p>";
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
    
    
   #------------- FIM DO CADASTRAR -----------
    
    if(isset($_POST['editar']) && $_GET['op'] === "form"){
        #formulário foi enviado
        $for = new Fornecedor($_POST['cnpj'], $_POST['nome'], $_POST['insc_est'], $_POST['insc_mun'], $_POST['telefone'], $_POST['celular'], $_POST['fax'], $_POST['contato'], $_POST['email']);
        $end = new Endereco($_POST['cep'], $_POST['codmun'], $_POST['endereco'], $_POST['nro'], $_POST['complemento'], $_POST['bairro'], $_POST['cidade'], $_POST['uf']);
        $erros = $for->validaDados();
        $erros2 = $end->validaDados();
        
        $id = filter_var($_POST['forId'], FILTER_SANITIZE_NUMBER_INT);
       
        if(!isset($erros) && !empty($id) && !isset($erros2)){
            $for->setId($id);
            $end->setIdFor($id);
            
            $result = $for->editar();
            
            if($result == true){
                $end->editar("id_for");
                
                echo "<p class=\"text-center cd-erro\">Fornecedor $nome alterado no banco de dados!<br></p>";
                  
                $cadastro = true;
                $_POST['busca'] = $for->getId();
                $_POST['forId'] = $for->getId();
                
            } else {
                echo "<p class=\"text-center cd-erro\">Problema desconhecido ao alterar o fornecedor!<br></p>";
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
        $for = new Fornecedor();
        $end = new Endereco();
        $tipo;
        
        if(is_numeric($_POST['busca'])){
            $busca = filter_var($_POST['busca'], FILTER_SANITIZE_NUMBER_INT);
            $tipo=1;
        } else {
            $busca = filter_var($_POST['busca'], FILTER_SANITIZE_STRING);
            $tipo=2;
        }
        
        if($for->buscar($busca, $tipo) == true){
            $end->buscar($for->getId(), "id_for");
            
            $_POST['forId'] = $for->getId();
            $_POST['cnpj'] = $for->getCnpj();
            $_POST['nome'] = $for->getNome();
            $_POST['celular'] = $for->getCelular();
            $_POST['telefone'] = $for->getTelefone();
            $_POST['fax'] = $for->getFax();
            $_POST['insc_est'] = $for->getInsc_est();
            $_POST['insc_mun'] = $for->getInsc_mun();
            $_POST['contato'] = $for->getContato();
            $_POST['email'] = $for->getEmail();
            $_POST['cep'] = $end->getCep();
            $_POST['codmun'] = $end->getCodmun();
            $_POST['endereco'] = $end->getEndereco();
            $_POST['nro'] = $end->getNro();
            $_POST['complemento'] = $end->getComplemento();
            $_POST['bairro'] = $end->getBairro();
            $_POST['cidade'] = $end->getCidade();
            $_POST['uf'] = $end->getUf();
        } else
            echo "<p class=\"text-center cd-erro\">Não foi encontrado nenhum fornecedor com a busca: $busca<br></p>";
    }
    
   if($_GET['op'] === "form" && isset($_POST['excluir'])){
        #enviado formulário de pesquisa
        $for = new Fornecedor();
        $end = new Endereco();
        
        $id = filter_var($_POST['forId'], FILTER_SANITIZE_NUMBER_INT);
        
        $for->setId($id);
        $end->setIdFor($id);
        
        if($end->deletar("id_for") == true){
            if($for->deletar() == true)
                echo "<p class=\"text-center cd-erro\">Deletado com sucesso!<br></p>";
            else
                echo "<p class=\"text-center cd-erro\">Problema ao deletar o fornecedor!<br></p>";
        }
    }

?>

<div class="container">
    <h3 class="mt-3 text-center">Cadastro de fornecedores</h3>
    <div class="row">
        <div class="col-12">
            <form class="form-inline mt-4 mb-2" method="post" action="?page=cadfornecedores&op=pesquisa">
                <label for="busca" class="mr-2">Buscar: </label>
                <input type="text" placeholder="Nome ou código do fornecedor" value="<?=$_POST['busca'];?>" name="busca" id="busca" class="form-control mr-2">
                <input type="submit" value="Buscar" class="btn btn-warning" name="enviar">
            </form>
        </div>
    </div>
    <hr> 
    <div class="row">
        <div class="col-12">
            <form class="form-group mt-3" method="post" action="?page=cadfornecedores&op=form">
                <input type="text" name="forId" value="<?=$_POST['forId'];?>" id="forId" hidden="true">
                <h5>Informações Básicas</h5>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="cnpj">CNPJ</label>
                        <input type="text" class="form-control" value="<?=$_POST['cnpj'];?>" maxlength="16" id="cnpj" name="cnpj">
                    </div>
                    <div class="form-group col-md-9">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" value="<?=$_POST['nome'];?>" maxlength="90" id="nome" name="nome">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-3">
                        <label for="celular">Celular</label>
                        <input type="text" class="form-control" value="<?=$_POST['celular'];?>" maxlength="15" id="celular" name="celular">
                    </div>
                    <div class="col-md-3">
                        <label for="telefone">Telefone</label>
                        <input type="text" class="form-control" value="<?=$_POST['telefone'];?>" maxlength="15" id="telefone" name="telefone">
                    </div>
                    <div class="col-md-2 ml-auto">
                        <label for="fax">FAX</label>
                        <input type="text" class="form-control"  value="<?=$_POST['fax'];?>" maxlength="15" id="fax" name="fax">
                    </div>
                </div>
                
                <div class="form-row mt-3 mb-2">
                    <div class="col-md-5">
                        <label for="insc_est">Inscrição Estadual</label>
                        <input type="text" class="form-control" value="<?=$_POST['insc_est'];?>" maxlength="15" id="insc_est" name="insc_est">
                    </div>
                    <div class="col-md-5 ml-auto">
                        <label for="insc_mun">Inscrição Municipal</label>
                        <input type="text" class="form-control" value="<?=$_POST['insc_mun'];?>" maxlength="15" id="insc_mun" name="insc_mun">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-7">
                        <label for="contato">Contato</label>
                        <input type="text" class="form-control" value="<?=$_POST['contato'];?>" maxlength="50" id="contato" name="contato">
                    </div>
                    <div class="col-md-5">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" value="<?=$_POST['email'];?>" maxlength="100" id="email" name="email">
                    </div>
                </div>
                
                <h5 class="mt-5">Endereço empresarial</h5>
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="cep">CEP</label>
                        <input type="text" class="form-control is-valid" value="<?=$_POST['cep'];?>" maxlength="9" id="cep" name="cep">
                    </div>
                    <div class="col-md-4 ml-auto">
                        <label for="codmun">Cód. de Município do IBGE</label>
                        <input type="text" class="form-control" value="<?=$_POST['codmun'];?>" maxlength="9" id="codmun" name="codmun">
                        <div class="small text-muted">Nome do município - UF</div>
                    </div>
                </div>

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
                        <label for="complemento">Complemento</label>
                        <input type="text" class="form-control" value="<?=$_POST['complemento'];?>" maxlength="20" id="complemento" name="complemento">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" value="<?=$_POST['bairro'];?>" maxlength="40" id="bairro" name="bairro">
                    </div>
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