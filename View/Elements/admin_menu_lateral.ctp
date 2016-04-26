<div class="page-sidebar">
	<ul class="x-navigation x-navigation-custom">
		<li class="xn-logo">
			<?= $this->Html->link(
				'<span class="fa fa-dashboard"></span> <span class="x-navigation-control">Backend</span>',
				'/admin',
				array('escape' => false)
			); ?>
		</li>
		<!-- Get Modules View -->	
		<?= $this->element('modulos'); ?>
		
		<? 	$controladores		=  array_map(function($controlador) {

					return str_replace('Controller', '', $controlador);

				}, App::objects('controller')); ?>
		<li class="xn-openable">
			<a href="#"><span class="fa fa-cog"></span> <span class="xn-text">Controladores</span></a>
			<ul>
				<? foreach ( $controladores as $controlador ) : ?>
				<? if ( $controlador === 'App' ) continue; ?>
				<li class="<?= ($this->Html->menuActivo(array('controller' => strtolower($controlador))) ? 'active' : ''); ?>">
					<?= $this->Html->link(
						sprintf('<span class="fa fa-list"></span> <span class="xn-text">%s</span>', ucfirst($controlador)),
						array('controller' => strtolower($controlador), 'action' => 'index'),
						array('escape' => false)
					); ?>
				</li>
				<? endforeach; ?>
			</ul>
		</li>

	</ul>
</div>
