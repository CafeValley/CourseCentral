<?php
require_once "config.php";


function add_column_if_not_exist($db, $column, $column_attr = "int(10) " )
{
    global $link;
    $exists = false;
    $columns = mysqli_query($link,"show columns from $db");
    while($c = mysqli_fetch_assoc($columns)){
        if($c['Field'] == $column){
            $exists = true;
            break;
        }
    }
    if(!$exists){
        echo "ALTER TABLE `group` ADD `$column`  $column_attr";
        mysqli_query($link,"ALTER TABLE `group` ADD `$column`  $column_attr");
    }
    if($exists) {
        
        $resultForSetID = mysqli_query($link, "SELECT level_id FROM `group`  ");
        while ($returnForSetID = mysqli_fetch_array($resultForSetID))
        {
            $Inlevelid = $returnForSetID['level_id'];

            $resultForSet = mysqli_query($link, "SELECT `level_fees` FROM `levels` WHERE Level_id = $Inlevelid ");
            $returnForSet = mysqli_fetch_array($resultForSet);
            $InlevelFees = $returnForSet['level_fees'];

            mysqli_query($link, "UPDATE `group` SET  `feesforgroup`=$InlevelFees WHERE `level_id`=$Inlevelid");
        }
//get the leveil id ,
//then take the level fees
    }
}

function add_column_if_not_exist2($db, $column, $column_attr = "int(10) " )
{
    global $link;
    $exists = false;
    $columns = mysqli_query($link,"show columns from $db");
    while($c = mysqli_fetch_assoc($columns)){
        if($c['Field'] == $column){
            $exists = true;
            break;
        }
    }

    if(!$exists){
        echo "ALTER TABLE `group` ADD `$column`  $column_attr";
        mysqli_query($link,"ALTER TABLE `group` ADD `$column`  $column_attr");
    }
    if($exists) {

        $resultForSetID = mysqli_query($link, "SELECT level_id FROM `group`  ");
        while ($returnForSetID = mysqli_fetch_array($resultForSetID))
        {
            $Inlevelid = $returnForSetID['level_id'];

            $resultForSet = mysqli_query($link, "SELECT `level_book` FROM `levels` WHERE Level_id = $Inlevelid ");
            $returnForSet = mysqli_fetch_array($resultForSet);
            $InlevelFees = $returnForSet['level_book'];

            mysqli_query($link, "UPDATE `group` SET  `feesforbookgroup`=$InlevelFees WHERE `level_id`=$Inlevelid");
        }
//get the leveil id ,
//then take the level fees
    }
}

add_column_if_not_exist('concor.group','feesforgroup');
add_column_if_not_exist2('concor.group','feesforbookgroup');


?>