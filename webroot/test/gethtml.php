<?php
header('Conte nt-Type: text/html; charset=utf-8');
include_once 'ForceUTF8/Encoding.php';

$html = new DOMDocument();
@$html->loadHtmlFile('http://www.almasryalyoum.com/news/details/395168');
$xpath = new DOMXPath($html);
$articel = array();
$nodelist = $xpath->query("//div[@class='article']/a");
foreach ($nodelist as $n) {
    $articel['title'] = $n->nodeValue . "\n";
}
$nodelist = $xpath->query("//div[@class='articleimg']//img//attribute::src");
foreach ($nodelist as $n) {
    $articel['imgsrc'] = $n->nodeValue;
}
$nodelist = $xpath->query("//div[@class='articleimg']//img//attribute::alt");
foreach ($nodelist as $n) {
    $articel['imgalt'] = $n->nodeValue;
}
$nodelist = $xpath->query( "//div[@id='NewsStory']" );
foreach ($nodelist as $n){
    $articel['content'][] = $n->nodeValue."\n";
}

echo $articel['content'][0];
echo 'fixUTF8 <hr />';
echo Encoding::fixUTF8($articel['content'][0]);


