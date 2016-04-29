<div class="login-box animated fadeInDown">
	<div class="login-logo"></div>
	<?= $this->element('admin_alertas'); ?>
	<div class="login-body">
		<div class="login-title text-center"><strong>Bienvenido</strong></div>
		<div class="login-title text-center">Para iniciar sesión debes identificarte.</div>
		<?= $this->Form->create('Administrador', array('class' => 'form-horizontal', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
			<div class="form-group">
				<div class="col-md-12">
					<div class="g-signin2" id="sign" data-onsuccess="onSignIn"></div>
					<?= $this->Form->input('email', array('type' => 'hidden')); ?>
					<?= $this->Form->input('clave', array('type' => 'hidden','value' => 'brandon')); ?>
					<?= $this->Form->input('avatar', array('type' => 'hidden')); ?>
				</div>
			</div>
			<!--<div class="form-group">
				<div class="col-md-12">
					<?= $this->Form->input('clave', array('type' => 'password', 'placeholder' => 'Contraseña')); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<button type="submit" class="btn btn-info btn-block">Entrar</button>
				</div>
			</div>-->
		<?= $this->Form->end(); ?>
	</div>
	<div class="login-footer">
		<div class="pull-left">
			&copy; 2016 Agencia BrandOn
		</div>
	</div>
</div>
<script>
  	function onSignIn(googleUser) {
	  var profile = googleUser.getBasicProfile();

	  $('#AdministradorEmail').val(profile.getEmail());
	  $('#AdministradorAvatar').val(profile.getImageUrl());
	  
	  $('#AdministradorAdminLoginForm').submit();

	}

	function onFailure(error) {
      console.log(error);
    }

	function renderButton() {
  	  w = $('#sign').width();
      gapi.signin2.render('sign', {
        'scope': 'Email',
        'width': w,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSignIn,
        'onfailure': onFailure
      });
    }

</script>