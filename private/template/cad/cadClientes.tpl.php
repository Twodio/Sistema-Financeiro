<?php
    $cadastro = false;
    $erros = null;
    $cli;
    
    if($_GET['op'] === "form" && isset($_POST['cadastrar'])){
        #formulário foi enviado
        $cli = new Cliente($_POST['estrangeiro'], $_POST['doc'], $_POST['nome'], $_POST['rg'], $_POST['telefone'], $_POST['celular'], $_POST['fax'], $_POST['observacao'], $_POST['contato'], $_POST['email'], $_POST['inscestadual'], $_POST['inscmunicipal'], $_POST['maladireta']);
        $erros = $cli->validaDados();
        
        if(!isset($erros)){
            $result = $cli->cadastrar();
            
            if(is_numeric($result) && $result > 0){
                echo "<p class=\"text-center cd-erro\">Cliente $nome cadastrado no banco de dados!<br></p>";
                  
                $cadastro = true;
                $_POST['busca'] = $result;
                $_POST['userId'] = $result;
                $cli->setId($result);
                
            } else {
                if($result['doc'] != false)
                    echo "<p class=\"text-center cd-erro\">Já existe um cliente com o doc: $doc cadastrado!<br></p>";
                
                if($result['email'] != false)
                    echo "<p class=\"text-center cd-erro\">Já existe um cliente com o email: $email cadastrado!<br></p>";
            }
            
        } else {
            foreach($erros as $erro)
                echo "<p class=\"text-center cd-erro\">$erro<br></p>";
        }
    }
    
    #------------- FIM DO CADASTRAR -----------
    
    if(isset($_POST['editar']) && $_GET['op'] === "form"){
        #formulário foi enviado
        $cli = new Cliente($_POST['estrangeiro'], $_POST['doc'], $_POST['nome'], $_POST['rg'], $_POST['telefone'], $_POST['celular'], $_POST['fax'], $_POST['observacao'], $_POST['contato'], $_POST['email'], $_POST['inscestadual'], $_POST['inscmunicipal'], $_POST['maladireta']);
        $erros = $cli->validaDados();
        
        $id = filter_var($_POST['userId'], FILTER_SANITIZE_NUMBER_INT);
       
        if(!isset($erros) && !empty($id)){
            $cli->setId($id);
            $result = $cli->editar();
            
            if($result == true){
                echo "<p class=\"text-center cd-erro\">Cliente $nome alterado no banco de dados!<br></p>";
                  
                $cadastro = true;
                $_POST['busca'] = $cli->getId();
                $_POST['userId'] = $cli->getId();
                
            } else {
                echo "<p class=\"text-center cd-erro\">Problema desconhecido ao alterar o cliente!<br></p>";
            }
            
        } else {
            foreach($erros as $erro)
                echo "<p class=\"text-center cd-erro\">$erro<br></p>";
        }
    }
    
    #------------- FIM DO EDITAR -------------
    
    if($_GET['op'] === "pesquisa" && isset($_POST['enviar'])){
        #enviado formulário de pesquisa
        $cli = new Cliente();
        $tipo;
        
        if(is_numeric($_POST['busca'])){
            $busca = filter_var($_POST['busca'], FILTER_SANITIZE_NUMBER_INT);
            $tipo=1;
        } else {
            $busca = filter_var($_POST['busca'], FILTER_SANITIZE_STRING);
            $tipo=2;
        }
        
        if($cli->buscar($busca, $tipo) == true){
            $_POST['userId'] = $cli->getId();
            $_POST['doc'] = $cli->getDoc();
            $_POST['nome'] = $cli->getNome();
            $_POST['rg'] = $cli->getRg();
            $_POST['celular'] = $cli->getCelular();
            $_POST['telefone'] = $cli->getTelefone();
            $_POST['fax'] = $cli->getFax();
            $_POST['inscestadual'] = $cli->getInscricao_estadual();
            $_POST['inscmunicipal'] = $cli->getInscricao_municipal();
            $_POST['contato'] = $cli->getContato();
            $_POST['email'] = $cli->getEmail();
            $_POST['observacao'] = $cli->getObservacao();
            $_POST['maladireta'] = $cli->getMala_direta();
            $_POST['estrangeiro'] = $cli->getTipoPessoa();
        } else
            echo "<p class=\"text-center cd-erro\">Não foi encontrado nenhum cliente com a busca: $busca<br></p>";
    }
?>

<div class="container">
    <h3 class="mt-3 text-center">Cadastro de clientes</h3>
    <div class="row">
        <div class="col-12">
            <form class="form-inline mt-4 mb-2" method="post" action="?page=cadclientes&op=pesquisa">
                <label for="busca" class="mr-2">Buscar: </label>
                <input type="text" placeholder="Nome ou código do cliente" name="busca" value="<?=$_POST['busca'];?>" id="busca" class="form-control mr-2">
                <input type="submit" value="Buscar" class="btn btn-warning" name="enviar" id="buscar">
            </form>
        </div>
    </div>
    <hr> 
    <div class="row">
        <div class="col-12">
            <form class="form-group mt-3" method="post" action="?page=cadclientes&op=form">
                <input type="text" name="userId" value="<?=$_POST['userId'];?>" id="userId" hidden="true">
                <h5>Informações Pessoais</h5>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="doc">CPF, CNPJ ou Passaporte</label>
                        <input type="text" class="form-control" maxlength="16" id="doc" name="doc" value="<?=$_POST['doc'];?>" required>
                    </div>
                    <div class="form-group col-md-9">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" maxlength="90" id="nome" name="nome" value="<?=$_POST['nome'];?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-3">
                        <label for="rg">RG</label>
                        <input type="text" class="form-control" maxlength="15" id="rg" name="rg" value="<?=$_POST['rg'];?>">
                    </div>
                    <div class="col-md-3">
                        <label for="celular">Celular</label>
                        <input type="text" class="form-control" maxlength="15" id="celular" name="celular" value="<?=$_POST['celular'];?>">
                    </div>
                    <div class="col-md-3">
                        <label for="telefone">Telefone</label>
                        <input type="text" class="form-control" maxlength="15" id="telefone" name="telefone" value="<?=$_POST['telefone'];?>">
                    </div>
                    <div class="col-md-2 ml-auto">
                        <label for="fax">FAX</label>
                        <input type="text" class="form-control" maxlength="15" id="fax" name="fax" value="<?=$_POST['fax'];?>">
                    </div>
                </div>
                
                <div class="form-row mt-3 mb-2">
                    <div class="col-md-5">
                        <label for="inscestadual">Inscrição Estadual</label>
                        <input type="text" class="form-control" maxlength="15" id="inscestadual" name="inscestadual" value="<?=$_POST['inscestadual'];?>">
                    </div>
                    <div class="col-md-5 ml-auto">
                        <label for="inscmunicipal">Inscrição Municipal</label>
                        <input type="text" class="form-control" maxlength="15" id="inscmunicipal" name="inscmunicipal" value="<?=$_POST['inscmunicipal'];?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="contato">Contato</label>
                        <input type="text" class="form-control" maxlength="50" id="contato" name="contato" value="<?=$_POST['contato'];?>">
                    </div>
                    <div class="col-md-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" maxlength="100" id="email" name="email" value="<?=$_POST['email'];?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="observacao">Observação</label>
                        <input type="text" class="form-control" maxlength="100" id="observacao" name="observacao" value="<?=$_POST['observacao'];?>">
                    </div>
                </div>
                
                <div class="form-group mt-3 form-inline">
                    <div class="form-check mr-3">
                        <input type="checkbox" class="form-check-input" <?php if(!empty($_POST['maladireta'])) echo "checked"; ?> id="maladireta" name="maladireta">
                        <label class="form-check-label" for="maladireta">Mala direta</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" <?php if(!empty($_POST['estrangeiro'])) echo "checked"; ?> id="estrangeiro" name="estrangeiro">
                        <label class="form-check-label" for="estrangeiro">Estrangeiro</label>
                    </div>
                </div>
                
                <div class="form-row">
                    <input type="submit" class="btn btn-warning mr-3" name="cadastrar" value="Cadastrar">
                    <input type="submit" class="btn btn-warning mr-3" name="editar" value="Editar">
                    <input type="button" class="btn btn-warning mr-3" onclick="alteraUserId(<?=$_POST['userId'];?>);" data-toggle="modal" data-target="#delModal2" value="Excluir">
                </div>
            </form>
            
            <hr>
            
            <?php
                $end;
                
                if((!empty($cli) && $cli->getId() > 0) || $cadastro == true){
                    $end = $cli->buscarEndereco();
                } else 
                    $end = false;
            ?>
            
            <div class="row">
                <div class="col-md-6 border-right">
                    <h4 class="text-center">Lista de Endereços</h4>
                    <table class="table  text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Endereço</th>
                                <th scope="col">Nro</th>
                                <th scope="col">Ações</th>
                            </tr>
                        <a href="#" data-toggle="modal" data-target="#addEndereco" onclick="alteraUserId(<?=$cli->getId();?>);">Adicionar novo</a>
                        </thead>
                        <tbody>
                            <?php
                            if($end != false){
                                foreach($end as $endereco){
                            ?>
                            <tr>
                                <th><?=$endereco['id'];?></th>
                                <td><?=$endereco['endereco'];?></td>
                                <td><?=$endereco['nro'];?></td>
                                <td><a href="#" onclick="alteraEndId(<?=$endereco['id'];?>);" data-toggle="modal" data-target="#delModal"><i class="fas fa-trash"></i></a> | <a href="#endereco" data-toggle="modal" data-target="#addEndereco" onclick="alteraEndId(<?=$endereco['id'];?>);" data-cep="<?=$endereco['cep'];?>" data-codmun="<?=$endereco['cod_mun'];?>" data-endereco="<?=$endereco['endereco'];?>" data-nro="<?=$endereco['nro'];?>" data-complemento="<?=$endereco['complemento'];?>" data-bairro="<?=$endereco['bairro'];?>" data-cidade="<?=$endereco['cidade'];?>" data-uf="<?=$endereco['uf'];?>" data-value="alterar"><i class="far fa-edit"></i></a> | <a href="#endereco"><i class="fas fa-check"></i></a></td>
                            </tr>
                            
                            <?php 
                                }
                            } else 
                                echo "<tr><th colspan=\"4\">Nenhum endereço cadastrado para o cliente</th></tr>";
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h4 class="text-center" style="margin-bottom: 31px;">Lista de Compras</h4>
                    <table class="table text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Data</th>
                                <th scope="col">Obs</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                      <tbody>
                        <tr>
                          <th>1</th>
                          <td>03/06/2013</td>
                          <td>Pago: R$837,00</td>
                          <td><a href="#" data-toggle="modal" data-target="#verCompra"><i class="fas fa-check"></i></a></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEndereco" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Novo Endereço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0);">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="cep">CEP</label>
                            <input type="text" class="form-control is-valid" maxlength="9" id="cep" name="cep">
                        </div>
                        <div class="col-md-4 ml-auto">
                            <label for="codmun">Cód. de Município do IBGE</label>
                            <input type="text" class="form-control" maxlength="9" id="codmun" name="codmun">
                            <div class="small text-muted">Nome do município - UF</div>
                        </div>
                    </div>

                    <div class="form-row mt-2">
                        <div class="form-group col-md-9">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" maxlength="40" id="endereco" name="endereco">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="nro">Nro</label>
                            <input type="text" class="form-control" maxlength="5" id="nro" name="nro">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="complemento">Complemento</label>
                            <input type="text" class="form-control" maxlength="20" id="complemento" name="complemento">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="form-control" maxlength="40" id="bairro" name="bairro">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control" maxlength="20" id="cidade" name="cidade">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="uf">UF</label>
                            <input type="text" class="form-control" maxlength="2" id="uf" name="uf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="salvarEndereco" id="salvarEndereco" class="btn btn-dark" value="Salvar Endereço">
                        <input type="button" class="btn" data-dismiss="modal" value="Fechar" >
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="verCompra" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ver compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <table class="table text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col"># item</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Subtotal R$</th>
                        </tr>
                    </thead>
                  <tbody>
                    <tr>
                      <th>1</th>
                      <td>28</td>
                      <td>Brinco Pequeno Retangular</td>
                      <td>1</td>
                      <td>40,00</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Total R$</td>
                        <td>40,00</td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                Você tem certeza que deseja deletar?
            </div>
            
            <div class="modal-footer">
                <button onclick="delEnd();" data-dismiss="modal" class="btn btn-dark">Deletar</button>
                <button type="button" class="btn" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delModal2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                Você tem certeza que deseja deletar?
            </div>
            
            <div class="modal-footer">
                <button onclick="delUsuario();" data-dismiss="modal" class="btn btn-dark">Deletar</button>
                <button type="button" class="btn" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="js/main.js"></script>