<?php
require_once "config.php";
//echo "<br>";
//print_r ($_POST);
//echo "<br>";
$C_Fees_Name = $_POST['C_Fees_Name'];
$C_Fees      = $_POST['C_Fees'];

if ($C_Fees < 0 )
    header ('Location:feesset.php?F_name='.$C_Fees_Name.'&FeesError=' . 1 );
else
{
    //there no c'e dont work
    $CheckIfHere      = mysqli_query ($link , "SELECT `F_C_id`,`F_name`, `F_active` FROM `fees_change` WHERE F_name = '$C_Fees_Name' and F_active = 1 ");
    $CheckIfReturn   = mysqli_fetch_array ($CheckIfHere);

    $IdCF = $CheckIfReturn['F_C_id'];
    $CheckIfCount = mysqli_num_rows($CheckIfHere);
    if ($CheckIfCount > 0)
        $CheckIfHere      = mysqli_query ($link , "UPDATE `fees_change` SET `F_active`=0 WHERE F_C_id = $IdCF");

    $query = "INSERT INTO `fees_change`(`F_C_id`, `F_name`, `F_value`, `F_date`, `F_active`)
    VALUES (null,'$C_Fees_Name',$C_Fees ,NOW(),1)";
    
    //echo "<br>";
    //echo $query;
    //echo "<br>";
    mysqli_query ($link , $query);
    switch ($C_Fees_Name)
    {
        case "Student_Fees":
            $C_Fees_Name ="Student Fees";
            break;
        case "Registration_Fees":
            $C_Fees_Name ="Registration Penalty";
            break;
        case "Early_Bird_Fees":
            $C_Fees_Name ="Early Bird Fees";
            break;
        case "Freeze_Fees":
            $C_Fees_Name ="Freeze Fees";
            break;
        case "Unfreeze_Fees":
            $C_Fees_Name ="Unfreeze Fees";
            break;
    }

header ('Location:feesset.php?F_name='.$C_Fees_Name.'&FeesError=' . 0 );
}

//active check if there are any old data , if there is , set them all to 0 if not then its 1
//date 
?>