<?php require_once "config.php";
echo "<br>";
print_r ($_POST);
echo "<br>";
$idkeys = array();
$sqlregisid = mysqli_query ($link , "SELECT `regis_id`  FROM `registration` ");
if (!$sqlregisid) {
	error_log("Query failed: " . $link->error);
	die("An error occurred. Please try again later.");
}
while ($row = mysqli_fetch_array ($sqlregisid)) {
	$idskeys[ $row['regis_id'] ] = 0;
}
$sqlregisidmax = mysqli_query ($link , "SELECT max(regis_id)+1  FROM `registration` ");
if (!$sqlregisidmax) {
	error_log("Query failed: " . $link->error);
	die("An error occurred. Please try again later.");
}
$countregisidmax = mysqli_fetch_array ($sqlregisidmax);
if ($countregisidmax[0] > 0) {
	$regisIDmax = $countregisidmax[0];
}
else {
	$regisIDmax = 1;
}
$sqlregisidcount = mysqli_query ($link , "SELECT count(regis_id)+1  FROM `registration` ");
if (!$sqlregisidcount) {
	error_log("Query failed: " . $link->error);
	die("An error occurred. Please try again later.");
}
$countregisidcount = mysqli_fetch_array ($sqlregisidcount);
if ($countregisidcount[0] > 0) {
	$regisIDcount = $countregisidcount[0];
}
else {
	$regisIDcount = 1;
}
if ($regisIDcount == $regisIDmax) {
	$sqlregisid = mysqli_query ($link , "SELECT max(regis_id)+1  FROM `registration` ");
	if (!$sqlregisid) {
		error_log("Query failed: " . $link->error);
		die("An error occurred. Please try again later.");
	}
	$countregisid = mysqli_fetch_array ($sqlregisid);
	if ($countregisid[0] > 0) {
		$regisID = $countregisid[0];
	}
	else {
		$regisID = 1;
	}
	//here we add the +1 to max
}
else {
	//here was using some of the old values
	$missing = array();
	$keys    = array_keys ($idskeys);
	for ($i = 1; $i <= max ($keys); $i++) {
		if (!array_key_exists ($i , $idskeys)) {
			$missing[] = $i;
		}
	}
	$regisID = $missing[0];
}

// Validate and sanitize input
$discountset = safe_get('Discount', '', 'string');
$setlevelid   = safe_get('levelcode', 0, 'int');
$setgroupid   = safe_get('groupid', 0, 'int');
$setstudentid = safe_get('StudentCode', 0, 'int');

	/* $_POST['Early'] here is the early fees
	if there are any.
	there active a sql to add date into a table
	to be subtracted , later from the registration
	cash income , day or time ~
	*/
if (isset($_POST['Early']) && !empty($_POST['Early']))
{
	$EarlyFees = safe_get('Early', 0, 'float');
	// Use prepared statement to prevent SQL injection
	$stmt = $link->prepare("INSERT INTO `extra_fees_holder`(`EFH_id`, `Regis_id`, `type`, `Amount`, `WhenEFH`) VALUES (null, ?, 'Early', ?, NOW())");
	if ($stmt) {
		$stmt->bind_param("id", $regisID, $EarlyFees);
		$stmt->execute();
		$stmt->close();
	} else {
		error_log("Prepare failed for Early fees: " . $link->error);
	}
}


if (isset($_POST['Finstallment']) && $_POST['Finstallment'] == "on")
{
	$txtBoxId2 = safe_get('txtBoxId2', '', 'string');
	$parts = explode("+", $txtBoxId2);
	$HofThePay = isset($parts[0]) ? (float)$parts[0] : 0;
	$PofThePay = isset($parts[1]) ? (float)$parts[1] : 0;
	echo $HofThePay;
	echo "Why so Sec";
	echo $PofThePay;

	/*
	 * here its to add the extra fees when the students comes late or
	wanted installments , will be stored in another table
	*/
	// Use prepared statement for penalty fees
	$stmt = $link->prepare("INSERT INTO `extra_fees_holder`(`EFH_id`, `Regis_id`, `type`, `Amount`, `WhenEFH`) VALUES (null, ?, 'Penalty', ?, NOW())");
	if ($stmt) {
		$stmt->bind_param("id", $regisID, $PofThePay);
		$stmt->execute();
		$stmt->close();
	} else {
		error_log("Prepare failed for Penalty fees: " . $link->error);
	}
	$paidfees = $HofThePay;
}
else {
	$paidfees = safe_get('Finstallment2', 0, 'float');
}

// Use prepared statement for main registration insert
$stmt = $link->prepare("INSERT INTO `registration`(`regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date`) VALUES (?, ?, ?, ?, ?, 1, ?, NOW())");
if (!$stmt) {
	error_log("Prepare failed for registration: " . $link->error);
	die("An error occurred processing your registration. Please try again.");
}
$stmt->bind_param("iiidsi", $regisID, $setlevelid, $setgroupid, $paidfees, $discountset, $setstudentid);
if (!$stmt->execute()) {
	error_log("Execute failed for registration: " . $stmt->error);
	$stmt->close();
	die("An error occurred processing your registration. Please try again.");
}
$stmt->close();
print_r(CalRem($setstudentid,$setgroupid));
header ('Location:RegisFrom.php?RID=' . $setstudentid . '&Ridals=' . $regisID . '');
?>