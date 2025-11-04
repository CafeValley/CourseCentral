<?php
/**
 * Common Footer Component
 * Include this file at the end of pages for consistent footer
 */
?>
<style>
/* Ensure the main content fills the viewport so the footer sits at the bottom */
.main { min-height: calc(100vh - 140px); }
</style>
<div class="footer">
    <div class="footer-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <p style="text-align: center; color: #999; margin: 10px 0;">
                        &copy; <?php echo date('Y'); ?> <?php echo $SYSTEM_NAME; ?> | 
                        Powered by <a href='http://cafavalley.comoj.com/' target='_blank'>Cafavalley</a>
                    </p>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /footer-inner -->
</div>
<!-- /footer -->

