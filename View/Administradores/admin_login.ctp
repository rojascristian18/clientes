<div class="login-box animated fadeInDown">
	<div class="login-logo"></div>
	<?= $this->element('admin_alertas'); ?>
	<div class="login-body">
		<div class="login-title text-center"><strong>Bienvenido</strong></div>
		<div class="login-title text-center">Para iniciar sesión debes identificarte.</div>
		<div class="login-title text-center">
			<?= $this->Html->link(
				$this->Html->image('/backend/img/login_google.png'),
				$authUrl,
				array('escape' => false)
			); ?>
		</div>
	</div>
	<div class="login-footer">
		<div class="pull-left">
			&copy; 2016 Agencia BrandOn
		</div>
	</div>
</div>