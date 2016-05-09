<?php
App::uses('AppController', 'Controller');
class ClientesController extends AppController
{
	public function admin_index()
	{	
		if ($this->Session->read('Auth.Administrador.Rol.id') == 3) {
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
				'order' => array('activo DESC')
			));
		}else{
			$clientes	= $this->Cliente->find('all',array('order' => array('activo DESC')));
		}
		
		$this->set(compact('clientes'));
	}

	public function admin_asignar()
	{
		if ($this->Session->read('Auth.Administrador.Rol.id') == 3) {
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

					/*$this->Cliente->AdministradoresCliente->deleteAll(
						array('administrador_id' => $this->request->data['Administrador']['id'],
							'cliente_id' => $clienteId));
					*/
					$this->Cliente->AdministradoresCliente->updateAll(array('administrador_id' => $this->request->data['Administrador']['id']),array('cliente_id' => $clienteId));
					
					$this->Session->setFlash('Clientes reasigandos.', null, array(), 'success');
					$this->redirect(array('action' => 'asignar'));

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

			$admines = $this->Cliente->Administrador->find('list',array('condtions' => array('activo' => 1)));
			$rubros = $this->Cliente->Rubro->find('list');
			$asignados = $this->Cliente->Administrador->find('list',array('condtions' => array('activo' => 1)));
			
		}
		
		$this->set(compact('clientes','admines','asignados','rubros'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{	
			/**
			*	Eliminar Contacto si nombre
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
		$administradores	= $this->Cliente->Administrador->find('list');
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
			*	Eliminar array vacio
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
		$administradores	= $this->Cliente->Administrador->find('list');
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

	public function getCalendar($id){
		$this->request->data	= $this->Cliente->find('first', array(
				'conditions'	=> array('Cliente.id' => $id),
				'contain'		=> array('Calendario')
			));
		$this->layout = 'ajax';
	}

	public function admin_getClientHistory(){
		$clientes = $this->Cliente->query("SELECT COUNT(id),MONTH(creado),nombre FROM tb_clientes WHERE activo=1 GROUP BY MONTH(creado)");
		$arrayMeses = array(
			array('numero' => 1,'nombre' 	=> 'Enero'),
			array('numero' => 2,'nombre' 	=> 'Febrero'),
			array('numero' => 3,'nombre' 	=> 'Marzo'),
			array('numero' => 4,'nombre' 	=> 'Abril'),
			array('numero' => 5,'nombre' 	=> 'Mayo'),
			array('numero' => 6,'nombre' 	=> 'Junio'),
			array('numero' => 7,'nombre' 	=> 'Julio'),
			array('numero' => 8,'nombre' 	=> 'Agosto'),
			array('numero' => 9,'nombre' 	=> 'Septiembre'),
			array('numero' => 10,'nombre' 	=> 'Octubre'),
			array('numero' => 11,'nombre' 	=> 'Noviembre'),
			array('numero' => 12,'nombre' 	=> 'Diciembre')
		);

		foreach ($arrayMeses as $indixe => $registro) {
			foreach ($clientes as $key => $value) {
				if ($value[$key]['MONTH(creado)'] == $registro['numero']) {
					echo $value['tb_clientes']['nombre'];
					echo $registro['numero'];
				}
			}
		}

		prx($clientes);
	}


	/**
	*	Perfil del cliente
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
