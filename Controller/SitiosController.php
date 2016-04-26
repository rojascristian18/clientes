<?php
App::uses('AppController', 'Controller');
class SitiosController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$sitios	= $this->paginate();
		$this->set(compact('sitios'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Sitio->create();
			if ( $this->Sitio->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		$clientes	= $this->Sitio->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Sitio->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Sitio->save($this->request->data) )
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
			$this->request->data	= $this->Sitio->find('first', array(
				'conditions'	=> array('Sitio.id' => $id)
			));
		}
		$clientes	= $this->Sitio->Cliente->find('list');
		$this->set(compact('clientes'));
	}

	public function admin_delete($id = null)
	{
		$this->Sitio->id = $id;
		if ( ! $this->Sitio->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Sitio->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Sitio->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Sitio->_schema);
		$modelo			= $this->Sitio->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}
}
