<?php
App::uses('AppController', 'Controller');
class ClientesController extends AppController
{
	public function admin_index()
	{
		if ($this->Session->read('Auth.Administrador.Rol.id') == 3) {
			$this->paginate		= array(
				'recursive'			=> 0,
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
				)
			);
		}else{
			$this->paginate		= array(
				'recursive'			=> 0
			);
		}
		$clientes	= $this->paginate();
		$this->set(compact('clientes'));
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
		$administradores	= $this->Cliente->Administrador->find('list');
		$this->set(compact('administradores','contactos'));
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
		$administradores	= $this->Cliente->Administrador->find('list');
		$this->set(compact('administradores','contactos','designados'));
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
}
