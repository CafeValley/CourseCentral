<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheckRegis("Teacher");
?>
<style type="text/css">
    label {
        display: block;
        line-height: 1.75em;
    }

    input,
    textarea {
        width: 120px;
        height: 34px;
        display: inline-block;
        margin-bottom: 2em;
        padding: .75em .5em;
        color: #999;
        border: 1px solid #e9e9e9;
        outline: none;
    }

    input:focus,
    textarea:focus {
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
                            <h3>Teachers</h3>
                        </div>
                        <div class="widget-content">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <?php if (isset($_POST['callingsingle'])) { ?>
                                        <li><a href="#New" data-toggle="tab">New</a></li>
                                    <?php } else { ?>
                                        <li class="active"><a href="#New" data-toggle="tab">New</a></li>

                                    <?php } ?>


                                    <li><a href="#Modify" data-toggle="tab">Modify</a></li>

                                </ul>

                                <div class="tab-content">
                                    <?php if (isset($_POST['callingsingle'])) { ?>
                                        <div class="tab-pane" id="New">
                                        <?php } else { ?>
                                            <div class="tab-pane active" id="New">
                                            <?php } ?>


                                            <form action="teacher.php" method="post">

                                                <div class="control-group"><label class="control-label" for="radiobtns">Teacher Name</label>
                                                    <div class="controls">
                                                        <div class="input-append">
                                                            <input type="text" id="name1" name="name1" value="" required placeholder="1st Name" class="login" />
                                                            <input type="text" id="name2" name="name2" value="" required placeholder="Middle Name" class="login" />
                                                            <input type="text" id="name3" name="name3" value="" required placeholder="Last Name" class="login" />
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="control-group"><label class="control-label" for="radiobtns">Teacher Age</label>
                                                    <div class="controls">
                                                        <div class="input-append">
                                                            <input type="text" id="age" name="age" value="" required placeholder="1st Name" class="login" />

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="control-group"><label class="control-label" for="radiobtns">Teacher Telphone</label>
                                                    <div class="controls">
                                                        <div class="input-append">
                                                            <input type="text" id="tel1" name="tel1" value="" required placeholder="1st Name" class="login" />
                                                            <input type="text" id="tel2" name="tel2" value="" required placeholder="Middle Name" class="login" />
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="controls">
                                                    <label class="control-label" for="radiobtns">Appointed Day</label>
                                                    <div class="input-append">

                                                        <select id="Month" name="Month" class="icon-pencil">
                                                            <option value="Month" selected> Month</option>
                                                            <?php for ($i = 01; $i <= 12; $i++) echo "<option value = $i> $i</option>"; ?>
                                                        </select>
                                                        <select id="Year" name="Year" class="icon-pencil">
                                                            <option value="Year" selected> Year</option>
                                                            <?php for ($i = date("Y") + 1; $i >= 1970; $i--) echo "<option value = $i> $i</option>"; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label" for="radiobtns">Interview Comment</label>


                                                    <textarea name='interviewcomment' style=" width: 375px;height:100%;" class="form-control" id="exampleFormControlTextarea1" cols="2" rows="3"></textarea>




                                                </div>

                                                <?php if (isset($_GET['GID'])) { ?>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <div class="alert alert-success">
                                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                                Teacher Created & It's ID is
                                                                <strong><?php echo htmlspecialchars($_GET['GID']); ?></strong>.
                                                            </div>
                                                        </div>
                                                    </div><?php } ?>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button class="btn">Cancel</button>
                                                </div>
                                                </fieldset>
                                            </form>
                                            </div>



                                            <div class="tab-pane" id="Modify">
                                                <?php


                                                $COCO = '';
                                                if (isset($_POST['E'])) {
                                                    $COCO = 'E';
                                                    //print_r($_POST);

                                                    $var1 = isset($_POST['theid']) ? (int)$_POST['theid'] : 0;
                                                    $var2 = isset($_POST['name']) ? $_POST['name'] : '';
                                                    $var3 = isset($_POST['name2']) ? $_POST['name2'] : '';
                                                    $var4 = isset($_POST['name3']) ? $_POST['name3'] : '';
                                                    $var5 = isset($_POST['age']) ? $_POST['age'] : '';
                                                    $var6 = isset($_POST['tel']) ? $_POST['tel'] : '';
                                                    $var7 = isset($_POST['tel2']) ? $_POST['tel2'] : '';
                                                    $var8 = isset($_POST['appointeddate']) ? $_POST['appointeddate'] : '';
                                                    $var9 = isset($_POST['interviewcomment']) ? $_POST['interviewcomment'] : '';
                                                    if ($var1 > 0) {
                                                        $stmtU = $link->prepare("UPDATE `teachers` SET `name`=?,`name2`=?,`name3`=?,`age`=?,`tel`=?,`tel2`=?,`appointeddate`=?,`interviewcomment`=? WHERE `id`=?");
                                                        if ($stmtU) {
                                                            $stmtU->bind_param("ssssssssi", $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var1);
                                                            $stmtU->execute();
                                                            $stmtU->close();
                                                        }
                                                    }
                                                }
                                                if (isset($_POST['D'])) {
                                                    $var1 = isset($_POST['theid']) ? (int)$_POST['theid'] : 0;
                                                    $COCO = 'D';
                                                    if ($var1 > 0) {
                                                        $stmtD = $link->prepare("DELETE FROM `teachers` WHERE `id`=?");
                                                        if ($stmtD) {
                                                            $stmtD->bind_param("i", $var1);
                                                            $stmtD->execute();
                                                            $stmtD->close();
                                                        }
                                                    }
                                                }
                                                $Sql_Select = mysqli_query($link, "SELECT count(*) FROM `teachers` ") or die(mysqli_error());
                                                $Sql_Select_Count = mysqli_fetch_array($Sql_Select);
                                                if ($Sql_Select_Count[0] > 0) {
                                                    $Result_Between = mysqli_query($link, "SELECT `id`, `name`, `name2`, `name3`, `age`, `tel`, `tel2`, `appointeddate`, `interviewcomment`, `whenwasit`, `whodidthis` FROM `teachers`  ");
                                                ?>
                                                    <table class="table table-striped table-sm">
                                                        <tr>
                                                            <td> Name</td>
                                                            <td> Age</td>
                                                            <td>Telphone</td>
                                                            <td>Appointed Day</td>
                                                            <td>Interview Comment</td>

                                                        </tr>
                                                        <?php
                                                        $N_Labels = 0;
                                                        if ($Result_Between instanceof mysqli_result) while ($Row_Set = mysqli_fetch_array($Result_Between)) { { ?>
                                                                <form id="Form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit='return confirm("Are you sure?")'>
                                                                    <input id="theid" name="theid" value='<?php echo htmlspecialchars($Row_Set['id']) ?>' type="hidden">

                                                                    <tr>
                                                                        <td>
                                                                            <input id="name" autofocus="" name="name" type="text" value='<?php echo htmlspecialchars($Row_Set['name']) ?>'>
                                                                            <input id="name2" autofocus="" name="name2" type="text" value='<?php echo htmlspecialchars($Row_Set['name2']) ?>'>
                                                                            <input id="name3" autofocus="" name="name3" type="text" value='<?php echo htmlspecialchars($Row_Set['name3']) ?>'>
                                                                        </td>
                                                                        <td>
                                                                            <input id="age" autofocus="" name="age" type="text" value='<?php echo htmlspecialchars($Row_Set['age']) ?>'>
                                                                        </td>

                                                                        <td>
                                                                            <input id="tel" autofocus="" name="tel" type="text" value='<?php echo htmlspecialchars($Row_Set['tel']) ?>'>
                                                                            <input id="tel2" autofocus="" name="tel2" type="text" value='<?php echo htmlspecialchars($Row_Set['tel2']) ?>'>
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" id="appointeddate" autofocus="" name="appointeddate" value='<?php echo htmlspecialchars($Row_Set['appointeddate']) ?>'>
                                                                        </td>

                                                                        <td>
                                                                            <textarea name='interviewcomment' style=" width: 375px;height:100%;" class="form-control" id="exampleFormControlTextarea1" cols="2" rows="3"> <?php echo htmlspecialchars($Row_Set['interviewcomment']) ?></textarea>


                                                                        </td>



                                                                        <td>
                                                                            <button type="submit" name="E" class="btn btn-success">Edit</button>&nbsp;&nbsp;
                                                                            <button type="submit" name="D" class="btn btn-danger">Delete</button>
                                                                        </td>


                                                                    </tr>
                                                                </form><?php $N_Labels += 1;
                                                                    }
                                                                }
                                                            } else { ?>
                                                        <div class="alert">
                                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                            <strong>No!</strong>Teachers to retrieve , Or you deleted all of them.
                                                        </div><?php
                                                            }
                                                                ?>
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


<?php require_once "common_scripts.php"; ?>
    <script>
        (function() {
            if (typeof jQuery === 'undefined') return;
            jQuery(function($){
                $('.nav-tabs a').on('click', function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                    if (this.hash) { window.location.hash = this.hash; }
                });
                var hash = window.location.hash;
                if (hash) {
                    var $target = $('.nav-tabs a[href="' + hash + '"]');
                    if ($target.length) { $target.tab('show'); }
                }
            });
        })();
    </script>
</body>
</html>