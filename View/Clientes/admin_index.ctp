<div class="page-title">
	<h2><span class="fa fa-list"></span> Clientes</h2>
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
							<td><?= h($cliente['Cliente']['nombre']); ?>&nbsp;</td>
							<td><?= h($cliente['Cliente']['razon_social']); ?>&nbsp;</td>
							<td><?= h($cliente['Cliente']['rut']); ?>&nbsp;</td>
							<td><?= h($cliente['Cliente']['email']); ?>&nbsp;</td>
							<td><?= h($cliente['Cliente']['fono']); ?>&nbsp;</td>
							<td><?= ($cliente['Cliente']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $cliente['Cliente']['id']), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<a href="#" class="btn btn-xs btn-danger confirmar-eliminacion mb-control" data-box="#mb-confirm-delete" rel="tooltip" title="Eliminar este registro"><i class="fa fa-remove"></i> Eliminar</a>
							</td>
						</tr>
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
												<?= $this->Form->postLink('<i class="fa fa-remove"></i> Eliminar', array('action' => 'delete', $cliente['Cliente']['id']), array('class' => 'btn btn-success btn-lg', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
												<button class="btn btn-default btn-lg mb-control-close">No</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
