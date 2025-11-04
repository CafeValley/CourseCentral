<?php
/*/
$hostname = 'localhost';
$dbusername = 'root';             // Your old database username.
//$dbpassword = 'WanthtcM8';
$dbpassword = 'oracle';                 // Your old database password. If your database has no password, leave it empty.
$dbname = 'concor';                 // Your old database name.


//here to set the date , with the correct format
//$today = "2017-12-14";

list($Tyear, $Tmonth, $Tday) = explode("-", $today);



echo "Test";



 $yesterday = new DateTime('yesterday');
 
$twoDaysLater = new DateTime('+ 2 days');
 
$oneWeekEarly = new DateTime('- 1 week');

$currentDateTime = new DateTime();

echo "<br>";
echo "testing ";
//echo $AfricaKhartoumTime = new DateTime('today', new DateTimeZone(''));
echo "<br>";

//$interval = $today->diff($yesterday);
//echo $interval->format('%d day ago');
 
// Output
//1 day ago
echo "hello";
echo "treeee!";
/*/
?> 


<?php

date_default_timezone_set("Africa/Khartoum");
echo "this is Today - >";
echo $today = date("Y-m-d");
echo "<br>";
$date = new DateTime($today, new DateTimeZone('Africa/Khartoum'));
echo $today = $date->format('Y-m-d') . "\n";
//echo $today = $date->format('Y-m-d H:i:sP') . "\n";




/*/

echo "The time is " . date("h:i:sa");
/*/


echo "<br>";
echo "Make it !";
$d=mktime(11, 14, 54, 8, 12, 2014);
echo "Created date is " . date("Y-m-d h:i:sa", $d);
?>

