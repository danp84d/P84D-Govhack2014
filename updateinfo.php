<?php
include 'db.php';
$fbid=$_GET['fbid'];
$name=$_POST['name'];
$dob=$_POST['dob'];
$arrival=$_POST['arrival'];
$suburb=$_POST['suburb'];
$namearray=explode(" ", $name);
if (count($namearray)>1)
{
	$lastname=$namearray[1];
}
else
{
	$lastname="";
}
$dobarray=explode("/",$dob);
$sqlbirthday=$dobarray[2] . "-" . $dobarray[0] . "'" . $dobarray[1];
$firstname=$namearray[0];
$stmt = $db->query('SELECT state,postcode FROM postcode_db where suburb="' . mysql_real_escape_string($suburb) . '" and type="Delivery Area" limit 1');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$state=$row['state'];
$postcode=$row['postcode'];
if ($state=="")
{
	$suburberror=1;
}
if (strlen($name) < 2)
{
	$nameerror=1;
}
if (strtotime($arrival) < strtotime($dob))
{
	$arrivalerror=1;
}
if ($suburberror > 0 || $nameerror > 0 || $arrivalerror > 0)
{
	header('Location: info.php?fbid=' . $fbid . '&suburberror=' . $suburberror . '&nameerror=' . $nameerror . '&arrivalerror=' . $arrivalerror);
	exit(0);
}
$age = date_diff(date_create($dob), date_create('now'))->y;
$arrivalarray=explode("/",$arrival);
$sqlarrival=$arrivalarray[2] . "-" . $arrivalarray[0] . "'" . $arrivalarray[1];
$arrivalage=date_diff(date_create($arrival), date_create('now'))->y;
$stmt = $db->query('SELECT lga FROM postcodetolga where postcode="' . $postcode . '" limit 1');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$lga=$row['lga'];

$stmt = $db->query('SELECT sum(ratio) from popprofile where agemin < ' . $arrivalage);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$popratio=$row['sum(ratio)'];
$stmt = $db->query('SELECT agemin, agemax, ratio from popprofile where agemax >= ' . $arrivalage . ' and agemin <= ' . $arrivalage);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$ratio=$row['ratio'];
$agemin=$row['agemin'];
$agemax=$row['agemax'];
$partratio=($ratio/($agemax-$agemin))*($arrivalage-$agemin);
$popratio=$popratio+$partratio;
$partratio=(($ratio/($agemax-$agemin))/12)*$arrivalarray[0];
$popratio=$popratio+$partratio;
$partratio=(($ratio/($agemax-$agemin))/365)*$arrivalarray[1];
$popratio=$popratio+$partratio;
$randomfactor=rand(1,floor((($ratio/($agemax-$agemin))/365)*22700000));
$citizennumber=floor((((100-$popratio)/100)*22700000)+$randomfactor);

$stmt = $db->query('update users set name="' . mysql_real_escape_string($name) . '", first_name="' . mysql_real_escape_string($firstname) . '", last_name="' . mysql_real_escape_string($lastname) . '", birthday="' . mysql_real_escape_string($sqlbirthday) . '", suburb="' . mysql_real_escape_string($suburb) . '", country="Australia", state="' . mysql_real_escape_string($state) . '", age="' . mysql_real_escape_string($age) . '", arrival="' . mysql_real_escape_string($sqlarrival) . '", citizennumber=' . $citizennumber . ', postcode="' . $postcode . '", lga="' . $lga . '" where fbid="' . mysql_real_escape_string($fbid) . '"');
$stmt->fetch(PDO::FETCH_ASSOC);
header('Location: preload.php?fbid=' . $fbid);
?>
