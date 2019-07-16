<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <script src="js/jquery-3.4.1.min.js"></script>
        <title>SisFin</title>
    </head>
    
    <body>
        <main>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="<?=$_SERVER['PHP_SELF'];?>">SisFin</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBar" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navBar">
                    <ul class="navbar-nav mr-auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">Vendas</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">1 - Cotação</a>
							</div>
						</li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pag=">Estoque</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pag=">Contas a Pg</a>
                        </li>
                        <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown">Cadastros</a>
                                <div class="dropdown-menu">
                                        <a class="dropdown-item" href="?page=cadclientes">1 - Clientes</a>
                                        <a class="dropdown-item" href="?page=cadfornecedores">2 - Fornecedores</a>
                                        <a class="dropdown-item" href="?page=cadeditoras">3 - Editoras</a>
                                        <a class="dropdown-item" href="?page=cadvendedores">4 - Vendedores</a>
                                        <a class="dropdown-item" href="?page=cadtransportadoras">5 - Transportadoras</a>
                                        <a class="dropdown-item" href="#">6 - Plano de Pagamento</a>
                                        <a class="dropdown-item" href="#">7 - Etiquetar Cliente</a>
                                        <a class="dropdown-item" href="#">8 - Parâmetros</a>
                                        <a class="dropdown-item" href="#">9 - Reindexação</a>
                                        <a class="dropdown-item" href="#">A - Senha</a>
                                        <a class="dropdown-item" href="#">B - Natureza de operação</a>
                                        <a class="dropdown-item" href="#">C - Itens e Despesas</a>
                                        <a class="dropdown-item" href="#">D - Mala direta</a>
                                        <a class="dropdown-item" href="#">E - Participante de concurso</a>
                                        <a class="dropdown-item" href="#">F - Empresa NF paulista</a>
                                </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pag=">Relatórios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Sair</a>
                        </li>
                    </ul>
                    <span class="navbar-text">
                        Sistema de Gerenciamento Financeiro
                    </span>
                </div>
            </nav>