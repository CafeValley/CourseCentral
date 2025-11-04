<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("Level");
?>
<link href="css/modern-forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
    .level-form-container {
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
    
    .levels-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    .levels-table th {
        background: #f5f5f5;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid #ddd;
    }
    
    .levels-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    
    .levels-table tbody tr:hover {
        background: #f9f9f9;
    }
    
    .levels-table input[type="text"],
    .levels-table select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>

<div class="main">

    <div class="main-inner">

        <div class="container">

            <div class="row">
                <div class="span12">
                    
                    <!-- Page Header -->
                    <div style="margin-bottom: 30px; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <h1 style="margin: 0 0 10px 0; color: #0b9bba; font-size: 28px;">
                            <i class="icon-book" style="margin-right: 10px;"></i>
                            Course Levels Management
                        </h1>
                        <p style="margin: 0; color: #666; font-size: 14px;">
                            Create new course levels or modify existing ones
                        </p>
                    </div>

                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-bolt"></i>
                            <h3>Levels</h3>
                        </div> <!-- /widget-header -->

                        <div class="widget-content" style="padding: 25px;">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" style="margin-bottom: 20px;">
                                    <li class="active">
                                        <a href="#New" data-toggle="tab">
                                            <i class="icon-plus"></i> New Level
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#Modify" data-toggle="tab">
                                            <i class="icon-edit"></i> Modify Levels
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="New">
                                        <form action="level.php" method="post" class="level-form-container">
                                            <div class="form-section">
                                                <h4><i class="icon-book"></i> Level Information</h4>
                                                <div style="margin-bottom: 20px;">
                                                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Level Name</label>
                                                    <input type="text" id="levelname" name="levelname" value=""
                                                           required placeholder="Enter level name" 
                                                           style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"/>
                                                </div>
                                                
                                                <div style="margin-bottom: 20px;">
                                                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Level Period</label>
                                                    <select id="LevelPeriod" name="LevelPeriod" style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                                        <option selected value='nothing'>-- Select Period --</option>
                                                        <option value='2 Week'>2 Weeks</option>
                                                        <option value='1 Month'>1 Month</option>
                                                        <option value='6 Week'>6 Weeks</option>
                                                        <option value='2 Month'>2 Months</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-section">
                                                <h4><i class="icon-money"></i> Pricing Information</h4>
                                                <div style="margin-bottom: 20px;">
                                                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Tuition Fees</label>
                                                    <input type="number" id="LevelFees" name="LevelFees" value=""
                                                           required placeholder="Enter tuition fees" step="0.01"
                                                           style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"/>
                                                </div>
                                                
                                                <div style="margin-bottom: 20px;">
                                                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Books Fee</label>
                                                    <input type="number" id="LevelBook" name="LevelBook" value=""
                                                           required placeholder="Enter books fee" step="0.01"
                                                           style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"/>
                                                </div>
                                            </div>

                                            <div class="form-section">
                                                <h4><i class="icon-cog"></i> Payment Options</h4>
                                                <div style="margin-bottom: 15px;">
                                                    <label style="display: flex; align-items: center; cursor: pointer;">
                                                        <input type="checkbox" id="cashways" name="cashways" value="checked" 
                                                               style="margin-right: 10px; width: auto;"/>
                                                        <span>Big First Installment (60% first, 40% second)</span>
                                                    </label>
                                                    <small style="color: #999; margin-left: 28px;">If unchecked, payments will be split 50/50</small>
                                                </div>
                                                
                                                <div style="margin-bottom: 15px;">
                                                    <label style="display: flex; align-items: center; cursor: pointer;">
                                                        <input type="checkbox" id="earlyDiscount" name="earlyDiscount" value="checked" 
                                                               style="margin-right: 10px; width: auto;"/>
                                                        <span>Disable Early Bird Fees</span>
                                                    </label>
                                                    <small style="color: #999; margin-left: 28px;">Check this if early registration discounts should not apply</small>
                                                </div>
                                            </div>

                                            <?php
                                            if (isset($_GET['LID'])) {
                                                echo '<div class="modern-alert modern-alert-success" style="margin-top: 20px;">
                                                        <i class="icon-ok"></i> <strong>Success!</strong> 
                                                        Level added successfully! Level ID: <strong>' . escape_html($_GET['LID']) . '</strong>
                                                      </div>';
                                            }
                                            ?>

                                            <div class="form-actions" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                                                <button type="submit" class="btn btn-primary btn-large">
                                                    <i class="icon-save"></i> Save Level
                                                </button>
                                                <button type="reset" class="btn">
                                                    <i class="icon-refresh"></i> Reset
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="Modify">
                                        <div class="level-form-container">
                                            <?php
                                            // Handle form submissions with security fixes
                                            $level_id = "";
                                            $level_name = "";
                                            $level_period = "";
                                            $level_fees = "";
                                            $level_book = "";
                                            $level_C_date = "";
                                            $Level_cashways = 0;
                                            $earlyDiscount = 0;
                                            
                                            if (isset($_POST['Level_id'])) {
                                                $level_id = safe_get('Level_id', 0, 'int');
                                                $level_name = safe_get('level_name', '', 'string');
                                                $level_period = safe_get('level_period', '', 'string');
                                                $level_fees = safe_get('level_fees', 0, 'float');
                                                $level_book = safe_get('level_book', 0, 'float');
                                                $level_C_date = safe_get('level_C_date', '', 'string');
                                                $Level_cashways = isset($_POST['cashways']) ? 1 : 0;
                                                $earlyDiscount = isset($_POST['earlyDiscount']) ? 1 : 0;
                                            }
                                            
                                            // Handle Edit
                                            if (isset($_POST['E']) && $level_id > 0) {
                                                $stmt = $link->prepare("UPDATE `levels` SET `earlyDiscount` = ?, `cashways` = ?, `level_name` = ?, `level_period` = ?, `level_fees` = ?, `level_book` = ?, `level_C_date` = ? WHERE `Level_id` = ?");
                                                if ($stmt) {
                                                    $stmt->bind_param("iissddsi", $earlyDiscount, $Level_cashways, $level_name, $level_period, $level_fees, $level_book, $level_C_date, $level_id);
                                                    $stmt->execute();
                                                    $stmt->close();
                                                    echo '<div class="modern-alert modern-alert-success" style="margin-bottom: 20px;">
                                                            <i class="icon-ok"></i> <strong>Success!</strong> Level updated successfully.
                                                          </div>';
                                                }
                                            }

                                            // Handle Delete
                                            if (isset($_POST['D']) && $level_id > 0) {
                                                $stmt = $link->prepare("DELETE FROM `levels` WHERE `Level_id` = ?");
                                                if ($stmt) {
                                                    $stmt->bind_param("i", $level_id);
                                                    $stmt->execute();
                                                    $stmt->close();
                                                    echo '<div class="modern-alert modern-alert-success" style="margin-bottom: 20px;">
                                                            <i class="icon-ok"></i> <strong>Success!</strong> Level deleted successfully.
                                                          </div>';
                                                }
                                            }

                                            // Get levels count
                                            $Sql_Select = mysqli_query($link, "SELECT COUNT(*) as count FROM `levels`");
                                            $Sql_Select_Count = mysqli_fetch_assoc($Sql_Select);

                                            if ($Sql_Select_Count && $Sql_Select_Count['count'] > 0) {
                                                $Result_Between = mysqli_query($link, "SELECT `Level_id`, `level_name`, `level_period`, `level_fees`, `level_book`, `cashways`, `earlyDiscount`, `level_C_date` FROM `levels` ORDER BY `level_name` ASC");
                                                
                                                if ($Result_Between && mysqli_num_rows($Result_Between) > 0) {
                                                    // Get unique periods for dropdown
                                                    $Result_Level_Per = mysqli_query($link, "SELECT DISTINCT `level_period` FROM `levels` ORDER BY `level_period`");
                                                    $periods = array();
                                                    while ($Row_Per_Level = mysqli_fetch_assoc($Result_Level_Per)) {
                                                        $periods[] = $Row_Per_Level['level_period'];
                                                    }
                                                    ?>
                                                    <div style="overflow-x: auto;">
                                                        <table class="levels-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Level Name</th>
                                                                    <th>Period</th>
                                                                    <th>Tuition Fees</th>
                                                                    <th>Books Fee</th>
                                                                    <th>Payment Options</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                while ($Row_Set = mysqli_fetch_assoc($Result_Between)) {
                                                                    ?>
                                                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" onsubmit='return confirm("Are you sure you want to perform this action?")'>
                                                                        <tr>
                                                                            <input type="hidden" name="Level_id" value="<?php echo escape_html($Row_Set['Level_id']); ?>">
                                                                            <input type="hidden" name="level_C_date" value="<?php echo escape_html($Row_Set['level_C_date']); ?>">
                                                                            
                                                                            <td>
                                                                                <input type="text" name="level_name" value="<?php echo escape_html($Row_Set['level_name']); ?>" 
                                                                                       style="min-width: 150px;" required>
                                                                            </td>
                                                                            <td>
                                                                                <select name="level_period" style="min-width: 120px;">
                                                                                    <?php foreach ($periods as $period) { ?>
                                                                                        <option value="<?php echo escape_html($period); ?>" 
                                                                                                <?php echo ($period == $Row_Set['level_period']) ? 'selected' : ''; ?>>
                                                                                            <?php echo escape_html($period); ?>
                                                                                        </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="level_fees" value="<?php echo escape_html($Row_Set['level_fees']); ?>" 
                                                                                       step="0.01" style="min-width: 100px;" required>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="level_book" value="<?php echo escape_html($Row_Set['level_book']); ?>" 
                                                                                       step="0.01" style="min-width: 100px;" required>
                                                                            </td>
                                                                            <td style="font-size: 12px;">
                                                                                <div style="margin-bottom: 5px;">
                                                                                    <input type="checkbox" name="cashways" value="1" 
                                                                                           <?php echo ($Row_Set['cashways'] == "1") ? 'checked' : ''; ?>>
                                                                                    <label style="display: inline; font-weight: normal;">Big Installment</label>
                                                                                </div>
                                                                                <div>
                                                                                    <input type="checkbox" name="earlyDiscount" value="1" 
                                                                                           <?php echo ($Row_Set['earlyDiscount'] == "1") ? 'checked' : ''; ?>>
                                                                                    <label style="display: inline; font-weight: normal;">No Early Fees</label>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="submit" name="E" class="btn btn-success btn-small" style="margin-right: 5px;">
                                                                                    <i class="icon-edit"></i> Edit
                                                                                </button>
                                                                                <button type="submit" name="D" class="btn btn-danger btn-small">
                                                                                    <i class="icon-remove"></i> Delete
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </form>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php
                                                } else {
                                                    echo '<div style="padding: 40px; text-align: center; color: #999;">
                                                            <i class="icon-info-sign" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                                            <p style="font-size: 16px;">No levels found.</p>
                                                          </div>';
                                                }
                                            } else {
                                                echo '<div style="padding: 40px; text-align: center; color: #999;">
                                                        <i class="icon-info-sign" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                                        <p style="font-size: 16px;">No levels found. Create a new level first.</p>
                                                      </div>';
                                            }
                                            ?>
                                        </div>
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
<div class="extra">

    <div class="extra-inner">

        <div class="container">

            <div class="row">

          
            </div> <!-- /row -->

        </div> <!-- /container -->

    </div> <!-- /extra-inner -->

</div> <!-- /extra -->


<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>


</body>

</html>
