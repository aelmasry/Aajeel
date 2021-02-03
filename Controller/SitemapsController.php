<?php

/**
 * @property Article $Article 
 */
class SitemapsController extends AppController
{

    public $uses = array('Category', 'Country', 'Article');
            
    public function beforeRender()
    {
        $this->layout= NULL;
        parent::beforeRender();
    }
    /*
     * Our sitemap 
     */
    public function index()
    {
        $dynamics = $this->__get_data();
        $this->set('dynamics', $dynamics);
        //var_dump($this->RequestHandler->accepts('xml')); exit;
        if ($this->RequestHandler->accepts('html')) {
            $this->RequestHandler->respondAs('html');
        } elseif ($this->RequestHandler->accepts('xml')) {
            $this->RequestHandler->respondAs('xml');
        }
    }

    /*
     * Action for send sitemaps to search engines
     */

    public function send_sitemap()
    {
        // This action must be only for admins
    }

    /*
     * This make a simple robot.txt file use it if you don't have your own
     */

    public function robot()
    {
        Configure::write('debug', 0);
        $expire = 25920000;
        header('Date: ' . date("D, j M Y G:i:s ", time()) . ' GMT');
        header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $expire) . ' GMT');
        header('Content-Type: text/plain');
        header('Cache-Control: max-age=' . $expire . ', s-maxage=' . $expire . ', must-revalidate, proxy-revalidate');
        header('Pragma: nocache');
        echo 'User-Agent: *' . "\n" . 'Allow: /' . "\n" . 'Sitemap: ' . FULL_BASE_URL . $this->sitemap_url;
        exit();
    }

    /*
     * Here must be all our public controllers and actions
     */

    protected function __get_data()
    {
        $result['Section'] = $this->Category->find('list', array(
            'conditions' => array('Category.status'=> 1),
            'fields'=> array('Category.id', 'Category.alias'),
        ));
        
        $result['Country'] = $this->Country->find('list', array(
            'conditions' => array('Country.status'=> 1),
            'fields'=> array('Country.id', 'Country.alias'),
        ));
        
        $result['Article'] = $this->Article->find('all', array(
            'conditions' => array('Article.status'=> 1),
            'fields'=> array('Article.id', 'Article.alias'),
            'recursive' => -1,
        ));
       
            
    }

    /*
     * This make a GET petition to search engine url
     */

//    function __ping_site($url = null, $params = null)
//    {
//        if (is_null($url) || empty($url) || is_null($params) || empty($params)) {
//            return false;
//        }
//        App::import('Core', 'HttpSocket');
//        $HttpSocket = new HttpSocket();
//        $html = $HttpSocket->get($url, $params);
//        return $HttpSocket->response;
//    }

    /*
     * Show response for ajax based on a boolean result
     */

//    function __ajaxresponse($result = false)
//    {
//        if (!$result) {
//            return 'fail';
//        }
//        return 'success';
//    }

    /*
     * Function for ping Google
     */

//    function ping_google()
//    {
//        Configure::write('debug', 0);
//        $url = 'http://www.google.com/webmasters/tools/ping';
//        $params = 'sitemap=' . urlencode(FULL_BASE_URL . $this->sitemap_url);
//        echo $this->__ajaxresponse($this->__check_ok_google($this->__ping_site($url, $params)));
//        exit();
//    }

    /*
     * Function for check Google's response
     */

//    function __check_ok_google($response = null)
//    {
//        if (is_null($response) || !is_array($response) || empty($response)) {
//            return false;
//        }
//        if (
//                isset($response['status']['code']) && $response['status']['code'] == '200' &&
//                isset($response['status']['reason-phrase']) && $response['status']['reason-phrase'] == 'OK' &&
//                isset($response['body']) && !empty($response['body']) &&
//                strpos(strtolower($response['body']), "successfully added") != false) {
//            return true;
//        }
//        return false;
//    }

    /*
     * Function for ping Ask.com
     */

//    function ping_ask()
//    { // fail if we are in local environment
//        Configure::write('debug', 0);
//        $url = 'http://submissions.ask.com/ping';
//        $params = 'sitemap=' . urlencode(FULL_BASE_URL . $this->sitemap_url);
//        echo $this->__ajaxresponse($this->__check_ok_ask($this->__ping_site($url, $params)));
//        exit();
//    }

    /*
     * Function for check Ask's response
     */

//    function __check_ok_ask($response = null)
//    {
//        if (is_null($response) || !is_array($response) || empty($response)) {
//            return false;
//        }
//        if (
//                isset($response['status']['code']) && $response['status']['code'] == '200' &&
//                isset($response['status']['reason-phrase']) && $response['status']['reason-phrase'] == 'OK' &&
//                isset($response['body']) && !empty($response['body']) &&
//                strpos(strtolower($response['body']), "has been successfully received and added") != false) {
//            return true;
//        }
//        return false;
//    }

    /*
     * Function for ping Yahoo
     */

//    function ping_yahoo()
//    {
//        Configure::write('debug', 0);
//        $url = 'http://search.yahooapis.com/SiteExplorerService/V1/updateNotification';
//        $params = 'appid=' . $this->yahoo_key . '&url=' . urlencode(FULL_BASE_URL . $this->sitemap_url);
//        echo $this->__ajaxresponse($this->__check_ok_yahoo($this->__ping_site($url, $params)));
//        exit();
//    }

    /*
     * Function for check Yahoo's response
     */

//    function __check_ok_yahoo($response = null)
//    {
//        if (is_null($response) || !is_array($response) || empty($response)) {
//            return false;
//        }
//        if (
//                isset($response['status']['code']) && $response['status']['code'] == '200' &&
//                isset($response['status']['reason-phrase']) && $response['status']['reason-phrase'] == 'OK' &&
//                isset($response['body']) && !empty($response['body']) &&
//                strpos(strtolower($response['body']), "successfully submitted") != false) {
//            return true;
//        }
//        return false;
//    }

    /*
     * Function for ping Bing
     */

//    function ping_bing()
//    {
//        Configure::write('debug', 0);
//        $url = 'http://www.bing.com/webmaster/ping.aspx';
//        $params = '&siteMap=' . urlencode(FULL_BASE_URL . $this->sitemap_url);
//        echo $this->__ajaxresponse($this->__check_ok_bing($this->__ping_site($url, $params)));
//        exit();
//    }

    /*
     * Function for check Bing's response
     */

//    function __check_ok_bing($response = null)
//    {
//        if (is_null($response) || !is_array($response) || empty($response)) {
//            return false;
//        }
//        if (
//                isset($response['status']['code']) && $response['status']['code'] == '200' &&
//                isset($response['status']['reason-phrase']) && $response['status']['reason-phrase'] == 'OK' &&
//                isset($response['body']) && !empty($response['body']) &&
//                strpos(strtolower($response['body']), "thanks for submitting your sitemap") != false) {
//            return true;
//        }
//        return false;
//    }

}

?> 