<?php
require "../vendor/autoload.php";

use Ifsnop\Mysqldump as IMysqldump;

$content = file_get_contents( '../config.json' );
$data = json_decode( $content );

$date = date('Y-m-d');

$ftp = new Ftp();
$ftp->connect( $data->ftp->hostname );
$ftp->login( $data->ftp->username , $data->ftp->password );

foreach ( $data->mysql->databases as $db )
{
    try {
        $dump = new IMysqldump\Mysqldump( 'mysql:host=' . $data->mysql->hostname . ';dbname=' . $db->dbname , $db->user, $db->password , array('compress' => IMysqldump\Mysqldump::GZIP ));
        $file_name = $db->dbname  . '_' . $date .'.gz';
        $storage_dir = 'storage/work/';
        $dump->start($storage_dir . $file_name );
        echo 'Géneration du dump de la db '. $db->dbname .' effectuée.' . PHP_EOL;
        $ftp->put( $file_name, $storage_dir . $file_name , FTP_BINARY) ;
    } catch (\Exception $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
    }
}
$ftp->close();
echo 'Sauvegarde effectuée.' . PHP_EOL;