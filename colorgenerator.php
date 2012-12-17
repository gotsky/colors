<?php

include_once("colors.inc.php");

/* The image from which the palette will be generated */
$image_to_read = "gotsky.jpg";


/* Make sure that this number is a perfect square - 9,16,25,36 etc;
   this will enable the following code to create a square grid of
   a palette.
   
   The following will create a palette of 25 squares.
 */
 
$colors_to_show = 18;

$pal = new GetMostCommonColors();
$pal->image = $image_to_read;
$colors=$pal->Get_Color();
$colors_key=array_keys($colors); 
?>

<html>
<head>
<style type="text/css">

</style>
</head>
<body>
<h1>color generator</h1>
<div><img src="<?php echo $image_to_read; ?>"/></div>

<?php

$inc = sqrt($colors_to_show);

for ($i = 0; $i < $colors_to_show; $i += $inc) {
    for($j=0;$j<$inc;$j++) {
    	echo'<div style="float:left"><div style="background-color:#'.$colors_key[$i + $j].';height:70px;width:70px;margin:4px;border: solid 1px black"></div><div style="font-size:12">#'.$colors_key[$i + $j].'</div></div>';
    }
    echo '<div style="clear:both;"></div>';
}
$ch = curl_init();
$url = 'http://pictaculous.com/api/1.0/';
 
$fields = array('image'=>file_get_contents($image_to_read));
 
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
//print_r(json_decode($json, true));
$mytabcolor = json_decode($json, true);

$info = $mytabcolor['info'];
echo "<h2>info</h2>";
for ($j=0;$j<count($info["colors"]);$j++){
	echo'<div style="float:left"><div style="background-color:#'.$info["colors"][$j].';height:70px;width:70px;margin:4px;border: solid 1px black"></div><div style="font-size:12">#'.$info["colors"][$j].'</div></div>';
}
echo '<div style="clear:both;"></div>';

//echo "<br>";
//echo $mytabcolor['kuler_themes'][0]['colors'][0];
$kuler = $mytabcolor['kuler_themes'];
echo "<h2>kuler</h2>";
for ($i=0;$i<count($kuler);$i++){
	echo "<h3>".$kuler[$i]['title']."</h3>";
	for ($j=0;$j<count($kuler[$i]["colors"]);$j++){
		echo'<div style="float:left"><div style="background-color:#'.$kuler[$i]["colors"][$j].';height:70px;width:70px;margin:4px;border: solid 1px black"></div><div style="font-size:12">#'.$kuler[$i]["colors"][$j].'</div></div>';
	}
	//echo $kuler[$i]['thumb'];
	//echo  "<div><img src=".$kuler[$i]['thumb']."/></div>";
	echo '<div style="clear:both;"></div>';
}

$cl_themes = $mytabcolor['cl_themes'];
echo "<h2>cl_themes</h2>";
for ($i=0;$i<count($cl_themes);$i++){
	echo "<h3>".$cl_themes[$i]['title']."</h3>";
	for ($j=0;$j<count($cl_themes[$i]["colors"]);$j++){
		echo'<div style="float:left"><div style="background-color:#'.$cl_themes[$i]["colors"][$j].';height:70px;width:70px;margin:4px;border: solid 1px black"></div><div style="font-size:12">#'.$cl_themes[$i]["colors"][$j].'</div></div>';
	}
	echo '<div style="clear:both;"></div>';
}
?>
</body>
</html>
