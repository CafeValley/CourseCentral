<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("ReportAllStudents");
?>

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
<div class="main">

    <div class="main-inner">

        <div class="container">

            <div class="row">

                <div class="span12">

                    <div class="widget ">

                        <div class="widget-header">
                            <i class="icon-print"></i>
                            <h3>Students</h3>
                        </div> <!-- /widget-header -->


                        <!-- here code-->
                        <div class="widget-content">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#New" data-toggle="tab">By Name</a>
                                    </li>
                                    <li ><a href="#Modify" data-toggle="tab">By ID</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="New">
                                        <div class="main">
                                            <div class="main-inner">
                                                <div id="printableArea" class="container">
                                                    <div class="row">
                                                        <div class="span12">
                                                            <div class="widget ">
                                                                <!--
                                                                **********************************
                                                                Here for the for input
                                                                **********************************
                                                                -->
                                                                <div class="widget-content">
                                                                    <div class="tabbable">
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active" id="jscontrols">
                                                                                <form action="markentryform.php" method="POST">
                                                                                    <?php
                                                                                    /*
                                                                                    here to puf data in the form
                                                                                    */
                                                                                    ?>
                                                                                    <table class="table table-striped table-bordered">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th><center>No</center></th>
                                                                                            <th><center> Student Name</center></th>
                                                                                            <th><center> ID    </center></th>
                                                                                            <th><center>Telephones   </center></th>
                                                                                            <th><center> Date of Register   </center></th>


                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php

                                                                                        //stduents data
                                                                                        //to each id his/her payment


                                                                                        $resultSAH = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2` , `ST_Gid` , `S_date_On` FROM `student` ORDER BY `student`.`S_firstname` ASC ");

                                                                                        $x = 0;
                                                                                        while($rowSAH = mysqli_fetch_array($resultSAH))
                                                                                        {
                                                                                            $studentid = $rowSAH['s_id'];
                                                                                            $x = $x + 1;
                                                                                            $Fname = $rowSAH['S_firstname'] . " " . $rowSAH['S_midname1'];
                                                                                            $Sirname = " " . $rowSAH['S_midname2'] . " " . $rowSAH['S_lastname1'];
                                                                                            $fullName = $Fname . " " . $Sirname;

                                                                                            $phonenumber = $rowSAH['S_phone1'];
                                                                                            if (strlen($rowSAH['S_phone2']) > 8)
                                                                                            {
                                                                                                $phonenumber = $phonenumber." - ".$rowSAH['S_phone2'];
                                                                                            }

                                                                                            ?>
                                                                                            <tr>
                                                                                                <th><center><?php echo $x;?></center></th>
                                                                                                <th><?php echo $fullName;?></th>
                                                                                                <th><?php echo $rowSAH['ST_Gid'];?></th>
                                                                                                <th><?php echo $phonenumber;?></th>
                                                                                                <th><?php echo $rowSAH['S_date_On'];?></th>

                                                                                            </tr>
                                                                                            <?php
                                                                                        }

                                                                                        if (isset($resultsgs) && $resultsgs instanceof mysqli_result) {
                                                                                        while ($rowsgs = mysqli_fetch_array($resultsgs)) {
                                                                                             /***************************
                                                                                              * here to get the name for each studnet starting wtih the name
                                                                                              ***************************/
                                                                                             $resultSNC = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = " . $rowsgs['st_id'] . "");
                                                                                             $rowSNC = mysqli_fetch_array($resultSNC);
                                                                                             $Fname = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
                                                                                             $Sirname = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
                                                                                             $fullName = $Fname . " " . $Sirname;


                                                                                             $resultLinfo = mysqli_query($link, "SELECT CONCAT(UCASE(LEFT(`level_name`, 1)), SUBSTRING(`level_name`, 2)) as level_name , `level_fees` , `level_book` , `level_period` , `level_C_date` FROM `levels` WHERE `Level_id` = " . $rowsgs['level_id'] . "");
                                                                                             $rowLinfo = mysqli_fetch_array($resultLinfo);
                                                                                            if (isset($i) && $i == 0) {

                                                                                                 echo $rowLinfo['level_name'];
                                                                                                 echo " Created on " . $rowLinfo['level_C_date'];

                                                                                                 $i += 1;
                                                                                             }

                                                                                             $levelfullFees = $rowLinfo['level_fees'] + $rowLinfo['level_book'] - $rowsgs['discount'];
                                                                                             $feesleft = $levelfullFees - $rowsgs['paid_fees'];

                                                                                             // $Gid may be undefined in this context; skip mark join when not available
                                                                                             $resultmark = false;
                                                                                             $rowLmark = mysqli_fetch_array($resultmark);

                                                                                             $gotmark = $rowLmark['mark'];
                                                                                             $levelid = $rowsgs['level_id'];
                                                                                             ?>
                                                                                             <tr>
                                                                                                 <td width="30%"><h3><?php echo $fullName ?></h3></td>
                                                                                                 <input type="hidden" value= <?php echo $rowsgs['st_id']; ?> name="s_Name" >
                                                                                                 <td width="15%" height="15%"></td>
                                                                                                 <td width="15%" height="15%"></td>
                                                                                                 <td width="15%" height="15%"></td>
                                                                                                 <td width="15%" height="15%"></td>

                                                                                             </tr>
                                                                                             <?php


                                                                                        } } ?>

                                                                                         </tbody>
                                                                                     </table>
                                                                                 </form>
                                                                                 </fieldset>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="form-actions">
                                                 <script>
                                                     function printDiv(divName) {
                                                         var printContents = document.getElementById(divName).innerHTML;
                                                         var originalContents = document.body.innerHTML;

                                                         document.body.innerHTML = printContents;

                                                         window.print();

                                                         document.body.innerHTML = originalContents;
                                                     }
                                                 </script>
                                                 <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print!"/>

                                             </div> <!-- /form-actions --></div>
                                         <div class="extra">
                                             <div class="extra-inner">
                                                 <div class="container">
                                                     <div class="row"></div>
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
                                     </div>
                                     <div class="tab-pane" id="Modify">
                                         <div class="main">
                                             <div class="main-inner">
                                                 <div id="printableArea" class="container">
                                                     <div class="row">
                                                         <div class="span12">
                                                             <div class="widget ">
                                                                 <!--
                                                                 **********************************
                                                                 Here for the for input
                                                                 **********************************
                                                                 -->
                                                                 <div class="widget-content">
                                                                     <div class="tabbable">
                                                                         <div class="tab-content">
                                                                             <div class="tab-pane active" id="jscontrols">
                                                                                 <form action="markentryform.php" method="POST">
                                                                                     <?php
                                                                                     /*
                                                                                     here to puf data in the form
                                                                                     */
                                                                                     ?>
                                                                                     <table class="table table-striped table-bordered">
                                                                                         <thead>
                                                                                         <tr>
                                                                                             <th><center>ID</center></th>
                                                                                             <th><center> Student Name</center></th>
                                                                                             <th><center>Telephones   </center></th>
                                                                                             <th><center> Date of Register   </center></th>

                                                                                         </tr>
                                                                                         </thead>
                                                                                         <tbody>
                                                                                         <?php

                                                                                         $resultSAH = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2` , `ST_Gid` , `S_date_On` FROM `student` ORDER BY `student`.`ST_Gid` ASC ");

                                                                                         while($rowSAH = mysqli_fetch_array($resultSAH))
                                                                                         {
                                                                                             $studentid = $rowSAH['s_id'];

                                                                                             $Fname = $rowSAH['S_firstname'] . " " . $rowSAH['S_midname1'];
                                                                                             $Sirname = " " . $rowSAH['S_midname2'] . " " . $rowSAH['S_lastname1'];
                                                                                             $fullName = $Fname . " " . $Sirname;

                                                                                             $phonenumber = $rowSAH['S_phone1'];
                                                                                             if (strlen($rowSAH['S_phone2']) > 8)
                                                                                             {
                                                                                                 $phonenumber = $phonenumber." - ".$rowSAH['S_phone2'];
                                                                                             }

                                                                                             ?>
                                                                                             <tr>
                                                                                                 <th><center><?php echo $rowSAH['ST_Gid'];?></center></th>
                                                                                                 <th><?php echo $fullName;?></th>
                                                                                                 <th><?php echo $phonenumber;?></th>
                                                                                                 <th><?php echo $rowSAH['S_date_On'];?></th>



                                                                                             </tr>
                                                                                             <?php

                                                                                         }



                                                                                         if (isset($resultsgs) && $resultsgs instanceof mysqli_result) { while ($rowsgs = mysqli_fetch_array($resultsgs)) {
                                                                                              /***************************
                                                                                               * here to get the name for each studnet starting wtih the name
                                                                                               ***************************/
                                                                                             $resultSNC = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = " . $rowsgs['st_id'] . "");
                                                                                             $rowSNC = mysqli_fetch_array($resultSNC);
                                                                                             $Fname = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
                                                                                             $Sirname = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
                                                                                             $fullName = $Fname . " " . $Sirname;


                                                                                             $resultLinfo = mysqli_query($link, "SELECT CONCAT(UCASE(LEFT(`level_name`, 1)), SUBSTRING(`level_name`, 2)) as level_name , `level_fees` , `level_book` , `level_period` , `level_C_date` FROM `levels` WHERE `Level_id` = " . $rowsgs['level_id'] . "");
                                                                                             $rowLinfo = mysqli_fetch_array($resultLinfo);
                                                                                             if ($i == 0) {

                                                                                                 echo $rowLinfo['level_name'];
                                                                                                 echo " Created on " . $rowLinfo['level_C_date'];

                                                                                                 $i += 1;
                                                                                             }

                                                                                             $levelfullFees = $rowLinfo['level_fees'] + $rowLinfo['level_book'] - $rowsgs['discount'];
                                                                                             $feesleft = $levelfullFees - $rowsgs['paid_fees'];

                                                                                             $resultmark = false;
                                                                                              $rowLmark = mysqli_fetch_array($resultmark);

                                                                                              $gotmark = $rowLmark['mark'];
                                                                                              $levelid = $rowsgs['level_id'];
                                                                                              ?>
                                                                                              <tr>
                                                                                                  <td width="30%"><h3><?php echo $fullName ?></h3></td>
                                                                                                  <input type="hidden" value= <?php echo $rowsgs['st_id']; ?> name="s_Name" >
                                                                                                  <td width="15%" height="15%"></td>
                                                                                                  <td width="15%" height="15%"></td>
                                                                                                  <td width="15%" height="15%"></td>
                                                                                                  <td width="15%" height="15%"></td>

                                                                                              </tr>
                                                                                              <?php


                                                                                         } } ?>

                                                                                         </tbody>
                                                                                     </table>
                                                                                 </form>
                                                                                 </fieldset>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="form-actions">
                                                 <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print!"/>

                                             </div> <!-- /form-actions --></div>
