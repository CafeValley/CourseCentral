<?php 
include ('dumper.php');
include ('config.php');

$today = date("Y-m-d");
$todayClock = date("H:i:s");
list($Tyear, $Tmonth, $Tday) = explode("-", $today);
list($Thour, $Tmin, $Tsec) = explode(":", $todayClock);

$SubName = $Tyear."_".$Tmonth."_".$Tday."_".$Thour."_".$Tmin;
  
try {
	$world_dumper = Shuttle_Dumper::create(array(
		'host' => $hostname,
		'username' => $dbusername,
		'password' => $dbpassword,
		'db_name' => $dbname,
	));

	// dump the database to gzipped file
	$world_dumper->dump('backupdb/'.$SubName.'concor.sql.gz');

	// dump the database to plain text file
	$world_dumper->dump('backupdb/'.$SubName.'concor.sql');


} catch(Shuttle_Exception $e) {
	echo "Couldn't dump database: " . $e->getMessage();
}