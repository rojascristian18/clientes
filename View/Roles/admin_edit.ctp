<div class="page-title">
	<h2><span class="fa fa-list"></span> Perfiles</h2>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Editar Perfil</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Rol', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<?= $this->Form->input('id'); ?>
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('Modulo', 'Modulo'); ?></th>
						<td><?= $this->Form->input('Modulo'); ?></td>
					</tr>
				</table>
				<?php
					//marca en el select las motos asociadas al producto
					if (count($modulosSeleccionados['Modulo']) > 0) {

					       $ListaRelacionados = "";

					       for ($i = 0; $i < count($modulosSeleccionados['Modulo']); $i++) {

					               if ($ListaRelacionados != "") $ListaRelacionados .= ", ";

					               $ListaRelacionados .= $modulosSeleccionados['Modulo'][$i]['id'];

					       }
					       ?>
							<script type="text/javascript">
				                   $(document).ready(function() {
				                   		$("select#ModuloModulo").val([<?= $ListaRelacionados; ?>]);
				                   });
				           </script>
				<?php
					}
				?>

				<div class="pull-right">
					<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
					<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
				</div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>
