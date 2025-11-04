<?php

require_once "config.php";

$todayCheck = $Tyear."-".$Tmonth."-".$Tday;
//here i mean !!!
//current_time_check -> meant to check if the time was changed!!!!!
//Holder_date        ->
function dontchangethetime(){
    global $link;
    global $todayCheck;

$SqlCommandForCFe = "SELECT `lock_password`, `current_time_check`, `Holder_date`, `active` FROM `checkingdataandkey` ";
$CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);
$CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

//$CheckIfCount = mysqli_num_rows($CheckIfHereInF);

 $current_time_check = $CheckIfReturnInF['current_time_check'];


if (strtotime($todayCheck) < strtotime($current_time_check))
{
    //Shit happen someone or something
    //changed the time ~

    //update $current_time_check
    return (0);
    //return you are not a good person!
}
else {

    mysqli_query($link ,"UPDATE `checkingdataandkey` SET 
                         `current_time_check`='$todayCheck'
                         WHERE `id_controller` = 1");
    //return all good !!!
    return (1);
// sorry change back the time please
}
}

function closewhen2month(){
    global $link;
    global $todayCheck;
    $SqlCommandForCFe = "SELECT `lock_password`, `current_time_check`, `Holder_date`, `active` FROM `checkingdataandkey` ";
    $CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);
    $CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

//$CheckIfCount = mysqli_num_rows($CheckIfHereInF);

    $Holder_date = $CheckIfReturnInF['Holder_date'];

   
    list($Tyear, $Tmonth, $Tday) = explode("-", $todayCheck);
    list($Hyear, $Hmonth, $Hday) = explode("-", $Holder_date);

    if (($Tmonth - $Hmonth) == 1)
        return (1);//"press here to renew";
    if (($Tmonth - $Hmonth) >= 2)
        return (2);//"lock";
    //if ($_POST['GroupMonth'] == date('m', strtotime('first day of +2 months')));
}

function GetActive(){
    global $link;

    $SqlCommandForCFe = "SELECT `active` FROM `checkingdataandkey` ";
    $CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);
    $CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

//$CheckIfCount = mysqli_num_rows($CheckIfHereInF);
    $active = $CheckIfReturnInF['active'];
    return ($active);
}
function GetActiveup(){
    global $link;

    $SqlCommandForCFe = "SELECT  `active` FROM `checkingdataandkey` ";
    $CheckIfHereInF      = mysqli_query ($link , $SqlCommandForCFe);
    $CheckIfReturnInF   = mysqli_fetch_array ($CheckIfHereInF);

//$CheckIfCount = mysqli_num_rows($CheckIfHereInF);
    $active = $CheckIfReturnInF['active'];
    $active = $active + 1;
    $SqlChangeactive = "UPDATE `checkingdataandkey` SET `active`= $active ";
    mysqli_query ($link , $SqlChangeactive);

    return ($active);
}
function ResetActive(){
    global $link;

    $SqlChangeactiveto0 = "UPDATE `checkingdataandkey` SET `active`= 0 ";
    mysqli_query ($link , $SqlChangeactiveto0);}
?>
