<!DOCTYPE html>
<form action="./e.php" method="post">
    <input type="text" name="exc" placeholder="name">
</br>
    <input type="number" name="az" placeholder="az">
    <input type="number" name="ta" placeholder="ta">
    </br>
    <input type="submit">
</form>

<?php
if(isset($_POST["exc"])){
require_once("excel/vendor/autoload.php");
$nam = file_get_contents('web/'.$_POST["exc"].'.json');
$name=json_decode($nam);
$exc=[];

for($i=$_POST["az"];$i<$_POST["ta"];$i++){
$page=[];
$page[]=$name->product_names[$i];
$html = file_get_contents('data/'.$_POST["exc"].'/'.$_POST["exc"].$i.'.html');

// Modify the pattern to be more flexible and handle variations
$pattern = '/\s*\<\/span>\s*\<span\>(.*)\<\/span\> \<\/span>\<\/li>/i';

preg_match_all($pattern, $html, $matches);
//print_r($matches[1]);
$page=array_merge($page,$matches[1]);
array_push($exc,$page);
}
$xlsx =Shuchkin\SimpleXLSXGen::fromArray( $exc, 'My books' )->downloadAs($_POST["exc"].'.xlsx');
//$xlsx->saveAs($_POST["exc"].'.xlsx');
}
//$matches[0][1-7]
?>
