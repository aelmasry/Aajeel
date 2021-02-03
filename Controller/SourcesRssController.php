<?php

App::uses('AppController', 'Controller');

/**
 * SourcesRsses Controller
 *
 * @property SourcesRss $SourcesRss
 * @property PaginatorComponent $Paginator
 */
class SourcesRssController extends AppController
{

    /**
     * cpadmin_index method
     *
     * @return void
     */
    public function cpadmin_index()
    {
        $this->SourcesRss->recursive = 0;
        $this->set('sourcesRsses', $this->Paginator->paginate());
    }

    /**
     * cpadmin_add method
     *
     * @return void
     */
    public function cpadmin_add()
    {
        if ($this->request->is('post')) {
            $this->SourcesRss->create();
            if ($this->SourcesRss->save($this->request->data)) {
                $this->Session->setFlash(__('The sources rss has been saved.'), 'default', array(), 'good');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The sources rss could not be saved. Please, try again.'));
            }
        }
        
        $sources = $this->SourcesRss->Source->find('list');
        $categories = $this->SourcesRss->Category->find('list');
        $countries = $this->SourcesRss->Country->find('list', array(
            'fields' => array('id', 'name')
        ));

        $this->set(compact('sources', 'categories', 'countries'));
    }

    /**
     * cpadmin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function cpadmin_edit($id = null)
    {
        if (!$this->SourcesRss->exists($id)) {
            throw new NotFoundException(__('Invalid sources rss'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->SourcesRss->save($this->request->data)) {
                $this->Session->setFlash(__('The sources rss has been saved.'), 'default', array(), 'good');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The sources rss could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('SourcesRss.' . $this->SourcesRss->primaryKey => $id));
            $this->request->data = $this->SourcesRss->find('first', $options);
        }

        $sources = $this->SourcesRss->Source->find('list');
        $categories = $this->SourcesRss->Category->find('list', array(
            'fields' => array('id', 'name')
        ));
        $countries = $this->SourcesRss->Country->find('list', array(
            'fields' => array('id', 'name')
        ));
       

        $this->set(compact('sources', 'categories', 'countries'));
        $this->render('cpadmin_add');
    }

    /**
     * cpadmin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function cpadmin_delete($id = null)
    {
        $this->SourcesRss->id = $id;
        if (!$this->SourcesRss->exists()) {
            throw new NotFoundException(__('Invalid sources rss'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->SourcesRss->delete()) {
            $this->Session->setFlash(__('The sources rss has been deleted.'));
        } else {
            $this->Session->setFlash(__('The sources rss could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * cpadmin_unpublish method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function cpadmin_unpublish($id = null)
    {
//        Configure::write('debug', 2);
        $this->autoRender = false;
        $this->SourcesRss->id = $id;
        if (!$this->SourcesRss->exists()) {
            throw new NotFoundException(__('Invalid Source Rss'));
        }
        $this->request->onlyAllow('get');
        $update = $this->SourcesRss->updateAll(
                array('SourcesRss.status' => 0), 
                array('SourcesRss.id' => $id)
        );
        
        if ($update) {
            $this->Session->setFlash(__('The Source Rss has been updated.'), 'default', array(), 'success');
        } else {
            $this->Session->setFlash(__('The Source Rss could not be saved. Please, try again.'));
        }
        
        return $this->redirect(array('action' => 'index'));
        
    }

    /**
     * cpadmin_unpublish method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function cpadmin_publish($id = null)
    {
        $this->autoRender = false;
        $this->SourcesRss->id = $id;
        if (!$this->SourcesRss->exists()) {
            throw new NotFoundException(__('Invalid SourcesRss'));
        }
        $this->request->onlyAllow('get');
        $update = $this->SourcesRss->updateAll(
                array('SourcesRss.status' => 1), 
                array('SourcesRss.id' => $id)
        );
        
        if ($update) {
            $this->Session->setFlash(__('The Source Rss has been updated.'), 'default', array(), 'success');
        } else {
            $this->Session->setFlash(__('The Source Rss could not be saved. Please, try again.'));
        }
        
        return $this->redirect(array('action' => 'index'));
    }
}
