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
		/**
		 * Login normal
		 */
		if ( $this->request->is('post') )
		{
			if ( $this->Auth->login() )
			{
				$this->Session->delete('Google.token');
				$this->redirect($this->Auth->redirectUrl());
			}
			else
			{
				$this->Session->setFlash('Nombre de usuario y/o clave incorrectos.', null, array(), 'danger');
			}
		}

		/**
		 * Login con sesion Google
		 */
		if ( $this->Session->check('Google.token') )
		{
			/**
			 * Si el usuario ya tiene sesion de cake activa, lo redirecciona
			 */
			if ( $this->Auth->user() )
			{
				$this->redirect('/');
			}

			/**
			 * Obtiene los datos del usuario
			 */
			$google			= $this->Session->read('Google');
			$this->Google->plus();
			$me				= null;

			/**
			 * Si no obtiene los datos del usuario es porque el token fue invalidado
			 */
			try
			{
				$me				= $this->Google->plus->people->get('me');
			}
			catch ( Exception $e )
			{	
				$this->Auth->logout();
				$this->Session->setFlash('Tu sesión ha expirado. Por favor ingresa nuevamente.', null, array(), 'success');
			}

			/**
			 * Con los datos del usuario google, intenta autenticarlo
			 */

			if ( $me )
			{
				$emails			= $me->getEmails();

				/**
				 * Verificamos que tenemos el email
				 */
				if ( empty($me->getEmails()) )
				{
					$this->Session->setFlash('No tienes acceso a esta aplicación.', null, array(), 'danger');
				}
				else
				{
					/**
					 * Verificamos que exista el usuario en la DB y esté activo
					 */
					$administrador			= $this->Administrador->find('first', array(
						'conditions'			=> array('Administrador.email' => $emails[0]->value),
						'contain'				=> array('Rol')
					));

					if ( ! $administrador || ! $administrador['Administrador']['activo'] )
					{
						$this->Session->setFlash('No tienes acceso a esta aplicación.', null, array(), 'danger');
					}
					else
					{	
						/**
						 * Si no tiene google_id, es primera vez que entra. Actualiza datos
						 */
						if ( ! $administrador['Administrador']['google_id'] )
						{
							$usuario		= array_merge($administrador['Administrador'], array(
								'google_id'			=> $me->getId(),
								'google_dominio'	=> $me->getDomain(),
								'google_nombre'		=> $me->getName()->givenName,
								'google_apellido'	=> $me->getName()->familyName,
								'google_imagen'		=> $me->getImage()->url
							));

							unset($usuario['clave']);
							$this->Administrador->id = $usuario['id'];
							$this->Administrador->save($usuario);
						}

						/**
						 * Normaliza los datos segun AuthComponent::identify
						 */
						$administrador['Administrador']['Rol'] = $administrador['Rol'];
						$administrador = $administrador['Administrador'];

						/**
						 * Logea al usuario y lo redirecciona
						 */
			
						$this->Auth->login($administrador);
						$this->Administrador->id = $administrador['id'];
						$this->Administrador->save(array('ultimo_acceso' => date('Y-m-d H:m:s')));
						$this->redirect($this->Auth->redirectUrl());
					}
				}
			}
		}


		/**
		 * Inicializa y configura el cliente Google
		 */
		$authUrl			= $this->Google->cliente->createAuthUrl();
		$this->set(compact('authUrl'));

		$this->layout	= 'login';
	}

	public function admin_logout()
	{	
		$this->Session->delete('Google.token');
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
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{	

			if ( $this->Administrador->save($this->request->data) )
			{
				$this->Session->setFlash('Registro editado correctamente', null, array(), 'success');
				$this->redirect(array('action' => 'perfil',$id));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}

		}else{

			$this->request->data	= $this->Administrador->find('first', array(
				'conditions'	=> array('id' => $id)
			));
			
		}	

			$administrador = $this->Administrador->find('first', array('conditions' => array('id' => $id)));
			$this->set(compact('administrador'));
		
		
	}

	public function admin_savepass($id = null) {
		
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
		
	}

}
