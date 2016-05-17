<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="page-title">
			<h2><span class="fa fa-users"></span> Clientes</h2>
		</div>
		<?= $this->Form->create('Cliente', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="fa fa-plus"></span> Nuevo Cliente</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
							<td><?= $this->Form->input('nombre',array('placeholder' => 'Ingrese nombre')); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('razon_social', 'Razón social'); ?></th>
							<td><?= $this->Form->input('razon_social',array('placeholder' => 'Ingrese razón social')); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('rut', 'Rut'); ?></th>
							<td><?= $this->Form->input('rut',array('placeholder' => 'Ingrese rut')); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('email', 'Email'); ?></th>
							<td><?= $this->Form->input('email',array('placeholder' => 'ejemplo@brandon.cl')); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('fono', 'Fono'); ?></th>
							<td><?= $this->Form->input('fono',array('placeholder' => 'Ingrese fono de 9 dígitos','size' => 12)); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('direccion', 'Direccion'); ?></th>
							<td><?= $this->Form->input('direccion',array('placeholder' => 'Ingrese dirección')); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('comentario', 'Comentarios'); ?></th>
							<td><?= $this->Form->input('comentario',array('placeholder' => 'Comentarios adicionales')); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('activo', 'Activo'); ?></th>
							<td><?= $this->Form->input('activo', array('class' => 'icheckbox')); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('vendedor_id', 'Vendedor'); ?></th>
							<td><?= $this->Form->input('vendedor_id',array('empty' => 'Seleccione vendedor')); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('rubro_id', 'Rubro'); ?></th>
							<td><?= $this->Form->input('rubro_id',array('empty' => 'Seleccione rubro')); ?></td>
						</tr>
					</table>

					<div class="pull-right">
						<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
						<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
					</div>
				</div>
			</div>
		</div>
		<? if ($this->Session->read('Auth.Administrador.Rol.id') < 3) { ?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="fa fa-bullhorn"></span> Desginar Administrador</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th><?= $this->Form->label('Administrador', 'Administradores'); ?></th>
								<td><?= $this->Form->input('Administrador'); ?></td>
							</tr>
						</table>
						<div class="pull-right">
							<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
							<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
						</div>
					</div>
				</div>
			</div>
		<? }else{
			echo $this->Form->input('Administrador', array('class' => 'hidden'));
			?>
			<script type="text/javascript">
               $(document).ready(function() {
               		$("select#AdministradorAdministrador").val([<?= $this->Session->read('Auth.Administrador.id'); ?>]);
               });
           </script>
			<? } ?>
		<!-- SITIOS -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="fa fa-file"></span> Sitios</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table js-clon-scope">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Url</th>
								<th>IP</th>
								<th>Comentario</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody class="js-clon-contenedor js-clon-blank">
							<tr class="js-clon-base hidden">
								<td><?=$this->Form->input('Sitio.999.nombre',array('placeholder' => 'Ingrese nombre'));?></td>
								<td><?=$this->Form->input('Sitio.999.url',array('placeholder' => 'ej: www.ejemplo.cl'));?></td>
								<td><?=$this->Form->input('Sitio.999.ip',array('placeholder' => 'ej: 192.168.0.2'));?></td>
								<td><?=$this->Form->input('Sitio.999.comentario',array('placeholder' => 'Ingrese comentarios'));?></td>
								<td>
									<a href="#" class="btn btn-xs btn-danger js-clon-eliminar"><i class="fa fa-trash"></i> Eliminar</a>
								</td>
							</tr>
							<? if ( ! empty($this->request->data['Sitio']) ) : ?>
								<? foreach ( $this->request->data['Sitio'] as $index => $Sitio ) : ?>
								<tr>
									<td><?= $this->Form->input(sprintf('Sitio.%d.nombre', $index), array('class' => 'form-control','placeholder' => 'Ingrese nombre')); ?></td>
									<td><?= $this->Form->input(sprintf('Sitio.%d.url', $index), array('class' => 'form-control', 'placeholder' => 'ej: www.ejemplo.cl')); ?></td>
									<td><?= $this->Form->input(sprintf('Sitio.%d.ip', $index),array('class' => 'form-control', 'placeholder' => 'ej: 192.168.0.2')); ?></td>
									<td><?= $this->Form->input(sprintf('Sitio.%d.comentario', $index), array('class' => 'form-control', 'placeholder' => 'Ingrese comentarios')); ?></td>
									<td>
										<a href="#" class="btn btn-xs btn-danger js-clon-eliminar"><i class="fa fa-trash"></i> Eliminar</a>
										<!--<a href="#" class="btn btn-xs btn-primary js-clon-clonar"><i class="fa fa-clone"></i> Duplicar</a>-->
									</td>
								</tr>
								<? endforeach; ?>
								<? endif; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4">&nbsp;</td>
								<td><a href="#" class="btn btn-xs btn-success js-clon-agregar"><i class="fa fa-plus"></i> Agregar sitio</a></td>
							</tr>
						</tfoot>
					</table>
					<div class="pull-right">
						<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
						<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- CONTACTOS -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><sapan class="fa fa-envelope"></sapan> Contactos</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table js-clon-scope">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Email</th>
								<th>Fono</th>
								<th>Cargo</th>
								<th>Comentario</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody class="js-clon-contenedor js-clon-blank">
							<tr class="js-clon-base hidden">
								<td><?=$this->Form->input('Contacto.999.nombre',array('placeholder' => 'Ingrese nombre'));?></td>
								<td><?=$this->Form->input('Contacto.999.email',array('placeholder' => 'Ingrese email'));?></td>
								<td><?=$this->Form->input('Contacto.999.fono',array('placeholder' => 'Ingrese fono'));?></td>
								<td><?=$this->Form->input('Contacto.999.cargo',array('placeholder' => 'Ingrese cargo'));?></td>
								<td><?=$this->Form->input('Contacto.999.comentario',array('placeholder' => 'Ingrese comentarios'));?></td>
								<td>
									<a href="#" class="btn btn-xs btn-danger js-clon-eliminar"><i class="fa fa-trash"></i> Eliminar</a>
								</td>
							</tr>
							<? if ( ! empty($this->request->data['Contacto']) ) : ?>
								<? foreach ( $this->request->data['Contacto'] as $index => $contacto ) : ?>
								<tr>
									<td><?= $this->Form->input(sprintf('Contacto.%d.nombre', $index), array('class' => 'form-control','placeholder' => 'Ingrese nombre')); ?></td>
									<td><?= $this->Form->input(sprintf('Contacto.%d.email', $index), array('class' => 'form-control', 'placeholder' => 'Ingrese email')); ?></td>
									<td><?= $this->Form->input(sprintf('Contacto.%d.fono', $index),array('class' => 'form-control', 'placeholder' => 'Ingrese fono')); ?></td>
									<td><?= $this->Form->input(sprintf('Contacto.%d.cargo', $index), array('class' => 'form-control', 'placeholder' => 'Ingrese cargo')); ?></td>
									<td><?= $this->Form->input(sprintf('Contacto.%d.comentario', $index), array('class' => 'form-control', 'placeholder' => 'Ingrese comentarios')); ?></td>
									<td>
										<a href="#" class="btn btn-xs btn-danger js-clon-eliminar"><i class="fa fa-trash"></i> Eliminar</a>
										<!--<a href="#" class="btn btn-xs btn-primary js-clon-clonar"><i class="fa fa-clone"></i> Duplicar</a>-->
									</td>
								</tr>
								<? endforeach; ?>
								<? endif; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5">&nbsp;</td>
								<td><a href="#" class="btn btn-xs btn-success js-clon-agregar"><i class="fa fa-plus"></i> Agregar contacto</a></td>
							</tr>
						</tfoot>
					</table>
					<div class="pull-right">
						<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
						<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- CALENDARIO -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><sapan class="fa fa-calendar"></sapan> Calendario</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table calendario">
						<thead>
							<tr>
								<th>Semana/Día</th>
								<th>Lunes</th>
								<th>Martes</th>
								<th>Miercoles</th>
								<th>Jueves</th>
								<th>Viernes</th>
							</tr>
						</thead>
						<tbody>
							<? for ($i=1; $i < 6; $i++) {
								echo "<tr><td><span class='semana'>Semana ".$i."</span></td>";
								for ($j=1; $j < 6; $j++) {
									echo "<td><div class='calendar-box' data-semana='".$i."' data-dia='".$j."'><span id='etiqueta'></span>"; ?>
									<div class="modal fade" id="confirmar" tabindex="-1" role="dialog">
									  <div class="modal-dialog">
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title">Registrar evento</h4>
									      </div>
									      <div class="modal-body" id="eventContent">
									        	<div class="form-group">
									        		<?= $this->Form->label('Calendario.'.$i.$j.'.nombre', 'Nombre'); ?>
									        		<?= $this->Form->input('Calendario.'.$i.$j.'.nombre', array('class' => 'form-control input_nombre')); ?>
									        		<?= $this->Form->input('Calendario.'.$i.$j.'.dia',array('type' => 'hidden','class' => 'input_dia','value' => $j)); ?>
									        		<?= $this->Form->input('Calendario.'.$i.$j.'.semana',array('type' => 'hidden','class' => 'input_semana','value' => $i)); ?>
									        	</div>
									        	<div class="form-group">
									        		<?= $this->Form->label('Calendario.'.$i.$j.'.observacion', 'Observación'); ?>
									        		<?= $this->Form->input('Calendario.'.$i.$j.'.observacion',array('class' => 'form-control input_observacion')); ?>
									        	</div>
									        <div class="pull-left">
												<a href="" id="removerEvento" class="btn btn-danger btn-xs"><span class="fa fa-remove"></span> Eliminar evento</a>
											</div>
											<div class="pull-right">
												<button id="btn_agregar_evento" class="btn btn-primary esperar-carga">Agregar</button>
												<button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
											</div>
									      </div>
									    </div><!-- /.modal-content -->
									  </div><!-- /.modal-dialog -->
									</div><!-- /.modal -->
								<?	echo "</div></td>";
								}
								echo "<tr>";
							}?>
						</tbody>
					</table>
					<div class="pull-right">
						<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
						<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
					</div>
				</div>
			</div>
		</div>

<script type="text/javascript">


	$('.calendar-box').on('click', function(){
		var box 		= $(this);
		var semana 		= box.data('semana');
		var dia 		= box.data('dia');
		var modal 		= box.children('#confirmar');
		modalMostrar(modal);
	});


	$('.calendar-box #etiqueta label').on('click', function(){
		var box 		= $(this).parent().parent('.calendar-box');
		var semana 		= box.data('semana');
		var dia 		= box.data('dia');
		var modal 		= $(box).children('#confirmar');
		modalMostrar(modal);
	});


	$(document).on('click','#removerEvento',function(event){	
		event.preventDefault();

		var caja1 = $(this).parent().parent().find('input[type="text"]');
		var caja2 = $(this).parent().parent().find('textarea');
		
		$(caja1).val('');
		$(caja2).val('');

		var box			= $(this).parent().parent().parent().parent().parent().parent().children('#etiqueta');
		var modal 		= $(this).parent().parent().parent().parent().parent().parent().children('#confirmar');
		console.log(box);
		$(box).html('');
		ocultarModal(modal);
	});


	$(document).on('click','#btn_agregar_evento',function(event){
		event.preventDefault();

		var data 		= $(this).parent().parent();
		var nombre 		= $(data).find('.input_nombre').val();
		var dia 		= $(data).find('.input_dia').val();
		var semana 		= $(data).find('.input_semana').val();
		var observacion = $(data).find('.input_observacion').val();

		var box			= $(data).parent().parent().parent().parent().children('#etiqueta');
		var modal 		= $(data).parent().parent().parent().parent().children('#confirmar');
		
		ocultarModal(modal);

		$(box).html("<label>" + nombre + "</label>");
	});

	/**
	*	Mostrar modal
	*/
	function modalMostrar(objeto){
		$(objeto).modal('show');
	}

	/**
	*	Ocultar modal
	*/
	function ocultarModal(objeto){
		$(objeto).modal('hide');
	}

</script>
		<?=$this->Form->input('Log.0.administrador_id',array('type' => 'hidden', 'value' => $this->Session->read('Auth.Administrador.id')));?>
		<?=$this->Form->input('Log.0.comentario',array('type' => 'hidden', 'value' => 'Cliente creado'));?>
		<?=$this->Form->input('Log.0.fecha',array('type' => 'hidden', 'value' => date('Y-m-d H:m:s')));?>
		<?=$this->Form->input('Log.0.realizado',array('type' => 'hidden', 'value' => '1'));?>
		<?= $this->Form->end(); ?>
	</div>
</div>