<?php
App::uses('AppController', 'Controller');
class VendedoresController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$vendedores	= $this->paginate();
		$this->set(compact('vendedores'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Vendedor->create();
			if ( $this->Vendedor->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Vendedor->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Vendedor->save($this->request->data) )
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
			$this->request->data	= $this->Vendedor->find('first', array(
				'conditions'	=> array('Vendedor.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->Vendedor->id = $id;
		if ( ! $this->Vendedor->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Vendedor->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Vendedor->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Vendedor->_schema);
		$modelo			= $this->Vendedor->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}


	/**
	
		Genera un Json con el total de clientes por vendedor durante X meses.
	
	*/
	public function admin_getSalesmanHistory( $cantidadMeses ){

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

		$ykeys = array();
		
		foreach ($fechas as $indixe => $fecha) :
			
			$mesOperacional	= $fecha['inicio'];
			
			foreach ($arrayMeses as $mes) {
				if ($mesOperacional == $mes['numero']) {
					$mesNombre = $mes['nombre'];
				}
			}

			$totalClientes 		= $this->Vendedor->find('all', array(
				'contain' => array(
					'Cliente' => array(
						'conditions'		=> array(
							'Cliente.creado >='			=> sprintf('%s 00:00:00', $fecha['inicio']),
							'Cliente.creado <='			=> sprintf('%s 23:59:59', $fecha['fin']),
							'Cliente.activo'		=> 1
						)
					)
				),
				'conditions'				=> array('Vendedor.activo' => 1)
			)
			);
			
			foreach ($totalClientes as $indice => $clientes) {
				$totalClientes = ( ! empty($clientes['Cliente']) ? count($clientes['Cliente']) : 0 );
				$identificador = strtolower(Inflector::slug($clientes['Vendedor']['nombre'], $replacement = ''));

				// Esta varibale representa los valores del eje Y dela grafica
				$datoCliente[$identificador] = $totalClientes;
			}

			// Esta varibale representa los valores del eje X de la grafica
			$datoCliente['fecha'] = $mesOperacional;

			array_push($arrayData,$datoCliente);

		endforeach;

		$this->layout		= 'ajax';
		
		$this->set(compact('arrayData'));

	}
}
