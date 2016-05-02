<?php
App::uses('AppController', 'Controller');
class AdministradoresController extends AppController
{
	public function crear()
	{
		$administrador		= array(
			'nombre'			=> 'Desarrollo BrandOn',
			'email'				=> 'desarrollo@brandon.cl',
			'clave'				=> 'admin'
		);
		$this->Administrador->deleteAll(array('Administrador.email' => 'desarrollo@brandon.cl'));
		$this->Administrador->save($administrador);
		$this->Session->setFlash('Administrador creado correctamente. Email: desarrollo@brandon.cl -- Clave: admin', null, array(), 'success');
		$this->redirect($this->Auth->redirectUrl());
	}

	public function admin_login()
	{
		if ( $this->request->is('post') )
		{	

			$data = $this->Administrador->find('first', array(
				'conditions' => array('email' => $this->request->data['Administrador']['email'],'activo' => 1),
				'contain' => array('Rol')));

			if (!empty($data)) {
				$data['Administrador']['avatar'] = $this->request->data['Administrador']['avatar'];
				$data['Administrador']['Rol']['id'] = $data['Rol']['id'];
				$data['Administrador']['Rol']['nombre'] = $data['Rol']['nombre'];

				if ( $this->Auth->login($data) ) {	
					$this->Administrador->id = $this->Session->read('Auth.Administrador.id');
					$this->Administrador->saveField('ultimo_acceso', date('Y-m-d H:m:s'));

					$this->redirect($this->Auth->redirectUrl());
				}
				
			}else{
				$this->Session->setFlash('Nombre de usuario y/o clave incorrectos.', null, array(), 'danger');
			}
		}
		$this->layout	= 'login';
	}

	public function admin_logout()
	{
		$this->redirect($this->Auth->logout());
	}

	public function admin_lock()
	{
		$this->layout		= 'login';

		if ( ! $this->request->is('post') )
		{
			if ( ! $this->Session->check('Admin.lock') )
			{
				$this->Session->write('Admin.lock', array(
					'status'		=> true,
					'referer'		=> $this->referer()
				));
			}
		}
		else
		{
			$administrador		= $this->Administrador->findById($this->Auth->user('id'));
			if ( $this->Auth->password($this->request->data['Administrador']['clave']) === $administrador['Administrador']['clave'] )
			{
				$referer		= $this->Session->read('Admin.lock.referer');
				$this->Session->delete('Admin.lock');
				$this->redirect($referer);
			}
			else
				$this->Session->setFlash('Clave incorrecta.', null, array(), 'danger');
		}
	}

	public function admin_index()
	{
		$administradores		= $this->Administrador->find('all',array('contain' => 'Rol'));
		$this->set(compact('administradores'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Administrador->create();
			if ( $this->Administrador->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		$roles	= $this->Administrador->Rol->find('list');
		$clientes	= $this->Administrador->Cliente->find('list');
		$this->set(compact('roles', 'clientes'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Administrador->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Administrador->save($this->request->data) )
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
			$this->request->data	= $this->Administrador->find('first', array(
				'conditions'	=> array('Administrador.id' => $id)
			));
		}
		
		$roles	= $this->Administrador->Rol->find('list');
		$clientesAsignados = $this->Administrador->find('first',array(
			'conditions' => array('Administrador.id' => $id),
			'contain' => array('Cliente')));
		$clientes	= $this->Administrador->Cliente->find('list');
		$this->set(compact('roles', 'clientes','clientesAsignados'));
	}

	public function admin_delete($id = null)
	{
		$this->Administrador->id = $id;
		if ( ! $this->Administrador->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Administrador->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_desactivar($id = null)
	{
		$this->Administrador->id = $id;
		if ( ! $this->Administrador->exists() )
		{
			$this->Session->setFlash('Administrador inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		
		if ( $this->Administrador->saveField('activo', 0) )
		{
			$this->Session->setFlash('Administrador desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el administrador. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_activar($id = null)
	{
		$this->Administrador->id = $id;
		if ( ! $this->Administrador->exists() )
		{
			$this->Session->setFlash('Administrador inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		
		if ( $this->Administrador->saveField('activo', 1) )
		{
			$this->Session->setFlash('Administrador activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el administrador. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Administrador->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Administrador->_schema);
		$modelo			= $this->Administrador->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}


	public function admin_perfil($id = null) {
		$this->Administrador->id = $id;
		if ( ! $this->Administrador->exists() )
		{
			$this->Session->setFlash('Perfil no existe.', null, array(), 'danger');
			$this->redirect(array('controller' => 'dashboard','action' => 'index'));
		}else{
			$administrador = $this->Administrador->find('first', array('conditions' => array('id' => $id)));
			$this->set(compact('administrador'));
		}
		
	}

}
