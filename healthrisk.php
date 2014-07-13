<?php
include 'db.php';
$state="NSW";
$gender="man";
$birthday="22/11/1976";
$name="Dan Hart";
$gender="man";
$age = "37";
$suburb="Mosman";
$birthday=explode("/",$birthday);
list($chosenyear,$ageatyear)=pickhistoricyear($birthday[2],1978,2002);
$stmt = $db->query('select * from health where minage <=' . $age . ' and  maxage >= '. $age) ;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))

{
print $row['risk'] . '=' . $row['factor'];

}



function pickhistoricyear($yearofbirth,$minyear,$maxyear)
{
	if ($yearofbirth >= $minyear && $yearofbirth <= $maxyear)
	{
		$chosenyear=$yearofbirth;
		$age=0;
	}
	elseif ($yearofbirth+18 >= $minyear && $yearofbirth+18 <= $maxyear)
	{
		$chosenyear=$yearofbirth+18;
		$age=18;
	}
	elseif ($yearofbirth+21 >= $minyear && $yearofbirth+21 <= $maxyear)
	{
		$chosenyear=$yearofbirth+21;
		$age=21;
	}
	elseif ($yearofbirth+40 >= $minyear && $yearofbirth+40 <= $maxyear)
	{
		$chosenyear=$yearofbirth+40;
		$age=40;
	}
	elseif ($yearofbirth+60 >= $minyear && $yearofbirth+60 <= $maxyear)
	{
		$chosenyear=$yearofbirth+60;
		$age=60;
	}
	else
	{
		$chosenyear=$minyear;
		$age=$chosenyear-$minyear;
		if ($age < 0 )
		{
			$age=-1;
		}
	}
	return array($chosenyear,$age);
}
?>
