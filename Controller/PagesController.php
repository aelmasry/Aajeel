<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() 
    {
        $path = func_get_args();
        $count = count($path);
        
		if (!$count) {
			return $this->redirect('/');
		}
		
        if($path[0] == 'about') {
            $title_for_layout = __('about page title');
        }elseif($path[0] == 'contact') {
             $title_for_layout = __('contact us', true);
        }
        
        $this->set('keywords', __('keywords', true));
        $this->set('description', __('description', true));
        
        $this->pageTitle = $title_for_layout;
        
		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
        
	}
    
    public function rss()
    {
        $this->pageTitle = 'RSS';
        
        $this->loadModel('Country');
        $this->Country->recursive = -1;
        $countries = $this->Country->find('all', array(
            'fields' => array ('Country.id', 'Country.name', 'Country.alias'),
            'conditions' => array('Country.status' => 1),
        ));
            
        $this->set('countries', $countries);
        
        $this->set('keywords', __('keywords', true));
        $this->set('description', __('description', true));
        
    }
    
    public function testcode()
    {
        echo '<pre>';
        print_r($_SERVER);
        echo '</pre>';
        var_dump(isset($_SERVER["HTTP_CF_CONNECTING_IP"]));
        var_dump(!empty($_SERVER["HTTP_CF_CONNECTING_IP"]));
        
        $this->_pingServer();
        
        exit;
    }
}
