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

require_once ROOT . DS . APP_DIR . DS . 'Lib/ForceUTF8/Encoding.php';

if (!defined('FULL_BASE_URL'))
{
    define('FULL_BASE_URL', Configure::read('App.fullBaseUrl'));
}

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 * 
 * @property Article $Article
 * @property SourcesRss $SourcesRss
 */
class CronController extends AppController
{

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array('SourcesRss', 'Article', 'Country');

    // App Controller Code.
    public function beforeFilter()
    {
        $this->layout = NULL;

        $this->initializeAuth();

        @ini_set('memory_limit', '5024M');

        Configure::write('debug', 2);

        parent::beforeFilter();
    }

    public function reader()
    {
        //if (!defined('CRON_DISPATCHER')) {
          //  $this->redirect('/');
          //  exit();
        //}

        $this->autoRender = FALSE;

        $file = new File(ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'cron.log');

        $expire = $file->lastChange() + 60;

        if ($file->exists() && $expire > time()) {
            exit;
        } else {
            $fw = "Cron Start " . date('d-m-Y h:i:s') . PHP_EOL;
            $fw .= $file->path . PHP_EOL;
            $file->write($fw);
            $file->close();
        }

        $countries = $this->Country->find('list', array(
            'conditions' => array('Country.status' => 1),
            'fields' => array('Country.id', 'Country.code'),
			'order' => array('Country.order ASC', 'Country.id ASC'),
        ));

		while (list ($key, $value) = each($countries))
        {
            $this->SourcesRss->unbindModel(
                    array('belongsTo' => array('Category', 'Country'))
            );

            $sourcesRss = $this->SourcesRss->find('all', array(
                'conditions' => array('SourcesRss.status' => 1, 'Source.status' => 1, 'SourcesRss.country_id' => $key),
            ));

            foreach ($sourcesRss as $sources)
            {
                echo $sources['SourcesRss']['link'] . "\n \r";

                $xmlObject = json_decode($sources['Source']['xml']);
                $htmlObject = json_decode($sources['Source']['html']);
                
                if (empty($xmlObject->permalink))
                {
                    $articels = $this->getHtmlParams($sources['SourcesRss']['link'], $htmlObject);
                }
                else
                {
                    $articels = $this->getXmlParams($sources['SourcesRss']['link'], $xmlObject);
                }

                for ($i = 0; $i < 2; $i++)
                {
                    if (empty($articels['permalink'][$i]))
                    {
                        break;
                    }

                    $result = $this->Article->find('count', array(
                        'recursive' => -1,
                        'conditions' => array(
							// "MATCH(title) AGAINST ('".$articels['title'][$i]."' IN BOOLEAN MODE)",
                            'OR' => array(
                                'Article.permalink' => $this->_urlEncoding($articels['permalink'][$i], $sources['Source']['domain']),
                                "Article.title" => "" . $articels['title'][$i] . "",
                            ),
                            // 'Article.source_id' => $sources['SourcesRss']['source_id'],
                        )
                    ));
                    
                    if ($result >= 1)
                    {
                        break;
                    }

                    if (empty($articels['content'][$i]))
                    {
                        $content = $this->getContent($articels['permalink'][$i], $htmlObject->content);
                    }
                    else
                    {
                        $content = $this->clearContent($sources['Source']['domain'], $articels['content'][$i]);
                    }

                    $image = null;
                    if (empty($articels['image'][$i]))
                    {
                        if (!empty($htmlObject->imagesrc))
                        {
                            $imageArray['src'] = $this->getByParams($articels['permalink'][$i], $htmlObject->imagesrc);
                        }
                        if (!empty($htmlObject->imagealt))
                        {
                            $imageArray['caption'] = $this->getByParams($articels['permalink'][$i], $htmlObject->imagealt);
                        }
                        if (!empty($imageArray))
                        {
                            $image = json_encode($imageArray);
                        }
                    }
                    else
                    {
                        if (!empty($articels['image'][$i]))
                        {
                            $image = json_encode(array('src' => $articels['image'][$i]));
                        }
                    }

                    $publish_up = date("Y-m-d H:i:s");
                    $data['Article'] = array(
                        'permalink' => $this->_urlEncoding($articels['permalink'][$i], $sources['Source']['domain']),
                        'title' => $articels['title'][$i],
                        'publish_up' => $publish_up,
                        'source_id' => $sources['SourcesRss']['source_id'],
                        'country_id' => $sources['SourcesRss']['country_id'],
                    );

                    if (!empty($image))
                    {
                        $data['Article']['image'] = $image;
                    }

                    if (!empty($content))
                    {
                        $data['Article']['content'] = $content;
                    }

                    $this->Article->create();

                    $return = $this->Article->save($data);

                    $data['Article']['id'] = $this->Article->getLastInsertID();

                    $this->_postTweet($value, $data, $sources['Source']['name']);

                    unset($data);

                    Cache::clear();

                    echo "Done insert \n \r";
                }
	
                unset($articels);
                unset($sources);
                unset($sourcesRss);
            }
			
			// exit;
        }

        echo date('Y-m-d h:i:s') . "\n \r";

        $file->delete();

        $file->close();

        echo "delete File \n \r";

        $parsed = parse_url(FULL_BASE_URL);
        if ($parsed['host'] == 'www.3ajeel.com')
        {
            $this->_generateSitemap();
        }

        exit;
    }

    /**
     * get content from html page by DOMXPath
     * @param string $permalink     page url
     * @param string $params        part you need take
     * @return string
     */
    protected function getByParams($permalink, $params)
    {
        $html = new DOMDocument();
        @$html->loadHTMLFile($permalink);
        $xpath = new DOMXPath($html);
        $articels = array();

        $result = null;
        $nodelist = $xpath->query($params);
        foreach ($nodelist as $n)
        {
            $result = $n->nodeValue . "\n";
        }

        return $result;
    }

    /**
     * get content from html page 
     * 
     * @param string $permalink     page url
     * @param string $params        part you need take
     * @return string
     */
    protected function getContent($permalink, $params)
    {
        $html = new DOMDocument();
        @$html->loadHTMLFile($permalink);
        $xpath = new DOMXPath($html);
        $articels = array();

        $result = null;
        $nodelist = $xpath->query($params);
        foreach ($nodelist as $n)
        {
            $result .= $n->nodeValue . "\n";
        }

        $parse = parse_url($permalink);

        $result = $this->clearContent($parse['host'], $result);

        return $result;
    }

    /**
     * clear content for spical chart
     * 
     * @param string $domain 'http://www.youm7.com'
     * @param string $content
     * @return type
     */
    protected function clearContent($domain, $content)
    {
        switch ($domain)
        {
            case 'www.shorouknews.com':
                $content = ForceUTF8\Encoding::toWin1252($content);
                break;
            case 'www.vetogate.com':
                $content = ForceUTF8\Encoding::toWin1252($content);
                break;
            default :
                $content;
        }

        return strip_tags(trim($content));
    }

    /**
     * Generate new sitemap
     * @return type
     */
    protected function _generateSitemap()
    {
		$articles = $this->Article->find('all', array(
            'recursive' => -1,
            'conditions' => array('Article.status' => 1, 'Article.publish_up >= "'.date( "Y-m-d", strtotime("-1 day")).'"'),
            'fields' => array('id', 'title'),
            'order' => array('Article.publish_up' => 'DESC'),
        ));

		$out = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $out .='<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . PHP_EOL;
            
        while (list(, $source) = each($articles))
        {
            $out .= '<url>' . PHP_EOL;
            $out .= '<loc>' . FULL_BASE_URL . '/article/' . $source['Article']['id'] . '-' . $this->_cleanString($source['Article']['title']) . '</loc>' . PHP_EOL;
            $out .= '<changefreq>never</changefreq>' . PHP_EOL;
            $out .= '</url>' . PHP_EOL;
        }
            
        $out .= '</urlset>';

        $file = new File(ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'articles.xml', true);
        $file->write($out);
        $file->close();
                
        sleep(2);

        echo 'ping Google <br />';
        $this->_pingGoogle('articles.xml');
//        $this->_pingAsk('articles.xml');
        echo 'ping Bing <br />';
        $this->_pingBing('articles.xml');
        echo 'ping Yahoo <br />';
        $this->_pingYahoo('articles.xml');
        echo 'ping Server <br />';
        $this->_pingServer();

        return;
    }

    
    protected function _postTweet($country, $data, $source)
    {

        $countryName = $this->Country->find('first', array(
            'recursive' => -1,
            'conditions' => array('Country.code' => $country),
            'fields' => array('Country.id', 'Country.name'),
        ));

        $countryName = preg_replace('/[-\s]+/', '_', $countryName['Country']['name']);

        $source = preg_replace('/[-\s]+/', '_', $source);

        $twitterApi = Configure::read('TwitterAPI');

        include_once ROOT . DS . APP_DIR . DS . 'Lib/TwitterAPIExchange.php';

        if (array_key_exists($country, $twitterApi))
        {

            $settings = array(
                'consumer_key' => $twitterApi[$country]['consumer_key'],
                'consumer_secret' => $twitterApi[$country]['consumer_secret'],
                'oauth_access_token' => $twitterApi[$country]['oauth_access_token'],
                'oauth_access_token_secret' => $twitterApi[$country]['oauth_access_token_secret']
            );

            $postFields['status'] = '#عاجل #' . $countryName . ' #' . $source . ' ' . $data['Article']['title'] . '  ' . FULL_BASE_URL . '/article/' . $data['Article']['id'];
            $twitter = new TwitterAPIExchange($settings);
            $rs = json_decode($twitter->buildOauth('https://api.twitter.com/1.1/statuses/update.json', 'POST')->setPostfields($postFields)->performRequest());
        }

        $settings = array(
            'consumer_key' => $twitterApi['all']['consumer_key'],
            'consumer_secret' => $twitterApi['all']['consumer_secret'],
            'oauth_access_token' => $twitterApi['all']['oauth_access_token'],
            'oauth_access_token_secret' => $twitterApi['all']['oauth_access_token_secret']
        );

        $postFields['status'] = '#عاجل #' . $countryName . ' #' . $source . ' ' . $data['Article']['title'] . '  ' . FULL_BASE_URL . '/article/' . $data['Article']['id'];
        $twitter = new TwitterAPIExchange($settings);
        $rs = json_decode($twitter->buildOauth('https://api.twitter.com/1.1/statuses/update.json', 'POST')->setPostfields($postFields)->performRequest());

        return true;
    }

    protected function getHtmlParams($sourceLink, $params)
    {
        $html = new DOMDocument();
        @$html->loadHtmlFile($sourceLink);
        $xpath = new DOMXPath($html);
        $articel = array();
        $nodelist = $xpath->query($params->title);
        foreach ($nodelist as $n) {
            $articel['title'][] = $n->nodeValue;
        }
        $nodelist = $xpath->query($params->publish_up);
        foreach ($nodelist as $n) {
            $articel['date'][] = $n->nodeValue;
        }
        $nodelist = $xpath->query($params->permalink);
        foreach ($nodelist as $n) {
            $parsed = parse_url($sourceLink);
            if ($parsed['host'] == 'www.skynewsarabia.com')
            {
                $articel['permalink'][] = 'http://www.skynewsarabia.com/'.$n->nodeValue;
            }else {
                $articel['permalink'][] = $n->nodeValue;
            }
        }

        $nodelist = $xpath->query($params->content);
        foreach ($nodelist as $n) {
            $articel['content'][] = $n->nodeValue;
        }
        
        $nodelist = $xpath->query($params->publish_up);
        foreach ($nodelist as $n) {
            $articel['publish_up'][] = $n->nodeValue;
        }
        
        $nodelist = $xpath->query($params->imagesrc);
        foreach ($nodelist as $n) {
            $imageArray['src'] = $n->nodeValue;
        }
        
        $nodelist = $xpath->query($params->imagealt);
        foreach ($nodelist as $n) {
            $imageArray['caption'] = $n->nodeValue;
        }
        
        $articel['image'][] = json_encode($imageArray);
        
        return $articel;
    }
    
    protected function getXmlParams($sourceLink, $params)
    {
        $html = new DOMDocument();
        @$html->load($sourceLink);
        $xpath = new DOMXPath($html);
        $articels = array();
        if (!empty($params->title))
        {

            $nodelist = $xpath->query($params->title);

            foreach ($nodelist as $n)
            {
                $articels['title'][] = $n->nodeValue;
            }
        }

        if (!empty($params->permalink))
        {

            $nodelist = $xpath->query($params->permalink);

            foreach ($nodelist as $n)
            {

                $articels['permalink'][] = $n->nodeValue;
            }
        }

        if (!empty($params->content))
        {

            $nodelist = $xpath->query($params->content);

            foreach ($nodelist as $n)
            {

                $articels['content'][] = $n->nodeValue;
            }
        }


        if (!empty($params->image))
        {

            $nodelist = $xpath->query($params->image);

            foreach ($nodelist as $n)
            {

                if (!empty($n->nodeValue))
                {

                    $articels['image'][] = $n->nodeValue;
                }
            }
        }
        
        if (!empty($params->publish_up))
        {

            $nodelist = $xpath->query($params->publish_up);

            foreach ($nodelist as $n)
            {

                if (!empty($n->nodeValue))
                {

                    $articels['publish_up'][] = $n->nodeValue;
                }
            }
        }
        
        return $articels ;
    }
}
