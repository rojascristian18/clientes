<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-primary">
	            <div class="panel-heading">
	                <h3 class="panel-title">Tu información</h3>
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