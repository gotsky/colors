<?php

include_once("colors.inc.php");

/* The image from which the palette will be generated */
$image_to_read = "gotsky.jpg";


/* Make sure that this number is a perfect square - 9,16,25,36 etc;
   this will enable the following code to create a square grid of
   a palette.
   
   The following will create a palette of 25 squares.
 */
 
$colors_to_show = 25;

$pal = new GetMostCommonColors();
$pal->image = $image_to_read;
$colors=$pal->Get_Color();
$colors_key=array_keys($colors);

?>
<html>
<head>
<style type="text/css">
/* Change the width and height of the palette squares */
td { width: 25px; height: 25px; }
</style>
</head>
<body>

<table border="1">

<?php

$inc = sqrt($colors_to_show);

for ($i = 0; $i < $colors_to_show; $i += $inc) {
	$out = "<tr>";
    
    for($j=0;$j<$inc;$j++) {
        $out .= "<td title=\"#".$colors_key[$i + $j]."\" bgcolor=\"".$colors_key[$i + $j]."\"></td>";
    }
    $out .= "</tr>";
    echo $out;
}
?>
</table>
</body>
</html>