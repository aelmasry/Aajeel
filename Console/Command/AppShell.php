<?php
/**
 * AppShell file
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 2.0
 */

App::uses('Shell', 'Console');
//App::uses('Encoding', 'Lib/ForceUTF8');
include_once ROOT.DS.APP_DIR.DS.'Lib/ForceUTF8/Encoding.php';
/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class AppShell extends Shell 
{
    
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
        foreach ($nodelist as $n){
            $result = $n->nodeValue."\n";
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
        foreach ($nodelist as $n){
            $result .= $n->nodeValue."\n";
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
        switch ($domain) {
            case 'http://www.youm7.com':
                $content = explode("<span Class='NewsSubTitleText'>" , $content);
                $content = $content[0];
                break;
            case 'www.shorouknews.com':
                $content = ForceUTF8\Encoding::toWin1252($content);
                break;
            default :
               $content;
        }
        
        return strip_tags(trim($content));
    }
}
