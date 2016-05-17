<div class="page-title">
	<h2><span class="fa fa-user"></span> Administradores</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de Administradores</h3>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo Administrador', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
				<?= $this->Html->link('<i class="fa fa-file-excel-o"></i> Exportar a Excel', array('action' => 'exportar'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table datatable">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('rol_id', 'Perfil', array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('nombre', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('email', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('ultimo_acceso', 'Último Acceso', array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('activo', 'Activo', array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $administradores as $administrador ) : ?>
						<tr>
							<td><?= h($administrador['Rol']['nombre']); ?></td>
							<td><?= h($administrador['Administrador']['nombre']); ?>&nbsp;</td>
							<td><?= h($administrador['Administrador']['email']); ?>&nbsp;</td>
							<td><?= h($administrador['Administrador']['ultimo_acceso']); ?>&nbsp;</td>
							<td><?= ($administrador['Administrador']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $administrador['Administrador']['id']), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<? if ($administrador['Administrador']['activo'] == 1) { ?>
									<?= $this->Form->postLink('<i class="fa fa fa-eye-slash"></i> Desactivar', array('action' => 'desactivar', $administrador['Administrador']['id']), array('class' => 'btn btn-warning btn-xs', 'rel' => 'tooltip', 'title' => 'Desactivar este registro', 'escape' => false)); ?>
								<? }else{ ?>
									<?= $this->Form->postLink('<i class="fa fa-eye"></i> Activar', array('action' => 'activar', $administrador['Administrador']['id']), array('class' => 'btn btn-primary btn-xs', 'rel' => 'tooltip', 'title' => 'Activar este registro', 'escape' => false)); ?>
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

