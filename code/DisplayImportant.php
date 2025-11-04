<head>
    <style type="text/css">
        label {
            display: block;
            line-height: 1.75em;
        }

        input, textarea {
            width: 120px;
            display: inline-block;
            margin-bottom: 2em;
            padding: .75em .5em;
            color: #999;
            border: 1px solid #e9e9e9;
            outline: none;
        }

        input:focus, textarea:focus {
            -moz-box-shadow: inset 0 0 3px #aaa;
            -webkit-box-shadow: inset 0 0 3px #aaa;
            box-shadow: inset 0 0 3px #aaa;
        }

        textarea {
            height: 100px;
        }

        ul {
            margin: 0;
        }
    </style>
</head>
<?php
function DisplayData($BuName) {
    //Global Variable
    global $link;
    $group_id       = "";
    $group_time     = "";
    $group_teacher  = "";
    $group_day      = "";
    $group_startday = "";
    $level_id       = "";
    if (isset($_POST['group_id'])) {
        $group_id       = $_POST['group_id'];
        $group_time     = $_POST['group_time'];
        $group_teacher  = $_POST['group_teacher'];
        $group_day      = $_POST['group_day'];
        $group_startday = $_POST['group_startday'];
        $level_id       = $_POST['Level_id'];
    }
    $COCO = '';
    if (isset($_POST['E'])) {
        $COCO = 'E';
        mysqli_query($link, "UPDATE `group` SET `level_id` = $level_id , `group_time` = '$group_time', `group_teacher` = '$group_teacher' , `group_day` = '$group_day',`group_startday` = '$group_startday' WHERE `group_id`='$group_id'");
    }

    if (isset($_POST['D'])) {
        $COCO = 'D';
        mysqli_query($link, "DELETE FROM `group` WHERE `group_id` = $group_id");
    }
    if (isset($_POST['PAY'])) {
        header('Location:paymententryform.php?GID=' . $group_id . '');
    }

    if (isset($_POST['ATT'])) {
        header('Location:attenedentryform.php?GID=' . $group_id . '');
    }

    if (isset($_POST['MAK'])) {
        header('Location:markentryform.php?GID=' . $group_id . '');
    }

    $Sql_Select = mysqli_query($link, "SELECT count(*) FROM `group` ORDER BY `group`.`group_id`") or die(mysqli_error());
    $Sql_Select_Count = mysqli_fetch_array($Sql_Select);

    if ($Sql_Select_Count[0] > 0) {

        $Result_Between = mysqli_query($link, "SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday` FROM `group` ORDER BY `group`.`group_id` ASC ");
        echo "<table border =1 >";
        while ($Row_Set = mysqli_fetch_array($Result_Between)) {
            {
                ?>

                <form id="Form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                      onSubmit='return confirm("Are you sure?")'>
                    <ul style="float: left">
                        <label>Group Id</label>
                        <input id="group_id" autofocus="" name="group_id"
                               value='<?php echo $Row_Set['group_id'] ?>' type="text">
                    </ul>
                    <ul style="float: left">
                        <label>Level Name</label>
                        <select id='Level_id' name='Level_id'><?php
                            $Result_Between_Level = mysqli_query($link, "SELECT `Level_id`, `level_name`, `level_period`, `level_fees`, `level_book` FROM `levels` ");
                            while ($Row_Set_Level = mysqli_fetch_array($Result_Between_Level)) {
                                if ($Row_Set_Level['Level_id'] == $Row_Set['level_id']) {
                                    echo "<option selected value = " . $Row_Set_Level['Level_id'] . ">" . $Row_Set_Level['level_name'] . "</option>";
                                } else {
                                    echo "<option value = " . $Row_Set_Level['Level_id'] . ">" . $Row_Set_Level['level_name'] . "</option>";
                                }
                            } ?>
                        </select>
                    </ul>
                    <ul style="float: left">
                        <label for="group_time">Group Time</label>
                        <input id="group_time" autofocus="" name="group_time" type="text"
                               value='<?php echo $Row_Set['group_time'] ?>'>
                    </ul>
                    <ul style="float: left">
                        <label for="group_teacher">Group Teacher</label>
                        <input id="group_teacher" autofocus="" name="group_teacher"
                               type="text" value='<?php echo $Row_Set['group_teacher'] ?>'>
                    </ul>
                    <ul style="float: left">
                        <label for="group_day">Group Day</label>
                        <input id="group_day" autofocus="" name="group_day" type="text"
                               value='<?php echo $Row_Set['group_day'] ?>'>
                    </ul>
                    <ul style="float: left">
                        <label for="group_startday">Group Starting Day</label>
                        <input type="text" id="group_startday" autofocus="" name="group_startday"
                               value='<?php echo $Row_Set['group_startday'] ?>'>
                    </ul>
                    <br><br>
                    <?php if ($BuName != 'Search') { ?>
                        <button type="submit" name="E" class="btn btn-success">Edit</button>
                        &nbsp;&nbsp;
                        <button type="submit" name="D" class="btn btn-danger">Delete</button>
                        &nbsp;&nbsp;
                    <?php } else {
                        echo "<br/>";
                    } ?>
                    <?php
                    if ($BuName == 'Payment') {

                        ?>
                        <button type="submit" name="PAY" class="btn btn-success">Payment</button><?php

                    }
                    if ($BuName == 'Attend') {

                        ?>
                        <button type="submit" name="ATT" class="btn btn-success">Attendancet</button><?php
                    }
                    if ($BuName == 'Mark') {

                        ?>
                        <button type="submit" name="MAK" class="btn btn-success">Marks</button><?php
                    }
                    ?>


                    &nbsp;&nbsp;
                </form>
                <br><br>
                <?php
            }
        }
    } else {
        ?>
        <div class="alert">
            <button type="button" class="close"
                    data-dismiss="alert">&times;</button>
            <strong>No!</strong>Data to retrieve.
        </div><?php }
    switch ($COCO) {
        case 'E':
            ?>
            <div class="alert alert-info">
                <button type="button" class="close"
                        data-dismiss="alert">&times;</button>
                <strong>Record: </strong>Edited.
            </div>
            <?php break;
        case 'D':
            ?>
            <div class="alert alert-info">
                <button type="button" class="close"
                        data-dismiss="alert">&times;</button>
                <strong>Record: </strong>Deleted.
            </div><?php break;
    }
}

?>