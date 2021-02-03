<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

ignore_user_abort(true); // run script in background

set_time_limit(0);       // run script forever 

App::uses('AppShell', 'Console/Command');

/**

 * Description of cron

 *

 * @author ali

 */
class HtmlCronShell extends AppShell
{

    /**

     * This controller does not use a model

     *

     * @var array

     */
    public $uses = array('SourcesRss', 'Article');

    public function main()
    {
        $this->out('Cron job working HTML.');

        $sourcesRss = $this->SourcesRss->find('all', array(
            'conditions' => array('SourcesRss.status' => 1, 'Source.getdata' => 'html', 'Source.status' => 1)
        ));

        foreach ($sourcesRss as $sources) 
        {
            $this->out($sources['Source']['domain']);

            $xmlObject = json_decode($sources['Source']['xml']);

            $htmlObject = json_decode($sources['Source']['html']);

            $html = new DOMDocument();

            $html->load($sources['SourcesRss']['link']);

            $xpath = new DOMXPath($html);

            $articels = array();

            if (!empty($xmlObject->title)) {

                $nodelist = $xpath->query($xmlObject->title);

                foreach ($nodelist as $n) {

                    $articels['title'][] = $n->nodeValue;
                }
            }

            if (!empty($xmlObject->permalink)) {

                $nodelist = $xpath->query($xmlObject->permalink);

                foreach ($nodelist as $n) {

                    $articels['permalink'][] = $n->nodeValue;
                }
            }

            if (!empty($xmlObject->content)) {

                $nodelist = $xpath->query($xmlObject->content);

                foreach ($nodelist as $n) {

                    $articels['content'][] = $n->nodeValue;
                }
            }


            if (!empty($xmlObject->image)) {

                $nodelist = $xpath->query($xmlObject->image);

                foreach ($nodelist as $n) {

                    if (!empty($n->nodeValue)) {

                        $articels['image'][] = $n->nodeValue;
                    }
                }
            }


            if (!empty($xmlObject->publish_up)) {

                @$nodelist = $xpath->query($xmlObject->publish_up);

                foreach ($nodelist as $n) {

                    $publish_up = date("Y-m-d H:i:s", strtotime($n->nodeValue));
                    if(empty($publish_up)) {
                        $publish_up = date("Y-m-d H:i:s");
                    }

                    $articels['publish_up'][] = $publish_up;
                }
            }

            for ($i = 0; $i < count($articels['title']); $i++) 
            {
                if ($sources['Source']['getdata'] == 'html' || empty($articels['content'][$i])) {
                    $content = $this->getContent($articels['permalink'][$i], $htmlObject->content);
                }else { 
                    $content = $this->clearContent($sources['Source']['domain'], $articels['content'][$i]);
                }

                if (empty($articels['image'][$i])) {

                    if (!empty($htmlObject->imagesrc)) {

                        $imageArray['src'] = $this->getByParams($articels['permalink'][$i], $htmlObject->imagesrc);
                    }

                    if (!empty($htmlObject->imagealt)) {

                        $imageArray['caption'] = $this->getByParams($articels['permalink'][$i], $htmlObject->imagealt);
                    }

                    $image = json_encode($imageArray);
                } else {

                    $image = json_encode(array('src' => $articels['image'][$i]));
                }


                if (empty($articels['permalink'][$i])) {
                    break;
                } else {

                    $result = $this->Article->find('count', array(
                        'conditions' => array('Article.permalink' => $articels['permalink'][$i])
                    ));

                    if ($result >= 1) {
                        break;
                    } else {

                        $this->out($articels['permalink'][$i]);

                        $data['Article'] = array(
                            'permalink' => $articels['permalink'][$i],
                            'title' => $articels['title'][$i],
                            'publish_up' => $articels['publish_up'][$i],
                            'alias' => preg_replace('/\s+/', '-', trim($articels['title'][$i])),
                            'content' => $content,
                            'image' => $image,
                            'category_id' => $sources['SourcesRss']['category_id'],
                            'source_id' => $sources['SourcesRss']['source_id']
                        );



                        $this->Article->create();

                        $this->Article->save($data);
                    }

                    unset($data);
                }
            }

            unset($articels);
        }
        
        $this->out('Cron job working XML.');
        
        $sourcesRss = $this->SourcesRss->find('all', array(
           'conditions' => array('SourcesRss.status' =>  1, 'Source.getdata' => 'xml', 'Source.status' =>  1) 
        ));
        
        foreach($sourcesRss as $sources) 
        {
            if($sources['Source']['getdata'] == 'xml') {
                $this->out($sources['Source']['domain']);
                $xmlObject = json_decode($sources['Source']['xml']);
                $htmlObject = json_decode($sources['Source']['html']);
                $html = new DOMDocument();
                $html->load($sources['SourcesRss']['link']);
                $xpath = new DOMXPath($html);
                $articels = array();
                if(!empty($xmlObject->title)) {
                    $nodelist = $xpath->query($xmlObject->title);
                    foreach ($nodelist as $n) {
                        $articels['title'][] = $n->nodeValue;
                    }
                }
				if(!empty($xmlObject->permalink)) {
                   $nodelist = $xpath->query($xmlObject->permalink);
                   foreach ($nodelist as $n) {
                       $articels['permalink'][] = $n->nodeValue;
                   }
				}
				if(!empty($xmlObject->content)) {
                   $nodelist = $xpath->query($xmlObject->content);
                   foreach ($nodelist as $n) {
                       $articels['content'][] = $n->nodeValue;
                   }
               }
               if(!empty($xmlObject->image)) {
                   $nodelist = $xpath->query($xmlObject->image);
                   foreach ($nodelist as $n) {
                       if(!empty($n->nodeValue)) {
                           $articels['image'][] = $n->nodeValue;
                       }
                   }
               }
               if(!empty($xmlObject->publish_up)) {
                   @$nodelist = $xpath->query($xmlObject->publish_up);
                   foreach ($nodelist as $n) {
                       $articels['publish_up'][] = date("Y-m-d H:i:s", strtotime($n->nodeValue));
                   }
               }
				
				for($i= 0; $i<count($articels['title']); $i++) {   
                   if($sources['Source']['getdata'] == 'html' || empty($articels['content'][$i])) {
                       $content = $this->getContent($articels['permalink'][$i], $htmlObject->content);
                   }else {
                       $content = $this->clearContent($sources['Source']['domain'], $articels['content'][$i]);
                   }
                
                   if(empty($articels['image'][$i])) {
                       $src = $this->getByParams($articels['permalink'][$i], $htmlObject->imagesrc);
                       $caption = $this->getByParams($articels['permalink'][$i], $htmlObject->imagealt);
                       $imageArray['src'] = $src;
                       $imageArray['caption'] = $caption;
                       $image = json_encode($imageArray);
                   }else {
                       $image = json_encode(array('src'=> $articels['image'][$i]));
                   }
				  if(empty($articels['permalink'][$i])) {
                       break;
                   }else {
                       $result = $this->Article->find('count', array(
                           'conditions' => array('Article.permalink' => $articels['permalink'][$i])
                       ));
					
                       if($result >= 1) {
                           break;
                       }else {
                           $this->out($articels['permalink'][$i]);
                           $data['Article'] = array(
                               'permalink' => $articels['permalink'][$i],
                               'title' => $articels['title'][$i],
                               //'publish_up' => $articels['publish_up'][$i],
                               'alias' => preg_replace('/\s+/', '-', trim($articels['title'][$i])),
                               'content' => $content,
                               'image' => $image,
                               'category_id' => $sources['SourcesRss']['category_id'],
                               'source_id' => $sources['SourcesRss']['source_id']
                           );
							$this->Article->create();
                           $this->Article->save($data);
						}
                       unset($data);
                   }
               }
               unset($articels);
           }
       }
       
       Cache::clear();
       
       sleep(60);

       $this->main();
    }

}
