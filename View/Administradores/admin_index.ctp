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
				<table class="table">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('rol_id', 'Perfil', array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('nombre', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('email', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('ultimo_acceso', 'Último Acceso', array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $administradores as $administrador ) : ?>
						<tr>
							<td><?= $this->Html->link($administrador['Rol']['nombre'], array('controller' => 'roles', 'action' => 'edit', $administrador['Rol']['id'])); ?></td>
							<td><?= h($administrador['Administrador']['nombre']); ?>&nbsp;</td>
							<td><?= h($administrador['Administrador']['email']); ?>&nbsp;</td>
							<td><?= h($administrador['Administrador']['ultimo_acceso']); ?>&nbsp;</td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $administrador['Administrador']['id']), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<a href="#" class="btn btn-xs btn-danger confirmar-eliminacion mb-control" data-box="#mb-confirm-delete" rel="tooltip" title="Eliminar este registro"><i class="fa fa-remove"></i> Eliminar</a>
								
							</td>
							<div class="message-box message-box-warning animated fadeIn" data-sound="alert" id="mb-confirm-delete">
								<div class="mb-container">
									<div class="mb-middle">
										<div class="mb-title"><span class="fa fa-sign-out"></span>¿Eliminar <strong>registro</strong>?</div>
										<div class="mb-content">
											<p>¿Seguro que desea eliminar este registro?</p>
											<p>Presiona NO para continuar trabajando y SI para eliminar.</p>
										</div>
										<div class="mb-footer">
											<div class="pull-right">
												<?= $this->Form->postLink('<i class="fa fa-remove"></i> Eliminar', array('action' => 'delete', $administrador['Administrador']['id']), array('class' => 'btn btn-success btn-lg', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
												<button class="btn btn-default btn-lg mb-control-close">No</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="pull-right">
	<ul class="pagination">
		<?= $this->Paginator->prev('« Anterior', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'first disabled hidden')); ?>
		<?= $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'modulus' => 2, 'currentClass' => 'active', 'separator' => '')); ?>
		<?= $this->Paginator->next('Siguiente »', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'last disabled hidden')); ?>
	</ul>
</div>

