<div class="page-title">
	<h2><span class="fa fa-list"></span> Contactos</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo Contacto</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Contacto', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<tr>
						<th><?= $this->Form->label('cliente_id', 'Cliente'); ?></th>
						<td><?= $this->Form->input('cliente_id'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('email', 'Email'); ?></th>
						<td><?= $this->Form->input('email'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('fono', 'Fono'); ?></th>
						<td><?= $this->Form->input('fono'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('cargo', 'Cargo'); ?></th>
						<td><?= $this->Form->input('cargo'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('comentario', 'Comentario'); ?></th>
						<td><?= $this->Form->input('comentario'); ?></td>
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
