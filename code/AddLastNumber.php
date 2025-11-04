<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheckRegis("AddPassNumber");

$COCO = '';
if (isset($_POST['add'])){

    $COCO = 'A';
    // sanitize input
    $NewFixNumber = isset($_POST['newFixNumber']) ? (int)$_POST['newFixNumber'] : 0;
    if ($NewFixNumber > 0) {
        $stmt = $link->prepare("INSERT INTO `PlaceLastNumberIncrement`(`IDSet`, `ChangeTime`) VALUES (?, NOW())");
        if ($stmt) {
            $stmt->bind_param("i", $NewFixNumber);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        $COCO = '';
    }

}

$resultSNMax = mysqli_query ($link , "SELECT max(ST_Gid) as maxid FROM `student` ");
$returnSNMax    = ($resultSNMax instanceof mysqli_result) ? mysqli_fetch_array ($resultSNMax) : null;
$MaxId = $returnSNMax ? $returnSNMax['maxid'] : '';

?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-asterisk"></i>
                            <h3>Student Register Delete </h3></div>
                        <div class="widget-content">
                            <div class="tabbable">
                                <div class="tab-content">
                                    <form action = "AddLastNumber.php" method = "POST">
                                        <div class = "controls">
                                            <p><strong>Note:</strong>
                                                This number the system will give to the next student <br>
                                            unless there is aready a student with that number<br>
                                            in which case <br>the system will asssign all the new students to the greatest number</p>
                                            
                                            Last Stduent Number -><?php echo htmlspecialchars($MaxId);?><br>
                                            Last Assigned Number -><?php echo htmlspecialchars(GetMaxID());?><br>

                                        </div>

                                            <div class = "controls">
                                                <div class = "input-append"><label class = "control-label"
                                                                                   for = "radiobtns"></label>
                                                    <input type = "text" id = "newFixNumber" required
                                                           name = "newFixNumber" placeholder = "New Fix Number"
                                                           value = '' class = "login"/>
                                                    <button name = "add" type = "submit" class = "btn btn-primary">+</button>
                                                </div>
                                            </div>

                                    </form>

                                </div>
                            </div>
                            <?php
                             if ($COCO == "A") { ?>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="alert alert-success">
                                            <button type="button" class="close"
                                                    data-dismiss="alert">&times;</button>
                                            Last
                                            <strong>Number</strong> Added.
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