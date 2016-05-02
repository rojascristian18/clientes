<div class="page-title">
	<h2><span class="fa fa-users"></span> Asignación de clientes</h2>
</div>

<div class="page-content-wrap">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-right">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3>Asignar</h3>
				</div>
				<div class="panel-body">
					<div class="row">
					<?= $this->Form->create('Asignar', array('class' => 'form-inline', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
						<div class="col-xs-12 col-md-6">
							<?=$this->Form->label('asignados', 'Administradores'); ?>
							<?=$this->Form->input('asignados'); ?>
							<? if (isset($clientes[0]['Administrador'][0]['id'])) {?>
								<?=$this->Form->input('ClienteAnterior.id',array('type' => 'hidden','value' => $clientes[0]['Administrador'][0]['id'])); ?>
							<? } ?>
						</div>
						<div class="col-md-offset-2 col-md-4">
							<button type="submit" class="btn btn-primary esperar-carga btn-asignar" disabled="disabled"><span class="fa fa-refresh"></span> Asignar seleccionados</button>
						</div>
					<?= $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3>Filtro</h3>
				</div>
				<div class="panel-body">
					<div class="row">
					<?= $this->Form->create('Filtro', array('class' => 'form-inline', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
						<div class="col-xs-12 col-md-5">
							<?=$this->Form->label('admines', 'Administradores'); ?>
							<?=$this->Form->input('admines',array('empty' => 'Seleccione')); ?>
						</div>
						<div class="col-xs-12 col-md-4">
							<?=$this->Form->label('Rubro', 'Rubros'); ?>
							<?=$this->Form->input('Rubro',array('empty' => 'Seleccione')); ?>
						</div>
						<div class="col-xs-12 col-md-3">
							<div class="pull-right">
								<button type="submit" class="btn btn-info esperar-carga"><span class="fa fa-filter"></span> Filtrar clientes</button>
							</div>
						</div>
					<?= $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3>Resultados</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table tabla-asignar">
							<thead>
								<tr class="sort">
									<th><input type="checkbox" id="all"> Todo</th>
									<th><?= $this->Paginator->sort('nombre', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
									<th><?= $this->Paginator->sort('Administrador', 'Responsable', array('title' => 'Haz click para ordenar por este criterio')); ?></th>
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
									<td><input type="checkbox" value="<?=$cliente['Cliente']['id'];?>" class="add-to-form"></td>
									<td><?= h($cliente['Cliente']['nombre']); ?>&nbsp;</td>
									<td><?= h($cliente['Administrador'][0]['nombre']); ?>&nbsp;</td>
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
	</div>
</div>

<script type="text/javascript">

$(document).ready(function(){

	$('.add-to-form').on('click', function(){
		$(this).each(function(){
			addToform($(this));
		});
	});

	$('#all').on('click', function(){
		selectAll($(this));
	});

	function addToform(obj){
		if ( $( obj ).prop( 'checked' ) ) {

			var htmlInput = "<input type='checkbox' class='hidden counter' name='data[Cliente][][id]' id='selected_input" + $( obj ).val() + "' value='" + $( obj ).val() + "' checked>";
			$('.btn-asignar').removeAttr('disabled');
			$( '#AsignarAdminAsignarForm' ).append(htmlInput);

		}else{

			$( '#selected_input' + $( obj ).val() ).remove();

			if ($('.counter').size() == 0) {
				$('.btn-asignar').attr('disabled','disabled');
			};

		}
	}

	function selectAll(obj){
		if ( $( obj ).prop( 'checked' ) ) {
			$( '.tabla-asignar .add-to-form' ).each(function(){
				$(this).trigger('click');
			});
		}else{
			$( '.tabla-asignar .add-to-form' ).each(function(){
				$(this).trigger('click');
			});
		}
	}

});

</script>