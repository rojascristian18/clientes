<?php
App::uses('AppModel', 'Model');
class Administrador extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	var $displayField = "nombre";
	/**
	 * BEHAVIORS
	 */
	var $actsAs			= array(
		/**
		 * IMAGE UPLOAD
		 */
		/*
		'Image'		=> array(
			'fields'	=> array(
				'imagen'	=> array(
					'versions'	=> array(
						array(
							'prefix'	=> 'mini',
							'width'		=> 100,
							'height'	=> 100,
							'crop'		=> true
						)
					)
				)
			)
		)
		*/
	);

	/**
	 * VALIDACIONES
	 */
	public $validate = array(
		'repetir_clave' => array(
			'repetirClave' => array(
				'rule'			=> array('repetirClave'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'repetir_clave_nueva' => array(
			'repetirClaveNueva' => array(
				'rule'			=> array('repetirClaveNueva'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
	);

	/**
	 * ASOCIACIONES
	 */
	public $belongsTo = array(
		'Rol' => array(
			'className'				=> 'Rol',
			'foreignKey'			=> 'rol_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> true,
			//'counterScope'			=> array('Asociado.modelo' => 'Roles')
		)
	);
	public $hasMany = array(
		'Log' => array(
			'className'				=> 'Log',
			'foreignKey'			=> 'administrador_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		)
	);
	public $hasAndBelongsToMany = array(
		'Cliente' => array(
			'className'				=> 'Cliente',
			'joinTable'				=> 'administradores_clientes',
			'foreignKey'			=> 'administrador_id',
			'associationForeignKey'	=> 'cliente_id',
			'unique'				=> true,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'finderQuery'			=> '',
			'deleteQuery'			=> '',
			'insertQuery'			=> ''
		)
	);

	/**
	 * CALLBACKS
	 */
	public function beforeSave($options = array())
	{
		if ( isset($this->data[$this->alias]['clave']) )
		{
			if ( trim($this->data[$this->alias]['clave']) == false )
			{
				unset($this->data[$this->alias]['clave'], $this->data[$this->alias]['repetir_clave']);
			}
			else
			{
				$this->data[$this->alias]['clave']	= AuthComponent::password($this->data[$this->alias]['clave']);
			}
		}

		if ( isset($this->data[$this->alias]['clave_nueva']) )
		{
			if ( trim($this->data[$this->alias]['clave_nueva']) == false )
			{
				unset($this->data[$this->alias]['clave_nueva'], $this->data[$this->alias]['repetir_clave_nueva']);
			}
			else
			{
				$this->data[$this->alias]['clave_nueva']	= AuthComponent::password($this->data[$this->alias]['clave_nueva']);
			}
		}

		if (isset($this->data[$this->alias]['clave_actual'])) {

			$claveActual = AuthComponent::password($this->data[$this->alias]['clave_actual']);
			$claveRegistrada = $this->getClaveActual($this->data[$this->alias]['id']);

			if ($claveActual == $claveRegistrada) {
				$this->data[$this->alias]['clave'] = $this->data[$this->alias]['clave_nueva'];
				unset($this->data[$this->alias]['clave_actual'],$this->data[$this->alias]['clave_nueva'],$this->data[$this->alias]['repetir_clave_nueva']);
			}else{
				return false;
			}
		}

		return true;
	}


	public function getClaveActual($id){
		$clave = $this->find('first',array('fields' => array('clave'),'conditions' => array('id' => $id)));
		return $clave[$this->alias]['clave'];
	}
}
