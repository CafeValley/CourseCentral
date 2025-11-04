<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
require_once "SingleDataRecover.php";
maincheck ("reportallfileupload");

if (isset($_POST['StudentCode']))
	$StudentId = $_POST['StudentCode'];
//print_r($_POST);

if (isset($_POST['delfromin']))
{
	
	$id = $_POST['id'];
	// DISABLED - Second database concor_fileholder not in use
	// mysqli_query($link2nd ,"delete from file where fileid = '$id'  ") or die("".mysql_error());
}
	
	

/*/this method from the after login file to make sure in
 which page you are right now/*/
?>
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

    ul {
        margin: 0;
    }
</style>
<div class = "main">
	<div class = "main-inner">
		<div class = "container">
			<div class = "row">
				<div class = "span12">
					<div class = "widget ">
						<div class = "widget-header">
							<i class = "icon-pinterest"></i>
							<h3>Remainder</h3></div>
						<div class = "widget-content">
							<div class = "tabbable">
								<div class = "tab-content">
									<div class = "tab-pane active" id = "jscontrols">
										
										<!--
										**********************************
										Querying to get Name
										**********************************
										-->
									
											
											<table border="0" cellpadding="2px" width="600px">
		<?php
			// DISABLED - Second database concor_fileholder not in use
			// $result=mysqli_query($link2nd ,"select * from file  ") or die("".mysql_error());
			// while($row=mysqli_fetch_array($result)){
			$result = array(); // Empty array to prevent errors
			while(false){ // Disabled loop
				$row = array(); // Prevent undefined variable errors
		?>	
<form action = "reportallfileupload.php" method = "POST">
		<?php
		echo "<input type='hidden' name='id' value = '".$row['fileid']."' />";
		
	
    	echo "<tr>";
			file_put_contents("muzic/".$row['filename'], $row['filedata']);
					$name =$row['filename'];
					echo "<td><img src=\"muzic/".$row['filename']."\" width=200px height = 200px/>
					<br>";	
					
			echo"<td><b> </b><br />";
            		 echo "<br />";
					 echo "<br />";
                    echo "Student ID:<big style='color:R'>";
                    	 echo "".$row['filetowho']."</big><br /><br />";
                   
				   $resultSNC = mysqli_query ($link , "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1))
											, SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)),
 											  SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = "
											                                   .$row['filetowho']. " ");
											$rowSNC    = mysqli_fetch_array ($resultSNC);
											$Fname     = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
											$Sirname   = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
											echo $Fname.$Sirname;
				   
					?>
					<input type = "submit" name = "delfromin" value = "del" class = "btn btn-danger">
			</td>
		</tr>
        <tr><td colspan="2"><hr size="1" /></td>
		</form>
        <?php } ?>
    </table>
										
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
<div class = "extra">
	<div class = "extra-inner">
		<div class = "container">
			<div class = "row"></div>
		</div>
	</div>
</div>
<div class = "footer">
	<div class = "footer-inner">
		<div class = "container">
			<div class = "row">
				<div class = "span12">&copy; 2015 <a href = 'http://cafavalley.comoj.com/'>Cafavalley</a></div>
			</div>
		</div>
	</div>
</div>
<?php require_once "common_scripts.php"; ?>
</body>
</html>