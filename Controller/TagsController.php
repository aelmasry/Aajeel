<?php

App::uses('AppController', 'Controller');

/**
 * Tags Controller
 *
 * @property Tag $Tag
 * @property Articel $Articel
 * @property PaginatorComponent $Paginator
 */
class TagsController extends AppController
{

    /**
     * This controller does not use a model
     * @var array
     */
    public $uses = array('Tag', 'Article');

    public function beforeFilter()
    {
        $this->initializeAuth(array('search'));

        parent::beforeFilter();
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->pageTitle = __('Most popular', true);
        $this->Tag->recursive = -1;
        $tags = $this->Tag->find('all', array(
            'fields' => array('Tag.id', 'Tag.name', 'Tag.alias'),
            'conditions' => array('Tag.status' => 1),
//            'order' => array('Tag.hits' => 'DESC')
        ));

        $this->set('keywords', __('keywords', true));
        $this->set('description', __('description', true));
        $this->set('items', $tags);
    }

    public function search()
    {
        $alias = trim($_GET['q']);
        $tags = $this->Tag->find('count', array(
            'conditions' => array(
                'Tag.name' => $alias,
            ),
        ));

        if ($tags >= 1)
        {
            $this->Tag->updateAll(
                    array('Tag.hits' => 'Tag.hits+1'), array('Tag.name ' => $alias)
            );
        }
        else
        {
            $this->Tag->create();
            $this->Tag->set(array(
                'name' => $alias,
                'alias' => preg_replace('/\s+/', '-', $alias),
                'status' => 0,
            ));
            $this->Tag->save();
        }

        $this->Article->unbindModel(array('belongsTo' => array('Category', 'Country')));
        $articels = $this->Article->find('all', array(
            'conditions' => array(
                'Article.status' => 1,
                "MATCH(title, content) AGAINST ('" . $alias . "')",
            // 'OR' => array(
            // "Article.title MATCH(title, content) AGAINST ('".$articels['title'][$i]."')",
            // 'Article.title LIKE' => '%' . $alias . '%',
            // 'Article.content LIKE' => '%' . $alias . '%',
            // ),
            ),
            'limit' => 20,
            'order' => array('Article.publish_up' => 'DESC')
        ));

        $this->pageTitle = $alias;
        $this->set('title', $alias);
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
    public function display($alias = null)
    {
        $alias = @preg_replace('/-/', ' ', $alias);
        $aliass = @preg_replace('/-/', '+', $alias);

        $this->Article->recursive = 0;
        $articels = $this->Article->find('all', array(
            'fields' => array(
                "Article.id, Article.title, Article.alias, Article.content, Article.source_id, Article.category_id, Article.country_id, Article.publish_up, Source.id, Source.name, Source.alias, Source.logo, Source.country_id",
                "MATCH(title, content) AGAINST ('" . $aliass . "' IN BOOLEAN MODE) as score"
            ),
            'conditions' => array(
                'Article.status' => 1,
                "MATCH(title, content) AGAINST ('" . $aliass . "' IN BOOLEAN MODE)",
            // 'OR' => array(
            // 'Article.title LIKE' => '%' . $alias . '%',
            // 'Article.content LIKE' => '%' . $alias . '%',
            // ),
            ),
            'limit' => 20,
            'order' => array('score' => 'DESC', 'Article.publish_up' => 'DESC')
        ));

        $this->Tag->updateAll(
                array('Tag.hits' => 'Tag.hits+1'), array('Tag.alias ' => $alias)
        );

        $this->pageTitle = $alias;
        $this->set('title', $alias);
        $this->set('keywords', $alias);
        $this->set('description', $alias);

        $this->set('articels', $articels);

        if (!empty($articels))
        {
            $this->render('/Elements/articles');
        }
        else
        {
            $this->render('/Elements/not-data');
        }
    }

    /**
     * cpadmin_index method
     *
     * @return void
     */
    public function cpadmin_index()
    {
        $this->Tag->recursive = 0;
        $this->set('tags', $this->Paginator->paginate());
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
        if (!$this->Tag->exists($id))
        {
            throw new NotFoundException(__('Invalid tag'));
        }
        $options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
        $this->set('tag', $this->Tag->find('first', $options));
    }

    /**
     * cpadmin_add method
     *
     * @return void
     */
    public function cpadmin_add()
    {
        if ($this->request->is('post'))
        {
            $this->Tag->create();
            if ($this->Tag->save($this->request->data))
            {
                $this->_generateSitemap();
                $this->Session->setFlash(__('The tag has been saved.'));
                $this->_clearCache('tags');
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
            }
        }
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
        if (!$this->Tag->exists($id))
        {
            throw new NotFoundException(__('Invalid tag'));
        }
        if ($this->request->is(array('post', 'put')))
        {
            if ($this->Tag->save($this->request->data))
            {
                $this->_generateSitemap();
                $this->Session->setFlash(__('The tag has been saved.'));
                $this->_clearCache('tags');
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
            $this->request->data = $this->Tag->find('first', $options);
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
        $this->Tag->id = $id;
        if (!$this->Tag->exists())
        {
            throw new NotFoundException(__('Invalid tag'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Tag->delete())
        {
            $this->Session->setFlash(__('The tag has been deleted.'));
        }
        else
        {
            $this->Session->setFlash(__('The tag could not be deleted. Please, try again.'));
        }
        $this->_generateSitemap();
        $this->_clearCache('tags');
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
        $this->Tag->id = $id;
        if (!$this->Tag->exists())
        {
            throw new NotFoundException(__('Invalid tags'));
        }
        $this->request->onlyAllow('get');
        $update = $this->Tag->updateAll(
                array('status' => 0), array('id' => $id)
        );

        if ($update)
        {
            $this->Session->setFlash(__('The tags has been saved.'), 'default', array(), 'success');
        }
        else
        {
            $this->Session->setFlash(__('The tags could not be saved. Please, try again.'));
        }

        $this->_generateSitemap();
        $this->_clearCache('tags');
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
        $this->Tag->id = $id;
        if (!$this->Tag->exists())
        {
            throw new NotFoundException(__('Invalid tags'));
        }
        $this->request->onlyAllow('get');
        $update = $this->Tag->updateAll(
                array('status' => 1), array('id' => $id)
        );

        if ($update)
        {
            $this->Session->setFlash(__('The tag has been saved.'), 'default', array(), 'success');
        }
        else
        {
            $this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
        }

        $this->_generateSitemap();
        $this->_clearCache('tags');
        return $this->redirect(array('action' => 'index'));
    }

    protected function _generateSitemap()
    {
        $this->Tag->recursive = -1;
        $tags = $this->Tag->find('all', array('conditions' => array('Tag.status' => 1), 'fields' => array('id', 'alias')));
        $out = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $out .='<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . PHP_EOL;

        $out .= '<url>' . PHP_EOL;
        $out .= '<loc>' . FULL_BASE_URL . '</loc>' . PHP_EOL;
        $out .= '<changefreq>always</changefreq>' . PHP_EOL;
        $out .= '</url>' . PHP_EOL;

        while (list(, $tag) = each($tags)) {
            $out .= '<url>' . PHP_EOL;
            $out .= '<loc>' . FULL_BASE_URL . '/tag/' . $tag['Tag']['alias'] . '</loc>' . PHP_EOL;
            $out .= '<changefreq>always</changefreq>' . PHP_EOL;
//            $out .= '<priority>0.9</priority>'.PHP_EOL;
            $out .= '</url>' . PHP_EOL;
        }

        $out .= '</urlset>';

        $file = new File(ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'tags.xml', true);
        $file->write($out);

        sleep(2);

        $this->_pingGoogle('tags.xml');
//        $this->_pingAsk('tags.xml');
        $this->_pingBing('tags.xml');
        $this->_pingYahoo('tags.xml');

        return;
    }

}
