<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-primary">
	            <div class="panel-heading">
	                <h2 class="panel-title"><span class="fa fa-user"></span> Su información</h2>
	            </div>
	            <div class="panel-body">
	            	<div class="table-responsive">
		                <table class="table table-striped">
		                	<tr>
			                	<td>Nombre</td>
			                	<td><?=$administrador['Administrador']['nombre'];?></td>
			                </tr>
			                <tr>
			                	<td>Email</td>
			                	<td><?=$administrador['Administrador']['email'];?></td>
			                </tr>
			                <tr>
		                		<td>Fono</td>
		                		<td><?=$administrador['Administrador']['fono'];?></td>
		                	</tr>
		                	<tr>
		                		<td>Clave</td>
		                		<td><button class="btn btn-xs btn-success" data-toggle="modal" data-target="#form"><span class="fa fa-key"></span> Cambiar contraseña</button></td>
		                	</tr>
		                	<tr>
			                	<td>Último acceso</td>
			                	<td><?=$administrador['Administrador']['ultimo_acceso'];?></td>
			                </tr>
			                <tr>
			                	<td>Estado de tu cuenta</td>
			                	<td><?=($administrador['Administrador']['activo'] ? '<i class="fa fa-check"></i> Activa' : '<i class="fa fa-remove"></i> Desactivada');?></td>
			                </tr>
		                </table>
	                </div>
	            </div>
	            <div class="panel-footer">
				</div>
	            </div>                            
	        </div>
		</div>
	</div>
</div>
<div class="modal fade" id="form" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Actualizar clave</h4>
			</div>
			<div class="modal-body">
				<?= $this->Form->create('Administrador', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<?= $this->Form->input('id'); ?>
				<table class="table table-striped">
					<tr>
						<td>Clave actual</td>
						<td><?= $this->Form->input('clave_actual', array('type' => 'password', 'autocomplete' => 'off', 'value' => ''));?></td>
					</tr>
					<tr>
						<td>Clave nueva</td>
						<td><?= $this->Form->input('clave_nueva', array('type' => 'password', 'autocomplete' => 'off', 'value' => ''));?></td>
					</tr>
					<tr>
						<td>Repetir clave nueva</td>
						<td><?= $this->Form->input('repetir_clave_nueva', array('type' => 'password', 'autocomplete' => 'off', 'value' => ''));?></td>
					</tr>
					<tr>
						<td colspan="2"><div class="pull-right">
						<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
						<?= $this->Html->link('Cancelar', array('' => ''), array('class' => 'btn btn-danger', 'data-dismiss' => 'modal')); ?>
						</div>
						</td>
					</tr>
				</table>
				<?= $this->Form->end(); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->