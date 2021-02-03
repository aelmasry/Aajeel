<?php

App::uses('AppController', 'Controller');

/**
 * Articles Controller
 *
 * @property Article $Article
 * @property PaginatorComponent $Paginator
 */
class ArticlesController extends AppController
{

    // App Controller Code.
    public function beforeFilter()
    {

        parent::beforeFilter();
    }

    /**
     * index method
     *
     * @return void
     */
    public function home()
    {
        $this->Article->unbindModel(array('belongsTo' => array('Category')));
        $this->Article->recursive = 0;
        $articels = $this->Article->find('all', array (
            'fields' => array (
                'Article.id', 'Article.title', 'Article.content', 'Article.source_id',  'Article.country_id',
                'Article.publish_up', 'Source.name', 'Source.alias', 'Source.logo',
            ),
            'conditions' => array('Article.status' => 1, 'Source.status' => 1),
            'offset' => 0,
            'limit' => 20,
            'order' => array('Article.publish_up' => 'DESC')
        ));

        $this->pageTitle = __('ajeel', true);
        $this->set('keywords', __('keywords', true));
        $this->set('description', __('description', true));
        $this->set('articels', $articels);
        $this->render('/Elements/articles');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function display($sAlias = null)
    {
		$aAlias = explode('-', $sAlias);
        $this->Article->unbindModel(
                array('belongsTo' => array('Category', 'Country'))
        );
        
        $articel = $this->Article->find('first', array(
            'fields' => array(
                'Article.id', 'Article.title', 'Article.content', 'Article.source_id',  'Article.country_id',
                'Article.publish_up', 'Article.permalink', 'Source.name', 'Source.alias', 'Source.logo', 'Source.metakey'
            ),
            'conditions' => array('Article.status' => 1, 'Article.id' => $aAlias[0]),
        ));

        if (!empty($articel['Article']['id'])) {
            $this->Article->recursive = -1;
            $this->Article->query("UPDATE `articles` AS `Article` SET `Article`.`hits` = Article.hits+1 WHERE `Article`.`id` = " . $aAlias[0]);
        }
        
        $this->pageTitle = $articel['Article']['title'];
        $keywords = __('3ajeel', true).','.$articel['Source']['name'].','.$articel['Source']['metakey'].','.$articel['Article']['title'];
        $this->set('keywords', $keywords);
        $this->set('description', mb_substr($articel['Article']['content'], 0, 255, 'UTF-8'));
        
		$articel['Article']['permalink'] = $this->_urlEncoding($articel['Article']['permalink']);
        // $articel['Article']['permalink'] = preg_replace('/[^A-Za-z0-9\/:.?=&-_]/', '', $articel['Article']['permalink']);
        //$articel['Article']['permalink'] = htmlentities($articel['Article']['permalink']);
        $this->set('articel', $articel);
    }

    /**
     * add method
     *
     * @return void
     */
    public function loadmore($start = 0)
    {
        $alias = NULL;
        $limit = 10;
        $this->Article->unbindModel(array('belongsTo' => array('Category')));
        if (!empty($this->request->data['country'])) {
            $alias = array('Country.alias' => $this->request->data['country']);
        } elseif (!empty($this->request->data['source'])) {
            $this->Article->unbindModel(array('belongsTo' => array('Country')));
            $alias = array('Source.alias' => $this->request->data['source']);
        } elseif (!empty($this->request->data['tag'])) {
            $this->Article->unbindModel(array('belongsTo' => array( 'Country')));
            $alias = array('OR' => array(
                    'Article.title LIKE' => '%' . $this->request->data['tag'] . '%',
                    'Article.content LIKE' => '%' . $this->request->data['tag'] . '%',
            ));
        }

        $this->request->data['group_no'] = filter_var($this->request->data['group_no'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        $start = ($limit * $this->request->data['group_no']);
        $articels = $this->Article->find('all', array(
            'fields' => array (
                'Article.id', 'Article.title', 'Article.content', 'Article.source_id', `Article`.`country_id`,
                'Article.publish_up', 'Source.name', 'Source.alias', 'Source.logo',
            ),
            'conditions' => array('Article.id <> ' => $this->request->data['source'], 'Article.status' => 1, 'Source.status' => 1, $alias),
            'offset' => $start,
            'limit' => $limit,
            'order' => array('Article.publish_up' => 'DESC')
        ));

        $this->set('articels', $articels);

        $this->render('/Elements/load_more');
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        if (!$this->Article->exists($id)) {
            throw new NotFoundException(__('Invalid article'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Article->save($this->request->data)) {
                $this->Session->setFlash(__('The article has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The article could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
            $this->request->data = $this->Article->find('first', $options);
        }
        //$categories = $this->Article->Category->find('list');
        $sources = $this->Article->Source->find('list');
        $this->set(compact('categories', 'sources'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->Article->id = $id;
        if (!$this->Article->exists()) {
            throw new NotFoundException(__('Invalid article'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Article->delete()) {
            $this->Session->setFlash(__('The article has been deleted.'));
        } else {
            $this->Session->setFlash(__('The article could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * cpadmin_index method
     *
     * @return void
     */
    public function cpadmin_index()
    {
        $this->Article->recursive = 0;
        $this->set('articles', $this->Paginator->paginate());
    }

    /**
     * cpadmin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function cpadmin_view($id = null)
    {
        if (!$this->Article->exists($id)) {
            throw new NotFoundException(__('Invalid article'));
        }
        $options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
        $this->set('article', $this->Article->find('first', $options));
    }

    /**
     * cpadmin_add method
     *
     * @return void
     */
    public function cpadmin_add()
    {
        if ($this->request->is('post')) {
            $this->Article->create();
            if ($this->Article->save($this->request->data)) {
                $this->Session->setFlash(__('The article has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The article could not be saved. Please, try again.'));
            }
        }
        //$categories = $this->Article->Category->find('list');
        $sources = $this->Article->Source->find('list');
        $this->set(compact('categories', 'sources'));
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
        if (!$this->Article->exists($id)) {
            throw new NotFoundException(__('Invalid article'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Article->save($this->request->data)) {
                $this->Session->setFlash(__('The article has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The article could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
            $this->request->data = $this->Article->find('first', $options);
        }
        //$categories = $this->Article->Category->find('list');
        $sources = $this->Article->Source->find('list');
        $this->set(compact('categories', 'sources'));
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
        $this->Article->id = $id;
        if (!$this->Article->exists()) {
            throw new NotFoundException(__('Invalid article'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Article->delete()) {
            $this->Session->setFlash(__('The article has been deleted.'));
        } else {
            $this->Session->setFlash(__('The article could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
