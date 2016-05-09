<div class="page-title">
	<h2><span class="fa fa-users"></span> Clientes</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<h3 class="panel-title">Listado de Clientes</h3>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="btn-group pull-right">
						<? if ($this->Session->read('Auth.Rol.id') != 3 ) { ?>
							<?= $this->Html->link('<i class="fa fa-user"></i> Asignar Clientes', array('action' => 'asignar'), array('class' => 'btn btn-default', 'escape' => false)); ?>
						<? } ?>
						<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo Cliente', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
						<?= $this->Html->link('<i class="fa fa-file-excel-o"></i> Exportar a Excel', array('action' => 'exportar'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table datatable">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('nombre', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('razon_social', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('rut', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('email', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('fono', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('activo', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $clientes as $cliente ) : ?>
						<tr>
							<td><?= $this->Html->link($cliente['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'perfil', $cliente['Cliente']['id'])); ?>&nbsp;</td>
							<td><?= h($cliente['Cliente']['razon_social']); ?>&nbsp;</td>
							<td><?= h($cliente['Cliente']['rut']); ?>&nbsp;</td>
							<td><?= h($cliente['Cliente']['email']); ?>&nbsp;</td>
							<td><?= h($cliente['Cliente']['fono']); ?>&nbsp;</td>
							<td><?= ($cliente['Cliente']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $cliente['Cliente']['id']), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<? if ($cliente['Cliente']['activo'] == 1) { ?>
									<?= $this->Form->postLink('<i class="fa fa fa-eye-slash"></i> Desactivar', array('action' => 'desactivar', $cliente['Cliente']['id']), array('class' => 'btn btn-warning btn-xs', 'rel' => 'tooltip', 'title' => 'Desactivar este registro', 'escape' => false)); ?>
								<? }else{ ?>
									<?= $this->Form->postLink('<i class="fa fa-eye"></i> Activar', array('action' => 'activar', $cliente['Cliente']['id']), array('class' => 'btn btn-primary btn-xs', 'rel' => 'tooltip', 'title' => 'Activar este registro', 'escape' => false)); ?>
								<?	} ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
