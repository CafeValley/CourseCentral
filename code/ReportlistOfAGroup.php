<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("ReportForAGroupData");
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
                            <i class="icon-group"></i>
                            <h3>A Group</h3>
                        </div> <!-- /widget-header -->
                        <!-- here code-->
                        <div class="widget-content">

                            <div class="tabbable">
                                <ul class="nav nav-tabs">

                                </ul>
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
                                                                <form action = "ReportlistOfAGroup.php" method = "POST">
                                                                From :
                                                                    <select id="BDay" name="BDay" class="icon-pencil">
                                                                        <?php
                                                                        if (isset($_POST['AfterDate']))
                                                                        {
                                                                            ?><option value="<?php echo htmlspecialchars($_POST['BDay']);?>" selected><?php echo htmlspecialchars($_POST['BDay']);?></option><?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?><option value="Day" selected> Day</option><?php
                                                                        }
                                                                        ?>
                                                                        <?php for ($i = 1; $i <= 31; $i++)
                                                                        {
                                                                            if (isset($_POST['AfterDate']))
                                                                            {
                                                                                if ($i != (int)$_POST['BDay'])
                                                                                {
                                                                                    echo "<option value = $i> $i</option>";
                                                                                }
                                                                            }
                                                                            else
                                                                                echo "<option value = $i> $i</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <select id="BMonth" name="BMonth" class="icon-pencil">
                                                                        <?php
                                                                            if (!isset($_POST['AfterDate']))
                                                                            {
                                                                                    echo "<option value = 0>Month</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                            }
                                                                            else
                                                                            {
                                                                                switch ((int)$_POST['BMonth'])
                                                                                {
                                                                                    case 1 :  echo "<option value = 1  selected>Jan</option>";

                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 2 :  echo "<option value = 2  selected>Feb</option>";
                                                                                        echo "<option value = 1>Jan</option>";

                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 3 :  echo "<option value = 3  selected>Mar</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";

                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 4 :  echo "<option value = 4  selected>Apr</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";

                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 5 :  echo "<option value = 5  selected>May</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";

                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 6 :  echo "<option value = 6  selected>June</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";

                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 7 :  echo "<option value = 7  selected>July</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";

                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 8 :  echo "<option value = 8  selected>Aug</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";

                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 9 :  echo "<option value = 9  selected>Sept</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";

                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 10 : echo "<option value = 10 selected>Oct</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";

                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 11 : echo "<option value = 11 selected>Nov</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";

                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                    case 12 : echo "<option value = 12 selected>Dec</option>";
                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";

                                                                                        break;
                                                                                    default:

                                                                                        echo "<option value = 1>Jan</option>";
                                                                                        echo "<option value = 2>Feb</option>";
                                                                                        echo "<option value = 3>Mar</option>";
                                                                                        echo "<option value = 4>Apr</option>";
                                                                                        echo "<option value = 5>May</option>";
                                                                                        echo "<option value = 6>June</option>";
                                                                                        echo "<option value = 7>July</option>";
                                                                                        echo "<option value = 8>Aug</option>";
                                                                                        echo "<option value = 9>Sept</option>";
                                                                                        echo "<option value = 10>Oct</option>";
                                                                                        echo "<option value = 11>Nov</option>";
                                                                                        echo "<option value = 12>Dec</option>";
                                                                                        break;
                                                                                }
                                                                            }

                                                                        ?>
                                                                    </select>
                                                                <select id="BYear" name="BYear" class="icon-pencil">
                                                                    <?php
                                                                    if (isset($_POST['AfterDate']))
                                                                    {
                                                                        ?><option value="<?php echo htmlspecialchars($_POST['BYear']);?>" selected><?php echo htmlspecialchars($_POST['BYear']);?></option><?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?><option value="Year" selected> Year</option><?php
                                                                    }
                                                                    ?>
                                                                    <?php for ($i = date("Y")+1; $i >= 1970; $i--)
                                                                    {
                                                                        if (isset($_POST['AfterDate']))
                                                                        {
                                                                            if ($i != (int)$_POST['BYear'])
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
                                                                    <select id="EDay" name="EDay" class="icon-pencil">
                                                                        <?php
                                                                        if (isset($_POST['AfterDate']))
                                                                        {
                                                                            ?><option value="<?php echo htmlspecialchars($_POST['EDay']);?>" selected><?php echo htmlspecialchars($_POST['EDay']);?></option><?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?><option value="Day" selected> Day</option><?php
                                                                        }
                                                                        ?>
                                                                        <?php for ($i = 1; $i <= 31; $i++)
                                                                        {
                                                                            if (isset($_POST['AfterDate']))
                                                                            {
                                                                                if ($i != (int)$_POST['EDay'])
                                                                                {
                                                                                    echo "<option value = $i> $i</option>";
                                                                                }
                                                                            }
                                                                            else
                                                                                echo "<option value = $i> $i</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <select id="EMonth" name="EMonth" class="icon-pencil">
                                                                        <?php
                                                                        if (!isset($_POST['AfterDate']))
                                                                        {
                                                                            echo "<option value = 0>Month</option>";
                                                                            echo "<option value = 1>Jan</option>";
                                                                            echo "<option value = 2>Feb</option>";
                                                                            echo "<option value = 3>Mar</option>";
                                                                            echo "<option value = 4>Apr</option>";
                                                                            echo "<option value = 5>May</option>";
                                                                            echo "<option value = 6>June</option>";
                                                                            echo "<option value = 7>July</option>";
                                                                            echo "<option value = 8>Aug</option>";
                                                                            echo "<option value = 9>Sept</option>";
                                                                            echo "<option value = 10>Oct</option>";
                                                                            echo "<option value = 11>Nov</option>";
                                                                            echo "<option value = 12>Dec</option>";
                                                                        }
                                                                        else
                                                                        {
                                                                            switch ((int)$_POST['EMonth'])
                                                                            {
                                                                                case 1 :  
                                                                                    echo "<option value = 1  selected>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 2 :  
                                                                                    echo "<option value = 2  selected>Feb</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 3 :  echo "<option value = 3  selected>Mar</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 4 :  echo "<option value = 4  selected>Apr</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 5 :  echo "<option value = 5  selected>May</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 6 :  echo "<option value = 6  selected>June</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 7 :  echo "<option value = 7  selected>July</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 8 :  echo "<option value = 8  selected>Aug</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 9 :  echo "<option value = 9  selected>Sept</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 10 : echo "<option value = 10 selected>Oct</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 11 : echo "<option value = 11 selected>Nov</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                                case 12 : echo "<option value = 12 selected>Dec</option>";
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    break;
                                                                                default:
                                                                                    echo "<option value = 1>Jan</option>";
                                                                                    echo "<option value = 2>Feb</option>";
                                                                                    echo "<option value = 3>Mar</option>";
                                                                                    echo "<option value = 4>Apr</option>";
                                                                                    echo "<option value = 5>May</option>";
                                                                                    echo "<option value = 6>June</option>";
                                                                                    echo "<option value = 7>July</option>";
                                                                                    echo "<option value = 8>Aug</option>";
                                                                                    echo "<option value = 9>Sept</option>";
                                                                                    echo "<option value = 10>Oct</option>";
                                                                                    echo "<option value = 11>Nov</option>";
                                                                                    echo "<option value = 12>Dec</option>";
                                                                                    break;
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                <select id="EYear" name="EYear" class="icon-pencil">
                                                                    <?php
                                                                    if (isset($_POST['AfterDate']))
                                                                    {
                                                                        ?><option value="<?php echo htmlspecialchars($_POST['EYear']);?>" selected><?php echo htmlspecialchars($_POST['EYear']);?></option><?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?><option value="Year" selected> Year</option><?php
                                                                    }
                                                                    ?>
                                                                    <?php for ($i = date("Y")+1; $i >= 1970; $i--)
                                                                    {
                                                                        if (isset($_POST['AfterDate']))
                                                                        {
                                                                            if ($i != (int)$_POST['EYear'])
                                                                            {
                                                                                echo "<option value = $i> $i</option>";
                                                                            }
                                                                        }
                                                                        else
                                                                            echo "<option value = $i> $i</option>";
                                                                    }
                                                                    ?>
                                                                <input type="submit" name="AfterDate" class="btn btn-primary"  value="Display"/>
                                                                </form>
                                                                    <div class="widget-content">
                                                                    <div class="tabbable">
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active" id="jscontrols">
                                                                                <form action="markentryform.php" method="POST">
                                                                                    <?php
                                                                                    /*
                                                                                    here to puf data in the form
                                                                                    */
                                                                                    if (isset($_POST['AfterDate']))
                                                                                    {
                                                                                    $BDay = isset($_POST['BDay']) ? (int)$_POST['BDay'] : 0;
                                                                                    $BMonth = isset($_POST['BMonth']) ? (int)$_POST['BMonth'] : 0;
                                                                                    $BYear = isset($_POST['BYear']) ? (int)$_POST['BYear'] : 0;
                                                                                    $EDay = isset($_POST['EDay']) ? (int)$_POST['EDay'] : 0;
                                                                                    $EMonth = isset($_POST['EMonth']) ? (int)$_POST['EMonth'] : 0;
                                                                                    $EYear = isset($_POST['EYear']) ? (int)$_POST['EYear'] : 0;
                                                                                    $StartingDate = $BYear."-".$BMonth."-".$BDay;
                                                                                    $EndingDate   = $EYear."-".$EMonth."-".$EDay;
                                                                                    if ($EndingDate<$StartingDate)
                                                                                    {
                                                                                        echo "The -To Date- can't be before the -From Date-";

                                                                                    }
                                                                                    ?>
                                                                                    <table class="table table-striped table-bordered">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th><center>No</center></th>
                                                                                            <th><center>Level Name</center></th>
                                                                                            <th><center>Group Time</center></th>
                                                                                            <th><center>Teacher Name</center></th>
                                                                                            <th><center>Day</center></th>
                                                                                            <th><center>Starting Date</center></th>
                                                                                            <th><center>Room</center></th>
                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php

                                                                                        $resultGRR = mysqli_query($link, "SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date` FROM `group` 
                                                                                                                          WHERE group_startday between '$StartingDate' and '$EndingDate' ");
                                                                                         $x = 0;
                                                                                        if ($resultGRR instanceof mysqli_result) while($rowGRR = mysqli_fetch_array($resultGRR))
                                                                                        {
                                                                                            $LevelId = $rowGRR['level_id'];
                                                                                            $resultLN = mysqli_query($link, "SELECT `level_name` FROM `levels` WHERE Level_id = $LevelId");
                                                                                            $rowLN = ($resultLN instanceof mysqli_result) ? mysqli_fetch_array($resultLN) : null;
                                                                                            $LevelName  = $rowLN ? $rowLN['level_name'] : '';
                                                                                            $GroupTime  = $rowGRR['group_time'];
                                                                                            $GroupTeNa  = $rowGRR['group_teacher'];

                                                                                            if ($rowGRR['group_day'] == "e")
                                                                                                $GroupDay = "Even";
                                                                                            if ($rowGRR['group_day']==  "d")
                                                                                                $GroupDay = "Odd" ;
                                                                                            if ($rowGRR['group_day']== "o")
                                                                                                $GroupDay = "Other";

                                                                                            $GroupStar  = $rowGRR['group_startday'];
                                                                                            $GroupCreaD = $rowGRR['group_C_date'];
                                                                                            $x = $x +1 ;
                                                                                            ?>
                                                                                            <tr>
                                                                                                <th><center><?php echo $x;?></center></th>
                                                                                                <th><center><?php echo htmlspecialchars($LevelName);?></center></th>
                                                                                                <th><center><?php echo htmlspecialchars($GroupTime);?></center></th>
                                                                                                <th><center><?php echo htmlspecialchars($GroupTeNa);?></center></th>
                                                                                                <th><center><?php echo htmlspecialchars($GroupDay);?></center></th>
                                                                                                <th><center><?php echo htmlspecialchars($GroupStar);?></center></th>
                                                                                                <th><center></center></th>
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