<div class="container">
    <h3 class="mt-3 text-center">Cadastro de vendedores</h3>
    <div class="row">
        <div class="col-12">
            <form class="form-inline mt-4 mb-2" method="post" action="?page=cadvendedores&op=pesquisa">
                <label for="busca" class="mr-2">Buscar: </label>
                <input type="text" placeholder="Nome ou código do vendedor" name="busca" id="busca" class="form-control mr-2">
                <input type="submit" value="Buscar" class="btn btn-warning" name="enviar">
            </form>
        </div>
    </div>
    <hr> 
    <div class="row">
        <div class="col-12">
            <form class="form-group mt-3" method="post" action="?page=cadfornecedores&op=form">
                <h5>Informações Básicas</h5>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="doc">Documento</label>
                        <input type="text" class="form-control" maxlength="16" id="doc" name="doc">
                    </div>
                    <div class="form-group col-md-9">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" maxlength="90" id="nome" name="nome">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="contato">Contato</label>
                        <input type="text" class="form-control" maxlength="30" id="contato" name="contato">
                    </div>
                    <div class="col-md-1">
                        <label for="comissao">Comissão</label>
                        <input type="text" class="form-control" maxlength="5" id="comissao" name="comissao">
                    </div>
                </div>
                
                <h5 class="mt-5">Meio de Trabalho</h5>
                <div class="form-row mt-2">
                    <div class="form-group col-md-12">
                        <label for="obs">Observações</label>
                        <input type="text" class="form-control" maxlength="40" id="obs" name="obs">
                    </div>
                </div>
                
                <div class="form-row">
                    <input type="submit" class="btn btn-warning mr-3" value="Salvar">
                    <input type="button" class="btn btn-warning mr-3" value="Excluir">
                </div>
            </form>
            
        </div>
    </div>
</div>