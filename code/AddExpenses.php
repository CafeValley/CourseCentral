<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("AddExpenses");
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

    textarea { height: 100px; }
    ul { margin: 0; }
</style>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <!--
                        **********************************
                        Here for the for input
                        **********************************
                        -->
                        <div class="widget-header"><i class="icon-beaker"></i>
                            <h3>Expenses</h3></div> <!-- Form Naming -->
                        <div class="widget-content" style="padding: 25px;">
                            <div class="tabbable">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="jscontrols">

                                        <form action="AddExpensesintodb.php" method="POST" class="group-form-container">
                                            <div class="form-section">
                                                <div style="margin-bottom: 12px;">
                                                    <label style="display:block; margin-bottom:6px; font-weight:600;">Name of the Expense</label>
                                                    <input type = "text" required name = "Nameexpenses" >
                                                </div>
                                                <div style="margin-bottom: 12px;">
                                                    <label style="display:block; margin-bottom:6px; font-weight:600;">Cost</label>
                                                    <input type = "text" required name = "Cost" size = "6" >
                                                </div>
                                                <button type = "submit" class="btn btn-primary">
                                                    <i class="icon-save"></i> Store Expense
                                                </button>
                                            </div>

                                            <?php if (isset($_GET['FeesError']))
                                            {
                                                $FeesError = escape_html($_GET['FeesError']);
                                                if ($FeesError == 0) { ?>
                                                    <div class="modern-alert modern-alert-success" style="margin-top: 15px;">
                                                        <i class="icon-ok"></i> <strong>Expense Saved.</strong>
                                                    </div>
                                            <?php } elseif ($FeesError == 1) { ?>
                                                <div class="modern-alert modern-alert-warning" style="margin-top: 15px;">
                                                    <i class="icon-warning-sign"></i> <strong>Error:</strong> The Amount can't be 0.
                                                </div>
                                            <?php } }?>
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
</div>
<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>