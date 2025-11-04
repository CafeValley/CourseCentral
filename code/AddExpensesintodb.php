<?php
require_once "config.php";
echo "<br>";
print_r ($_POST);
echo "<br>";

$expenses_name = $_POST['Nameexpenses'];
$expenses_cost = $_POST['Cost'];


    $query = "INSERT INTO `expenses`(`expenses_id`, `expenses_name`, `expenses_cost`  , `expenses_date`) 
              VALUES (null,'$expenses_name' , $expenses_cost , NOW())";

    //echo "<br>";
    //echo $query;
    //echo "<br>";
mysqli_query ($link , $query);
header ('Location:AddExpenses.php?FeesError=' . 0 );

?>