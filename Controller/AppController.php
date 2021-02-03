<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */
App::uses ('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @property AuthComponent $Auth
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{


    /**
     * Components
     *
     * @var array
     */
    public $components = array('Session', 'Auth', 'RequestHandler', 'Paginator', 'DebugKit.Toolbar', 'Cookie');


    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array('Session', 'Html', 'Form');


    /**
     * page layout 
     * @var string 
     */
    public $layout = 'default';


    /**
     * Page title 
     * @var string 
     */
    public $pageTitle = null;


    // App Controller Code.
    public function beforeFilter()
    {
        $this->initializeAuth (array('index', 'home', 'display', 'loadMore', 'rss'));
        if (!isset ($this->request->params['prefix'])) {
            $this->_detectLocation ();
            $this->response->disableCache ();
        }
		
		parent::beforeFilter ();
    }


    public function beforeRender()
    {
        $this->set ('title_for_layout', $this->pageTitle);

        if (isset ($this->request->params['prefix']) && $this->request->params['prefix'] == 'cpadmin') {
            $this->layout = 'admin';
        }

        $this->set ('site_description', __ ('site_description'));

        if (!isset ($this->request->params['prefix'])) {
            $this->loadCountries ();
            $this->loadTags ();
        }

        parent::beforeRender ();
    }


    /**
     * load categories 
     */
    protected function loadCategories()
    {
        $this->loadModel ('Category');

        $this->Category->recursive = -1;
        $categories = $this->Category->find ('all', array(
            'fields' => array('Category.id', 'Category.name', 'Category.alias'),
            'conditions' => array('Category.status' => 1),
        ));

        $this->set ('categories', $categories);
    }


    /**
     * load categories 
     */
    protected function loadCountries()
    {
        $countries = $this->_getObjectCache ('countries', '3600');

        if (empty ($countries) || $countries === FALSE) {
            $this->loadModel ('Country');
            $this->Country->recursive = -1;
            $countries = $this->Country->find ('all', array(
                'fields' => array('Country.id', 'Country.name', 'Country.alias'),
                'conditions' => array('Country.status' => 1),
				'order' => array('Country.order asc'),
            ));

            $this->_setObjectCache ('countries', $countries);
        }


        $this->set ('countries', $countries);
    }


    /**
     * load categories 
     */
    protected function loadTags()
    {
        $tags = $this->_getObjectCache ('tags', '3600');

        if (empty ($tags) || $tags === FALSE) {

            $this->loadModel ('Tag');
            $this->Tag->recursive = -1;
            $tags = $this->Tag->find ('all', array(
                'fields' => array('Tag.id', 'Tag.name', 'Tag.alias'),
                'conditions' => array('Tag.status' => 1),
                'order' => array('Tag.hits' => 'DESC'),
                'limit' => 15,
            ));

            $this->_setObjectCache ('tags', $tags);
        }

        $this->set ('tags', $tags);
    }


    protected function initializeAuth($allow = NULL)
    {
        $this->Auth->authenticate = ClassRegistry::init ('User');

        $this->Auth->allow ($allow);

        // By default, the Auth component expects a username and a password
        // columns in the User table. But we would like to override those defaults
        // and use the email column instead of the username column.
        $this->Auth->authenticate = array(
            AuthComponent::ALL => array(
                'fields' => array(
                    'username' => 'username',
                    'password' => 'password'
                ),
                'userModel' => 'Users.User',
                'scope' => array('User.active' => 1)
            ), 'Form'
        );

        $this->Auth->loginAction = array('cpadmin' => true, 'controller' => 'users', 'action' => 'login');

        $this->Auth->logoutRedirect = array('cpadmin' => false, 'controller' => '/', 'action' => '/');

        $this->Auth->loginRedirect = array('cpadmin' => true, 'controller' => 'users', 'action' => 'dashboard');
    }


    /**
     * get userId from Session 
     */
    public function _getUserId()
    {
        return $this->Session->read ('Auth.User.id');
    }


    protected function _detectLocation()
    {
        $countryCode = $this->Cookie->read ('countryCode');

        if ($this->params['controller'] == 'articles' && $this->params['action'] == 'home') {
            if (!isset ($countryCode) && empty ($countryCode)) {
                if (isset ($_SERVER["HTTP_CF_IPCOUNTRY"]) || !empty ($_SERVER["HTTP_CF_IPCOUNTRY"])) {
                    $countryCode = strtolower ($_SERVER["HTTP_CF_IPCOUNTRY"]);
                } else {
                    $geoplugin = unserialize (file_get_contents ('http://www.geoplugin.net/php.gp?ip=' . $this->_getUserIP ()));
                    $countryCode = strtolower ($geoplugin['geoplugin_countryCode']);
                }
            } elseif ($countryCode == 'all') {
                return;
            }

            $this->loadModel ('Country');
            $this->Country->recursive = -1;
            $countries = $this->Country->find ('first', array('conditions' => array('Country.code' => $countryCode)));

            if (!empty ($countries['Country']['alias'])) {
                $this->Cookie->write ('countryCode', $countryCode, false, time () - 300);
                $this->redirect (array('controller' => '/', 'action' => $countries['Country']['alias']));
            } else {
                $this->Cookie->write ('countryCode', 'all');
            }
        }
    }


    protected function _getUserIP()
    {
        if (isset ($_SERVER["HTTP_CF_CONNECTING_IP"]) || !empty ($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            return $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else if (array_key_exists ('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty ($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (strpos ($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
                $addr = explode (",", $_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim ($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }


    /*
     * This make a GET petition to search engine url
     */


    protected function __ping_site($url = null, $params = null)
    {
        if (is_null ($url) || empty ($url) || is_null ($params) || empty ($params)) {
            return false;
        }
        App::uses ('HttpSocket', 'Network/Http');
        $HttpSocket = new HttpSocket();
        $html = $HttpSocket->get ($url, $params);
        return $HttpSocket->response;
    }


    /*
     * Function for ping Google
     */


    function _pingGoogle($sitemap = 'articles.xml')
    {
        // fail if we are in local environment
        Configure::write ('debug', 0);
        $sitemap = $sitemap . '?t=' . time ();
        //ping to Google 
        $url = 'http://www.google.com/webmasters/tools/ping';
        $params = 'sitemap=' . FULL_BASE_URL . '/' . $sitemap;
        $this->__ping_site ($url, $params);

        //ping to Feedburner 
        $url = 'http://feedburner.google.com/fb/a/pingSubmit';
        $params = 'bloglink=' . FULL_BASE_URL . '/' . $sitemap;
        $this->__ping_site ($url, $params);

        //ping to weblogs 
        $url = 'http://rpc.weblogs.com/pingSiteForm';
        $params = 'BlogTitle=' . __ ('3ajeel', true) . '&url=' . FULL_BASE_URL . '/' . $sitemap;
        return $this->__ping_site ($url, $params);
    }


    /*
     * Function for ping Ask.com
     */


    function _pingAsk($sitemap = 'articles.xml')
    {
        return;
//        // fail if we are in local environment
//        Configure::write('debug', 0);
//        $url = 'http://submissions.ask.com/ping';
//        $params = 'sitemap='.FULL_BASE_URL.'/'.$sitemap;
//        return $this->__ping_site($url, $params);
    }


    /*
     * Function for ping Yahoo
     */


    function _pingYahoo($sitemap = 'articles.xml')
    {
        return;
//        Configure::write('debug', 0);
//        $url = 'http://search.yahooapis.com/SiteExplorerService/V1/updateNotification';
//        $params = 'appid=' . $this->yahoo_key . '&url='.FULL_BASE_URL.'/'.$sitemap;
//        return $this->__ping_site($url, $params);
    }


    /*
     * Function for ping Bing
     */


    function _pingBing($sitemap = 'articles.xml')
    {
        Configure::write ('debug', 0);
        $sitemap = $sitemap . '?t=' . time ();
        $url = 'http://www.bing.com/webmaster/ping.aspx';
        $params = 'siteMap=' . FULL_BASE_URL . '/' . $sitemap;
        return $this->__ping_site ($url, $params);
    }


    protected function _pingServer()
    {
        Configure::write ('debug', 0);
        $blogpost = array(
            'title' => __ ('3ajeel'),
            'postlink' => FULL_BASE_URL
        );

        $pingservers = Configure::read ('Conifg.pingservers');
        //Check if pingserver is set, or show an error message
        if (count ($pingservers) > 0) {

            //Go throug all the pingservers an start pinging.
            foreach ($pingservers as $server) {

                $parse = parse_url ($server);
                if (!isset ($parse['host']))
                    return false;
                $host = $parse['host'];
                $scheme = $parse['scheme'] . "://";
                $port = isset ($parse['port']) ? $parse['port'] : 80;
                $uri = isset ($parse['path']) ? $parse['path'] : '/';

                $fp = fsockopen ($host, $port, $errno, $errstr);
                if (!$fp) {
                    return array(-1, "Cannot open connection: $errstr ($errno)<br />\r\n");
                }

                //Set methodname according to ping type
                $methodName = "weblogUpdates.ping";

                $data = "<?xml version=\"1.0\"?>\r\n
                <methodCall>\r\n
                    <methodName>" . $methodName . "</methodName>\r\n
                    <params>\r\n
                        <param>\r\n
                            <value><string>" . $blogpost['title'] . "</string></value>\r\n
                        </param>\r\n
                        <param>\r\n
                            <value><string>" . $blogpost['postlink'] . "</string></value>\r\n
                        </param>\r\n
                    </params>\r\n
                </methodCall>";


                $len = strlen ($data);
                $out = "POST $uri HTTP/1.0\r\n";
                $out .= "User-Agent: BlogPing 1.0\r\n";
                $out .= "Host: $host\r\n";
                $out .= "Content-Type: text/xml\r\n";
                $out .= "Content-length: $len\r\n\r\n";
                $out .= $data;

                fwrite ($fp, $out);
                $response = '';
                while (!feof ($fp))
                    $response.=fgets ($fp, 128);
                fclose ($fp);

                $lines = explode ("\r\n", $response);

                $firstline = $lines[0];
                if (!ereg ("HTTP/1.[01] 200 OK", $firstline)) {
                    return array(-1, $firstline);
                }

                while ($lines[0] != '')
                    array_shift ($lines);
                array_shift ($lines);
                $lines = strip_tags (implode (' ', $lines));

                $n = preg_match (
                        '|<member>\s*<name>flerror</name>\s*<value>\s*<boolean>([^<]*)</boolean>\s*</value>\s*</member>|i', $response, $matches);
                if (0 == $n) {
                    return array(-1, $lines);
                }
                $flerror = $matches[1];

                $n = preg_match (
                        '|<member>\s*<name>message</name>\s*<value>\s*<string>([^<]*)</string>\s*</value>\s*</member>|i', $response, $matches);
                if (0 == $n) {
                    return array(-1, $lines);
                }

                $message = $matches[1];

                return;
            }
        }
    }


    protected function _getObjectCache($filename, $expire = 60)
    {
        $returnData = FALSE;
        $file = new File (ROOT . DS . APP_DIR . DS . 'tmp/cache/' . $filename . '.log');
        $expire_stamp = $file->lastChange () + $expire;
        if ($file->exists () && $expire_stamp >= time ()) {
            $returnData = unserialize ($file->read ());
        }

        $file->close ();

        return $returnData;
    }


    protected function _setObjectCache($filename, $data, $expire = 60)
    {
        $file = new File (ROOT . DS . APP_DIR . DS . 'tmp/cache/' . $filename . '.log');

        $file->write (serialize ($data));

        //close
        $file->close ();

        return;
    }


    /**
     * remove regx char (�, :, !)
     * @param type $string
     * @return type
     */
    protected function _cleanString($string = NULL)
    {
		$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "?", "»", "«", "\"\ ", "?");

        // $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "+", "[", "{", "]",
        //     "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        //     "â€”", "â€“", ",", "<", ".", ">", "/", "?", "»", "«", "\"\ ", "?");

        if (!is_null ($string)) {
            //$string = trim (str_replace ($strip, "", strip_tags ($string)));
            $string = preg_replace ('/[-\s]+/', '-', $string);
        }
        return $string;
    }


    protected function _urlEncoding($url, $domain=NULL)
    {
		$domainArray = array (
			'cairoportal.com', 'thebaghdadpost.com', 'alarab.qa'
		);
		
		$parse = parse_url(trim($url)); 
		$domainUrl = preg_replace('/^www\./', '', $parse['host']);
		
		if(in_array($domainUrl, $domainArray)) 
		{
			$url = preg_replace('/[^A-Za-z0-9\/:.?=&-_]/', '', trim($url));	
		}
		else 
		{
			$url = htmlspecialchars ($url, ENT_QUOTES, "UTF-8");
		}
		
		// switch ($domain) {
            // case 'cairoportal.com':
                // $url = htmlspecialchars ($url, ENT_QUOTES, "UTF-8");
                // $url = preg_replace('/[^A-Za-z0-9\/:.?=&-_]/', '', $url);
                // break;
			// case 'thebaghdadpost.com':
                // $url = preg_replace('/[^A-Za-z0-9\/:.?=&-_]/', '', $url);
                // break;
			// case 'alarab.qa':
                // $url = preg_replace('/[^A-Za-z0-9\/:.?=&-_]/', '', $url);
                // break;
			// case 'almesryoon.com':
                // $url = htmlspecialchars ($url, ENT_QUOTES, "UTF-8");
                // break;
            // default :
               // $url = $this->_cleanString($url);
        // }

		return $url;
    }

    protected function _clearCache($filename)
    {
        @unlink(ROOT . DS . APP_DIR . DS . 'tmp/cache/' . $filename . '.log');
    }

}
