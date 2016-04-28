<?php
App::uses('AppController', 'Controller');
class CalendariosController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$calendarios	= $this->paginate();
		$this->set(compact('calendarios'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Calendario->create();
			if ( $this->Calendario->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		$clientes	= $this->Calendario->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Calendario->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Calendario->save($this->request->data) )
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
			$this->request->data	= $this->Calendario->find('first', array(
				'conditions'	=> array('Calendario.id' => $id)
			));
		}
		$clientes	= $this->Calendario->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_delete($id = null)
	{
		$this->Calendario->id = $id;
		if ( ! $this->Calendario->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Calendario->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Calendario->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Calendario->_schema);
		$modelo			= $this->Calendario->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}


	public function getEventById($id){
		$this->request->data = $this->Calendario->find('first',array('conditions' => array('Calendario.id' => $id),'contain' => 'Cliente'));
		$clientes	= $this->Calendario->Cliente->find('list');
		$this->layout = 'ajax';
		$this->set(compact('clientes'));
	}


	public function saveEventById(){
		$id = $this->request->data['id'];
		$this->request->data['Calendario']['id'] = $this->request->data['id'];
		$this->request->data['Calendario']['nombre'] = $this->request->data['nombre'];
		$this->request->data['Calendario']['observacion'] = $this->request->data['observacion'];
		
		if ( ! $this->Calendario->exists($id) )
		{
			echo "<h3 class='text-warning'>El evento no existe</h3>";
			exit;
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Calendario->save($this->request->data) )
			{
				echo "<h3 class='text-success'>Guardado</h3>";
				exit;
			}
			else
			{
				echo "<h3 class='text-warning'>Error al guardar</h3>";
				exit;
			}
		}
		
	}

	public function addEvent(){
		if ( $this->request->is('post') )
		{	
			$this->request->data['Calendario']['cliente_id'] = $this->request->data['cliente'];
			$this->request->data['Calendario']['nombre'] = $this->request->data['nombre'];
			$this->request->data['Calendario']['dia'] = $this->request->data['dia'];
			$this->request->data['Calendario']['semana'] = $this->request->data['semana'];
			$this->request->data['Calendario']['observacion'] = $this->request->data['observacion'];

			$this->Calendario->create();
			if ( $this->Calendario->save($this->request->data) )
			{
				echo "<h3 class='text-success'>Guardado</h3>";
				exit;
			}
			else
			{
				echo "<h3 class='text-warning'>Error al guardar</h3>";
				exit;
			}
		}
		
		$idCliente 	= $_GET['cliente'];
		$semana 	= $_GET['semana'];
		$dia		= $_GET['dia'];
		$this->layout = 'ajax';
		$clientes	= $this->Calendario->Cliente->find('list');
		$this->set(compact('clientes','idCliente','semana','dia'));
	}
	
}
