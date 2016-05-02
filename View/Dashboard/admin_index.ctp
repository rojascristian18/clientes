<div class="page-title">
	<h2><span class="fa fa-dashboard"></span> Dashboard</h2>
</div>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="widget widget-default widget-carousel">
                <div class="owl-carousel">
			<? foreach ($clienteAdmin as $indice => $registro) { ?>
			    <!-- START WIDGET SLIDER -->
            		<div>                                    
                        <div class="widget-title"><?=$registro['Administrador']['nombre'];?></div>
                        <div class="widget-subtitle">Total clientes</div>
                        <div class="widget-int"><?=count($registro['Cliente']);?></div>
                    </div>        
                <!-- END WIDGET SLIDER -->
			<? } ?>
				</div>                                                        
            </div> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<!-- START WIDGET SLIDER -->
            <div class="widget widget-default widget-carousel">
                <div class="owl-carousel">
                    <div>                                    
                        <div class="widget-title">Clientes Activos</div>
                        <div class="widget-subtitle">al <?=date('d-m-Y H:m:s'); ?></div>
                        <div class="widget-int"><?=$totalActivos;?></div>
                    </div>
                    <div>                                    
                        <div class="widget-title">Clientes Inactivos</div>
                        <div class="widget-subtitle">al <?=date('d-m-Y H:m:s'); ?></div>
                        <div class="widget-int"><?=$totalDesactivos;?></div>
                    </div>
                </div>                                                        
            </div>         
            <!-- END WIDGET SLIDER -->
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<!-- START WIDGET SLIDER -->
            <div class="widget widget-default widget-carousel">
                <div class="owl-carousel">
                    <div>                                    
                        <div class="widget-title">Total Clientes</div>                                                           
                        <div class="widget-subtitle">al <?=date('d-m-Y H:m:s'); ?></div>
                        <div class="widget-int"><?=$totalClientes;?></div>
                    </div>
                    <div>                                    
                        <div class="widget-title">Clientes nuevos</div>
                        <div class="widget-subtitle">del Mes</div>
                        <div class="widget-int"><?=$totalNuevos;?></div>
                    </div>
                </div>                                                        
            </div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<!-- START WIDGET CLOCK -->
            <div class="widget widget-danger widget-padding-lg">
                <div class="widget-big-int plugin-clock">00:00</div>                            
                <div class="widget-subtitle plugin-date">Cargando...</div>
            </div>                        
            <!-- END WIDGET CLOCK -->
		</div>
	</div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Evolución clientes</h3>
                        <span>Total clientes nuevos por mes</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body padding-0">
                    <div class="chart-holder" id="dashboard-line-1" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

