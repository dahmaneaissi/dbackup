<?php
require "vendor/autoload.php";
use \Ifsnop\Mysqldump as IMysqldump;

$content = url_get_contents( 'config.json' );
$data = json_decode( $content );
var_dump( $data );

function url_get_contents ($Url) {
    if (!function_exists('curl_init')){
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}