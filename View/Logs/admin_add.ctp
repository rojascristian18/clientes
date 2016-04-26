<div class="page-title">
	<h2><span class="fa fa-list"></span> Logs</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo Log</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Log', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<tr>
						<th><?= $this->Form->label('administrador_id', 'Administrador'); ?></th>
						<td><?= $this->Form->input('administrador_id'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('comentario', 'Comentario'); ?></th>
						<td><?= $this->Form->input('comentario'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('fecha', 'Fecha'); ?></th>
						<td><?= $this->Form->input('fecha'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('realizado', 'Realizado'); ?></th>
						<td><?= $this->Form->input('realizado', array('class' => 'icheckbox')); ?></td>
					</tr>
				</table>

				<div class="pull-right">
					<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
					<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
				</div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>
