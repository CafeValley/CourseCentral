<?php require_once "config.php";
/*
  echo "<br>";
  print_r($_POST);
  echo "<br>";
*/
$idkeys = array();
$sqlLevelid = mysqli_query($link, "SELECT Level_id  FROM `levels` ") or die(mysqli_error());
while ($row = mysqli_fetch_array($sqlLevelid)) {
    $idskeys[ $row['Level_id'] ] = 0;
}

$sqlLevelidmax = mysqli_query($link, "SELECT max(Level_id)+1  FROM `levels` ") or die(mysqli_error());
$countLevelidmax = mysqli_fetch_array($sqlLevelidmax);
if ($countLevelidmax[0] > 0) {
    $levelIDmax = $countLevelidmax[0];
} else {
    $levelIDmax = 1;
}
$sqlLevelidcount = mysqli_query($link, "SELECT count(Level_id)+1  FROM `levels` ") or die(mysqli_error());
$countLevelidcount = mysqli_fetch_array($sqlLevelidcount);
if ($countLevelidcount[0] > 0) {
    $levelIDcount = $countLevelidcount[0];
} else {
    $levelIDcount = 1;
}
if ($levelIDcount == $levelIDmax) {
    $sqlLevelid = mysqli_query($link, "SELECT max(Level_id)+1  FROM `levels` ") or die(mysqli_error());
    $countLevelid = mysqli_fetch_array($sqlLevelid);
    if ($countLevelid[0] > 0) {
        $levelID = $countLevelid[0];
    } else {
        $levelID = 1;
    }
    //here we add the +1 to max
} else {
    //here was using some of the old values
    $missing = array();
    $keys    = array_keys($idskeys);
    for ($i = 1; $i <= max($keys); $i++) {
        if (!array_key_exists($i, $idskeys)) {
            $missing[] = $i;
        }
    }
    $levelID = $missing[0];
}
if ($_POST['cashways'] == 'checked')
    $CW = 1;
else
    $CW = 0;
if ($_POST['earlyDiscount'] == 'checked')
    $ED = 1;
else
    $ED = 0;

$LN = $_POST['levelname'];
$LP = $_POST['LevelPeriod'];
$LF = $_POST['LevelFees'];
$LB = $_POST['LevelBook'];

$query = "INSERT INTO `levels`(`Level_id`, `level_name`, `level_period`, `level_fees`, `level_book`,`cashways`,`earlyDiscount`,`level_C_date`)
VALUES ($levelID,'$LN','$LP',$LF,$LB,$CW,$ED,NOW())";
echo "<br>";
echo $query;
echo "<br>";

mysqli_query($link, $query);

header('Location:levelsform.php?LID=' . $levelID . '');


?>