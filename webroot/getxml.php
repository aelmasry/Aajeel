<?php
@header('Content-Type: text/html; charset=utf-8');
$html = new DOMDocument();
$html->load('http://www.alwafd.org/index.php?format=feed&type=rss');
$xpath = new DOMXPath($html);
$articel = array();
$nodelist = $xpath->query("//item//title");
foreach ($nodelist as $n){
	$articel['title'][] = $n->nodeValue;
}
$nodelist = $xpath->query("//item//link");
foreach ($nodelist as $n){
	$articel['permalink'][] = $n->nodeValue."\n";
}
// $nodelist = $xpath->query("//item//	");
// foreach ($nodelist as $n){
 // $articel['content'][] = $n->nodeValue."\n";
// }
// $nodelist = $xpath->query("//enclosure");
// foreach ($nodelist as $n){
	// $articel['image'][] = $n->nodeValue."\n";
// }
$nodelist = $xpath->query("//item//pubDate");
foreach ($nodelist as $n){
	$articel['pubDate'][] = date("Y-m-d h:i:s", strtotime($n->nodeValue));
}



echo '<pre>';
print_r($articel);
echo '</pre>';