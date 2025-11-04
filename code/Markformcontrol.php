<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
require_once "DisplayImportant.php";
require_once "TheRule.php";
maincheck("MarkControl");
/*/this method from the after login file to make sure in
 which page you are right now/*/
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-trophy"></i>
                            <h3>Marks List</h3>
                        </div>
                        <div class="widget-content" style="padding: 25px;">
                            <div class="tabbable">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="jscontrols">
                                        <div class="container">
                                            <?php
                                            DisplayRule("MarkList");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--
                        **********************************
                        Here for the for input
                        **********************************
                        -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>