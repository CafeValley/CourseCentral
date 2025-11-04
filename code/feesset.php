<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("Feeset");
?>
<link href="css/modern-forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
    label {
        display: block;
        line-height: 1.75em;
    }

    input[type="text"] { 
        width: 120px;
        height: 34px;
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

    ul { margin: 0; }
</style>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header"><i class="icon-table"></i>
                            <h3>Fees Setting</h3></div>
                        <div class="widget-content" style="padding: 25px;">
                            <div class="tabbable">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="jscontrols">
                                        <form action="feessetdb.php" method="POST" class="group-form-container">
                                            <div class="form-section">
                                                <h4><i class="icon-money"></i> Set Fee Value</h4>
                                                <div style="margin-bottom: 12px;">
                                                    <label style="display:block; margin-bottom:6px; font-weight:600;">Fee Type</label>
                                                    <select name='C_Fees_Name' style="max-width: 320px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                                        <option value="Student_Fees">Student Fees</option>
                                                        <option value="Registration_Fees">Registration Penalty</option>
                                                        <option value="Early_Bird_Fees">Early Bird Fees</option>
                                                        <option value="Freeze_Fees">Freeze Fees</option>
                                                        <option value="Unfreeze_Fees">Unfreeze Fees</option>
                                                    </select>
                                                </div>
                                                <div style="margin-bottom: 12px;">
                                                    <label style="display:block; margin-bottom:6px; font-weight:600;">Amount</label>
                                                    <input type="text" required name="C_Fees" size="6" style="max-width: 160px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="icon-save"></i> Store Fees
                                                </button>
                                            </div>

                                            <?php
                                            // Load current active fees
                                            $Student_Fees      = "Not Set";
                                            $Registration_Fees = "Not Set";
                                            $Early_Bird_Fees   = "Not Set";
                                            $Freeze_Fees       = "Not Set";
                                            $Unfreeze_Fees     = "Not Set";

                                            $SqlCurrent = mysqli_query($link, "SELECT `F_name`, `F_value` FROM `fees_change` WHERE F_active = 1");
                                            if ($SqlCurrent) {
                                                while ($row = mysqli_fetch_assoc($SqlCurrent)) {
                                                    if ($row['F_name'] === 'Student_Fees')        { $Student_Fees      = escape_html($row['F_value']); }
                                                    if ($row['F_name'] === 'Registration_Fees')   { $Registration_Fees = escape_html($row['F_value']); }
                                                    if ($row['F_name'] === 'Early_Bird_Fees')     { $Early_Bird_Fees   = escape_html($row['F_value']); }
                                                    if ($row['F_name'] === 'Freeze_Fees')         { $Freeze_Fees       = escape_html($row['F_value']); }
                                                    if ($row['F_name'] === 'Unfreeze_Fees')       { $Unfreeze_Fees     = escape_html($row['F_value']); }
                                                }
                                            }
                                            ?>

                                            <div class="form-section" style="margin-top:20px;">
                                                <h4><i class="icon-list"></i> Current Fees</h4>
                                                <div style="overflow-x:auto;">
                                                    <table class="table table-striped table-bordered" style="max-width: 640px;">
                                                        <thead>
                                                            <tr><th>Student Fees</th><th><?php echo $Student_Fees; ?></th></tr>
                                                            <tr><th>Registration Penalty</th><th><?php echo $Registration_Fees; ?></th></tr>
                                                            <tr><th>Early Bird Fees</th><th><?php echo $Early_Bird_Fees; ?></th></tr>
                                                            <tr><th>Freeze Fees</th><th><?php echo $Freeze_Fees; ?></th></tr>
                                                            <tr><th>Unfreeze Fees</th><th><?php echo $Unfreeze_Fees; ?></th></tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                            <?php if (isset($_GET['FeesError'])) {
                                                $FeesError = escape_html($_GET['FeesError']);
                                                $fname = isset($_GET['F_name']) ? escape_html($_GET['F_name']) : '';
                                                if ($FeesError == '0') { ?>
                                                    <div class="modern-alert modern-alert-success" style="margin-top: 15px;">
                                                        <i class="icon-ok"></i> <strong>Fees Saved</strong> for <?php echo $fname; ?>.
                                                    </div>
                                                <?php } elseif ($FeesError == '1') { ?>
                                                    <div class="modern-alert modern-alert-warning" style="margin-top: 15px;">
                                                        <i class="icon-warning-sign"></i> <strong>Error:</strong> The Amount can't be less than 0.
                                                    </div>
                                                <?php } } ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>