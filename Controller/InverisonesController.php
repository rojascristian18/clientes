<?php
App::uses('AppController', 'Controller');
class InverisonesController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$inverisones	= $this->paginate();
		$this->set(compact('inverisones'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Inverison->create();
			if ( $this->Inverison->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		$clientes	= $this->Inverison->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Inverison->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Inverison->save($this->request->data) )
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
			$this->request->data	= $this->Inverison->find('first', array(
				'conditions'	=> array('Inverison.id' => $id)
			));
		}
		$clientes	= $this->Inverison->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_delete($id = null)
	{
		$this->Inverison->id = $id;
		if ( ! $this->Inverison->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Inverison->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Inverison->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Inverison->_schema);
		$modelo			= $this->Inverison->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}
}
