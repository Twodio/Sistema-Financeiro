<div class="container">
	<p class="text-center mt-2">O administrador requer que todos os usuários se identifiquem para usar o sistema.</p>
	<form class="col-5 mt-3" style="position: relative; left: 30%; min-height: 350px;" action="?page=index" method="POST">
		<div class="form-group">
			<label for="login">Login</label>
			<input type="text" class="form-control" id="login" name="login" placeholder="Digite o seu login" />
		</div>
		<div class="form-group">
			<label for="senha">Senha</label>
			<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" />
		</div>
		<div class="form-group form-check">
			<input type="checkbox" class="form-check-input" id="conexao" name="conexao" />
			<label class="form-check-label" for="conexao">Manter conexão</label>
		</div>
		<button type="submit" name="entrar" class="btn btn-primary btn-block">Entrar</button>
	</form>
</div>