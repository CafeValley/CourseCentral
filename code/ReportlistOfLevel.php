<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("ReportForLevelBooks");
$MonNames = array("Jan",
    "Feb","Mar","Apr","May","June",
    "July","Aug","Sept","Oct","Nov","Dec" , "Total");
$JanBooks  = array();
$FebBooks  = array();
$MarBooks  = array();
$AprBooks  = array();
$MayBooks  = array();
$JuneBooks = array();
$JulyBooks = array();
$AugBooks  = array();
$SeptBooks = array();
$OctBooks  = array();
$NovBooks  = array();
$DecBooks  = array();
$FeedMeCount  = array();
$BooksTotal  = array();
$LevelName = array();

function MonthBookSql($BeginYear,$EndYear,$LevelNameInside,$month)
{
    global $link;
    $HowManyYears = ($EndYear - $BeginYear) + 1;

    $TheFatCountNo = 0;
    $Youngeryear = $BeginYear;
    while($HowManyYears > 0)
    {
         $theSql = "SELECT level_name , count(registration.level_id) as \"NumberOfBooks\" 
FROM `registration` , `levels`  
where registration.level_id = levels.Level_id
and regis_date between '$Youngeryear-$month-1' and '$Youngeryear-$month-31'
group by registration.level_id 
having levels.level_name ='$LevelNameInside'
ORDER BY count(registration.level_id) ASC ";

        $resultInSCheck = mysqli_query($link,$theSql );
        $rowInSCheck = mysqli_fetch_array($resultInSCheck);

        
        if (!isset($rowInSCheck['NumberOfBooks']))
        {
            $CountNo   = 0;
        }
        else 
        $CountNo   = $rowInSCheck['NumberOfBooks'];
        $TheFatCountNo += $CountNo;
        $Youngeryear++;
        $HowManyYears--;
    }


    return array ($TheFatCountNo);
    //return array ($CountNo,$F_V_FR);
}
//$JanBooks[$LevelName][$BooksCountForLevel]=0;
//1. location array for each level id and level name
//2. books count for that month !!
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
                            <i class="icon-paste"></i>
                            <h3>Books Report</h3>
                        </div> <!-- /widget-header -->
                        <!-- here code-->
                        <div class="widget-content">
                            <form action = "ReportlistOfLevel.php" method = "POST" >
                            From :
                                <select id="BYear" name="BYear" class="icon-pencil">
                                    <?php
                                    if (isset($_POST['submit']) || isset($_POST['BYear']) )
                                    {
                                        ?><option value="<?php echo $_POST['BYear'];?>" selected><?php echo $_POST['BYear'];?></option><?php
                                    }
                                    else
                                    {
                                        ?><option value="Year" selected> Year</option><?php
                                    }
                                    ?>
                                    <?php for ($i = date("Y")+1; $i >= 1970; $i--)
                                    {
                                        if (isset($_POST['submit'])||  isset($_POST['BYear']))
                                        {
                                            if ($i != $_POST['BYear'])
                                            {
                                                echo "<option value = $i> $i</option>";
                                            }
                                        }
                                        else
                                            echo "<option value = $i> $i</option>";
                                    }
                                    ?>
                                </select>
                            To :
                            <select id="EYear" name="EYear" class="icon-pencil">
                                <?php
                                if (isset($_POST['submit'])|| isset($_POST['EYear']) )
                                {
                                    ?><option value="<?php echo $_POST['EYear'];?>" selected><?php echo $_POST['EYear'];?></option><?php
                                }
                                else
                                {
                                    ?><option value="Year" selected> Year</option><?php
                                }
                                ?>
                                <?php for ($i = date("Y")+1; $i >= 1970; $i--)
                                {
                                    if (isset($_POST['submit'])|| isset($_POST['EYear']) )
                                    {
                                        if ($i != $_POST['EYear'])
                                        {
                                            echo "<option value = $i> $i</option>";
                                        }
                                    }
                                    else
                                        echo "<option value = $i> $i</option>";
                                }
                                ?>
                            </select>
                                <button type="submit" name = "submit" class="btn btn-primary">+</button>
                                </form>
                                <?php
                                if (isset($_POST['levelsbut']))
                                {
                                    $wherelevels = "where Level_id in ( ";
                                    $i=0;
                                    //print_r($_POST);
                                    foreach ($_POST as $key => $value) {
                                         $key1 = preg_replace('/[0-9]+/', '', $key);
                                      $key2 = preg_replace("/[^0-9]/", "", $key);
                        
                                    //
                                    if ($key1 == "name") {
                                        if($i == 0)
                                            {$wherelevels=$wherelevels." $key2 ";
                                            $i++;
                                        }
                                        else
                                            $wherelevels=$wherelevels." , $key2 ";
                                    }
                                }
                                $wherelevels=$wherelevels." ) ";
                                }
                                else 
                                $wherelevels = "";
                                ?>
                                <form action = "ReportlistOfLevel.php" method = "POST" >
                                 
                                <?php if (isset($_POST['BYear'])) { ?>
                                
                                    <input type = "hidden" name = "BYear" value = "<?php echo $_POST['BYear'];?>" >
                                    <input type = "hidden" name = "EYear" value = "<?php echo $_POST['EYear'];?>" >
                                   
                                <?php
                                } 
                                $countrow=0;
                                $resultLNs = mysqli_query($link, "SELECT Level_id,level_name FROM  `levels` ");
                                while($rowLNs = mysqli_fetch_array($resultLNs))
                                {
                                    echo "<strong><em>".$levelname = $rowLNs['level_name']."</em></strong>";
                                     $levelid = $rowLNs['Level_id'];
                                    ?>
                                     <input name = '<?php echo $levelid?>name' value = '<?php echo $levelid; ?>' type = 'checkbox' class = 'login'>
                                    <?php
                                    $countrow++;
                                    if ($countrow == 8 )
                                        {
                                            $countrow = 0;
                                            echo "<hr class='mb-4'>";
                                        }
                                 }
                                                                                    ?>
                                                                                    <br>
                                                                                    <input type ='submit' name = 'levelsbut' value = 'Filter'>
                            </form>
                            <?php
                            if (!isset($_POST['submit'])) {
                                $EndYear = date("Y");
                                $BeginYear = date("Y");
                            }
                            if (isset($_POST['submit']) || isset($_POST['levelsbut']))
                            {
                                $_POST['BDay']="01";
                                $_POST['BMonth']="01";
                                $_POST['EMonth']="01";
                                $_POST['EDay']="01";
                                $WhereStatement = "";
                                $StartingDate = $_POST['BYear']."-".$_POST['BMonth']."-".$_POST['BDay'];
                                $EndingDate   = $_POST['EYear']."-".$_POST['EMonth']."-".$_POST['EDay'];
                                $EndYear = $_POST['EYear'];
                                $BeginYear = $_POST['BYear'];
                                $BeginMonth = $_POST['BMonth'];
                                $EndMonth = $_POST['EMonth'];


                                if ($EndingDate<$StartingDate)
                                {
                                    echo "The -To Date- can't be before the -From Date-";

                                }
                                else
                                {
                                    $WhereStatementToday = "registration.level_id = levels.Level_id and regis_date = '$StartingDate'";
                                    $WhereStatementMonth = "registration.level_id = levels.Level_id and regis_date between '$BeginYear-$BeginMonth-1' and '$EndYear-$EndMonth-31'";
                                    $WhereStatementYear  = "registration.level_id = levels.Level_id and regis_date between '$BeginYear-1-1' and '$EndYear-12-31'";
                                }
                            }
                            else
                            {
                                $Tyear = date("Y");
                                $WhereStatementYear  = "registration.level_id = levels.Level_id and regis_date between '$Tyear-1-1' and '$Tyear-12-31'";

                            }

                            //here to put data inside my date - starting and ending ?>
                            <div class="tabbable">
                                <div class="tab-content">

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
                                                                                    $resultLNs = mysqli_query($link, "SELECT Level_id,level_name FROM  `levels` $wherelevels");
                                                                                    if ($resultLNs instanceof mysqli_result) while($rowLNs = mysqli_fetch_array($resultLNs))
                                                                                    {
                                                                                        $LevelNameInside = $rowLNs['level_name'];
                                                                                        $theSql = "SELECT level_name , count(registration.level_id) as \"NumberOfBooks\" 
                                                                                                FROM `registration` , `levels`  
                                                                                                where registration.level_id = levels.Level_id
                                                                                                and year(regis_date) between '$BeginYear-1-1' and '$EndYear-1-1'
                                                                                                group by registration.level_id 
                                                                                                having levels.level_name ='$LevelNameInside'   
                                                                                                ORDER BY count(registration.level_id) ASC ";
                                                                                        $resultInSCheck = mysqli_query($link,$theSql );
                                                                                        $rowInSCheck = mysqli_fetch_array($resultInSCheck);
                                                                                       
                                                                                        if (!isset($rowInSCheck['NumberOfBooks']))
                                                                                        {
                                                                                            $CountNo   = 0;
                                                                                        }
                                                                                        else 
                                                                                        $CountNo   = $rowInSCheck['NumberOfBooks'];
                                                                                        $LevelName[] = $LevelNameInside;

                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,1));
                                                                                        $JanBooks[$LevelNameInside]  = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] = $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,2));
                                                                                        $FebBooks[$LevelNameInside]  = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,3));
                                                                                        $MarBooks[$LevelNameInside]  = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,4));
                                                                                        $AprBooks[$LevelNameInside]  = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,5));
                                                                                        $MayBooks[$LevelNameInside]  = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,6));
                                                                                        $JuneBooks[$LevelNameInside] = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,7));
                                                                                        $JulyBooks[$LevelNameInside] = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,8));
                                                                                        $AugBooks[$LevelNameInside]  = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,9));
                                                                                        $SeptBooks[$LevelNameInside] = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,10));
                                                                                        $OctBooks[$LevelNameInside]  = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,11));
                                                                                        $NovBooks[$LevelNameInside]  = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                        $FeedMeCount = (MonthBookSql($BeginYear,$EndYear,$LevelNameInside,12));
                                                                                        $DecBooks[$LevelNameInside]  = $FeedMeCount[0];
                                                                                        $BooksTotal[$LevelNameInside] += $FeedMeCount[0];
                                                                                    }
                                                                                    ?>

                                                                                    <table class="table table-striped table-bordered">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th><center>Month </center></th>
                                                                                            <?php if (!empty($LevelName)) foreach ($LevelName as &$value) { ?>
                                                                                                <th><center><?php echo $value;?></center></th>
                                                                                                <?php
                                                                                            } ?>


                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php

                                                                                        $resultLCN = mysqli_query($link, "SELECT level_name , count(registration.level_id) as \"numberofbooks\" FROM `registration` , `levels`  where $WhereStatementYear group by registration.level_id ORDER BY count(registration.level_id) ASC ");

                                                                                        $x = 0;
                                                                                        //while($rowLCN = mysqli_fetch_array($resultLCN))
                                                                                       while(isset($MonNames[$x]) && $MonNames[$x])
                                                                                        {
                                                                                            $rowLCN = mysqli_fetch_array($resultLCN);
                                                                                            $CountNo   = isset($rowLCN['numberofbooks']) ? $rowLCN['numberofbooks'] : 0;
                                                                                            $LevelNameIn   = isset($rowLCN['level_name']) ? $rowLCN['level_name'] : '';

                                                                                            ?>
                                                                                            <tr>
                                                                                                <th><center><?php echo $MonNames[$x];?></center></th>
                                                                                                <?php if (!empty($LevelName)) foreach ($LevelName as &$value) {

                                                                                                        switch($x)
                                                                                                        {  case 0: {
                                                                                                            ?>
                                                                                                            <th><center><?php echo  $JanBooks [$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                            <?php case 1: {?>

                                                                                                            <th><center><?php echo  $FebBooks [$value] ;?></center></th>
                                                                                                            <?php break;}?>
                                                                                                        <?php case 2: {?>
                                                                                                            <th><center><?php echo  $MarBooks [$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 3: {?>
                                                                                                            <th><center><?php echo  $AprBooks [$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 4: {?>
                                                                                                            <th><center><?php echo  $MayBooks [$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 5: {?>
                                                                                                            <th><center><?php echo  $JuneBooks[$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 6: {?>
                                                                                                            <th><center><?php echo  $JulyBooks[$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 7: {?>
                                                                                                            <th><center><?php echo  $AugBooks [$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 8: {?>
                                                                                                            <th><center><?php echo  $SeptBooks[$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 9: {?>
                                                                                                            <th><center><?php echo  $OctBooks [$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 10: {?>
                                                                                                            <th><center><?php echo  $NovBooks [$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 11: {?>
                                                                                                            <th><center><?php echo  $DecBooks [$value] ;?></center></th>
                                                                                                            <?php break; }?>
                                                                                                        <?php case 12: {?>
                                                                                                            <th><center><?php echo  $BooksTotal [$value] ;?></center></th>
                                                                                                            <?php break; } } }
                                                                                                $x = $x + 1; } ?>
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
                            </div>
                        </div> <!-- /widget-content -->
                    </div> <!-- /widget -->
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->
<div class="extra">
    <div class="extra-inner">
        <div class="container">
            <div class="row">
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /extra-inner -->
</div> <!-- /extra -->
<div class="footer">
    <div class="footer-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    &copy; 2015 <a href='http://cafavalley.comoj.com/'>Cafavalley</a>
                </div> <!-- /span12 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /footer-inner -->
</div> <!-- /footer -->
</body>
</html>
</body>
</html>
