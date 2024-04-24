<?php
require_once("vendor/autoload.php");
$sah=[['asdfasd','afsdfasd','afsdfds'],['sdaFASDFAD','TDRFEGTGTRF']];
$xlsx =Shuchkin\SimpleXLSXGen::fromArray( $sah, 'My books' );
$xlsx->saveAs('books5.xlsx');