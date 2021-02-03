<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File', 'duration' => 90));

Cache::config('short', array('engine' => 'File', 'duration' => 30));

Cache::config('long', array('engine' => 'File', 'duration' => '+1 hours'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter . By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');

CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));

CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

CakePlugin::loadAll(array(
    'DebugKit' => array('bootstrap' => false),
));

// Arabic localization
Configure::write('Config.language', 'ara');

Configure::write('Conifg.pingservers', array (
    'http://rpc.pingomatic.com',
    'http://rpc.twingly.com',
    'http://api.feedster.com/ping',
    'http://api.moreover.com/RPC2',
    'http://api.moreover.com/ping',
    'http://www.blogdigger.com/RPC2',
    'http://www.blogshares.com/rpc.php',
    'http://www.blogsnow.com/ping',
    'http://www.blogstreet.com/xrbin/xmlrpc.cgi',
    'http://bulkfeeds.net/rpc',
    'http://www.newsisfree.com/xmlrpctest.php',
    'http://ping.blo.gs/',
    'http://ping.feedburner.com',
    'http://ping.syndic8.com/xmlrpc.php',
    'http://ping.weblogalot.com/rpc.php',
    'http://rpc.blogrolling.com/pinger/',
    'http://rpc.technorati.com/rpc/ping',
    'http://rpc.weblogs.com/RPC2',
    'http://www.feedsubmitter.com',
    'http://blo.gs/ping.php',
    'http://www.pingerati.net',
    'http://www.pingmyblog.com',
    'http://geourl.org/ping',
    'http://ipings.com',
    'http://www.weblogalot.com/ping',
    'http://bblog.com/ping.php',
    'http://blogsearch.google.com/ping/RPC2',
    'http://ping.bloggers.jp/rpc/',
    'http://topicexchange.com/RPC2',
    'http://www.blogpeople.net/servlet/weblogUpdates',
    'http://xping.pubsub.com/ping',
));

// Twitter API
Configure::write('TwitterAPI', array(
    'eg' => array(
      'consumer_key' => 'oU3Ozv4VKwXAGnavEB5ZihvH4',
      'consumer_secret' => 'hP95EAGxf50zzEjwIOZ6XFE11pplBAVSKotC0uIiKgLoEcvsOl',
      'oauth_access_token' => '2849964069-aInwXaA4by5k1K9IjllpE7Zg9tmXthVbBcJIpTz',
      'oauth_access_token_secret'=> 'QrmVIum9uRY7pz3hqeidxIK7IKGOkq8BPFhrmtXMp1IaV',
      'hashTag' => '#مصر'
    ),
    'sa' => array(
      'consumer_key' => 'ojlRM4PfWfpIOVtn2Fqc60y4s',
      'consumer_secret' => 'MXXOClE8kDY6cRXWwYQUpTTT6CsBQrs3PTsM06hYWaoF4KbdrP',
	  'oauth_access_token' => '2850025324-cUhvzFWPrUTylt166MV5vnxQblg5lNNc5YACzn6',
	  'oauth_access_token_secret'=> 'F7xkUQMAN0suwg1FWHsP78ZIgSqZ6rNeMC4Wi00h8xzuB',
      'hashTag' => '#السعودية'
    ),
    'ae' => array(
      'consumer_key' => 'fyJ01407u834ouKT3n6ShIQzN',
      'consumer_secret' => '6ySrnP6NO527Ur2liynev284gQhwKr6e7Mq7uq8gICIUbS4IRo',
	  'oauth_access_token' => '2850000887-vrzLUa0kVYB0wg5RAJwQX3wuYQydbA5zhE3Z5hY',
	  'oauth_access_token_secret'=> 'hC1N6ThOwnba0xzH8KYl3ZbZxT1N7LeXZW9K7DWU3KQx9',
      'hashTag' => '#الإمارات'
    ),
    'qa' => array(
      'consumer_key' => 'aP6VXlZj2XRzG7TmwEUcSTbuB',
      'consumer_secret' => '8hLIptDJ9VsS7p1A6DotBUGgHX23sIAHgsqinbi4ClkFdwxpJM',
	  'oauth_access_token' => '2849979183-w2fWQ9QVjUd8YVw1u0qqTotCle79SqG8QVpINJT',
	  'oauth_access_token_secret'=> '3K8obKyDEZFQbQO8YBwIzccRUZVAqxMiGfZ3z2AmRLFsq',
      'hashTag' => '#قطر'
    ),
	'sy' => array(
      'consumer_key' => 'p0X5RWu5QMgHI5ZrJPVfNrPaX',
      'consumer_secret' => 'aCOtyPYnkDBu6UFraV97nylINGQKXhnnqOCQAvf6ky5HbKBugD',
	  'oauth_access_token' => '2849983629-eNIIExNig0aeUuBpKfsGohGvPBARhkrh4Bd1kS0',
	  'oauth_access_token_secret'=> 'VZLYoDHS0DMSuKzbXkwgzqB5hIkLo1WAgXu7RwGPxDb3B',
      'hashTag' => '#سوريا'
    ),
	'ly' => array(
      'consumer_key' => 'TVjfIUiu9Y1ok8YJDivi6Q0mQ',
      'consumer_secret' => 'jXL5W47KiRgilz2JEs7bvd3IkuWPOtD1ha9lT4jumPa38d6cUB',
	  'oauth_access_token' => '2850037030-QXCkSk1uL3HHc3fQl1zf6K2qNoq70K3YmP7lzBw',
	  'oauth_access_token_secret'=> '0RQQeKb3Xnt7D2fYO2UKRxrSZ91nUcTNLQbR7ZalRQgqu',
      'hashTag' => '#ليبيا'
    ),
	'kw' => array (
      'consumer_key' => 'XUm2tkIpX9MEX12SrVO9nmQZq',
      'consumer_secret' => 'OsSNJWMvyR8j3iyYy2gufWdomAXt9Rg1wxifMFIhazMjj9m3VB',
	  'oauth_access_token' => '2850031900-HflOv9TdfP6P8XcEvQoiC6FKRRiQPXaYWfGAhvK',
	  'oauth_access_token_secret'=> 'GwZ2WEMzl9Cgok34OIlEeHck8rV67aAG5ynQ2ndd6VybB',
      'hashTag' => '#الكويت'
    ),
	'ye' => array (
      'consumer_key' => '8WeAU2bMbg6AF9A3M4rQDB1FQ',
      'consumer_secret' => 'SIEGIhhTw8749zpINjHX9T05ZtcDWW075gXgFzSkQXaUzhL73M',
	  'oauth_access_token' => '3092129903-RGY2HjsO7j6gNBArFsvK5n84x673IqVpi5d6ORF',
	  'oauth_access_token_secret'=> 'pWRIXSsAyTDhRWoWNRBqxOAaBfuvLkfRUzGC4ElHZ5CRp',
      'hashTag' => '#اليمن'
    ),
	'iq' => array (
      'consumer_key' => 'x6BQO6ApZKDnFjm3vBHxKx5jg',
      'consumer_secret' => '0UxM8forB8fRLugy775JCXWu9rIG6ZW6VIgNMa2h2HxbNuu2t0',
	  'oauth_access_token' => '815208378901393409-y31yic91XNxxDdklDXMeSyNW2aOq1fG',
	  'oauth_access_token_secret'=> 'cgb11Iyd26Opn4pqckT8X9N5iH7UtYdE5AeqRMZMZ95VM',
      'hashTag' => '#العراق'
    ),
    
	'all' => array(
      'consumer_key' => 'aCG9f8JITZy7DSZpb1NtIt7ra',
      'consumer_secret' => 'MZafOaKuVms6KAIfnefG3ZdxgHHRjbOHsbXuleddVfo1C2dWEi',
	  'oauth_access_token' => '506980160-4NatfEZjgr0PIQYb4EbogeSbCPdLZhZsOFDu4iuF',
	  'oauth_access_token_secret'=> 'lXq4N9rlf5nnhss6xafPTZgwW9FdriROenldv3MH3AHTP',
      'hashTag' => '#مصر #اخبار'
    ),
	
    
));