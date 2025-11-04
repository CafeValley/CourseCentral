<?php
require_once "config.php";
require_once "configspecial.php";
//check if the form has been submitted
//cleanup the variables
//prevent mysql
echo "<br>";

$active = GetActive();
if ($active >= 2) {
    header("location:index.php?Failtwotimes=");
    exit();
}

// Validate input
if (!isset($_POST['fpassword'])) {
    GetActiveup();
    header("location:renewpage.php?fail=");
    exit();
}

$password = safe_get('fpassword', '', 'string');

// Use prepared statement to prevent SQL injection
$stmt = $link->prepare("SELECT COUNT(`lock_password`) as count FROM `checkingdataandkey` WHERE `lock_password` = ?");
if (!$stmt) {
    error_log("Prepare failed: " . $link->error);
    GetActiveup();
    header("location:renewpage.php?fail=");
    exit();
}

$stmt->bind_param("s", $password);
$stmt->execute();
$result = $stmt->get_result();
$count_row = $result->fetch_assoc();
$stmt->close();

if ($count_row && $count_row['count'] > 0) {
    ResetActive();
    
    // Get Holder_date
    $stmt = $link->prepare("SELECT `Holder_date` FROM `checkingdataandkey` LIMIT 1");
    if ($stmt && $stmt->execute()) {
        $result = $stmt->get_result();
        $CheckIfReturnInF = $result->fetch_assoc();
        $stmt->close();
        
        if ($CheckIfReturnInF && isset($CheckIfReturnInF['Holder_date'])) {
            $Holder_date = $CheckIfReturnInF['Holder_date'];
            
            list($Hyear, $Hmonth, $Hday) = explode("-", $Holder_date);
            $Holder_date = $Hyear."-".$Hmonth."-01";
            $Holder_date = date("d-m-Y", strtotime("$Holder_date +2 months"));
            list($Hday, $Hmonth, $Hyear) = explode("-", $Holder_date);
            $Holder_date = $Hyear."-".$Hmonth."-01";
            
            // Update with prepared statement
            $update_stmt = $link->prepare("UPDATE `checkingdataandkey` SET `Holder_date` = ?");
            if ($update_stmt) {
                $update_stmt->bind_param("s", $Holder_date);
                $update_stmt->execute();
                $update_stmt->close();
            }
            
            header("location:index.php?AllGood=");
            exit();
        }
    }
} else {
    GetActiveup();
    header("location:renewpage.php?fail=");
    exit();
}

?>