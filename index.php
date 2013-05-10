<html>
  <head>
    <link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <style type="text/css">
	body{
		background-color: #222;
		color: #fff;
		font-family: 'PT Sans', Helvetica, Arial, sans-serif;
	}
	h1 {
    font-family: 'Arvo', Georgia, Times, serif;
    font-size: 59px;
    line-height: 70px;
	}

	h2 {
	    font-family: 'Arvo', Georgia, Times, serif;
	    font-size: 35px;
	    line-height: 50px;
	}
	 
	a {
	    font-family: 'Arvo', Georgia, Times, serif;
	    font-size: 16px;
	    line-height: 25px;
	    text-decoration: none;
	    color:#cfcfef;
	}
	.colorclass{
	    position:absolute;
	    bottom: 1px;
	    right: 4px;
	    line-height: 20px;
	}
	</style>
  </head>
  <body>
    <h1>Get Colors!!!</h1>


<?php
$ch = curl_init();
$url = 'http://pictaculous.com/api/1.0/';
$images[1] = 'img/5ODGeTVFDE.gif';
$images[2] = 'img/daft-punk_00301703.jpg';
$images[3] = 'img/b238bc780c7cb6a39859f79f41931591.jpeg';
$images[4] = 'img/acid_picdump_83.jpg';
$images[5] = 'img/veau-fermier-de-cornouaille-190317.jpg';
$images[6] = 'img/WALLE.png';
$images[7] = 'http://www.zenzile.com/newhome/images/zenzile-electricsoul-474.jpg';
 

if (isset($_GET['key']) && $_GET['key']>=1){
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
echo '<div style="float:left;"><img src="'.$image.'" height="510px"/></div>';
//print_r(json_decode($json, true));
$mytabcolor = json_decode($json, true);



$info = $mytabcolor['info'];
$info['url'];
echo '<div style="float:left;margin-left:2px;">';
for ($j=0;$j<count($info['colors']);$j++){
	if (coldiff($info['colors'][$j])>=500){$colortxt='#ffffff';}else{$colortxt='#222222';}
	echo'<div style="background-color:#'.$info['colors'][$j].';height:100px;width:100px;margin:2px;color:'.$colortxt.';position:relative"><div class="colorclass">#'.strtolower($info['colors'][$j]).'</div></div>';
}
echo '</div>';
echo '<div style="clear:both;"></div>';

//echo "<br>";
//echo $mytabcolor['kuler_themes'][0]['colors'][0];
$kuler = $mytabcolor['kuler_themes'];
echo "<div style='float:left'>";
echo "<h2>kuler</h2>";
for ($i=0;$i<count($kuler);$i++){
	echo '<div><a href="'.$kuler[$i]['url'].'" target="_blank">'.$kuler[$i]['title'].'</a></div>';
	echo '<div class="draggable">';
	for ($j=0;$j<count($kuler[$i]['colors']);$j++){
		if (coldiff($kuler[$i]['colors'][$j])>=500){$colortxt='white';}else{$colortxt='black';}
		echo'<div style="float:left"><div style="background-color:#'.$kuler[$i]['colors'][$j].';height:100px;width:100px;color:'.$colortxt.';position:relative;"><div class="colorclass">#'.strtolower($kuler[$i]['colors'][$j]).'</div></div></div>';
	}
	echo '</div>';
	echo '<div style="clear:both;"></div>';
}
echo '</div>';

$cl_themes = $mytabcolor['cl_themes'];
echo "<div style='float:left;margin-left:100px'>";
echo "<h2>color lovers</h2>";
for ($i=0;$i<count($cl_themes);$i++){
	echo '<div><a href="'.$cl_themes[$i]['url'].'" target="_blank">'.$cl_themes[$i]['title'].'</a></div>';
	echo '<div class="draggable">';
	for ($j=0;$j<count($cl_themes[$i]['colors']);$j++){
		if (coldiff($cl_themes[$i]['colors'][$j])>=500){$colortxt='white';}else{$colortxt='black';}
		echo'<div style="float:left"><div style="background-color:#'.$cl_themes[$i]['colors'][$j].';height:100px;width:100px;color:'.$colortxt.';position:relative;"><div class="colorclass">#'.strtolower($cl_themes[$i]['colors'][$j]).'</div></div></div>';
	}
	echo '</div>';
	echo '<div style="clear:both;"></div>';
}
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
<script type="text/javascript">$(".draggable").draggable({ revert: true });</script>
  </body>
</html>