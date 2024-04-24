<!DOCTYPE html>
<form action="./index.php" method="post">
    <input type="text" name="li" placeholder="link">
    <input type="text" name="name" placeholder="name">
    <input type="submit">
</form>
<a href="./data.php">download page</a></br>
<a href="./e.php">download excel</a>
<?php
if(isset($_POST["li"])){
 require_once('c2.php');
}