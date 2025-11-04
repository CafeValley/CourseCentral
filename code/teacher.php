<?php require_once "config.php";

echo "<br>";
print_r($_POST);
echo "<br>";


$var1 = $_POST['name1'];
$var2 = $_POST['name2'];
$var3 = $_POST['name3'];
$var4 = $_POST['age'];
$var5 = $_POST['tel1'];
$var6 = $_POST['tel2'];
$var7 = $_POST['Month'];
$var8 = $_POST['Year'];
$var9 = $_POST['interviewcomment'];
$comdate = $var8 . "-" . $var7 . "-" . "01";
   
$query = "INSERT INTO `teachers`( `name`, `name2`, `name3`, `age`, `tel`, `tel2`, `appointeddate`, `interviewcomment`, `whenwasit`, `whodidthis`) VALUES ('$var1','$var2','$var3','$var4','$var5','$var6','$comdate','$var9',NOW(),'$suser_name')";
mysqli_query($link, $query);
header('Location:teachersform.php?GID=' . $var1 . '');