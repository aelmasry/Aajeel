<?php

App::uses('AppController', 'Controller');

/**
 * Countries Controller
 *
 * @property Country $Country
 */
class CountriesController extends AppController
{

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array('Country', 'Article');
    
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function display($alias = null, $rss=NULL)
    {
		$articels = $this->_getObjectCache ($alias, 30);
		
		if (empty ($articels) || $articels === FALSE) 
		{
			$this->Article->recursive = 0;
			$this->Article->unbindModel(array('belongsTo' => array('Category')));
			$articels = $this->Article->find('all', array(
				'fields'=> array (
					'Article.id', 'Article.title', 'Article.content', 'Article.source_id',
					'Article.publish_up', 'Source.name', 'Source.alias', 'Source.logo', 'Country.name', 'Country.metakey', 'Country.metadesc' 
				),
				'conditions' => array('Article.status' => 1, 'Source.status' => 1, 'Country.alias' => $alias),
				'offset' => 0,
				'limit' => 20,
				'order' => array('Article.publish_up' => 'DESC')
			));
			
			$this->_setObjectCache ($alias, $articels);
		}
        
        if(empty($articels[0])) {
            return $this->redirect('/');
        }
        
        if(!is_null($rss)) {
            $this->layout = '';
            $this->setAction('rss', $alias, $articels);
            exit;
        }
        
        $this->pageTitle = $articels[0]['Country']['name'];
        
        $this->set('title', $alias);
        $this->set('alias', $alias);
        
        if(!empty($articels[0]['Country']['metakey'])) {
            $this->set('keywords', $articels[0]['Country']['metakey']);
        }else {
            $this->set('keywords', __('keywords', true));
        }
        
        if(!empty($articels[0]['Country']['metadesc'])) {
            $this->set('description', $articels[0]['Country']['metadesc']);
        }else {
            $this->set('description', __('description', true));
        }
        
        $this->set('articels', $articels);
        
        if(!empty($articels)) {
            $this->render('/Elements/articles');
        }else {
            $this->render('/Elements/not-data');
        }
    }

    
    public function rss($alias, $articels)
    {
        $this->layout = FALSE;
        $title = __('news').$articels[0]['Country']['name'];
        $this->request->accepts('Content-type: application/rss+xml');
        $this->pageTitle = __('news').$articels[0]['Country']['name'];
        
        $out = '<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL;
        $out .='<rss version="2.0">'.PHP_EOL;
        $out .='<channel>'.PHP_EOL;
        $out .='<title>'.__('3ajeel', true).'  '.$title.'</title>'.PHP_EOL;
        $out .='<description>'.__('description', true).'</description>'.PHP_EOL;
        $out .='<language>ar</language>'.PHP_EOL;
        
        while(list(, $articel) = each($articels)) 
        {
            $out .='<item>'.PHP_EOL;
            $out .='<title>'.$articel['Article']['title'].'</title>'.PHP_EOL;
            $out .='<link>'.FULL_BASE_URL.Router::url(array('controller'=> 'article', 'action'=> $articel['Article']['id'])).'</link>'.PHP_EOL;
            $out .='<description><![CDATA['.mb_substr($articel['Article']['content'],0,255,'UTF-8').']]></description>'.PHP_EOL;
            $out .='<pubDate>'.$articel['Article']['publish_up'].'</pubDate>'.PHP_EOL;
            $out .='</item>'.PHP_EOL;
        }
        
        $out .='</channel>'.PHP_EOL;
        $out .='</rss>';
        echo $out;
    }
    
	/**
     * y_index method
     *
     * @return void
     */
    public function cpadmin_index()
    {
		$this->Paginator->settings = array(
			'order' => array(
				'Country.order' => 'asc'
			)
		);
		
        $this->pageTitle = __('Countries', true);
        $this->Country->recursive = 0;
		
        $this->set('countries', $this->Paginator->paginate());
    }

    /**
     * y_add method
     *
     * @return void
     */
    public function cpadmin_add()
    {
        if ($this->request->is('post')) {
            $this->request->data['Country']['code'] = strtolower($this->request->data['Country']['code']);
            $this->Country->create();
            if ($this->Country->save($this->request->data)) {
                $this->Session->setFlash(__('Saved successfully'));
                $this->_generateSitemap();
                $this->_clearCache('countries');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('save error, Please try again'));
            }
        }
		
		$order = $this->Country->query("SELECT MAX(`order`) as morder FROM countries;");
		
		$this->request->data['Country']['order'] = $order[0][0]['morder']+1;
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
        if (!$this->Country->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['Country']['code'] = strtolower($this->request->data['Country']['code']);
            if ($this->Country->save($this->request->data)) {
                $this->Session->setFlash(__('The country has been saved.'), 'default', array(), 'success');
                $this->_generateSitemap();
                $this->_clearCache('countries');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The country could not be saved. Please, try again.'));
            }
        } else {

            $options = array('conditions' => array('Country.' . $this->Country->primaryKey => $id));
            $this->Country->recursive = -1;
            $this->request->data = $this->Country->find('first', $options);
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
        $this->Country->id = $id;
        if (!$this->Country->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Country->delete()) {
            $this->Session->setFlash(__('The category has been deleted.'));
        } else {
            $this->Session->setFlash(__('The category could not be deleted. Please, try again.'));
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
        $this->Country->id = $id;
        if (!$this->Country->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->onlyAllow('get');
        $update = $this->Country->updateAll(
                array('status' => 0), 
                array('id' => $id)
        );
        
        if ($update) {
            $this->Session->setFlash(__('The category has been saved.'), 'default', array(), 'success');
        } else {
            $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
        }
        $this->_clearCache('countries');
        $this->_generateSitemap();
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
        $this->Country->id = $id;
        if (!$this->Country->exists()) {
            throw new NotFoundException(__('Invalid Country'));
        }
        $this->request->onlyAllow('get');
        $update = $this->Country->updateAll(
                array('status' => 1), 
                array('id' => $id)
        );
        
        if ($update) {
            $this->Session->setFlash(__('The Country has been saved.'), 'default', array(), 'success');
        } else {
            $this->Session->setFlash(__('The Country could not be saved. Please, try again.'));
        }
        $this->_clearCache('countries');
        $this->_generateSitemap();
        return $this->redirect(array('action' => 'index'));
    }

    
    protected function _generateSitemap()
    {
        $this->Country->recursive = -1;
        $countries = $this->Country->find('all', array('conditions'=>array('Country.status'=> 1), 'fields'=> array('id', 'alias')));
        $out = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $out .='<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">'.PHP_EOL;
        
        $out .= '<url>'.PHP_EOL;
        $out .= '<loc>'.FULL_BASE_URL.'</loc>'.PHP_EOL;
        $out .= '<changefreq>always</changefreq>'.PHP_EOL;
        $out .= '</url>'.PHP_EOL;
        
        while (list(, $country) = each($countries)) 
        {
            $out .= '<url>'.PHP_EOL;
            $out .= '<loc>'.FULL_BASE_URL.'/'.$country['Country']['alias'].'</loc>'.PHP_EOL;
            $out .= '<changefreq>always</changefreq>'.PHP_EOL;
//            $out .= '<priority>0.9</priority>'.PHP_EOL;
            $out .= '</url>'.PHP_EOL;
        }
        
        $out .= '</urlset>';

        $file = new File(ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'countries.xml', true);
        $file->write($out);
        
        sleep(2);
        
        $this->_pingGoogle('countries.xml');
//        $this->_pingAsk('countries.xml');
        $this->_pingBing('countries.xml');
        $this->_pingYahoo('countries.xml');
        
        return ;
    }
}
