<form action="<?= URL ?>validation_login" method="POST">
	<div class="container">
		<h4>Admin Login</h4>
		<div class="col-md-4">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" class="form-control" placeholder="username...">
			</div>
			<div class="form-group">
				<label for="password">password</label>
				<input type="password" name="password" class="form-control" placeholder="password...">
			</div>
			<div class="form-group">
				<button type="submit" name="btnLogin" class="btn btn-success">Login</button>
			</div>

		</div>
	</div>
</form>