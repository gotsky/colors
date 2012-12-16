<?php
$ch = curl_init();
$url = 'http://pictaculous.com/api/1.0/';
 
$fields = array('image'=>file_get_contents('gotsky.jpg'));
 
# Set some default CURL options
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_URL, $url);
 
$json = curl_exec($ch);
echo '<div><img src="gotsky.jpg"/></div>';
//print_r(json_decode($json, true));
$mytabcolor = json_decode($json, true);

$info = $mytabcolor['info'];
echo "<h2>info</h2>";
for ($j=0;$j<count($info["colors"]);$j++){
	echo'<div style="float:left"><div style="background-color:#'.$info["colors"][$j].';height:80px;width:80px;margin:4px;border: solid 1px black"></div><div>#'.$info["colors"][$j].'</div></div>';
}
echo '<div style="clear:both;"></div>';

//echo "<br>";
//echo $mytabcolor['kuler_themes'][0]['colors'][0];
$kuler = $mytabcolor['kuler_themes'];
echo "<h2>kuler</h2>";
for ($i=0;$i<count($kuler);$i++){
	for ($j=0;$j<count($kuler[$i]["colors"]);$j++){
		echo'<div style="float:left"><div style="background-color:#'.$kuler[$i]["colors"][$j].';height:80px;width:80px;margin:4px;border: solid 1px black"></div><div>#'.$kuler[$i]["colors"][$j].'</div></div>';
	}
	echo '<div style="clear:both;"></div>';
}

$cl_themes = $mytabcolor['cl_themes'];
echo "<h2>cl_themes</h2>";
for ($i=0;$i<count($cl_themes);$i++){
	for ($j=0;$j<count($cl_themes[$i]["colors"]);$j++){
		echo'<div style="float:left"><div style="background-color:#'.$cl_themes[$i]["colors"][$j].';height:80px;width:80px;margin:4px;border: solid 1px black"></div><div>#'.$cl_themes[$i]["colors"][$j].'</div></div>';
	}
	echo '<div style="clear:both;"></div>';
}