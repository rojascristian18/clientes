<div class="page-title">
	<h2><span class="fa fa-users"></span> Clientes</h2>
</div>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-4">
			<label>Instrucciones</label>
			<ul>
				<li>Si desea filtrar por fecha, selecione un rango de fecha y luego presione filtrar clientes.</li>
				<li>Si desea filtrar por creterio, seleccione un criterio, luego ingrese su busqueda y presion filtrar clientes.</li>
				<li>Si desea buscar por fecha y criterio, simplemente complete los campos con la información correspndeiente y luego presion filtrar clientes.</li>
			</ul>
		</div>
		<div class="col-md-8">
			<div class="btn-group pull-right">
				<? if ($this->Session->read('Auth.Administrador.Rol.id') < 3 ) { ?>
					<?= $this->Html->link('<i class="fa fa-user"></i> Asignar Clientes', array('action' => 'asignar'), array('class' => 'btn btn-default', 'escape' => false)); ?>
				<? } ?>

				<? if ($this->Session->read('Auth.Administrador.Rol.id') < 4 ) { ?>
					<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo Cliente', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
					<?= $this->Html->link('<i class="fa fa-file-excel-o"></i> Exportar a Excel', array('action' => 'exportar'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
				<? }?>
			</div>
		</div>
	</div>
	<div class="row">
		<?= $this->Form->create('Cliente', array('class' => 'form-inline', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h4>Filtrar por fecha</h4>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 col-xs-12">
							<div class="form-group">
								<span class="input-group-addon add-on" style="width:36px;float:left;"><span class="glyphicon glyphicon-calendar"></span></span>
								<?=$this->Form->input(
									'fecha_inicio', array(
										'type' => 'text',
										'class' => 'form-control',
										'placeholder' => 'Seleccione fecha inicial',
										'data-clear' => 'true'
									)
								); ?>
							</div>
							<div class="form-group">
								<span class="input-group-addon add-on" style="width:36px;float:left;"><span class="glyphicon glyphicon-calendar"></span></span>
								<?=$this->Form->input(
									'fecha_final', array(
										'type' => 'text',
										'class' => 'form-control',
										'placeholder' => 'Seleccione fecha final',
										'data-clear' => 'true'
									)
								); ?>
							</div>
						</div>						
					</div>
				</div>
				<div class="panel-footer">
					<div class="pull-left">
						<a class="btn btn-primary btn-block js-limpiar-busqueda"><span class="fa fa-ban"></span> Limpiar filtros</a>
					</div>
					<div class="pull-right">
						<button type="submit" class="btn btn-info btn-block esperar-carga"><span class="fa fa-filter"></span> Filtrar clientes</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h4>Filtrar por criterio</h4>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<? $options = array(
										'1' => 'Responsable',
										'2' => 'Sitios',
										'3' => 'Vendedor'
									);?>

								<?= $this->Form->input('findby', array(
									    'options' => $options,
									    'empty' => 'Seleccione criterio',
									    'class' => 'form-control',
									    'data-clear' => 'true'
									)); ?>
							</div>
							<div class="form-group">
								<?=$this->Form->input(
									'inputfind', array(
										'type' => 'text',
										'class' => 'form-control',
										'placeholder' => 'Ingrese',
										'data-clear' => 'true'
									)
								); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="pull-left">
						<a class="btn btn-primary btn-block js-limpiar-busqueda"><span class="fa fa-ban"></span> Limpiar filtros</a>
					</div>
					<div class="pull-right">
						<button type="submit" class="btn btn-info btn-block esperar-carga"><span class="fa fa-filter"></span> Filtrar clientes</button>
					</div>
				</div>
			</div>
		</div>
		<?= $this->Form->end(); ?>
		<? if ( !empty($fecha_inicio) || !empty($fecha_final) || !empty($inputSearch) ) { ?>
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading" style="color:#434A54;">
						<label>Resultados para:</label>
						<ul>
							<?= !empty($fecha_inicio) ? "<li><b>Fecha Inicial:</b> " . $fecha_inicio . "</li>" : ''; ?>
							<?= !empty($fecha_final) ? "<li><b>Fecha Final:</b> " . $fecha_final . "</li>" : ''; ?>
							<?= !empty($inputSearch) ? "<li><b>Palabra a buscar:</b> " . $inputSearch . " en " . $selectSearch . "</li>" : ''; ?>
						</ul>
					</div>
				</div>
			</div>
		<? } ?>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<h3 class="panel-title">Listado de Clientes</h3>
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
									<td><?= h($cliente['Cliente']['email']); ?>&nbsp;</td>
									<td><?= h($cliente['Cliente']['fono']); ?>&nbsp;</td>
									<td><?= ($cliente['Cliente']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
										<td>
										<?= $this->Html->link('<i class="fa fa-eye"></i> Ver', array('controller' => 'clientes', 'action' => 'perfil', $cliente['Cliente']['id']), array('class' => 'btn btn-xs btn-success', 'rel' => 'tooltip', 'title' => 'Ver perfil', 'escape' => false)); ?>
										<? if ($this->Session->read('Auth.Administrador.Rol.id') < 4 ) { ?>
										<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $cliente['Cliente']['id']), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
										<? if ($cliente['Cliente']['activo'] == 1) { ?>
											<?= $this->Form->postLink('<i class="fa fa fa-eye-slash"></i> Desactivar', array('action' => 'desactivar', $cliente['Cliente']['id']), array('class' => 'btn btn-warning btn-xs', 'rel' => 'tooltip', 'title' => 'Desactivar este registro', 'escape' => false)); ?>
										<? }else{ ?>
											<?= $this->Form->postLink('<i class="fa fa-eye"></i> Activar', array('action' => 'activar', $cliente['Cliente']['id']), array('class' => 'btn btn-primary btn-xs', 'rel' => 'tooltip', 'title' => 'Activar este registro', 'escape' => false)); ?>
										<?	} ?>
										<? } ?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
