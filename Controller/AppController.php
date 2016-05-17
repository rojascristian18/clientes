<?php
App::uses('Controller', 'Controller');
//App::uses('FB', 'Facebook.Lib');
class AppController extends Controller
{
	public $helpers		= array(
		'Session', 'Html', 'Form', 'PhpExcel'
		//, 'Facebook.Facebook'
	);
	public $components	= array(
		'Session',
		'Auth'		=> array(
			'loginAction'		=> array('controller' => 'administradores', 'action' => 'login', 'admin' => true),
			'loginRedirect'		=> '/admin',
			'logoutRedirect'	=> '/admin',
			'authError'			=> 'No tienes permisos para entrar a esta sección.',
			'authenticate'		=> array(
				'Form'				=> array(
					'userModel'			=> 'Usuario',
					'fields'			=> array(
						'username'			=> 'email',
						'password'			=> 'clave'
					),
					'scope'		=>	array('Administrador.activo' => 1)
				)
			)
		),
		'DebugKit.Toolbar',
		'Google'		=> array(
			'applicationName'		=> 'Sistema Brandon',
			'developerKey'			=> 'cristian.rojas@brandon.cl',
			'clientId'				=> '940098568661-eugvnkatiq01cj679cur3c8f2dfa0if2.apps.googleusercontent.com',
			'clientSecret'			=> 'VYcBpJdXvtXZd9C5GDxoSDl1',
			//'redirectUri'			=> Router::url(array('controller' => 'administradores', 'action' => 'google', 'admin' => false), true)),
			'approvalPrompt'		=> 'auto',
			'accessType'			=> null,//'offline',
			'scopes'				=> array('profile', 'email')
		)
		//'Facebook.Connect'	=> array('model' => 'Usuario'),
		//'Facebook'
	);

	public function beforeFilter()
	{
		/**
		 * Layout administracion y permisos publicos
		 */
		if ( ! empty($this->request->params['admin']) )
		{
			$this->layoutPath				= 'backend';
			AuthComponent::$sessionKey		= 'Auth.Administrador';
			$this->Auth->authenticate['Form']['userModel']		= 'Administrador';
		}
		else
		{
			AuthComponent::$sessionKey	= 'Auth.Usuario';
			$this->Auth->allow();
		}

		/**
		 * Logout FB
		 */
		/*
		if ( ! isset($this->request->params['admin']) && ! $this->Connect->user() && $this->Auth->user() )
			$this->Auth->logout();
		*/

		/**
		 * Detector cliente local
		 */
		$this->request->addDetector('localip', array(
			'env'			=> 'REMOTE_ADDR',
			'options'		=> array('::1', '127.0.0.1'))
		);

		/**
		 * Detector entrada via iframe FB
		 */
		$this->request->addDetector('iframefb', array(
			'env'			=> 'HTTP_REFERER',
			'pattern'		=> '/facebook\.com/i'
		));


		/**
		 * OAuth Google
		 */
		$this->Google->cliente->setRedirectUri(Router::url(array('controller' => 'administradores', 'action' => 'login'), true));
		$this->Google->oauth();

		if ( ! empty($this->request->query['code']) && $this->Session->read('Google.code') != $this->request->query['code'] )
		{
			$this->Google->oauth->authenticate($this->request->query['code']);
			$this->Session->write('Google', array(
				'code'		=> $this->request->query['code'],
				'token'		=> $this->Google->oauth->getAccessToken()
			));
		}

		if ( $this->Session->check('Google.token') )
		{
			$this->Google->cliente->setAccessToken($this->Session->read('Google.token'));
		}

		/**
		 * Cookies IE
		 */
		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

		/**
		*	Funciones personalizadas
		*/
		$modulosDisponibles = $this->getModuleByRole();
		$totalActivos		= $this->obtenerClientesActivos();
		$totalDesactivos	= $this->obtenerClientesInactivos();
		$totalClientes		= $this->obtenerClientes();
		$totalNuevos		= $this->obtenerClientesNuevos();
		$clienteAdmin 		= $this->obtenerClientesAdministrador();
		$vendedorClientes 	= $this->obtenerVendedorClientes();
		$avatar 			= $this->obtenerAvatar();
		$this->set(compact('modulosDisponibles','totalActivos','totalDesactivos','totalClientes','totalNuevos','clienteAdmin','avatar','vendedorClientes'));
	}

	/**
	 * Guarda el usuario Facebook
	 */
	public function beforeFacebookSave()
	{
		if ( ! isset($this->request->params['admin']) )
		{
			$this->Connect->authUser['Usuario']		= array_merge(array(
				'nombre_completo'	=> $this->Connect->user('name'),
				'nombre'			=> $this->Connect->user('first_name'),
				'apellido'			=> $this->Connect->user('last_name'),
				'usuario'			=> $this->Connect->user('username'),
				'clave'				=> $this->Connect->authUser['Usuario']['password'],
				'email'				=> $this->Connect->user('email'),
				'sexo'				=> $this->Connect->user('gender'),
				'verificado' 		=> $this->Connect->user('verified'),
				'edad'				=> $this->Session->read('edad')
			), $this->Connect->authUser['Usuario']);
		}

		return true;
	}


	/**

		Retorna todos los módulos por usuario.

	*/
	public function getModuleByRole(){
		$this->Modulo = $this->instanceModel( 'Modulo' );

		$modulos = $this->Modulo->find('all', array('conditions' => array('parent_id' => 0) ));
			$data = array();
			foreach ($modulos as $padre) {
				$data[] = array(
					'nombre' => $padre['Modulo']['nombre'],
					'hijos' => $this->Modulo->find(
						'all', array(
							'conditions' => array('Modulo.parent_id' => $padre['Modulo']['id'] ),
							'contain' => array('Rol'),
							'joins' => array(
								array(
									'table' => 'modulos_roles',
						            'alias' => 'md',
						            'type'  => 'INNER',
						            'conditions' => array(
						                'md.modulo_id = Modulo.id',
						                'md.rol_id' => $this->Session->read('Auth.Administrador.rol_id')
						            )
								)
							)
						)
					)
				);
		}

		return $data;
	}

	/**

		Obtener avatar

	*/
	private function obtenerAvatar(){
		$this->Administrador = $this->instanceModel('Administrador');
		return $this->Administrador->find('first',array('fields' => array('google_imagen'), 'conditions' => array('id' => $this->Session->read('Auth.Administrador.id'))));
	}

	/**

		Obtener clientes activos

	*/
	private function obtenerClientesActivos(){
		$this->Cliente = $this->instanceModel('Cliente');
		return $this->Cliente->find('count',array('conditions' => array('activo' => 1)));
	}


	/**

		Obtener clientes inactivos

	*/
	private function obtenerClientesInactivos(){
		$this->Cliente = $this->instanceModel('Cliente');
		return $this->Cliente->find('count',array('conditions' => array('activo' => 0)));
	}


	/**

		Obtener total clientes por vendedor

	*/
	private function obtenerVendedorClientes(){
		$this->Vendedor = $this->instanceModel('Vendedor');
		return $this->Vendedor->find('all',array(
			'conditions' => array('activo' => 1),
			'contain'	=> array('Cliente' => array('conditions' => array('activo' => 1)))
			)
		);
	}


	/**

		Obtener total clientes

	*/
	private function obtenerClientes(){
		$this->Cliente = $this->instanceModel('Cliente');
		return $this->Cliente->find('count');
	}


	/**

		Obtener total clientes

	*/
	private function obtenerClientesNuevos(){
		$this->Cliente = $this->instanceModel('Cliente');
		return $this->Cliente->find('count',array('conditions' => array('creado >=' => date('Y-m'))));
	}


	/**

		Obtener total clientes por Administrador

	*/
	private function obtenerClientesAdministrador(){
		$this->Administrador = $this->instanceModel('Administrador');
		return $this->Administrador->find('all',array('contain' => array('Cliente'),'conditions' => array('rol_id' => 3,'activo' => 1)));
	}


	/**

		Instanciar un modelo.
		
	*/
	protected function instanceModel( $model ){
		return ClassRegistry::init( $model );
	}
}
