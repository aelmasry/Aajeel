<?php
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'view-source:http://www.elwatannews.com/home/rssfeeds?sectionId=38',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
echo $resp;
exit;
$html = new DOMDocument();
$html->loadXML($resp);

$xpath = new DOMXPath($html);
$articel = array();
$nodelist = $xpath->query("//item//title");
foreach ($nodelist as $n){
	$articel['title'][] = $n->nodeValue;
}

echo '<pre>';
print_r($articel);
echo '</pre>';