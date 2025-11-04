<?php 



$today = date("Y-m-d");
$todayClock = date("H:i:s");
list($Tyear, $Tmonth, $Tday) = explode("-", $today);
list($Thour, $Tmin, $Tsec) = explode(":", $todayClock);

$SubName = $Tyear."_".$Tmonth."_".$Tday."_".$Thour."_".$Tmin;
  
// DISABLED - Second database concor_fileholder not in use
/*
try {
	$world_dumper = Shuttle_Dumper::create(array(
		'host' => $hostname,
		'username' => $dbusername,
		'password' => $dbpassword,
		'db_name' => $dbname2nd,
	));

	// dump the database to gzipped file
	$world_dumper->dump('backupdb/'.$SubName.'concor_fileholder.sql.gz');

	// dump the database to plain text file
	$world_dumper->dump('backupdb/'.$SubName.'concor_fileholder.sql');


} catch(Shuttle_Exception $e) {
	echo "Couldn't dump database: " . $e->getMessage();
}
*/