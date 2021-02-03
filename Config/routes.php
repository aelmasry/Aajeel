<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/cpadmin', array('prefix' => 'cpadmin', 'cpadmin' => TRUE, 'controller' => 'users', 'action' => 'dashboard'));

Router::connect('/cpadmin/:controller/:action/*', array('prefix' => 'cpadmin', 'cpadmin' => TRUE));

Router::connect('/cpadmin/:controller/*', array('prefix' => 'cpadmin', 'cpadmin' => TRUE));

Router::connect('/', array('controller' => 'articles', 'action' => 'home'));

Router::connect('/home', array('controller' => 'articles', 'action' => 'home'));

Router::connect('/search/*', array('controller' => 'tags', 'action' => 'search'));

Router::connect('/cron/reader', array('controller' => 'Cron', 'action' => 'reader'));
Router::connect('/cron/generateSitemap', array('controller' => 'Cron', 'action' => 'generateSitemap'));
Router::connect('/Cron/reader', array('controller' => 'Cron', 'action' => 'reader'));

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
Router::connect('/pages/testcode', array('controller' => 'pages', 'action' => 'testcode'));

Router::connect('/rss', array('controller' => 'pages', 'action' => 'rss'));
Router::connect('/about', array('controller' => 'pages', 'action' => 'display', 'about'));

Router::connect('/contact', array('controller' => 'pages', 'action' => 'display', 'contact'));

Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display', 'about'));

Router::connect('/section/', array('controller' => 'categories', 'action' => 'index'));

Router::connect('/section/*', array('controller' => 'categories', 'action' => 'display'));

Router::connect('/country/*', array('controller' => 'countries', 'action' => 'display'));

Router::connect('/source/', array('controller' => 'sources', 'action' => 'index'));

Router::connect('/source/*', array('controller' => 'sources', 'action' => 'display'));

Router::connect('/article/', array('controller' => 'articles', 'action' => 'home'));

Router::connect('/loadmore', array('controller' => 'articles', 'action' => 'loadmore'));

Router::connect('/article/*', array('controller' => 'articles', 'action' => 'display'));

Router::connect('/tags', array('controller' => 'tags', 'action' => 'index'));
Router::connect('/tag', array('controller' => 'tags', 'action' => 'index'));

Router::connect('/tag/*', array('controller' => 'tags', 'action' => 'display'));

Router::connect('/*', array('controller' => 'countries', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
