<?php

App::uses('AppController', 'Controller');

/**
 * Sources Controller
 *
 * @property Source $Source
 * @property PaginatorComponent $Paginator
 */
class SourcesController extends AppController
{

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array('Source', 'Article', 'Category', 'Country');
    

    public function beforeFilter()
    {
        parent::beforeFilter();
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
        $this->Article->unbindModel(array('belongsTo' => array('Category')));
        $articels = $this->Article->find('all', array (
            'fields'=> array(
                'Article.id', 'Article.title', 'Article.content', 'Article.source_id',
                'Article.publish_up', 'Source.name', 'Source.alias', 'Source.logo', 'Source.metakey', 'Source.metadesc', 'Country.name' 
            ),
            'conditions' => array('Article.status' => 1, 'Source.status' => 1, 'Source.alias' => $alias),
            'offset' => 0,
            'limit' => 20,
            'order' => array('Article.publish_up' => 'DESC')
        ));

        $this->pageTitle = $articels[0]['Country']['name'].' | '.$articels[0]['Source']['name'];

        if(!empty($articels[0]['Source']['metakey'])) {
            $this->set('keywords', $articels[0]['Source']['metakey']);
        }else {
            $this->set('keywords', __('keywords', true));
        }
        
        if(!empty($articels[0]['Source']['metadesc'])) {
            $this->set('description', $articels[0]['Source']['metadesc']);
        }else {
            $this->set('description', __('description', true));
        }
        
        $this->set('title', $alias);
        $this->set('articels', $articels);

        $this->render('/Elements/articles');
    }

    
    /**
     * cpadmin_index method
     *
     * @return void
     */
    public function cpadmin_index()
    {
        $this->pageTitle = __('List Sources');
        $this->Source->recursive = 0;
        $this->set('sources', $this->Paginator->paginate());
    }

    /**
     * cpadmin_add method
     *
     * @return void
     */
    public function cpadmin_add()
    {
        $this->pageTitle = __('Add source');
        if ($this->request->is('post')) {
            $isValid = $this->Source->validates(array('fieldList' => array('name', 'alias', 'logo')));
            if ($isValid) {
                $image =  $this->request->data['Source']['logo'] ;
                //upload folder - make sure to create one in webroot
                $uploadPath = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . '/img/sources/';
                //create full path with image name
                $full_image_path = $uploadPath . '/' . $image['name'];
                //upload image to upload folder
                if (move_uploaded_file($image['tmp_name'], $full_image_path)) {
                    $this->request->data['Source']['logo'] = $image['name'];
                }
                $xmlArray = json_encode($this->request->data['Source']['xml']);
                $htmlArray = json_encode($this->request->data['Source']['html']);
                $this->request->data['Source']['xml'] = $xmlArray;
                $this->request->data['Source']['html'] = $htmlArray;
                $this->Source->create();
                if ($this->Source->save($this->request->data, TRUE)) {
                    $this->Session->setFlash(__('The source has been saved.'), 'default', array(), 'success');
                    $this->_generateSitemap();
                    return $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Session->setFlash(__('The source could not be saved. Please, try again.'));
            }
        }
        
        $countries = $this->Country->find('list');
        $this->set(compact('countries'));
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
        $this->pageTitle = __('Edit Source');
        if (!$this->Source->exists($id)) {
            throw new NotFoundException(__('Invalid source'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if (!empty($this->request->data['Source']['logo']['name'])) {
                $fieldList = array('name', 'alias', 'logo');
                $image =  $this->request->data['Source']['logo'] ;
                //upload folder - make sure to create one in webroot
                $uploadPath = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . '/img/sources/';
                //create full path with image name
                $full_image_path = $uploadPath . '/' . $image['name'];
                //upload image to upload folder
                if (@move_uploaded_file($image['tmp_name'], $full_image_path)) {
                    $this->request->data['Source']['logo'] = $image['name'];
                }
            } else {
                $this->request->data['Source']['logo'] = null;
                $fieldList = array('name', 'alias');
            }
            
            $isValid = $this->Source->validates(array('fieldList' => $fieldList));
            
            if ($isValid) {

                $xmlArray = json_encode($this->request->data['Source']['xml']);
                $htmlArray = json_encode($this->request->data['Source']['html']);

                $data = array(
                    'Source.name' => "'" . $this->request->data['Source']['name'] . "'", 'Source.alias' => "'" . $this->request->data['Source']['alias'] . "'",
                    'Source.metakey' => "'" . $this->request->data['Source']['metakey'] . "'", 'Source.metadesc' => "'" . $this->request->data['Source']['metadesc'] . "'",
                    'Source.domain' => "'" . $this->request->data['Source']['domain'] . "'",
                    'Source.xml' => "'" . addslashes($xmlArray) . "'", 
                    'Source.html' => "'" . addslashes($htmlArray) . "'",
                    'Source.status' => $this->request->data['Source']['status'], 'Source.country_id' => "'" . $this->request->data['Source']['country_id'] . "'"
                );
                
               
                if (!is_null($this->request->data['Source']['logo'])) {
                    $data['Source.logo'] = "'" . $this->request->data['Source']['logo'] . "'";
                }

                $this->Source->updateAll(
                        $data, array('Source.id' => $this->request->data['Source']['id'])
                );

                $this->Session->setFlash(__('The source has been saved.'), 'default', array(), 'success');
                $this->_generateSitemap();
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The source could not be saved. Please, try again.'));
            }
        } else {
            $this->Source->recursive = -1;
            $options = array('conditions' => array('Source.id' => $id));
            $this->request->data = $this->Source->find('first', $options);

            if (!empty($this->request->data['Source']['xml'])) {
                $xml = json_decode($this->request->data['Source']['xml']);
                foreach ($xml as $k => $v) {
                    $xmlArray[$k] = $v;
                }

                $this->request->data['Source']['xml'] = $xmlArray;
            }

            if (!empty($this->request->data['Source']['html'])) {
                $html = json_decode($this->request->data['Source']['html']);
                
                foreach ($html as $k => $v) {
                    $htmlArray[$k] = $v;
                }

                $this->request->data['Source']['html'] = $htmlArray;
            }
            
            $countries = $this->Country->find('list');
            $this->set(compact('countries'));
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
        $this->Source->id = $id;
        if (!$this->Source->exists()) {
            throw new NotFoundException(__('Invalid source'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Source->delete()) {
            $this->Session->setFlash(__('The source has been deleted.'));
        } else {
            $this->Session->setFlash(__('The source could not be deleted. Please, try again.'));
        }
        
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
    public function cpadmin_unpublish($id = null)
    {
        $this->autoRender = false;
        $this->Source->id = $id;
        if (!$this->Source->exists()) {
            throw new NotFoundException(__('Invalid Source'));
        }
        $this->request->onlyAllow('get');
        $update = $this->Source->updateAll(
                array('status' => 0), 
                array('id' => $id)
        );
        
        if ($update) {
            $this->Session->setFlash(__('The Source has been updated.'), 'default', array(), 'success');
        } else {
            $this->Session->setFlash(__('The Source could not be saved. Please, try again.'));
        }
        
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
        $this->Source->id = $id;
        if (!$this->Source->exists()) {
            throw new NotFoundException(__('Invalid Source'));
        }
        $this->request->onlyAllow('get');
        $update = $this->Source->updateAll(
                array('status' => 1), 
                array('id' => $id)
        );
        
        if ($update) {
            $this->Session->setFlash(__('The Source has been updated.'), 'default', array(), 'success');
        } else {
            $this->Session->setFlash(__('The Source could not be saved. Please, try again.'));
        }
        
        $this->_generateSitemap();
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * Generate new sitemap
     * @return type
     */
    protected function _generateSitemap()
    {
        $this->Source->recursive = -1;
        $Sources = $this->Source->find('all', array('conditions'=>array('Source.status'=> 1), 'fields'=> array('id', 'alias')));
        $out = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $out .='<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">'.PHP_EOL;
        
        $out .= '<url>'.PHP_EOL;
        $out .= '<loc>'.FULL_BASE_URL.'</loc>'.PHP_EOL;
        $out .= '<changefreq>always</changefreq>'.PHP_EOL;
        $out .= '</url>'.PHP_EOL;
        
        while (list(, $source) = each($Sources)) 
        {
            $out .= '<url>'.PHP_EOL;
            $out .= '<loc>'.FULL_BASE_URL.'/source/'.$source['Source']['alias'].'</loc>'.PHP_EOL;
            $out .= '<changefreq>always</changefreq>'.PHP_EOL;
//            $out .= '<priority>0.9</priority>'.PHP_EOL;
            $out .= '</url>'.PHP_EOL;
        }
        
        $out .= '</urlset>';
        
        $file = new File(ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'sources.xml', true);
        $file->write($out);
        
        sleep(2);
        
        $this->_pingGoogle('sources.xml');
//        $this->_pingAsk('sources.xml');
        $this->_pingBing('sources.xml');
//        $this->_pingYahoo('sources.xml');
        
        return ;
    }
}
