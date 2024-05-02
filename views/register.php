<div class="row">
	<div class="col-12 col-md-6 mt-3">

		<form method="POST">
			<input type="hidden" name="token" value="<?= $token ?>">
			<div class="form-group">
				<label for="login">Логин</label>
				<input type="text" name="login" class="form-control" id="login" required>
			</div>
			<div class="form-group">
				<label for="password">Пароль</label>
				<input type="password" name="password" class="form-control" id="password" required>
			</div>
			<button name="submit" type="submit" class="btn btn-success">Зарегистрироваться</button>
		</form>
	</div>
</div>
