<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="page-title">
			<h2><span class="fa fa-users"></span> <?=$cliente['Cliente']['nombre'];?></h2>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="fa fa-info"></span> Información del cliente</h3>
			</div>
			<div class="panel-body">
				<table class="table table-stripped">
					<tr>
						<th>Nombre</th>
						<td><?=$cliente['Cliente']['nombre'];?></td>
					</tr>
					<tr>
						<th>Razón social</th>
						<td><?=$cliente['Cliente']['razon_social'];?></td>
					</tr>
					<tr>
						<th>Rut empresa</th>
						<td><?=$cliente['Cliente']['rut'];?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><?=$cliente['Cliente']['email'];?></td>
					</tr>
					<tr>
						<th>Fono</th>
						<td><?=$cliente['Cliente']['fono'];?></td>
					</tr>
					<tr>
						<th>Dirección</th>
						<td><?=$cliente['Cliente']['direccion'];?></td>
					</tr>
					<tr>
						<th>Comentarios</th>
						<td><?=$cliente['Cliente']['comentario'];?></td>
					</tr>
					<tr>
						<th>Fecha de creción</th>
						<td><?=$cliente['Cliente']['creado'];?></td>
					</tr>
					<tr>
						<th>Estado</th>
						<td><?= ($cliente['Cliente']['activo'] ? '<i class="fa fa-check"></i> Activo' : '<i class="fa fa-remove"></i> Inactivo'); ?>&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="fa fa-user"></span> Datos del responsable</h3>
			</div>
			<div class="panel-body">
				<table class="table table-stripped">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Email</th>
							<th>Fono</th>
						</tr>
					</thead>
				<? foreach ($cliente['Administrador'] as $indice => $admin) : ?>
					<tbody>
						<tr>
							<td><?=$admin['nombre'];?></td>
							<td><?=$admin['email'];?></td>
							<td><?=$admin['fono'];?></td>
						</tr>
					</tbody>
				<? endforeach; ?>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="fa fa-balance-scale"></span> Vendedor asignado</h3>
			</div>
			<div class="panel-body">
				<table class="table table-stripped">
					<tr>
						<th>Nombre</th>
						<td><?=$cliente['Vendedor']['nombre'];?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><?=$cliente['Vendedor']['email'];?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="fa fa-cube"></span> Rubro del cliente</h3>
			</div>
			<div class="panel-body">
				<table class="table table-stripped">
					<tr>
						<th>Nombre</th>
						<td><?=$cliente['Rubro']['nombre'];?></td>
					</tr>
					<tr>
						<th>Comentarios</th>
						<td><?=$cliente['Rubro']['comentario'];?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="fa fa-file"></span> Sitios</h3>
			</div>
			<div class="panel-body">
				<table class="table table-stripped">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Url</th>
							<th>Ip</th>
							<th>Comentario</th>
						</tr>
					</thead>
				<? foreach ($cliente['Sitio'] as $indice => $sitio) : ?>
					<tbody>
						<tr>
							<td><?=$sitio['nombre'];?></td>
							<td><?=$sitio['url'];?></td>
							<td><?=$sitio['ip'];?></td>
							<td><?=$sitio['comentario'];?></td>
						</tr>
					</tbody>
				<? endforeach; ?>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="fa fa-commenting"></span> Contactos</h3>
			</div>
			<div class="panel-body">
				<table class="table table-stripped">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Email</th>
							<th>Fono</th>
							<th>Cargo</th>
							<th>Comentario</th>
						</tr>
					</thead>
				<? foreach ($cliente['Contacto'] as $contacto) : ?>
					<tbody>
						<tr>
							<td><?=$contacto['nombre'];?></td>
							<td><?=$contacto['email'];?></td>
							<td><?=$contacto['fono'];?></td>
							<td><?=$contacto['cargo'];?></td>
							<td><?=$contacto['comentario'];?></td>
						</tr>
					</tbody>
				<? endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="float-button">
			<?= $this->Html->link('Volver', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
			<br>
		</div>
	</div>
</div>