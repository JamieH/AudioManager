<?php
set_time_limit (-0);

$url1 = $_GET['yturl'];
echo $url1;

function get_youtube_vidid ($url) {

parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
    if (is_null($my_array_of_vars['v']))
    {
    	die ("wrong");
    }
    return $my_array_of_vars['v'];  
}
echo get_youtube_vidid($url1);
            include '../class.String.php';

                $tooltipPlace = "./youtube-mp3 '{0}'";
                $tooltipinfo = String::FormatSimpler($tooltipPlace, escapeshellarg($url1));
				echo shell_exec($tooltipinfo);

?>