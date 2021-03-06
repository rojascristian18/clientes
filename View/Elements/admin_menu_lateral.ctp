<div class="page-sidebar">
	<ul class="x-navigation x-navigation-custom">
		<li class="xn-logo">
			<?= $this->Html->link(
				'<span class="fa fa-dashboard"></span> <span class="x-navigation-control">Backend</span><a href="#" class="x-navigation-control"></a>',
				'/admin',
				array('escape' => false)
			); ?>
		</li>
		<li class="xn-profile active">
            <div class="profile">
            	<div class="profile-image">
            		<? if ($this->Session->read('Auth.Administrador.google_imagen') == "") { ?>
	            			<?= $this->Html->link($this->Html->image('logo_user.jpg', array('alt' => 'Perfil','class' => 'mCS_img_loaded')),
								'/admin/administradores/perfil/' . $this->Session->read('Auth.Administrador.id'),
								array('escape' => false)
						); ?>
            			
            		<? }else{ ?>
            			<? $avatar =  str_replace('sz=50', 'sz=200', $avatar['Administrador']['google_imagen']);?>
						<?= $this->Html->link('<img class="mCS_img_loaded" src="' . $avatar .'" alt="">',
							'/admin/administradores/perfil/' . $this->Session->read('Auth.Administrador.id'),
							array('escape' => false)
						); ?>
            		<? } ?>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name"><?=$this->Session->read('Auth.Administrador.nombre');?></div>
                    <div class="profile-data-title"><?=$this->Session->read('Auth.Administrador.Rol.nombre');?></div>
                </div>
            </div>                                                                        
        </li>
		<li class="<?= ($this->Html->menuActivo(array('controller' => 'dashboard', 'action' => 'index')) ? 'active' : ''); ?>">
		<?= $this->Html->link(
				'<span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span>',
				'/admin/dashboard',
				array('escape' => false)
			); ?>
		</li>
		<!-- Get Modules View -->	
		<?= $this->element('modulos'); ?>
		
		<? if ($this->Session->read('Auth.Administrador.Rol.id') == 1) { ?>
			
			<?= $this->element('controladores'); ?>

		<? }?>

	</ul>
</div>
