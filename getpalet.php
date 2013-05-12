<!DOCTYPE html>
<html>
  <head>
    <link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" media="all" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  </head>
  <body>
  	<div id="container">
    <div id="contentpalet">
    	<h1><a href="getpalet.php">Get Palette</a></h1>


<?php
$ch = curl_init();
$url = 'http://pictaculous.com/api/1.0/';
$images[1] = 'img/5ODGeTVFDE.gif';
$images[2] = 'img/daft-punk_00301703.jpg';
$images[3] = 'img/b238bc780c7cb6a39859f79f41931591.jpeg';
$images[4] = 'img/acid_picdump_83.jpg';
$images[5] = 'img/b238bc780c7cb6a39859f79f41931591.jpg';
$images[6] = 'img/wb.png';
$images[7] = 'http://www.zenzile.com/newhome/images/zenzile-electricsoul-474.jpg';
 

if (isset($_POST['imgurl'])){
	$image = $_POST['imgurl'];
}
elseif (isset($_GET['key']) && $_GET['key']>=1){
	$image = $images[$_GET['key']];
}
else{
	$key = rand(1,7);
	$image = $images[$key];
}

$fields = array('image'=>file_get_contents($image));
 
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
echo '<div style="float:left;margin-left:40px;">';
echo "<h2>Image Palette</h2>";

//print_r(json_decode($json, true));
$mytabcolor = json_decode($json, true);



$info = $mytabcolor['info'];
$info['url'];
echo '<div style="margin-bottom:3px;">';
echo '<div><a href="'.$_POST['imgurl'].'" target="_blank">Image main colors</a></div>';
for ($j=0;$j<count($info['colors']);$j++){
	if (coldiff($info['colors'][$j])>=500){$colortxt='#ffffff';}else{$colortxt='#222222';}
	echo'<div style="background-color:#'.$info['colors'][$j].';height:90px;width:90px;color:'.$colortxt.';position:relative;float:left;margin-right:4px;"><div class="colorclass">#'.strtolower($info['colors'][$j]).'</div></div>';
	$palet .= "#".strtolower($info['colors'][$j])." ";
}
echo '<div style="clear:both;"></div>';
echo '</div>';
echo '<img src="'.$image.'" width="466px"/>';
//echo '<div><input type="text" size="40" onClick="this.select();" value="'.$palet.'"/></div>';
echo '<div><a href="index.html" class="button blue" id="demo">Another Pic<span></span></a></div>';
echo '</div>';


//echo "<br>";
//echo $mytabcolor['kuler_themes'][0]['colors'][0];
$kuler = $mytabcolor['kuler_themes'];
echo "<div style='float:left;margin-left:50px'>";
echo "<div id='kuler'>";
echo "<h2>Kuler Schemes <a href='#' onclick='$(\"#kuler\").hide();
$(\"#clove\").show(\"fade\", {}, 500);return false;' class='button mini blue'><span></span></a></h2>";
for ($i=0;$i<count($kuler);$i++){
	echo '<div><a href="'.$kuler[$i]['url'].'" target="_blank">'.$kuler[$i]['title'].'</a></div>';
	echo '<div class="draggable">';
	$listcolorskk = "";
	for ($j=0;$j<count($kuler[$i]['colors']);$j++){
		if (coldiff($kuler[$i]['colors'][$j])>=500){$colortxt='white';}else{$colortxt='black';}
		echo'<div style="float:left"><div style="background-color:#'.$kuler[$i]['colors'][$j].';height:90px;width:90px;color:'.$colortxt.';position:relative;"><div class="colorclass">#'.strtolower($kuler[$i]['colors'][$j]).' <img src="img/"/></div></div></div>';
		$listcolorskk .= "#".strtolower($kuler[$i]['colors'][$j])." ";
	}
	echo '</div>';
	//echo '<input type="text" size="30" onClick="this.select();" value="'.$listcolorskk.'"/>';
	echo '<div style="clear:both;"></div>';
}
echo '</div>';

$cl_themes = $mytabcolor['cl_themes'];

echo "<div id='clove' style='display:none;'>";
echo "<h2>Color Lovers Schemes <a href='#' onclick='$(\"#clove\").hide();
$(\"#kuler\").show(\"fade\", {}, 500);return false;' class='button mini blue'><span></span></a></h2>";
for ($i=0;$i<count($cl_themes);$i++){
	echo '<div><a href="'.$cl_themes[$i]['url'].'" target="_blank">'.$cl_themes[$i]['title'].'</a></div>';
	echo '<div class="draggable">';
	$listcolors ="";
	for ($j=0;$j<count($cl_themes[$i]['colors']);$j++){
		if (coldiff($cl_themes[$i]['colors'][$j])>=500){$colortxt='white';}else{$colortxt='black';}
		echo'<div style="float:left"><div style="background-color:#'.$cl_themes[$i]['colors'][$j].';height:90px;width:90px;color:'.$colortxt.';position:relative;"><div class="colorclass">#'.strtolower($cl_themes[$i]['colors'][$j]).'</div></div></div>';
		$listcolors .= "#".strtolower($cl_themes[$i]['colors'][$j])." ";
	}
	echo '</div>';
	//echo '<input type="text" size="30" onClick="this.select();" value="'.$listcolors.'"/>';
	echo '<div style="clear:both;"></div>';
}
echo '</div>';
echo '</div>';


function coldiff($color){//$R1,$G1,$B1,$R2,$G2,$B2)
	$tabrgb = html2rgb($color);
	$tabrgbwhite = html2rgb('#ffffff');
	$R1 = $tabrgb[0];
	$R2 = $tabrgbwhite[0];

	$G1 = $tabrgb[1];
	$G2 = $tabrgbwhite[1];

	$B1 = $tabrgb[2];
	$B2 = $tabrgbwhite[2];

    return max($R1,$R2) - min($R1,$R2) +
           max($G1,$G2) - min($G1,$G2) +
           max($B1,$B2) - min($B1,$B2);
}

function html2rgb($color)
{
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}

?>
<div style="clear:both;"></div>
<div id="footerpalet">
		<a href="http://about.me/gotsky" id="contact" style="color:#eee;float:right;margin-right:20px;margin-top:50px;">Contact</a>
    </div>
    </div>
</div>

<script type="text/javascript">//$(".draggable").draggable();</script>
  </body>
</html>