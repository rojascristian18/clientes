<?php
App::uses('AppController', 'Controller');
class RubrosController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$rubros	= $this->paginate();
		$this->set(compact('rubros'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Rubro->create();
			if ( $this->Rubro->save($this->request->data) )
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
		if ( ! $this->Rubro->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Rubro->save($this->request->data) )
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
			$this->request->data	= $this->Rubro->find('first', array(
				'conditions'	=> array('Rubro.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->Rubro->id = $id;
		if ( ! $this->Rubro->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Rubro->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Rubro->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Rubro->_schema);
		$modelo			= $this->Rubro->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}
}
