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
			AuthComponent::$sessionKey		= 'Auth';
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
		 * Cookies IE
		 */
		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

		/**
		*	Funciones personalizadas
		*/
		$modulosDisponibles = $this->getModuleByRole();
		$this->set(compact('modulosDisponibles'));
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

		Instanciar un modelo.
		
	*/
	private function instanceModel( $model ){
		return ClassRegistry::init( $model );
	}
}
