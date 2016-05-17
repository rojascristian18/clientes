<?php
App::uses('AppController', 'Controller');
class ClientesController extends AppController
{
	public function admin_index()
	{	
		if ( $this->request->is('post') ) {

			$selectSearch 	= $this->request->data['Cliente']['findby'];
			$inputSearch	= $this->request->data['Cliente']['inputfind'];

			$fecha_inicio = $this->request->data['Cliente']['fecha_inicio'];
			$fecha_final = $this->request->data['Cliente']['fecha_final'];
			
			$rangoFechas = "";

			/**
			* Si existe rango de fechas se aplica la sentencia BETWEEN
			*/
			if ( !empty($fecha_inicio) || !empty($fecha_final)) {

				$rangoFechas = 'Cliente.creado BETWEEN "' . $fecha_inicio . '" AND "' . $fecha_final .'" ';

			}

			/* Elimina los espacios en blanco */
			$clearInput		= str_replace(" ", "", $inputSearch);


			switch ($selectSearch) {
				case '1':
					/**
					* Busca el/los administradores asociados al criterio de busqueda
					*/
					$administradores = $this->Cliente->Administrador->find(
						'all',
						array(
							'conditions' => array(
								'Administrador.activo' => 1,
								'Administrador.email LIKE' => '%'.$clearInput.'%'
							),
							'fields' => array(
								'Administrador.id'
							)
						)
					);
				

					/**
					* Crea un array unidimendional con los id e los administradores
					*/
					$idAdministrador = Hash::extract($administradores,'{n}.Administrador.id');


					/**
					* Si es rol cuentas solo filtra sus clientes
					*/
					if ($this->Session->read('Auth.Administrador.Rol.id') >= 3) {

						$clientes		= array();

					}else{

						/**
						* Resultados de la busqueda para rol inferior a 3
						*/
						$clientes		= $this->Cliente->find('all',array(
							'joins' 	=> array(
								array(
						            'table' => 'administradores_clientes',
						            'alias' => 'AdminCliente',
						            'type'  => 'INNER',
						            'conditions' => array(
						                'AdminCliente.cliente_id = Cliente.id',
						                'AdminCliente.administrador_id' => $idAdministrador
						            )

					        	)
							),
							'conditions' => array(
								$rangoFechas
							),
							'order' => array('activo DESC')
						));

					}
					$selectSearch = "Administrador";
					break;
				case '2':
					
					/**
					* Busca el/los sitios asociados al criterio de busqueda
					*/
					$sitios = $this->Cliente->Sitio->find('all',array(
						'conditions' => array(
							'url LIKE' => '%'.$clearInput.'%'
						),
						'fields' => array('cliente_id')
					));


					/**
					* Crea un array unidimendional con los id e los administradores
					*/
					$idCliente = Hash::extract($sitios,'{n}.Sitio.cliente_id');


					/**
					* Si es rol cuentas solo filtra sus clientes
					*/
					if ($this->Session->read('Auth.Administrador.Rol.id') >= 3) {

						$clientes		= $this->Cliente->find('all',array(
							'joins' 	=> array(
								array(
						            'table' => 'administradores_clientes',
						            'alias' => 'AdminCliente',
						            'type'  => 'INNER',
						            'conditions' => array(
						                'AdminCliente.cliente_id = Cliente.id',
						                'AdminCliente.administrador_id' => $this->Auth->user('id')
						            )

					        	)
							),
							'conditions' => array(
								'Cliente.id' => $idCliente,
								$rangoFechas
							),
							'order' => array('activo DESC')
						));

					}else{

						/**
						* Resultados de la busqueda para rol inferior a 3
						*/
						$clientes		= $this->Cliente->find('all',array(
							'conditions' => array(
								'Cliente.id' => $idCliente,
								$rangoFechas
							),
							'order' => array('activo DESC'),
						));

					}

					$selectSearch = "Sitios";
					break;
				case '3':

					/**
					* Busca el/los Vendedores asociados al criterio de busqueda
					*/
					$vendedores = $this->Cliente->Vendedor->find('all',array(
						'conditions' => array(
							'email LIKE' => '%'.$clearInput.'%'
						),
						'fields' => array('id')
					));

	
					/**
					* Crea un array unidimendional con los id e los administradores
					*/
					$idVendedor = Hash::extract($vendedores,'{n}.Vendedor.id');
					

					/**
					* Si es rol cuentas solo filtra sus clientes
					*/
					if ($this->Session->read('Auth.Administrador.Rol.id') >= 3) {

						$clientes		= $this->Cliente->find('all',array(
							'joins' 	=> array(
								array(
						            'table' => 'administradores_clientes',
						            'alias' => 'AdminCliente',
						            'type'  => 'INNER',
						            'conditions' => array(
						                'AdminCliente.cliente_id = Cliente.id',
						                'AdminCliente.administrador_id' => $this->Auth->user('id')
						            )

					        	)
							),
							'conditions' => array(
								$rangoFechas,
								'Cliente.vendedor_id' => $idVendedor
							),
							'order' => array('activo DESC')
						));

					}else{

						/**
						* Resultados de la busqueda para rol inferior a 3
						*/
						$clientes	= $this->Cliente->find('all',array(
							'conditions' => array(
								'Cliente.vendedor_id' => $idVendedor,
								rangoFechas
							),
							'order' => array('activo DESC'),
						));

					}

					$selectSearch = "Vendedor";
					break;
				
				default:

					/**
					* Si es rol cuentas solo filtra sus clientes
					*/
					if ($this->Session->read('Auth.Administrador.Rol.id') >= 3) {

						$clientes		= $this->Cliente->find('all',array(
							'joins' 	=> array(
								array(
						            'table' => 'administradores_clientes',
						            'alias' => 'AdminCliente',
						            'type'  => 'INNER',
						            'conditions' => array(
						                'AdminCliente.cliente_id = Cliente.id',
						                'AdminCliente.administrador_id' => $this->Auth->user('id')
						            )

					        	)
							),
							'conditions' => array(
								$rangoFechas
							),
							'order' => array('activo DESC')
						));

					}else{

						/**
						* Resultados de la busqueda para rol inferior a 3
						*/
						$clientes	= $this->Cliente->find('all',array(
								'conditions' => array(
									$rangoFechas
								),
								'order' => array(
									'activo DESC'
								)
							)
						);

					}

					break;
			}
			
			$this->set(compact('clientes','fecha_inicio','fecha_final','inputSearch','selectSearch'));

		}else{

			if ($this->Session->read('Auth.Administrador.Rol.id') >= 3) {

				$clientes		= $this->Cliente->find('all',array(
					'joins' 	=> array(
						array(
				            'table' => 'administradores_clientes',
				            'alias' => 'AdminCliente',
				            'type'  => 'INNER',
				            'conditions' => array(
				                'AdminCliente.cliente_id = Cliente.id',
				                'AdminCliente.administrador_id' => $this->Auth->user('id')
				            )

			        	)
					),
					'order' => array('activo DESC')
				));

			}else{

				/**
				* Resultados de la busqueda para rol inferior a 3
				*/
				$clientes	= $this->Cliente->find('all',array('order' => array('activo DESC')));

			}
			
			$this->set(compact('clientes'));

		}
	}

	public function admin_asignar()
	{
		if ($this->Session->read('Auth.Administrador.Rol.id') >= 3) {
			$clientes		= $this->Cliente->find('all',array(
				'joins' 			=> array(
					array(
			            'table' => 'administradores_clientes',
			            'alias' => 'AdminCliente',
			            'type'  => 'INNER',
			            'conditions' => array(
			                'AdminCliente.cliente_id = Cliente.id',
			                'AdminCliente.administrador_id' => $this->Auth->user('id')
			            )

		        	)
				),
				'order' => array('Cliente.activo DESC'),
				'conditions' => array('Cliente.activo' => 1)
			));

		}else{

			if ( $this->request->is('post') )
			{	
				if ( !isset($this->request->data['Filtro'])) {

					$clienteId = Hash::extract($this->request->data,'Cliente.{n}.id');

					$this->request->data['Administrador']['id'] = $this->request->data['Asignar']['asignados'];

					unset($this->request->data['Asignar']);

					/**
					* Buscamos relaciones del cliente
					*/
					$relaciones = $this->Cliente->AdministradoresCliente->find('all',array('conditions' => array('cliente_id' => $clienteId)));

					/**
					* Si tiene relaciones se actualizan, de lo contrario se crean
					*/
					if ($relaciones) {
						$this->Cliente->AdministradoresCliente->updateAll(array('administrador_id' => $this->request->data['Administrador']['id']),array('cliente_id' => $clienteId));
						$this->Session->setFlash('Clientes reasigandos.', null, array(), 'success');
						$this->redirect(array('action' => 'asignar'));

					}else{
						
						$idAdministrador = $this->request->data['Administrador']['id'];
						unset($this->request->data['AdministradorAnterior'],$this->request->data['Administrador'],$this->request->data['Cliente']);
						
						foreach ($clienteId as $indice => $registro) {
							$this->request->data[$indice]['AdministradoresCliente']['cliente_id'] = $registro;
							$this->request->data[$indice]['AdministradoresCliente']['administrador_id'] = $idAdministrador;
						}

						$this->Cliente->AdministradoresCliente->create();
						$this->Cliente->AdministradoresCliente->saveAll($this->request->data);
							
						$this->Session->setFlash('Asociación creada.', null, array(), 'success');
						$this->redirect(array('action' => 'asignar'));
					}
				

				}else{

					if ( $this->request->data['Filtro']['admines'] != null && $this->request->data['Filtro']['Rubro'] != null) {
						
						$clientes		= $this->Cliente->find('all',array(
							'joins' 			=> array(
								array(
						            'table' => 'administradores_clientes',
						            'alias' => 'AdminCliente',
						            'type'  => 'INNER',
						            'conditions' => array(
						                'AdminCliente.cliente_id = Cliente.id',
						                'AdminCliente.administrador_id' => $this->request->data['Filtro']['admines']
						            )

					        	)
							),
							'order' => array('Cliente.activo DESC'),
							'conditions' => array('Cliente.activo' => 1,'Cliente.rubro_id' => $this->request->data['Filtro']['Rubro']),
							'contain' 	=> array('Administrador')
						));
					}

					if ($this->request->data['Filtro']['admines'] != null && $this->request->data['Filtro']['Rubro'] == null) {
						$clientes		= $this->Cliente->find('all',array(
							'joins' 			=> array(
								array(
						            'table' => 'administradores_clientes',
						            'alias' => 'AdminCliente',
						            'type'  => 'INNER',
						            'conditions' => array(
						                'AdminCliente.cliente_id = Cliente.id',
						                'AdminCliente.administrador_id' => $this->request->data['Filtro']['admines']
						            )

					        	)
							),
							'order' => array('Cliente.activo DESC'),
							'conditions' => array('Cliente.activo' => 1),
							'contain' 	=> array('Administrador')
						));
					}

					if ($this->request->data['Filtro']['admines'] == null && $this->request->data['Filtro']['Rubro'] != null) {
						$clientes		= $this->Cliente->find('all',array(
							'order' => array('Cliente.activo DESC'),
							'conditions' => array('Cliente.activo' => 1,'Cliente.rubro_id' => $this->request->data['Filtro']['Rubro']),
							'contain' 	=> array('Administrador')
						));
					}

					if ($this->request->data['Filtro']['admines'] == null && $this->request->data['Filtro']['Rubro'] == null) {
						$clientes		= $this->Cliente->find('all',array(
							'order' => array('Cliente.activo DESC'),
							'conditions' => array('Cliente.activo' => 1),
							'contain' 	=> array('Administrador')
						));
					}
				}
			}else{

				$clientes = $this->Cliente->find('all',array(
					'order' => array('Cliente.activo DESC'),
					'conditions' => array('Cliente.activo' => 1),
					'contain' 	=> array('Administrador')
				));

			}

			$admines = $this->Cliente->Administrador->find('list',array('conditions' => array('activo' => 1,'rol_id BETWEEN 2 AND 3')));
			$rubros = $this->Cliente->Rubro->find('list');
			$asignados = $this->Cliente->Administrador->find('list',array('conditions' => array('activo' => 1,'rol_id BETWEEN 2 AND 3')));
			
		}
		
		$this->set(compact('clientes','admines','asignados','rubros'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{	
			/**
			*	Eliminar campos sin nombre
			*/
			if (isset($this->request->data['Contacto'])) {
				foreach ($this->request->data['Contacto'] as $index => $registro) {
					if (empty($registro['nombre'])) {
						unset($this->request->data['Contacto'][$index]);
					}
				}
			}

			if (isset($this->request->data['Inverison'])) {
				foreach ($this->request->data['Inverison'] as $index => $registro) {
					if (empty($registro['comentario'])) {
						unset($this->request->data['Inverison'][$index]);
					}
				}
			}

			if (isset($this->request->data['Sitio'])) {
				foreach ($this->request->data['Sitio'] as $index => $registro) {
					if (empty($registro['nombre'])) {
						unset($this->request->data['Sitio'][$index]);
					}
				}
			}
			
			if (isset($this->request->data['Servicio'])) {
				foreach ($this->request->data['Servicio'] as $index => $registro) {
					if (empty($registro['comentario'])) {
						unset($this->request->data['Servicio'][$index]);
					}
				}
			}

			if (isset($this->request->data['Calendario'])) {
				foreach ($this->request->data['Calendario'] as $index => $registro) {
					if (empty($registro['nombre'])) {
						unset($this->request->data['Calendario'][$index]);
					}
				}
			}

			$this->Cliente->create();
			if ( $this->Cliente->saveAll($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		$vendedores	= $this->Cliente->Vendedor->find('list');
		$rubros	= $this->Cliente->Rubro->find('list');
		$administradores	= $this->Cliente->Administrador->find('list',array('conditions' => array('rol_id BETWEEN 2 AND 3')));
		$this->set(compact('administradores','contactos','vendedores','rubros'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Cliente->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{	
			/**
			*	Eliminar campos sin nombre
			*/
			if (isset($this->request->data['Contacto'])) {
				foreach ($this->request->data['Contacto'] as $index => $registro) {
					if (empty($registro['nombre'])) {
						unset($this->request->data['Contacto'][$index]);
					}
				}
			}

			if (isset($this->request->data['Inverison'])) {
				foreach ($this->request->data['Inverison'] as $index => $registro) {
					if (empty($registro['comentario'])) {
						unset($this->request->data['Inverison'][$index]);
					}
				}
			}

			if (isset($this->request->data['Sitio'])) {
				foreach ($this->request->data['Sitio'] as $index => $registro) {
					if (empty($registro['nombre'])) {
						unset($this->request->data['Sitio'][$index]);
					}
				}
			}
			
			if (isset($this->request->data['Servicio'])) {
				foreach ($this->request->data['Servicio'] as $index => $registro) {
					if (empty($registro['comentario'])) {
						unset($this->request->data['Servicio'][$index]);
					}
				}
			}

			/**
			*	Eliminar e insertar nuevos
			*/
			$this->Cliente->Contacto->deleteAll(
                   array(
                           'Contacto.cliente_id' => $id,
                   )
           	);

           	$this->Cliente->Inverison->deleteAll(
                   array(
                           'Inverison.cliente_id' => $id,
                   )
           	);

           	$this->Cliente->Sitio->deleteAll(
                   array(
                           'Sitio.cliente_id' => $id,
                   )
           	);

           	$this->Cliente->Servicio->deleteAll(
                   array(
                           'Servicio.cliente_id' => $id,
                   )
           	);
           	
			if ( $this->Cliente->saveAll($this->request->data) )
			{
				$this->Session->setFlash('Registro editado correctamente', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		else
		{	
			$this->request->data	= $this->Cliente->find('first', array(
				'conditions'	=> array('Cliente.id' => $id),
				'contain'		=> array('Contacto','Inverison','Servicio','Sitio','Log' => array('Administrador'),'Calendario')
			));
		}
		$designados = $this->Cliente->find('first', array(
			'conditions' 	=> array('Cliente.id' => $id),
			'contain' 		=> array('Administrador')) );
		$vendedores	= $this->Cliente->Vendedor->find('list');
		$rubros	= $this->Cliente->Rubro->find('list');
		$administradores	= $this->Cliente->Administrador->find('list',array('conditions' => array('rol_id BETWEEN 2 AND 3')));
		$this->set(compact('administradores','contactos','designados','vendedores','rubros'));
	}


	public function admin_desactivar($id = null)
	{
		$this->Cliente->id = $id;
		if ( ! $this->Cliente->exists() )
		{
			$this->Session->setFlash('Cliente inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		
		if ( $this->Cliente->saveField('activo', 0) )
		{
			$this->Session->setFlash('Cliente desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al desactivar el cliente. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}


	public function admin_activar($id = null)
	{
		$this->Cliente->id = $id;
		if ( ! $this->Cliente->exists() )
		{
			$this->Session->setFlash('Cliente inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		
		if ( $this->Cliente->saveField('activo', 1) )
		{
			$this->Session->setFlash('Cliente activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el Cliente. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_delete($id = null)
	{
		$this->Cliente->id = $id;
		if ( ! $this->Cliente->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Cliente->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Cliente->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Cliente->_schema);
		$modelo			= $this->Cliente->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}


	/**
	
		Obtiene e imprime el calendario para los clientes.
	
	*/
	public function getCalendar($id){
		$this->request->data	= $this->Cliente->find('first', array(
				'conditions'	=> array('Cliente.id' => $id),
				'contain'		=> array('Calendario')
			));
		$this->layout = 'ajax';
	}


	/**
	
		Genera un Json con el total de clientes por meses.
	
	*/
	public function admin_getClientHistory( $cantidadMeses ){

		$arrayMeses = array(
			array('numero' => 01,'nombre' 	=> 'Enero','cantidad' 		=> 0),
			array('numero' => 02,'nombre' 	=> 'Febrero','cantidad'  	=> 0),
			array('numero' => 03,'nombre' 	=> 'Marzo','cantidad'  		=> 0),
			array('numero' => 04,'nombre' 	=> 'Abril','cantidad'  		=> 0),
			array('numero' => 05,'nombre' 	=> 'Mayo','cantidad'  		=> 0),
			array('numero' => 06,'nombre' 	=> 'Junio','cantidad'  		=> 0),
			array('numero' => 07,'nombre' 	=> 'Julio','cantidad'  		=> 0),
			array('numero' => 08,'nombre' 	=> 'Agosto','cantidad'  	=> 0),
			array('numero' => 09,'nombre' 	=> 'Septiembre','cantidad' 	=> 0),
			array('numero' => 10,'nombre' 	=> 'Octubre','cantidad' 	=> 0),
			array('numero' => 11,'nombre' 	=> 'Noviembre','cantidad' 	=> 0),
			array('numero' => 12,'nombre' 	=> 'Diciembre','cantidad' 	=> 0)
		);
		
		$fechas = ultimosMeses($cantidadMeses);
		
		$arrayData = array();
		
		foreach ($fechas as $indixe => $fecha) :
			
			$mesOperacional	= $fecha['inicio'];
			
			foreach ($arrayMeses as $mes) {
				if ($mesOperacional == $mes['numero']) {
					$mesNombre = $mes['nombre'];
				}
			}

			$totalClientes 		= $this->Cliente->find('all', array(
				'conditions'		=> array(
					'Cliente.creado >='			=> sprintf('%s 00:00:00', $fecha['inicio']),
					'Cliente.creado <='			=> sprintf('%s 23:59:59', $fecha['fin']),
					'Cliente.activo'		=> 1
				),
				'fields'			=> array(
					'COUNT(Cliente.id) AS total'
				)
			));

			$totalClientes = ( ! empty($totalClientes[0][0]['total']) ? $totalClientes[0][0]['total'] : 0 );
			
			// Esta varibale representa los valores del eje Y dela grafica
			$datoCliente['total'] = $totalClientes;
			
			// Esta varibale representa los valores del eje X de la grafica
			$datoCliente['fecha'] = $mesOperacional;

			array_push($arrayData,$datoCliente);

		endforeach;

		$this->layout		= 'ajax';
		
		$this->set(compact('arrayData'));
	}

	

	/**
	
		Perfil del cliente
	
	*/
	public function admin_perfil($id = null ) {

		$this->Cliente->id = $id;
		if ( ! $this->Cliente->exists() )
		{
			$this->Session->setFlash('Cliente no existe.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		
		$cliente = $this->Cliente->find('first',array(
			'conditions' => array('Cliente.id' => $id),
			'contain'	=> array(
				'Vendedor',
				'Rubro',
				'Administrador',
				'Inverison',
				'Servicio',
				'Sitio',
				'Contacto',
				'Log' => array('Administrador'))));

		//prx($cliente);
		$this->set(compact('cliente'));

	}

}
