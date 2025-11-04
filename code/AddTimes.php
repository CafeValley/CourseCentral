<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheckRegis("AddTime");

//need a select all intervals here !
//begin and end
//
//and display all to give
//the function to delete
$COCO = '';
if (isset($_POST['add'])){
    $COCO = 'A';
    // sanitize inputs
    $TimeStart = isset($_POST['BeginT']) ? (int)$_POST['BeginT'] : 0;
    $Space     = isset($_POST['TimeSpace']) ? (int)$_POST['TimeSpace'] : 0;
    $selectAP  = isset($_POST['SelectAmPm']) ? $_POST['SelectAmPm'] : 'am';
    if ($selectAP == "am")
        $TimeStart += 0;
    if ($selectAP == "pm")
        $TimeStart += 12;

    // basic validation
    if ($TimeStart <= 0 || $Space <= 0) {
        $COCO = '';
    } else {
        // check existing using prepared statements
        $stmtC = $link->prepare("SELECT `CorusesTimeId` FROM `corusestime` WHERE `TimeB` = ? and `TimeSize` = ? LIMIT 1");
        if ($stmtC) {
            $stmtC->bind_param("ii", $TimeStart, $Space);
            $stmtC->execute();
            $stmtC->bind_result($IdForUpdate);
            $hasRow = $stmtC->fetch();
            $stmtC->close();
            if ($hasRow) {
                $stmtU = $link->prepare("UPDATE `corusestime` SET `TimeB`=?, `TimeSize`=? WHERE `CorusesTimeId` = ?");
                if ($stmtU) {
                    $stmtU->bind_param("iii", $TimeStart, $Space, $IdForUpdate);
                    $stmtU->execute();
                    $stmtU->close();
                }
            } else {
                $stmtI = $link->prepare("INSERT INTO `CorusesTime`(`CorusesTimeId`, `TimeB`, `TimeSize`) VALUES (NULL, ?, ?)");
                if ($stmtI) {
                    $stmtI->bind_param("ii", $TimeStart, $Space);
                    $stmtI->execute();
                    $stmtI->close();
                }
            }
        }
    }
}
if (isset($_POST['TrashThis'])){
    $COCO = 'T';
    $MyTimeId = isset($_POST['TimeId']) ? (int)$_POST['TimeId'] : 0;
    if ($MyTimeId > 0) {
        $stmtD = $link->prepare("DELETE FROM `CorusesTime` WHERE `CorusesTimeId` = ?");
        if ($stmtD) {
            $stmtD->bind_param("i", $MyTimeId);
            $stmtD->execute();
            $stmtD->close();
        }
    }
}
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-save"></i>
                            <h3>Student Register Delete </h3></div>
                        <div class="widget-content">
                            <div class="tabbable">
                                <div class="tab-content">
                                    <form action = "AddTimes.php" method = "POST">
                                        <div class = "controls">
                                            <div class = "input-append"><label class = "control-label"
                                                                               for = "radiobtns">Starts From</label>
                                                <input type = "text" id = "BeginT" required
                                                       name = "BeginT" placeholder = "Time"
                                                       value = '' style="width:10%" class = "login"/>
                                                <select name = "SelectAmPm" class="icon-pencil">
                                                    <option value = "am">Am</option>
                                                    <option value = "pm">Pm</option>
                                                </select>
                                                <input type = "text" id = "TimeSpace" required
                                                       name = "TimeSpace" value = "2"
                                                       value = '' style="width:10%"  class = "login"/>
                                            </div>
                                            <button name = "add" type = "submit" class = "btn btn-primary">+</button>
                                        </div>

                                    </form>
                                    <?php
                                    $SqlTime       = mysqli_query ($link , "SELECT `CorusesTimeId`, `TimeB`, `TimeSize` FROM `corusestime` order by `TimeB` ASC  ");
                                    $SqlTimeCount  = ($SqlTime instanceof mysqli_result) ? mysqli_num_rows($SqlTime) : 0;
                                    echo "<br>";
                                    echo "<br>";
                                    ?>

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="2%"><center>No</center></th>
                                            <th><center>Time</center></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                    <?php
                                    if ($SqlTimeCount > 0)
                                    {
                                        $x = 1;
                                        while($SqlTimeReturn = mysqli_fetch_array ($SqlTime))
                                        {
                                              ?>
                                    <form action="AddTimes.php" method="POST">
                                        <input type = "hidden" name = "TimeId" value = "<?php echo htmlspecialchars($SqlTimeReturn['CorusesTimeId']);?>">

                                            <?php
                                            $TimeSet = (int)$SqlTimeReturn['TimeB'];
                                            if ($TimeSet < 12)
                                                $AmorPm = "Am";
                                            if ($TimeSet > 12)
                                            {
                                                $AmorPm = "Pm";
                                                $TimeSet -= 12;
                                            }
                                            $TimeSetEnd = $TimeSet + (int)$SqlTimeReturn['TimeSize'];
                                            if ($TimeSetEnd > 12)
                                                $TimeSetEnd -= 12 ;
                                            ?>

                                            <tr>
                                                <th><center><?php echo $x;?></center></th>
                                                <th><h1><?php echo htmlspecialchars($TimeSet);?>-<?php echo htmlspecialchars($TimeSetEnd." ".$AmorPm);?></h1></th>
                                                <th><button name = "TrashThis" type = "submit" class = "btn btn-primary"><i class="icon-trash"></i></button></th>
                                    </form>
                                            </tr>
                                            <?php
                                            $x +=1;
                                        }
                                    } ?>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                            <?php
                            if ($COCO == "A") { ?>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="alert alert-success">
                                            <button type="button" class="close"
                                                    data-dismiss="alert">&times;</button>
                                            Time
                                            <strong>Number</strong> Added.
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            if ($COCO == "T") { ?>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="alert alert-success">
                                            <button type="button" class="close"
                                                    data-dismiss="alert">&times;</button>
                                            Time
                                            <strong>Number</strong> Removed.
                                        </div>
                                    </div>
                                </div>
                            <?php }?>

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