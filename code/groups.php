<?php require_once "config.php";

// Remove debug output in production
// echo "<br>";
// print_r($_POST);
// echo "<br>";

if (!isset($_POST['GroupDay']) || $_POST['GroupDay'] == 'nothing') {
    $GDF = 'nothing';
    header('Location:groupsform.php?GDF=' . $GDF . '');
} else {
    if ($_POST['Year'] == 'Year') {
        $FYI = 'Fyear';
        header('Location:groupsform.php?FYI=' . $FYI . '');
    } else {
        if ($_POST['level_id'] == 'nothing') {
            $FLID = 'LevelID';
            header('Location:groupsform.php?FLID=' . $FLID . '');
        } else {
            if ($_POST['GroupTime'] == 'nothing') {
                $FGT = 'GroupTime';
                header('Location:groupsform.php?FGT=' . $FGT . '');
            } else {
                 $GT = GetTimefromID($_POST['GroupTime']);

                $idkeys = array();
                $sqlLevelid = mysqli_query($link, "SELECT group_id  FROM `group` ");
                if (!$sqlLevelid) {
                    error_log("Query failed: " . $link->error);
                    die("An error occurred. Please try again later.");
                }
                while ($row = mysqli_fetch_array($sqlLevelid)) {
                    $idskeys[ $row['group_id'] ] = 0;
                }

                $sqlLevelidmax = mysqli_query($link, "SELECT max(group_id)+1  FROM `group` ");
                if (!$sqlLevelidmax) {
                    error_log("Query failed: " . $link->error);
                    die("An error occurred. Please try again later.");
                }
                $countLevelidmax = mysqli_fetch_array($sqlLevelidmax);
                if ($countLevelidmax[0] > 0) {
                    $levelIDmax = $countLevelidmax[0];
                } else {
                    $levelIDmax = 1;
                }

                $sqlLevelidcount = mysqli_query($link, "SELECT count(group_id)+1  FROM `group` ");
                if (!$sqlLevelidcount) {
                    error_log("Query failed: " . $link->error);
                    die("An error occurred. Please try again later.");
                }
                $countLevelidcount = mysqli_fetch_array($sqlLevelidcount);
                if ($countLevelidcount[0] > 0) {
                    $levelIDcount = $countLevelidcount[0];
                } else {
                    $levelIDcount = 1;
                }

                if ($levelIDcount == $levelIDmax) {
                    $sqlLevelid = mysqli_query($link, "SELECT max(group_id)+1  FROM `group` ");
                    if (!$sqlLevelid) {
                        error_log("Query failed: " . $link->error);
                        die("An error occurred. Please try again later.");
                    }
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
                if ($_POST['Month'] == 'Month') {
                    $month = 1;
                } else {
                    $month = $_POST['Month'];
                }
                if ($_POST['Day'] == 'Day') {
                    $day = 1;
                } else {
                    $day = $_POST['Day'];
                }

                // Validate GroupTeacher
                if (!isset($_POST['GroupTeacher']) || $_POST['GroupTeacher'] == 'nothing') {
                    $FT = 'GroupTeacher';
                    header('Location:groupsform.php?FT=' . $FT . '');
                    exit();
                }
                
                $GTR = $_POST['GroupTeacher'];
                $GD  = $_POST['GroupDay'];
                $GSD = $_POST['Year'] . "-" . $month . "-" . $day;
                $LID = $_POST['level_id'];

                $SqltoLevel = mysqli_query($link, "SELECT `level_fees`, `level_book` FROM `levels` 
                                                    WHERE `Level_id` = '$LID' ");
                $returntoLevel = mysqli_fetch_array($SqltoLevel);
                $ThisGroupFees = $returntoLevel['level_fees'];
                $ThisGroupBooksFees = $returntoLevel['level_book'];


                $query = "INSERT INTO `group`
                (`group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`,`group_C_date` , `feesforgroup` , `feesforbookgroup` ) 
                          VALUES ($levelID,$LID,'$GT','$GTR','$GD','$GSD',NOW(),$ThisGroupFees,$ThisGroupBooksFees)";
                echo "<br>";
                echo $query;
                echo "<br>";
                $result = mysqli_query($link, $query);
                header('Location:groupsform.php?GID=' . $levelID . '');
            }
        }
    }
}
?>