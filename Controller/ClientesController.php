<?php
App::uses('AppController', 'Controller');
class ClientesController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$clientes	= $this->paginate();
		$this->set(compact('clientes'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Cliente->create();
			if ( $this->Cliente->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		$administradores	= $this->Cliente->Administrador->find('list');
		$this->set(compact('administradores'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Cliente->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Cliente->save($this->request->data) )
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
			$this->request->data	= $this->Cliente->find('first', array(
				'conditions'	=> array('Cliente.id' => $id)
			));
		}
		$administradores	= $this->Cliente->Administrador->find('list');
		$this->set(compact('administradores'));
	}

	public function admin_delete($id = null)
	{
		$this->Cliente->id = $id;
		if ( ! $this->Cliente->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Cliente->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Cliente->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Cliente->_schema);
		$modelo			= $this->Cliente->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}
}
