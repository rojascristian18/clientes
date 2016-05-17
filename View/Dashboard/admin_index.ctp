<?//= $this->Html->scriptBlock(sprintf("var totalClientesMes = %s;", json_encode($totalClientesMes))); ?>
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
			<div class="widget widget-default widget-carousel">
                <div class="owl-carousel">
            <? foreach ($vendedorClientes as $indixe => $vendedor) { ?>
                <!-- START WIDGET SLIDER -->
                    <div>                                    
                        <div class="widget-title"><?=$vendedor['Vendedor']['nombre'];?></div>
                        <div class="widget-subtitle">Total clientes</div>
                        <div class="widget-int"><?=count($vendedor['Cliente']);?></div>
                    </div>        
                <!-- END WIDGET SLIDER -->
            <? } ?>
                </div>                                                        
            </div> 
		</div>
	</div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Evolución de clientes</h3>
                        <span>Total clientes nuevos por mes</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><select class="form-control select" id="selectMeses">
                            <option value="6">Seleccione meses a mostrar</option>
                            <option value="4">Últimos 4 meses</option>
                            <option value="5">Últimos 5 meses</option>
                            <option value="6">Últimos 6 meses</option>
                            <option value="7">Últimos 7 meses</option>
                            <option value="8">Últimos 8 meses</option>
                            <option value="9">Últimos 9 meses</option>
                            <option value="10">Últimos 10 meses</option>
                            <option value="11">Últimos 11 meses</option>
                            <option value="12">1 año</option>
                            <option value="24">2 años</option>
                        </select></li>
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Encoger</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Quitar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body padding-0">
                    <div id="dashboardClientes"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Evolución de vendedores</h3>
                        <span>Total clientes por vendedor</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><select class="form-control select" id="selectMesesVendedores">
                            <option value="6">Seleccione meses a mostrar</option>
                            <option value="4">Últimos 4 meses</option>
                            <option value="5">Últimos 5 meses</option>
                            <option value="6">Últimos 6 meses</option>
                            <option value="7">Últimos 7 meses</option>
                            <option value="8">Últimos 8 meses</option>
                            <option value="9">Últimos 9 meses</option>
                            <option value="10">Últimos 10 meses</option>
                            <option value="11">Últimos 11 meses</option>
                            <option value="12">1 año</option>
                            <option value="24">2 años</option>
                        </select></li>
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Encoger</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Quitar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body padding-0">
                    <div id="dashboardVendedores"></div>
                </div>
            </div>
        </div>
    </div>
</div>

