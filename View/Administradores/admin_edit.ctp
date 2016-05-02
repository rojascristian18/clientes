<div class="page-title">
	<h2><span class="fa fa-user"></span> Administradores</h2>
</div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Editar Administrador</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<?= $this->Form->create('Administrador', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<?= $this->Form->input('id'); ?>
					<table class="table">
						<tr>
							<th><?= $this->Form->label('rol_id', 'Perfil'); ?></th>
							<td><?= $this->Form->input('rol_id'); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
							<td><?= $this->Form->input('nombre'); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('email', 'Email'); ?></th>
							<td><?= $this->Form->input('email'); ?></td>
						</tr>
						<!--<tr>
							<th><?= $this->Form->label('clave', 'Clave'); ?></th>
							<td><?= $this->Form->input('clave', array('type' => 'password', 'autocomplete' => 'off', 'value' => '')); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('repetir_clave', 'Repetir clave'); ?></th>
							<td><?= $this->Form->input('repetir_clave', array('type' => 'password', 'autocomplete' => 'off', 'value' => '')); ?></td>
						</tr>-->
						<tr>
							<th><?= $this->Form->label('fono', 'Fono'); ?></th>
							<td><?= $this->Form->input('fono'); ?></td>
						</tr>
						<tr>
							<th><?= $this->Form->label('activo', 'Activo'); ?></th>
							<td><?= $this->Form->input('activo', array('class' => 'icheckbox')); ?></td>
						</tr>
					</table>
			</div>
		</div>
	</div>
</div>
<? if ($this->Session->read('Auth.Administrador.Rol.id') != 3) { ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Designar clientes</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th><?= $this->Form->label('Cliente', 'Clientes'); ?></th>
							<td><?= $this->Form->input('Cliente'); ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?	if (count($clientesAsignados['Cliente']) > 0) {

	       $ListaRelacionados = "";

	       for ($i = 0; $i < count($clientesAsignados['Cliente']); $i++) {
               if ($ListaRelacionados != "") $ListaRelacionados .= ", ";
               $ListaRelacionados .= $clientesAsignados['Cliente'][$i]['id'];
	       }
	    ?>
			<script type="text/javascript">
               $(document).ready(function() {
               		$("select#ClienteCliente").val([<?= $ListaRelacionados; ?>]);
               });
           </script>
		<? } ?>
<? }?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="pull-right">
			<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
			<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
		</div>
	<?= $this->Form->end(); ?>
</div>
