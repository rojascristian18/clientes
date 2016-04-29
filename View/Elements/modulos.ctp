<? foreach ($modulosDisponibles as $moduloPadre) { ?>
	<? if ( ! empty($moduloPadre['hijos']) ) { ?>
		<!--<li class="xn-title">
			<?=$moduloPadre['nombre'];?>
		</li>-->
		<? foreach ($moduloPadre['hijos'] as $modulo) { ?>
		<li class="<?= ($this->Html->menuActivo(array('controller' => strtolower($modulo['Modulo']['controlador']), 'action' => 'index')) ? 'active' : ''); ?>">
			<?= $this->Html->link(
				'<span class="'.$modulo['Modulo']['icono'].'"></span> <span class="xn-text">'.$modulo['Modulo']['nombre'].'</span>',
				array('controller' => strtolower($modulo['Modulo']['controlador']), 'action' => 'index'),
				array('escape' => false)
			); ?>
		</li>
		<? }?>
	<? } ?>
<? } ?>
