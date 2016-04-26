<?php
App::uses('AppController', 'Controller');
class ContactosController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$contactos	= $this->paginate();
		$this->set(compact('contactos'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Contacto->create();
			if ( $this->Contacto->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		$clientes	= $this->Contacto->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Contacto->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Contacto->save($this->request->data) )
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
			$this->request->data	= $this->Contacto->find('first', array(
				'conditions'	=> array('Contacto.id' => $id)
			));
		}
		$clientes	= $this->Contacto->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_delete($id = null)
	{
		$this->Contacto->id = $id;
		if ( ! $this->Contacto->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Contacto->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Contacto->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Contacto->_schema);
		$modelo			= $this->Contacto->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}
}
