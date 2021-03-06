<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="page-title">
			<h2><span class="fa fa-users"></span> Clientes</h2>
		</div>
		<?= $this->Form->create('Cliente', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="fa fa-pencil"></span> Editar Cliente</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
				<?= $this->Form->input('id'); ?>
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
					<?php
						if (count($designados['Administrador']) > 0) {

					       $ListaRelacionados = "";

					       for ($i = 0; $i < count($designados['Administrador']); $i++) {
				               if ($ListaRelacionados != "") $ListaRelacionados .= ", ";
				               $ListaRelacionados .= $designados['Administrador'][$i]['id'];
					       }
					    ?>
							<script type="text/javascript">
			                   $(document).ready(function() {
			                   		$("select#AdministradorAdministrador").val([<?= $ListaRelacionados; ?>]);
			                   });
				           </script>
						<?php
						}else{
							echo $this->Form->input('Administrador', array('class' => 'hidden'));
							?>
							<script type="text/javascript">
			                   $(document).ready(function() {
			                   		$("select#AdministradorAdministrador").val([<?= $this->Session->read('Auth.Administrador.id'); ?>]);
			                   });
				           </script>
							<? } ?>
					<div class="pull-right">
						<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
						<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
					</div>
				</div>
			</div>
		</div>
		<? }?>
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
		<div id="calendarioContainer">
		</div>
		<!-- Logs -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><sapan class="fa fa-bolt"></sapan> Logs</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr class="sort">
								<th>Detalle</th>
								<th>Responsable</th>
								<th>Fecha</th>
								<th>Realizado</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $this->request->data['Log'] as $log ) : ?>
							<tr>
								<td><?= h($log['comentario']); ?>&nbsp;</td>
								<td><?= h($log['Administrador']['nombre']); ?>&nbsp;</td>
								<td><?= h($log['fecha']); ?>&nbsp;</td>
								<td><?= ($log['realizado'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?=$this->Form->input('Log.0.administrador_id',array('type' => 'hidden', 'value' => $this->Session->read('Auth.Administrador.id')));?>
		<?=$this->Form->input('Log.0.comentario',array('type' => 'hidden', 'value' => 'Cliente modificado'));?>
		<?=$this->Form->input('Log.0.fecha',array('type' => 'hidden', 'value' => date('Y-m-d H:m:s')));?>
		<?=$this->Form->input('Log.0.realizado',array('type' => 'hidden', 'value' => '1'));?>
		<?= $this->Form->end(); ?>
	</div>
</div>