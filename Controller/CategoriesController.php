<?php

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 * @property yComponent $y
 */
class CategoriesController extends AppController
{

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array('Category', 'Article');

    
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function display($alias = null)
    {
        $this->Article->recursive = 0;
        $articels = $this->Article->find('all', array(
            'fields'=> array(
                'Article.id', 'Article.title', 'Article.content', 'Article.source_id','Article.category_id', 'Article.country_id',
                'Article.publish_up', 'Source.name', 'Source.alias', 'Source.logo', 'Category.name', 'Category.metakey', 'Category.metadesc' 
            ),
            'conditions' => array('Article.status' => 1, 'Source.status' => 1, 'Category.status' => 1, 'Category.alias' => $alias),
            'limit' => 20,
            'order' => array('Article.publish_up' => 'DESC', 'Article.created' => 'DESC')
        ));
        
        $this->pageTitle = $articels[0]['Category']['name'];
        
        if(!empty($articel[0]['Category']['metakey'])) {
            $this->set('keywords', $articel[0]['Category']['metakey']);
        }else {
            $this->set('keywords', __('keywords', true));
        }
        
        if(!empty($articel[0]['Category']['metadesc'])) {
            $this->set('description', $articel[0]['Category']['metadesc']);
        }else {
            $this->set('description', __('description', true));
        }
                
        $this->set('articels', $articels);
        $this->render('/Elements/articles');
    }

    /**
     * add method
     *
     * @return void
     */
    public function loadMore($start = 0)
    {
        $alias = $this->request->data['alias'];
        $start = $this->request->data['group_no'];
        $this->Article->recursive = 0;
        $articels = $this->Article->find('all', array(
            'conditions' => array('Article.status' => 1, 'Source.status' => 1, 'Category.status' => 1, 'Category.alias' => $alias),
            'offset' => $start,
            'limit' => 20,
            'order' => array('Article.publish_up' => 'DESC', 'Article.created' => 'DESC')
        ));

        $this->set('articels', $articels);

        $this->render('/Elements/load_more');
    }

    /**
     * y_index method
     *
     * @return void
     */
    public function cpadmin_index()
    {
        $this->pageTitle = __('List categories', true);
        $this->Category->recursive = 0;
        $this->set('categories', $this->Paginator->paginate());
    }

    /**
     * y_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
//    public function cpadmin_view($id = null)
//    {
//        if (!$this->Category->exists($id)) {
//            throw new NotFoundException(__('Invalid category'));
//        }
//        $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
//        $this->set('category', $this->Category->find('first', $options));
//    }

    /**
     * y_add method
     *
     * @return void
     */
    public function cpadmin_add()
    {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * y_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function cpadmin_edit($id = null)
    {
        $this->autoRender = false;
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved.'), 'default', array(), 'success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
        } else {

            $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
            $this->request->data = $this->Category->find('first', $options);
        }

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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Category->delete()) {
            $this->Session->setFlash(__('The category has been deleted.'));
        } else {
            $this->Session->setFlash(__('The category could not be deleted. Please, try again.'));
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
        $this->autoRender = false;
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->onlyAllow('get');
        $this->request->data = array(
            'status' => 0
        );
        if ($this->Category->save($this->request->data)) {
            $this->Session->setFlash(__('The category has been saved.'), 'default', array(), 'success');
        } else {
            $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->onlyAllow('get');
        $this->request->data = array(
            'status' => 1
        );
        if ($this->Category->save($this->request->data)) {
            $this->Session->setFlash(__('The category has been saved.'), 'default', array(), 'success');
        } else {
            $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
        }

        return $this->redirect(array('action' => 'index'));
    }

}
