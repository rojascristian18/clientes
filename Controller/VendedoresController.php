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
}
