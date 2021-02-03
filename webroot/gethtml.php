<?php
header('Conte nt-Type: text/html; charset=utf-8');
$html = new DOMDocument();
@$html->loadHtmlFile('http://www.elwatannews.com/happeningnow');
$xpath = new DOMXPath($html);
$articel = array();
$nodelist = $xpath->query("//ul[@id='newsItemList']//p");
foreach ($nodelist as $n) {
    $articel['title'][] = $n->nodeValue;
}
$nodelist = $xpath->query("//ul[@id='newsItemList']//a//attribute::href");
foreach ($nodelist as $n) {
    $articel['link'][] = $n->nodeValue;
}

$nodelist = $xpath->query("//ul[@id='newsItemList']//img//attribute::src");
foreach ($nodelist as $n) {
    $articel['src'] = $n->nodeValue;
}
$nodelist = $xpath->query("//ul[@id='newsItemList']//img//attribute::alt");
foreach ($nodelist as $n) {
    $articel['alt'] = $n->nodeValue;
}

echo '<pre>';
print_r($articel);
echo '</pre>';


