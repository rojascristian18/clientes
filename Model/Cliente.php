<?php
App::uses('AppModel', 'Model');
class Cliente extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField	= 'nombre';

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
        'email' => array(
			'validar_email' => array(
				'rule'			=> array('email'),
				'required'		=> true,
				'message'		=> 'Ingrese un email válido',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'fono' => array(
			'validar_fono_min' => array(
				'rule'			=> array('minLength',8),
				'required'		=> true,
				'message'		=> 'Ingrese un fono válido',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
			'validar_fono_max' => array(
				'rule'			=> array('maxLength',12),
				'required'		=> true,
				'message'		=> 'Ingrese un fono válido',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
			'validar_numero' => array(
				'rule'			=> 'numeric',
				'required'		=> true,
				'message'		=> 'Ingrese un solo números',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			)
		),
    );

	/**
	 * ASOCIACIONES
	 */
	public $hasMany = array(
		'Calendario' => array(
			'className'				=> 'Calendario',
			'foreignKey'			=> 'cliente_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		),
		'Contacto' => array(
			'className'				=> 'Contacto',
			'foreignKey'			=> 'cliente_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		),
		'Inverison' => array(
			'className'				=> 'Inverison',
			'foreignKey'			=> 'cliente_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		),
		'Servicio' => array(
			'className'				=> 'Servicio',
			'foreignKey'			=> 'cliente_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		),
		'Sitio' => array(
			'className'				=> 'Sitio',
			'foreignKey'			=> 'cliente_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		),
		'Log' => array(
			'className'				=> 'Log',
			'foreignKey'			=> 'cliente_id',
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
		'Administrador' => array(
			'className'				=> 'Administrador',
			'joinTable'				=> 'administradores_clientes',
			'foreignKey'			=> 'cliente_id',
			'associationForeignKey'	=> 'administrador_id',
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
}
