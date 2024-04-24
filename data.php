<!DOCTYPE html>
<form action="./data.php" method="post">
    <input type="text" name="name" placeholder="name">
</br>
    <input type="number" name="az" placeholder="az">
    <input type="number" name="ta" placeholder="ta">
    </br>
    <input type="submit">
</form>
<?php 
if(isset($_POST["name"])){
require_once('d4.php');
}