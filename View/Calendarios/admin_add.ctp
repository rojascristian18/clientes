<div class="page-title">
	<h2><span class="fa fa-list"></span> Calendarios</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo Calendario</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Calendario', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
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
						<th><?= $this->Form->label('dia', 'Dia'); ?></th>
						<td><?= $this->Form->input('dia'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('semana', 'Semana'); ?></th>
						<td><?= $this->Form->input('semana'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('observacion', 'Observacion'); ?></th>
						<td><?= $this->Form->input('observacion'); ?></td>
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
