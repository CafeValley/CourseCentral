<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("SeachPage");
require_once "SingleDataRecover.php";
?>
<div class="main">
    <div class="main-inner">
        <div class="main">
            <div class="main-inner">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            <div class="widget ">
                                <div class="widget-header">
                                    <i class="icon-search"></i>
                                    <h3>Student Data</h3>
                                </div> <!-- /widget-header -->
                                <div class="widget-content">
                                    <div class="tabbable">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="jscontrols">
                                                <div class="container">
                                                    <?php
                                                    $wantedSomething = $_POST['Searchedelement'];
                                                    $typeofSearch    = $_POST['radio'];

                                                    if ($typeofSearch == 'IDsearch') {
                                                    ?>
                                                        <table border="2" class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>First Name</th>
                                                                    <th>Sir Name</th>
                                                                    <th>Birthday</th>
                                                                    <th>First Phone</th>
                                                                    <th>Second Phone</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $StudentId         = $wantedSomething;
                                                                $regissql          = mysqli_query($link, "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE `st_id` = "
                                                                    . $StudentId);
                                                                $StudentDataSql    = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)),SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)),SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = "
                                                                    . $StudentId);
                                                                $num_rows          = mysqli_num_rows($StudentDataSql);
                                                                $StudentDataReturn = mysqli_fetch_array($StudentDataSql);
                                                                $StudentFirstName  = $StudentDataReturn['S_firstname'] . " " . $StudentDataReturn['S_midname1'];
                                                                $StudentSirName    = " " . $StudentDataReturn['S_midname2'] . " " . $StudentDataReturn['S_lastname1'];
                                                                $StudentPhone1     = $StudentDataReturn['S_phone1'];
                                                                $StudentPhone2     = $StudentDataReturn['S_phone2'];
                                                                $StudentBirthDay   = $StudentDataReturn['S_Birthdate'];
                                                                if ($num_rows > 0) {

                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $StudentFirstName; ?></td>
                                                                        <td><?php echo $StudentSirName; ?></td>
                                                                        <td><?php echo $StudentBirthDay; ?></td>
                                                                        <td><?php echo $StudentPhone1; ?></td>
                                                                        <td><?php echo $StudentPhone2; ?></td>


                                                                        </td>
                                                                    </tr>
                                                                <?php


                                                                }
                                                            }

                                                            if ($typeofSearch == 'Namesearch') {
                                                                ?>
                                                                <table border="2" class="table table-striped table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>First Name</th>
                                                                            <th>Sir Name</th>
                                                                            <th>Birthday</th>
                                                                            <th>First Phone</th>
                                                                            <th>Second Phone</th>
                                                                            <th>Student ID</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php


                                                                        $StudentName       = trim($wantedSomething);
                                                                        $StudentDataSql    = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)),
                                                                                                         SUBSTRING(`S_firstname`, 2)) as S_firstname ,
                                                                                                        CONCAT(UCASE(LEFT(`S_midname1`, 1)),
                                                                                                        SUBSTRING(`S_midname1`, 2)) as S_midname1 ,
                                                                                                        CONCAT(UCASE(LEFT(`S_midname2`, 1)),
                                                                                                         SUBSTRING(`S_midname2`, 2)) as S_midname2 ,
                                                                                                        CONCAT(UCASE(LEFT(`S_lastname1`, 1)),
                                                                                                        SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `S_firstname` = '"
                                                                            . $StudentName . "'");
                                                                        $num_rows          = mysqli_num_rows($StudentDataSql);
                                                                        $StudentDataReturn = mysqli_fetch_array($StudentDataSql);
                                                                        $StudentFirstName  = $StudentDataReturn['S_firstname'] . " " . $StudentDataReturn['S_midname1'];
                                                                        $StudentSirName    = " " . $StudentDataReturn['S_midname2'] . " " . $StudentDataReturn['S_lastname1'];
                                                                        $StudentPhone1     = $StudentDataReturn['S_phone1'];
                                                                        $StudentPhone2     = $StudentDataReturn['S_phone2'];
                                                                        $StudentBirthDay   = $StudentDataReturn['S_Birthdate'];
                                                                        $StudentID         = $StudentDataReturn['ST_Gid'];
                                                                        $regissql          = mysqli_query($link, "SELECT `regis_id`,
                                                                                                              `level_id`,
                                                                                                              `group_id`,
                                                                                                             `paid_fees`,
                                                                                                              `discount`, 
                                                                                                              `status`,
                                                                                                               `st_id`,
                                                                                                               `regis_date`
                                                                                                         FROM `registration` WHERE `st_id` = " . $StudentID);
                                                                        if ($num_rows > 0) {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $StudentFirstName; ?></td>
                                                                                <td><?php echo $StudentSirName; ?></td>
                                                                                <td><?php echo $StudentBirthDay; ?></td>
                                                                                <td><?php echo $StudentPhone1; ?></td>
                                                                                <td><?php echo $StudentPhone2; ?></td>
                                                                                <td><?php echo $StudentID; ?></td>


                                                                                </td>
                                                                            </tr>
                                                                        <?php
                                                                        }
                                                                    }

                                                                    if ($typeofSearch == 'Phonesearch') {
                                                                        ?>
                                                                        <table border="2" class="table table-striped table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>First Name</th>
                                                                                    <th>Sir Name</th>
                                                                                    <th>Birthday</th>
                                                                                    <th>First Phone</th>
                                                                                    <th>Second Phone</th>
                                                                                    <th>Student ID</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php

                                                                                $StudentPhone   = trim($wantedSomething);
                                                                                $StudentDataSql = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)),
                                                                                                      SUBSTRING(`S_firstname`, 2)) as S_firstname ,
                                                                                                     CONCAT(UCASE(LEFT(`S_midname1`, 1)),
                                                                                                      SUBSTRING(`S_midname1`, 2)) as S_midname1 ,
                                                                                                      CONCAT(UCASE(LEFT(`S_midname2`, 1)),
                                                                                                       SUBSTRING(`S_midname2`, 2)) as S_midname2 ,
                                                                                                       CONCAT(UCASE(LEFT(`S_lastname1`, 1)),
                                                                                                      SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` 
                                                                                                       WHERE `S_phone1` = '" . $StudentPhone . "' or `S_phone2` = '" . $StudentPhone . "'");
                                                                                $num_rows       = mysqli_num_rows($StudentDataSql);
                                                                                while ($StudentDataReturn = mysqli_fetch_array($StudentDataSql)) {
                                                                                    if ($num_rows > 0) {

                                                                                        $StudentFirstName = $StudentDataReturn['S_firstname'] . " " . $StudentDataReturn['S_midname1'];
                                                                                        $StudentSirName   = " " . $StudentDataReturn['S_midname2'] . " " . $StudentDataReturn['S_lastname1'];
                                                                                        $StudentPhone1    = $StudentDataReturn['S_phone1'];
                                                                                        $StudentPhone2    = $StudentDataReturn['S_phone2'];
                                                                                        $StudentBirthDay  = $StudentDataReturn['S_Birthdate'];
                                                                                        $StudentID        = $StudentDataReturn['ST_Gid'];

                                                                                ?>
                                                                                        <tr>
                                                                                            <td><?php echo $StudentFirstName; ?></td>
                                                                                            <td><?php echo $StudentSirName; ?></td>
                                                                                            <td><?php echo $StudentBirthDay; ?></td>
                                                                                            <td><?php echo $StudentPhone1; ?></td>
                                                                                            <td><?php echo $StudentPhone2; ?></td>
                                                                                            <td><?php echo $StudentID; ?></td>


                                                                                            </td>
                                                                                        </tr>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                $regissql = mysqli_query($link, "SELECT `regis_id`,
                                                                                                      `level_id`,
                                                                                                      `group_id`,
                                                                                                       `paid_fees`,
                                                                                                      `discount`, 
                                                                                                       `status`,
                                                                                                        `st_id`,
                                                                                                        `regis_date`
                                                                                                FROM `registration` WHERE `st_id` = " . $StudentID);
                                                                            }
                                                                            if ($typeofSearch == 'Yearsearch') {
                                                                                ?>
                                                                                <table border="2" class="table table-striped table-bordered">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>First Name</th>
                                                                                            <th>Sir Name</th>
                                                                                            <th>Birthday</th>
                                                                                            <th>First Phone</th>
                                                                                            <th>Second Phone</th>
                                                                                            <th>Student ID</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php

                                                                                        $StudentYear    = trim($wantedSomething);
                                                                                        $StudentDataSql = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)),
         SUBSTRING(`S_firstname`, 2)) as S_firstname ,
         CONCAT(UCASE(LEFT(`S_midname1`, 1)),
         SUBSTRING(`S_midname1`, 2)) as S_midname1 ,
         CONCAT(UCASE(LEFT(`S_midname2`, 1)),
          SUBSTRING(`S_midname2`, 2)) as S_midname2 ,
         CONCAT(UCASE(LEFT(`S_lastname1`, 1)),
         SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` 
         WHERE year(`S_Birthdate`) = '" . $StudentYear . "'");
                                                                                        $num_rows       = mysqli_num_rows($StudentDataSql);
                                                                                        while ($StudentDataReturn = mysqli_fetch_array($StudentDataSql)) {
                                                                                            if ($num_rows > 0) {
                                                                                                $StudentFirstName = $StudentDataReturn['S_firstname'] . " " . $StudentDataReturn['S_midname1'];
                                                                                                $StudentSirName   = " " . $StudentDataReturn['S_midname2'] . " " . $StudentDataReturn['S_lastname1'];
                                                                                                $StudentPhone1    = $StudentDataReturn['S_phone1'];
                                                                                                $StudentPhone2    = $StudentDataReturn['S_phone2'];
                                                                                                $StudentBirthDay  = $StudentDataReturn['S_Birthdate'];
                                                                                                $StudentID        = $StudentDataReturn['ST_Gid'];

                                                                                        ?>
                                                                                                <tr>
                                                                                                    <td><?php echo $StudentFirstName; ?></td>
                                                                                                    <td><?php echo $StudentSirName; ?></td>
                                                                                                    <td><?php echo $StudentBirthDay; ?></td>
                                                                                                    <td><?php echo $StudentPhone1; ?></td>
                                                                                                    <td><?php echo $StudentPhone2; ?></td>
                                                                                                    <td><?php echo $StudentID; ?></td>


                                                                                                    </td>
                                                                                                </tr>
                                                                                    <?php
                                                                                            }
                                                                                        }
                                                                                        $regissql = mysqli_query($link, "SELECT `regis_id`,
         `level_id`,
          `group_id`,
           `paid_fees`,
            `discount`, 
            `status`,
             `st_id`,
              `regis_date`
               FROM `registration` WHERE `st_id` = " . $StudentID);
                                                                                    }
                                                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- /widget-content -->


                                </div> <!-- /widget -->
                            </div> <!-- /span8 -->
                        </div> <!-- /row -->
                    </div> <!-- /container -->
                </div> <!-- /main-inner -->
            </div> <!-- /main -->
        </div>


        <?php require_once "common_scripts.php"; ?>



        </body>

        </html>