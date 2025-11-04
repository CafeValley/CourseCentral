<?php
require_once "config.php";
if (isset($_POST['main'])) {
    print_r($_POST);
    echo "hello";

    $var2 = $_POST['main'];
    $var1 = $_POST['level_idfrom'];

    mysqli_query($link, "UPDATE `registration` SET `level_id`='$var2' WHERE `level_id` = '$var1'");
    mysqli_query($link, "UPDATE `paymenttwo` SET `level_id`='$var2' WHERE `level_id` = '$var1'");
    mysqli_query($link, "UPDATE `freeze` SET `level_id`='$var2' WHERE `level_id` = '$var1'");
    $sql = "UPDATE `group` SET `level_id`='$var2' WHERE `level_id` = '$var1'";
    mysqli_query($link, $sql);
    mysqli_query($link, "UPDATE `groupunactive` SET `level_id`='$var2' WHERE `level_id` = '$var1'");
    mysqli_query($link, "UPDATE `mark` SET `level_id`='$var2' WHERE `level_id` = '$var1'");
    mysqli_query($link, "UPDATE `registrationunactive` SET `level_id`='$var2' WHERE `level_id` = '$var1'");
    mysqli_query($link, "UPDATE `unfreeze` SET `level_id`='$var2' WHERE `level_id` = '$var1'");

    //UPDATE `levels` SET `level_period` = '2 Month' WHERE `level_period` = '2' ; 
    //UPDATE `levels` SET `level_period` = '1 Month' WHERE `level_period` = '1' ; 
    // WHERE `level_period` LIKE '2'

    mysqli_query($link, "DELETE FROM `levels` WHERE `Level_id` = '$var1'");
}

?>
<form action="leveltolevel.php" method="post">
    <select id="main" name="main" class="icon-pencil">
        <?php $i     = 1;
        $resultlevel = mysqli_query($link, "select `Level_id`, `level_name` FROM `levels` order by `level_name`");
        if ($i == 1) {
            echo "<option selected value='nothing'>Level Name</option>";
            $i += 1;
        }
        while ($rowlevel = mysqli_fetch_assoc($resultlevel)) {
            if ($_POST['main'] == $rowlevel['Level_id'])
                echo "<option selected value='" . $rowlevel['Level_id'] . "'>" . $rowlevel['level_name'] . "</option>";
            else
                echo "<option value='" . $rowlevel['Level_id'] . "'>" . $rowlevel['level_name'] . "</option>";
        } ?></select>
    <select id="level_idfrom" name="level_idfrom" class="icon-pencil">
        <?php $i     = 1;
        $resultlevel = mysqli_query($link, "select `Level_id`, `level_name` FROM `levels` order by `level_name`");
        if ($i == 1) {
            echo "<option selected value='nothing'>Level Name</option>";
            $i += 1;
        }
        while ($rowlevel = mysqli_fetch_assoc($resultlevel)) {
            echo "<option value='" . $rowlevel['Level_id'] . "'>" . $rowlevel['level_name'] . "</option>";
        } ?></select>
    <input type="submit" value="Fthem">
</form>