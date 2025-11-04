<?php 
require_once "config.php";
mysqli_query($link, "UPDATE `group` SET`group_teacher`=''");
?>