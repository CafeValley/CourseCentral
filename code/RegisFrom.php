<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("Register");
$ReturnFCA = array();
$earlyFees = 0;
?>
<link href="css/modern-forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
    /* Enhanced Registration Form Styling */
    .registration-container {
        background: #fff;
        padding: 25px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .form-section {
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .form-section:last-child {
        border-bottom: none;
    }
    
    .form-section h4 {
        color: #0b9bba;
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 600;
    }
    
    .input-group-inline {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }
    
    .input-group-inline input,
    .input-group-inline select {
        flex: 1;
        min-width: 120px;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    
    .input-group-inline input:focus,
    .input-group-inline select:focus {
        outline: none;
        border-color: #0b9bba;
        box-shadow: 0 0 0 3px rgba(11, 155, 186, 0.1);
    }
    
    .info-box {
        background: #f9f9f9;
        border-left: 4px solid #0b9bba;
        padding: 15px;
        margin: 15px 0;
        border-radius: 4px;
    }
    
    .info-box strong {
        color: #0b9bba;
        display: block;
        margin-bottom: 5px;
    }
    
    .step-indicator {
        background: #f5f5f5;
        padding: 10px 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #666;
    }
    
    .step-indicator.active {
        background: #e8f4fd;
        border-left: 4px solid #0b9bba;
        color: #0b9bba;
        font-weight: 600;
    }
</style>
<script type="text/javascript" >
	
 var discount_options= new Array();
 discount_options["None"]    = 0;
 discount_options["DisQuid"] = 25;
 discount_options["DisHalf"] = 50;
 discount_options["DisHeavy"] = 90;


 function getDiscountValueFun()
{
    var discountchoicen=0;
    var theForm = document.forms["Registform"];
    var selectedFilling = theForm.elements["filling"];
    discountchoicen = discount_options[selectedFilling.value];
    return discountchoicen;
}

 function getBookPrice()
 {
     var BookPrice = document.getElementById('LevelBook');
     return BookPrice.value;
 }
function getFullPrice()
{
	var FullPrice = document.getElementById('LevelFees');
    return FullPrice.value;
}

function CalaDiscount(DiscountValue,DiscountPer)
{
    if (DiscountPer == 0)
    {
        return (DiscountValue);
    }
    DiscountMin = ( DiscountValue * DiscountPer ) / 100;
    TotalPayAfterDis = DiscountValue - DiscountMin;
    
    return (TotalPayAfterDis);
}

function calculateTotal()
{
    var divobj = document.getElementById('totalPrice');
    divobj.style.display='block';
	var added = CalaDiscount(+getFullPrice() , +getDiscountValueFun()) + +getBookPrice();

    divobj.innerHTML = "<?php spacingformat(10);?>After the Discount:<?php spacingformat(2);?><input readonly type = 'text' value = '" + added + "'>";
}
function hideTotal()
{
    var divobj = document.getElementById('totalPrice');
    divobj.style.display='none';
}
	</script>

<!-- Inline modal helper for opening pages within the same page -->
<script type="text/javascript">
function showGatepassModal(url) {
    var modal = document.getElementById('inlineModal');
    var iframe = document.getElementById('inlineModalIframe');
    if (!modal || !iframe) return;
    iframe.src = url;
    modal.style.display = 'block';
}

function closeGatepassModal() {
    var modal = document.getElementById('inlineModal');
    var iframe = document.getElementById('inlineModalIframe');
    if (!modal || !iframe) return;
    iframe.src = 'about:blank';
    modal.style.display = 'none';
}
</script>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    
                    <!-- Page Header -->
                    <div style="margin-bottom: 30px; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <h1 style="margin: 0 0 10px 0; color: #0b9bba; font-size: 28px;">
                            <i class="icon-user" style="margin-right: 10px;"></i>
                            Student Registration
                        </h1>
                        <p style="margin: 0; color: #666; font-size: 14px;">
                            Register new students or enroll existing students into courses
                        </p>
                    </div>
                    
                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-bullhorn"></i>
                            <h3>Registration Form</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content" style="padding: 25px;">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" style="margin-bottom: 20px;">
                                    <li>
                                        <a href="#formcontrols" data-toggle="tab">
                                            <i class="icon-plus"></i> New Student
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="#jscontrols" data-toggle="tab">
                                            <i class="icon-edit"></i> Existing Student
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane" id="formcontrols">
                                        <form action="student.php" method="post" class="registration-container">
                                            <div class="form-section">
                                                <h4><i class="icon-money"></i> Registration Fees</h4>
                                                <div class="hiddenInput2">
                                                    <div class="info-box">
                                                        <strong>Registration Fee:</strong>
                                                        <input type="text"
                                                               id="Regis_Fees"
                                                               name="Regis_Fees"
                                                               readonly
                                                               value="<?php $ReturnFCA=FeesData("Student"); echo $ReturnFCA['1']; ?>"
                                                               placeholder="Fees"
                                                               style="width: 200px; margin-top: 10px;"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-section">
                                                <h4><i class="icon-user"></i> Student Name</h4>
                                                <div class="input-group-inline">
                                                    <input type="text" id="firstname" name="firstname"
                                                           value="" required placeholder="First Name"/>
                                                    <input type="text" id="MiddleNameI" name="MiddleNameI"
                                                           value="" required placeholder="Middle Name I"/>
                                                    <input type="text" id="MiddleNameII" name="MiddleNameII"
                                                           value="" required placeholder="Middle Name II"/>
                                                    <input type="text" id="LastName" name="LastName"
                                                           value="" placeholder="Last Name"/>
                                                </div>
                                            </div>
                                            
                                            <div class="form-section">
                                                <h4><i class="icon-calendar"></i> Date of Birth</h4>
                                                <div class="input-group-inline">
                                                    <select id="Year" name="Year">
                                                        <option value="Year" selected>Year</option>
                                                        <?php
                                                        for ($i = 1950; $i <= date("Y"); $i++)
                                                            echo "<option value = $i> $i</option>";
                                                        ?>
                                                    </select>
                                                    <select id="Month" name="Month">
                                                        <option value="Month" selected>Month</option>
                                                        <?php
                                                        for ($i = 01; $i <= 12; $i++)
                                                            echo "<option value = $i> $i</option>";
                                                        ?>
                                                    </select>
                                                    <select id="Day" name="Day">
                                                        <option value="Day" selected>Day</option>
                                                        <?php
                                                        for ($i = 01; $i <= 31; $i++)
                                                            echo "<option value = $i> $i</option>";
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-section">
                                                <h4><i class="icon-phone"></i> Contact Information</h4>
                                                <div class="input-group-inline">
                                                    <input type="text" id="PhoneI" name="PhoneI" value=""
                                                           required placeholder="Phone I"/>
                                                    <input type="text" id="PhoneII" name="PhoneII" value=""
                                                           placeholder="Phone II (Optional)"/>
                                                </div>
                                                <div style="margin-top: 15px;">
                                                    <input type="text" id="FaceBookName" name="FaceBookName" value=""
                                                           placeholder="Facebook Name (Optional)" 
                                                           style="width: 100%; max-width: 400px;"/>
                                                </div>
                                                <div style="margin-top: 15px;">
                                                    <input type="email" id="E_mail" name="E_mail" value=""
                                                           placeholder="E-mail Address (Optional)" 
                                                           style="width: 100%; max-width: 400px;"/>
                                                </div>
                                            </div>


                                            <?php
                                            // Modern alert messages
                                            if (isset($_GET['IdDuplication'])) {
                                                echo '<div class="modern-alert modern-alert-error" style="margin-top: 20px;">
                                                        <i class="icon-warning-sign"></i> <strong>Error:</strong> 
                                                        Sorry, there is already a student with ID: ' . escape_html($_GET['IdDuplication']) . ' 
                                                        - Name: ' . escape_html($_GET['FullName']) . '.
                                                      </div>';
                                            }

                                            if (isset($_GET['FYI'])) {
                                                echo '<div class="modern-alert modern-alert-warning" style="margin-top: 20px;">
                                                        <i class="icon-info-sign"></i> <strong>Warning:</strong> Please enter the Birth Year.
                                                      </div>';
                                            }
                                            
                                            if (isset($_GET['IDEE'])) {
                                                echo '<div class="modern-alert modern-alert-warning" style="margin-top: 20px;">
                                                        <i class="icon-info-sign"></i> <strong>Warning:</strong> Please enter the ID or uncheck the box.
                                                      </div>';
                                            }
                                            
                                            if (isset($_GET['SID'])) {
                                                echo '<div class="modern-alert modern-alert-success" style="margin-top: 20px;">
                                                        <i class="icon-ok"></i> <strong>Success!</strong> 
                                                        Registration completed! Your Student ID is: <strong>' . escape_html($_GET['SID']) . '</strong>
                                                      </div>';
                                            }
                                            ?>

                                            <div class="form-actions" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                                                <button type="submit" class="btn btn-primary btn-large">
                                                    <i class="icon-save"></i> Save & Continue
                                                </button>
                                                <button type="reset" class="btn">
                                                    <i class="icon-refresh"></i> Reset
                                                </button>
                                            </div> <!-- /form-actions -->


                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="tab-pane active" id="jscontrols">
                                        <form action="RegisFrom.php" method="POST" class="registration-container">
                                            <div class="form-section">
                                                <h4><i class="icon-search"></i> Step 1: Enter Student Code</h4>
                                                <div class="step-indicator <?php echo isset($_POST['StudentCode']) ? '' : 'active'; ?>">
                                                    Enter the student's ID number to search for their record
                                                </div>
                                                <div class="input-group-inline" style="margin-top: 15px;">
                                                    <input type="text" id="StudentCode" required
                                                           name="StudentCode" placeholder="Student Code"
                                                           value="<?php 
                                                           if(isset($_POST['StudentCode'])) {
                                                               echo escape_html($_POST['StudentCode']);
                                                           } elseif(isset($_GET['SID'])) {
                                                               echo escape_html($_GET['SID']);
                                                           }
                                                           ?>" 
                                                           style="flex: 1; min-width: 200px;"/>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="icon-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!--
                                        **********************************
                                        Querying to get Name
                                        **********************************
                                        -->
                                        <?php if (isset($_POST['StudentCode'])) {
                                            $resultSNC = mysqli_query($link, "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = "
                                                . $_POST['StudentCode'] . " ");
                                            $rowSNC = mysqli_fetch_array($resultSNC);
                                            $Fname = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
                                            $Sirname = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
                                            if ($Fname == " ")
                                                $CountStudent = 0;
                                            else
                                                $CountStudent = 1;
                                        }  //here to display Name
                                        ?>
                                        
                                        <?php if (isset($Fname)) { ?>
                                            <div class="form-section">
                                                <h4><i class="icon-user"></i> Student Information</h4>
                                                <div class="info-box">
                                                    <strong>Student Name:</strong>
                                                    <div style="margin-top: 10px; font-size: 16px;">
                                                        <?php echo escape_html($Fname . $Sirname); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                        
                                        if (!isset($_POST['level_id'])) {
                                            ?>
                                            <form action="RegisFrom.php" method="POST" class="registration-container">
                                                <div class="form-section">
                                                    <h4><i class="icon-book"></i> Step 2: Select Course & Group</h4>
                                                    <div class="step-indicator active">
                                                        Choose the course level and group timing
                                                    </div>
                                                    
                                                    <div style="margin-top: 20px;">
                                                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Select Level</label>
                                                        <select id="level_id" name="level_id" style="width: 100%; max-width: 400px; padding: 10px;">
                                                            <?php 
                                                            $i = 1;
                                                            $result = mysqli_query($link, "SELECT `Level_id`, `level_name` FROM `levels`");
                                                            if ($i == 1) {
                                                                echo "<option selected value='nothing'>-- Select Level --</option>";
                                                                $i += 1;
                                                            }
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo "<option value='".escape_html($row['Level_id'])."'>".escape_html($row['level_name'])."</option>";
                                                            } 
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div style="margin-top: 20px;">
                                                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Group Time</label>
                                                        <div class="input-group-inline">
                                                            <?php DisplayInterval(); ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div style="margin-top: 20px;">
                                                        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Group Schedule</label>
                                                        <div class="input-group-inline">
                                                            <select id="GroupDay" name="GroupDay">
                                                                <option selected value='nothing'>Group Day</option>
                                                                <option value='1'>1st</option>
                                                                <option value='15'>15th</option>
                                                            </select>
                                                            <select id="GroupMonth" name="GroupMonth">
                                                                <option value = "nothing">Group Month</option>
                                                                <?php
                                                                echo "<option value = '".date('m', strtotime('first day of last month'))."'>".NameToMonth(date('m', strtotime('first day of last month')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of this month'))."'>".NameToMonth(date('m', strtotime('first day of this month')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +1 months'))."'>".NameToMonth(date('m', strtotime('first day of +1 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +2 months'))."'>".NameToMonth(date('m', strtotime('first day of +2 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +3 months'))."'>".NameToMonth(date('m', strtotime('first day of +3 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +4 months'))."'>".NameToMonth(date('m', strtotime('first day of +4 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +5 months'))."'>".NameToMonth(date('m', strtotime('first day of +5 months')))."</option>";
                                                                echo "<option value = '".date('m', strtotime('first day of +6 months'))."'>".NameToMonth(date('m', strtotime('first day of +6 months')))."</option>";
                                                                ?>
                                                            </select>
                                                            <select id="GroupYear" name="GroupYear">
                                                                <option value = "nothing">Group Year</option>
                                                                <?php for ($i=2017;$i <= date("Y")+3;$i++) {
                                                                    echo "<option>$i</option>"; }
                                                                ?>
                                                            </select>
                                                            <button name="DeathCall" type="submit" class="btn btn-primary">
                                                                <i class="icon-search"></i> Find Group
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="StudentCode" name="StudentCode"
                                                       value="<?php echo isset($_POST['StudentCode']) ? escape_html($_POST['StudentCode']) : ''; ?>"/>
                                            </form>
                                            <?php
                                        } else {
                                            ?>
                                            <form action="RegisFrom.php" method="POST">
                                                <ul style="float: left">
                                                    <label for="group_id">Which Level</label>
                                                    <select id="level_id" name="level_id" class="icon-pencil">
                                                        <?php
                                                        $result = mysqli_query($link, "SELECT `Level_id`, `level_name` ,`level_fees`, `level_book`  FROM `levels`");
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            if ($row['Level_id']
                                                                == $_POST['level_id']
                                                            )
                                                            {
                                                                echo "<option selected value='$row[Level_id]'>$row[level_name]</option>";
                                                            }
                                                            else
                                                                echo "<option value='$row[Level_id]'>$row[level_name]</option>";
                                                        } ?>
                                                    </select>
                                                </ul>

                                                <div class="control-group">
                                                    <label class="control-label" for="radiobtns">Group Time</label>
                                                    <div class="controls">
                                                        <div class="input-append">
                                                                <?php
                                                                DisplayInterval(GetTimefromID($_POST['GroupTime']));
                                                              ?>
                                                            <select id="GroupDay" name="GroupDay"
                                                                    class="icon-pencil">
                                                                <?php if ($_POST['GroupDay'] == 'nothing') { ?>
                                                                    <option selected value='nothing'>Group Day
                                                                    </option>
                                                                    <option value=1>1st</option>
                                                                    <option value=15>15th</option>
                                                                <?php } ?>
                                                                <?php if ($_POST['GroupDay'] == 1) { ?>
                                                                    <option value='nothing'>Group Day</option>
                                                                    <option selected value=1>1st</option>
                                                                    <option value=15>15th</option>
                                                                <?php } ?>

                                                                <?php if ($_POST['GroupDay'] == 15) { ?>
                                                                    <option value='nothing'>Group Day</option>
                                                                    <option value=1>1st</option>
                                                                    <option selected value=15>15th</option>
                                                                <?php } ?>
                                                            </select>
                                                            <select id="GroupMonth" name="GroupMonth" class="icon-pencil">
                                                                <?php
                                                                if ($_POST['GroupMonth'] == date('m', strtotime('first day of last month')) )
                                                                    echo "<option selected value = '".date('m', strtotime('first day of last month'))."'>".NameToMonth(date('m', strtotime('first day of last month')))."</option>";
                                                                else
                                                                    echo "<option value = '".date('m', strtotime('first day of last month'))."'>".NameToMonth(date('m', strtotime('first day of last month')))."</option>";

                                                                if ($_POST['GroupMonth'] == date('m', strtotime('first day of this month')) )
                                                                    echo "<option selected value = '".date('m', strtotime('first day of this month'))."'>".NameToMonth(date('m', strtotime('first day of this month')))."</option>";
                                                                else
                                                                    echo "<option value = '".date('m', strtotime('first day of this month'))."'>".NameToMonth(date('m', strtotime('first day of this month')))."</option>";

                                                                if ($_POST['GroupMonth'] == date('m', strtotime('first day of +1 months')))
                                                                    echo "<option selected value = '".date('m', strtotime('first day of +1 months'))."'>".NameToMonth(date('m', strtotime('first day of +1 months')))."</option>";
                                                                else
                                                                    echo "<option value = '".date('m', strtotime('first day of +1 months'))."'>".NameToMonth(date('m', strtotime('first day of +1 months')))."</option>";

                                                                if ($_POST['GroupMonth'] == date('m', strtotime('first day of +2 months')))
                                                                    echo "<option selected value = '".date('m', strtotime('first day of +2 months'))."'>".NameToMonth(date('m', strtotime('first day of +2 months')))."</option>";
                                                                else
                                                                    echo "<option value = '".date('m', strtotime('first day of +2 months'))."'>".NameToMonth(date('m', strtotime('first day of +2 months')))."</option>";

                                                                if ($_POST['GroupMonth'] == date('m', strtotime('first day of +3 months')))
                                                                    echo "<option selected value = '".date('m', strtotime('first day of +3 months'))."'>".NameToMonth(date('m', strtotime('first day of +3 months')))."</option>";
                                                                else
                                                                    echo "<option value = '".date('m', strtotime('first day of +3 months'))."'>".NameToMonth(date('m', strtotime('first day of +3 months')))."</option>";

                                                                if ($_POST['GroupMonth'] == date('m', strtotime('first day of +4 months')))
                                                                    echo "<option selected value = '".date('m', strtotime('first day of +4 months'))."'>".NameToMonth(date('m', strtotime('first day of +4 months')))."</option>";
                                                                else
                                                                    echo "<option value = '".date('m', strtotime('first day of +4 months'))."'>".NameToMonth(date('m', strtotime('first day of +4 months')))."</option>";

                                                                if ($_POST['GroupMonth'] == date('m', strtotime('first day of +5 months')))
                                                                    echo "<option selected value = '".date('m', strtotime('first day of +5 months'))."'>".NameToMonth(date('m', strtotime('first day of +5 months')))."</option>";
                                                                else
                                                                    echo "<option value = '".date('m', strtotime('first day of +5 months'))."'>".NameToMonth(date('m', strtotime('first day of +5 months')))."</option>";

                                                                if ($_POST['GroupMonth'] == date('m', strtotime('first day of +6 months')))
                                                                    echo "<option selected value = '".date('m', strtotime('first day of +6 months'))."'>".NameToMonth(date('m', strtotime('first day of +6 months')))."</option>";
                                                                else
                                                                    echo "<option value = '".date('m', strtotime('first day of +6 months'))."'>".NameToMonth(date('m', strtotime('first day of +6 months')))."</option>";

                                                                ?>
                                                            </select>
                                                            <select id="GroupYear" name="GroupYear"
                                                                    class="icon-pencil">

                                                                <?php for ($i=2017;$i <= date("Y")+3;$i++) {
                                                                    if ($_POST['GroupYear'] == $i )
                                                                        echo "<option selected>$i</option>";
                                                                    else
                                                                        echo "<option>$i</option>"; }
                                                                ?>
                                                            </select>
                                                            <button name = "DeathCall" type="submit" class="btn btn-primary">+</button>
                                                        </div>
                                                    </div>
                                                </div> <!-- /control-group -->
                                                <input type="hidden" id="StudentCode" name="StudentCode"
                                                       value="<?php echo isset($_POST['StudentCode']) ? $_POST['StudentCode'] : ''; ?>" class="login"/>
                                            </form>
                                            <?php
                                        }
                                        
                                        // Only call GetTimefromID if GroupTime is set
                                        $GT = isset($_POST['GroupTime']) ? GetTimefromID($_POST['GroupTime']) : '';
                                        $levelcode = isset($_POST['level_id']) ? $_POST['level_id'] : '';
                                        $Studocode = isset($_POST['StudentCode']) ? $_POST['StudentCode'] : '';
                                        $datafromfrom = '';
                                        $rowTGT = array('group_id' => '', 'group_teacher' => '', 'group_startday' => '');
                                        
                                        // Only build date and query if we have all required fields
                                        if (isset($_POST['GroupDay']) && isset($_POST['GroupYear']) && isset($_POST['GroupMonth']) 
                                            && $_POST['GroupDay'] != 'nothing' && $_POST['GroupYear'] != 'nothing' && $_POST['GroupMonth'] != 'nothing'
                                            && !empty($GT) && !empty($levelcode) && $levelcode != 'nothing') {
                                            
                                            if (strlen($_POST['GroupDay']) == 1) {
                                                $datafromfrom = $_POST['GroupYear'] . "-" . $_POST['GroupMonth'] . "-0" . $_POST['GroupDay'];
                                            } elseif (strlen($_POST['GroupDay']) == 2) {
                                                $datafromfrom = $_POST['GroupYear'] . "-" . $_POST['GroupMonth'] . "-" . $_POST['GroupDay'];
                                            }
                                            
                                            // Only query if we have a valid date
                                            if (!empty($datafromfrom)) {
                                                $levelcode_int = (int)$levelcode;
                                                $stmt = $link->prepare("SELECT `group_id`, `group_teacher`, `group_startday` FROM `group` WHERE `group_time` LIKE ? AND `level_id` = ? AND `group_startday` = ? ORDER BY `group_C_date`");
                                                if ($stmt) {
                                                    $stmt->bind_param("sis", $GT, $levelcode_int, $datafromfrom);
                                                    $stmt->execute();
                                                    $resultTGT = $stmt->get_result();
                                                    $rowTGT = $resultTGT->fetch_assoc();
                                                    $stmt->close();
                                                    
                                                    // Initialize $rowTGT if query didn't return results
                                                    if (!$rowTGT) {
                                                        $rowTGT = array('group_id' => '', 'group_teacher' => '', 'group_startday' => '');
                                                    }
                                                }
                                            }
                                        }
                                        
                                        if (isset($_POST['DeathCall'])){
                                        
                                        
                                        /*here for this group's
                                        Fees , not the same as 
                                        the level Fees*/
                                        $WantedLevelFees = CallMainFees($rowTGT['group_id']);
                                        $WantedLevelBookFees = CallFeesBook($rowTGT['group_id']);
                                        
                                        $MainSqlJu =  "SELECT count(*) as countthis FROM `group` where `group_time` = '"
                                            . $GT . "' and `level_id` =" . $levelcode
                                            . " and `group_startday` = '" . $datafromfrom
                                            . "' order by `group_C_date` ";
                                        $rcount = mysqli_query($link,$MainSqlJu);

                                        $rowcount = mysqli_fetch_assoc($rcount);
                                        $differfromtodaystart = dateDifference( $today, $datafromfrom , $differenceFormat = '%a');
                                        
                                        /*
                                        echo "<br>";
                                        echo "hello";
                                        echo $differfromtodaystart;
                                        echo "<br>";
                                        */
										if ($today <= $datafromfrom)
											$controbuter = true;
										else 
											$controbuter = False;
										
                                        if (($differfromtodaystart <= 8) or ($controbuter == true))
                                        {
                                        if ($rowcount['countthis'] == 1)
                                        {

                                        ?>
                                        <form action="Regis.php" method="POST" id="Registform">
                                            <?php
                                            $resultCashType = mysqli_query($link, "SELECT  `earlyDiscount`,`cashways` FROM `levels` WHERE `Level_id` = " . $levelcode . " ");
                                            $RowCashType = mysqli_fetch_array($resultCashType);
                                            $CashType = $RowCashType['cashways'];
                                            $earlyDiscount = $RowCashType['earlyDiscount'];
                                            ?>
                                            <input type="hidden" id="levelcode" name="levelcode"
                                                   value="<?php echo $levelcode; ?>" class="login"/>
                                            <input type="hidden" id="fromtotime" name="fromtotime"
                                                   value="<?php echo $GT; ?>" class="login"/>
                                            <input type="hidden" id="groupid" name="groupid"
                                                   value="<?php echo $rowTGT['group_id']; ?>" class="login"/>
                                            <input type="hidden" id="StudentCode" name="StudentCode"
                                                   value="<?php echo isset($_POST['StudentCode']) ? $_POST['StudentCode'] : ''; ?>" class="login"/>

                                            <ul style="float: left">
                                                No. of Students Registered<br>
                                                <strong><i><?php echo NoofregisterStudents($levelcode, $GT, $rowTGT['group_startday']); ?></i></strong>
                                                <br>
                                            </ul>

                                            <ul style="float: left">
                                                <label for="CoruseStartDate">Coruse Start Date</label>
                                                <input type="text" id="CoruseStartDate" name="CoruseStartDate"
                                                       value="<?php echo $rowTGT['group_startday']; ?>"
                                                       class="login"/>
                                                <?php
                                                /*here is the closerest location to
                                                the early fees */
                                                //$GroupStartedDay = "2017-10-1";

                                                $GroupStartedDay = $rowTGT['group_startday'];
                                                $GroupStartedDay = date('Y-m-d', strtotime('-2 day', strtotime($GroupStartedDay)));
                                                $EarlyFeesDays = dateDifference($GroupStartedDay, $today, $differenceFormat = '%a');

                                                if (strtotime($today) < strtotime($GroupStartedDay)) {
                                                    /* over here its 9 for 1st , and 6 for 15th
                                                        i choiced the max , this could be fixed
                                                         by selecting if the starting date (day) is 
                                                          1 then 10 becomes 10 ^^
                                                            if 15 then 10 becomes 6 
                                                    */
                                                    /*
                                                     * check database for that level thing
                                                     * and then make it more
                                                     * than $EarlyFeesDays = 15
                                                     *
                                                     * */
                                                    if ($earlyDiscount == 1)
                                                        $EarlyFeesDays = 3151885;
                                                    if ($EarlyFeesDays < 15) {
                                                        $Fees = FeesData("EarlyBird");
                                                        if ($earlyFees = !0) {
                                                            $earlyFees = $Fees[1];
                                                            echo "<input type ='text' name ='Early' value = '$earlyFees'>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            <div class="control-group"><label class="control-label"
                                                                              for="radiobtns">Teacher</label>
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <input type="text" id="GroupTeacher" name="GroupTeacher"
                                                               value="<?php echo $rowTGT['group_teacher']; ?>"
                                                               required class="login"/>
                                                    </div>
                                                </div>
                                            </div> <!-- /control-group -->
                                            <div class="option">
                                                <?php spacingformat(10); ?> Installments<?php spacingformat(2); ?><input
                                                    type="checkbox" name="Finstallment"
                                                    id="chkBoxId2" class="showHideCheck2"/>
                                                <br/>
                                                <div class="hiddenInput3">
                                                    <?php spacingformat(10); ?><input type="text" name="txtBoxId2"
                                                                                      readonly value="<?php
                                                    $FeesExtra = FeesData("Registration");
                                                    if ($CashType == "0") {
                                                        $PersentFirst = 50;
                                                        $PersentSecond = 50;
                                                    }
                                                    if ($CashType == "1") {
                                                        $PersentFirst = 60;
                                                        $PersentSecond = 40;
                                                    }
                                                    echo (($WantedLevelFees + $WantedLevelBookFees) * $PersentFirst) / 100;
                                                    echo "+" . $FeesExtra['1']; ?>"/>
                                                    Summation:<?php spacingformat(2);
                                                    echo ((($WantedLevelFees + $WantedLevelBookFees) * $PersentFirst) / 100) + $FeesExtra['1']; ?>
                                                    Reminder:<?php spacingformat(2);
                                                    echo((($WantedLevelFees + $WantedLevelBookFees) * $PersentSecond) / 100); ?>
                                                </div>
                                                <div class="hiddenInput4">

                                                    <?php spacingformat(10); ?> Cash

                                                    <div class="hiddenInput4"><?php spacingformat(10); ?><input
                                                            type="text"
                                                            id="Regis_FeesFull"
                                                            name="Finstallment2"
                                                            readonly
                                                            value="<?php
                                                            echo ($WantedLevelFees + $WantedLevelBookFees) - $earlyFees;
                                                            ?>"
                                                            placeholder="Fees"
                                                        />
                                                        <select id="filling" name='Discount' onchange="calculateTotal()"
                                                                class="icon-pencil">
                                                            <option value="None">Select Discount</option>
                                                            <option value="DisQuid">25%</option>
                                                            <option value="DisHalf">50%</option>
                                                            <option value="DisHeavy">90%</option>
                                                        </select>
                                                        <div id="totalPrice"></div>
                                                        <input type="hidden" name="LevelFees" id="LevelFees"
                                                               value="<?php echo $WantedLevelFees ?>">
                                                        <input type="hidden" name="LevelBook" id="LevelBook"
                                                               value="<?php echo $WantedLevelBookFees; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            }
                                            else {
                                                echo "<h3>Sorry, We Dont have Registered Group This Time</h3>";
                                            }
                                            }else
                                            {
                                                echo "<h3>Sorry, We Dont Registered Group after 8 days</h3>";
                                            }
                                            }//end for the first if
                                            if (isset($_GET['RID'])) { ?>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <div class="alert alert-success">
                                                            <button type="button" class="close"
                                                                    data-dismiss="alert">&times;</button>
                                                            Registration Complet & For
                                                            <strong><?php echo $_GET['RID']; ?></strong>.
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $Regisid = $_GET['Ridals'];
                                                $Regisid = $_GET['Ridals'];
                                                // Open gatepass inside an inline modal iframe instead of a new window
                                                echo "<script>showGatepassModal('gatepass.php?Regisid=$Regisid');</script>"; }
                                            if (isset($_GET['FGT'])) { ?>
                                                <div class="alert alert-info">
                                                    <button type="button" class="close"
                                                            data-dismiss="alert">&times;</button>
                                                    <strong>Error : </strong>Please Select the Group Time.
                                                </div>
                                            <?php }
                                            if (isset($_GET['FLID'])) { ?>
                                                <div class="alert alert-info">
                                                    <button type="button" class="close"
                                                            data-dismiss="alert">&times;</button>
                                                    <strong>Error : </strong>Please Select the Level.
                                                </div> <?php }
                                            if (isset($_GET['GDF'])) { ?>
                                                <div class="alert alert-info">
                                                    <button type="button" class="close"
                                                            data-dismiss="alert">&times;</button>
                                                    <strong>Error : </strong>Please Group Day.
                                                </div> <?php }

                                            if (isset($_POST['StudentCode']))
                                                if ($CountStudent == 0) { ?>
                                                    <div class="alert alert-info">
                                                        <button type="button" class="close"
                                                                data-dismiss="alert">&times;</button>
                                                        <strong>Error : </strong>Sorry we don't have a Student with the ID  <?php echo $_POST['StudentCode'];?>.
                                                    </div><?php }

                                            if (isset($_GET['FYI'])) {
                                                ?>
                                                <div class="alert alert-info">
                                                    <button type="button" class="close"
                                                            data-dismiss="alert">&times;</button>
                                                    <strong>Error : </strong>Please enter the Birth Year.
                                                </div><?php } ?>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="reset" class="btn">Reset</button>
                                            </div> <!-- /form-actions -->
                                        </form>
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
<!-- Inline modal for loading pages within the same page -->
<div id="inlineModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:2000;">
    <div style="position:relative; width:95%; max-width:1000px; height:90%; margin:30px auto; background:#fff; border-radius:6px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.2);">
        <button onclick="closeGatepassModal()" style="position:absolute; right:8px; top:8px; z-index:2010; padding:6px 10px; border:none; background:#e74c3c; color:#fff; border-radius:4px; cursor:pointer;">Close</button>
        <iframe id="inlineModalIframe" src="about:blank" style="width:100%; height:100%; border:0;" title="Inline Content"></iframe>
    </div>
</div>
<div class="extra">
    <div class="extra-inner">
        <div class="container">
            <div class="row">
                <div class="span3">
                </div>
                <!-- /span3 -->
                <div class="span3">
                </div>
                <!-- /span3 -->
                <div class="span3">
                </div>
                <!-- /span3 -->
                <div class="span3">
                </div>
                <!-- /span3 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /extra-inner -->
</div> <!-- /extra -->
<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>

<!-- here we have the hide JS code for the inputs to display and again to be shown -->
<!-- its need to be at the footer and not in the head  -->
<!-- why... Because in the footer the components are there to be hidden  -->
<script type="text/javascript">
    $(".hiddenInput").hide();
    $(".hiddenInput2").show();
    $(".showHideCheck").on("change", function () {
        $this = $(this);
        $input = $this.parent().find(".hiddenInput");
        if ($this.is(":checked")) {
            $input.slideDown();
        } else {
            $input.slideUp();
        }
    });
    $(".showHideCheck").on("change", function () {
        $this = $(this);
        $input = $this.parent().find(".hiddenInput2");
        if ($this.is(":checked")) {
            $input.slideUp();
        } else {
            $input.slideDown();
        }
    });
    $(".hiddenInput3").hide();
    $(".hiddenInput4").show();
    $(".showHideCheck2").on("change", function () {
        $this = $(this);
        $input = $this.parent().find(".hiddenInput3");
        if ($this.is(":checked")) {
            $input.slideDown();
        } else {
            $input.slideUp();
        }
    });
    $(".showHideCheck2").on("change", function () {
        $this = $(this);
        $input = $this.parent().find(".hiddenInput4");
        if ($this.is(":checked")) {
            $input.slideUp();
        } else {
            $input.slideDown();
        }
    });
</script>
</body>
</html>