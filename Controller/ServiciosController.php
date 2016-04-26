<?php
App::uses('AppController', 'Controller');
class ServiciosController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$servicios	= $this->paginate();
		$this->set(compact('servicios'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Servicio->create();
			if ( $this->Servicio->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		$clientes	= $this->Servicio->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Servicio->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Servicio->save($this->request->data) )
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
			$this->request->data	= $this->Servicio->find('first', array(
				'conditions'	=> array('Servicio.id' => $id)
			));
		}
		$clientes	= $this->Servicio->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_delete($id = null)
	{
		$this->Servicio->id = $id;
		if ( ! $this->Servicio->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Servicio->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Servicio->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Servicio->_schema);
		$modelo			= $this->Servicio->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}
}
