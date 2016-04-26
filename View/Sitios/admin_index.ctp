<div class="page-title">
	<h2><span class="fa fa-list"></span> Sitios</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de Sitios</h3>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo Sitio', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
				<?= $this->Html->link('<i class="fa fa-file-excel-o"></i> Exportar a Excel', array('action' => 'exportar'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('cliente_id', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('nombre', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('url', 'URL', array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('ip', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('comentario', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $sitios as $sitio ) : ?>
						<tr>
							<td><?= $this->Html->link($sitio['Cliente']['nombre'], array('controller' => 'clientes', 'action' => 'edit', $sitio['Cliente']['id'])); ?></td>
							<td><?= h($sitio['Sitio']['nombre']); ?>&nbsp;</td>
							<td><?= h($sitio['Sitio']['url']); ?>&nbsp;</td>
							<td><?= h($sitio['Sitio']['ip']); ?>&nbsp;</td>
							<td><?= h($sitio['Sitio']['comentario']); ?>&nbsp;</td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $sitio['Sitio']['id']), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<?= $this->Form->postLink('<i class="fa fa-remove"></i> Eliminar', array('action' => 'delete', $sitio['Sitio']['id']), array('class' => 'btn btn-xs btn-danger confirmar-eliminacion', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
							</td>
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
