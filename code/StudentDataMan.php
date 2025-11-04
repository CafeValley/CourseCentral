<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheckRegis("StudentEdit");

if (isset($_POST['edit'])){
    
    $studnetid = $_POST['StudentCode'];
    $sfirst    = $_POST['firstname'];
    $smid1     = $_POST['mid1'];
    $smid2     = $_POST['mid2'];
    $last      = $_POST['last'];
    $phone1    = $_POST['phone1'];
    $phone2    = $_POST['phone2'];
    $Bday      = $_POST['Birthday'];
    $facen     = $_POST['faceN'];
    $email     = $_POST['email'];


    $COCO = 'E';

    mysqli_query($link, "UPDATE `student` SET 
`S_firstname`='$sfirst',
`S_midname1`='$smid1',
`S_midname2`='$smid2',
`S_lastname1`='$last',
`S_phone1`='$phone1',
`S_phone2`= '$phone2',
`S_Birthdate`='$Bday',
`facebookname`='$facen',
`S_e_mail`='$email'
WHERE `ST_Gid` = $studnetid");

}
?>

<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-truck"></i>
                            <h3>Student Register Delete </h3></div>
                        <div class="widget-content">
                            <div class="tabbable">
                                <div class="tab-content">
                                    <form action = "StudentDataMan.php" method = "POST">
                                        <?php if (isset($_POST['StudentCode'])) { ?>
                                            <ul style = "float: left">
                                                <label for = "group_id">Student Code</label>
                                                <button type = "submit" class = "btn btn-primary">+</button>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type = "text" id = "StudentCode" name = "StudentCode"
                                                       value = "<?php echo $_POST['StudentCode']; ?>"
                                                       class = "login"/>
                                            </ul>
                                        <?php }
                                        else {
                                            ?>
                                            <div class = "controls">
                                                <div class = "input-append"><label class = "control-label"
                                                                                   for = "radiobtns">Student
                                                        Code</label>
                                                    <input type = "text" id = "StudentCode" required
                                                           name = "StudentCode" placeholder = "Student Code"
                                                           value = '' class = "login"/>
                                                    <button type = "submit" class = "btn btn-primary">+</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </form>
                                    <?php if (isset($_POST['StudentCode'])) {
                                        $resultSNC = mysqli_query ($link , "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1))
											, SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)),
 											  SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `facebookname`, `S_e_mail`,`ST_Gid` FROM `student` WHERE `ST_Gid` = "
                                            . $_POST['StudentCode'] . " ");
                                        $rowSNC    = mysqli_fetch_array ($resultSNC);
                                        $Fname     = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
                                        $Sirname   = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
                                    } ?>

                                    <?php //here to display Name
                                    if (isset($Fname)) {
                                        ?>
                                        <div class = "controls">
                                            <div class = "input-append">
                                                <input type = "text" id = "StudentName" readonly
                                                       name = "StudentName" value = "<?php echo $Fname; ?>"
                                                       class = "login"/>
                                                <input type = "text" id = "StudentName" readonly
                                                       name = "StudentName" value = "<?php echo $Sirname; ?>"
                                                       class = "login"/>
                                            </div>
                                        </div>
                                        <?php

                                        $StudentId = $_POST['StudentCode'];



                                        ?>
                                        <table >
                                            <tbody>
                                            <br>
                                            <br>
                                            <form action = "StudentDataMan.php" method = "POST">
                                                <input type = "hidden" name ="StudentCode" value = "<?php echo $StudentId;?>">
                                                <tr><td>First</td><td><input type = "text" name = "firstname" value = "<?php echo $rowSNC['S_firstname']; ?>"</td>
                                                <tr><td>Second</td><td><input type = "text" name = "mid1" value = "<?php echo $rowSNC['S_midname1']; ?>"</td>
                                                <tr><td>Third</td><td><input type = "text" name = "mid2" value = "<?php echo $rowSNC['S_midname2']; ?>"</td>
                                                <tr><td>Last Name</td><td><input type = "text" name = "last" value = "<?php echo $rowSNC['S_lastname1']; ?>"</td>
                                                <tr><td>Phone 1</td><td><input type = "text" name = "phone1" value = "<?php echo $rowSNC['S_phone1']; ?>"</td>
                                                <tr><td>Phone 2</td><td><input type = "text" name = "phone2" value = "<?php echo $rowSNC['S_phone2']; ?>"</td>
                                                <tr><td>Birthday</td><td><input type = "text" name = "Birthday" value = "<?php echo $rowSNC['S_Birthdate']; ?>"</td>
                                                <tr><td>Facebook</td><td><input type = "text" name = "faceN" value = "<?php echo $rowSNC['facebookname']; ?>"</td>
                                                <tr><td>E-Mail</td><td><input type = "text" name = "email" value = "<?php echo $rowSNC['S_e_mail']; ?>"</td>
                                                <tr><td width="2%"><button name = "edit" value = "E" type = "submit" class = "btn btn-primary">
                                                        <i class="icon-book "></i>
                                                    </button></td>

                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            if (isset($_POST['StudentCode'])) {
                             if ($COCO == "E") {?>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="alert alert-success">
                                            <button type="button" class="close"
                                                    data-dismiss="alert">&times;</button>
                                            Data
                                            <strong>Fixed</strong>.
                                        </div>
                                    </div>
                                </div>
                            <?php }}?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="extra">
    <div class="extra-inner">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="footer-inner">
        <div class="container">
            <div class="row">
                <div class="span12">&copy; 2015 <a href='http://cafavalley.comoj.com/'>Cafavalley</a></div>
            </div>
        </div>
    </div>
</div>
<?php require_once "common_scripts.php"; ?>
</body>
</html>