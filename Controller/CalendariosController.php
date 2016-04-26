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
}
