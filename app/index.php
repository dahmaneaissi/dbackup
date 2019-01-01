<?php
require "../vendor/autoload.php";

use Ifsnop\Mysqldump as IMysqldump;

$content = file_get_contents( '../config.json' );
$data = json_decode( $content );

$date = date('Y-m-d');
/*
$ftp = new Ftp();
$ftp->connect($host);
$ftp->login($username, $password);
*/

foreach ( $data->databases as $db )
{
    try {
        $dump = new IMysqldump\Mysqldump( 'mysql:host=' . $data->hostname . ';dbname=' . $db->dbname , $db->user, $db->password , array('compress' => IMysqldump\Mysqldump::GZIP ));
        $dump->start('storage/work/'. $db->dbname  . '_' . $date .'.gz');
    } catch (\Exception $e) {
        echo 'mysqldump-php error: ' . $e->getMessage();
    }
}
//$ftp->close();


