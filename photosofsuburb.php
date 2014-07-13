<link rel='stylesheet' href='photocss.css'>
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
$file = file_get_contents ("http://api.trove.nla.gov.au/result?key=j0um61l3b9fpt89r&zone=picture&q=" . $suburb);
$trove = new SimpleXMLElement($file);
print "Photos of " . $suburb . "<br>";
$linecount=0;
$maxtrove=count($trove->zone[0]->records[0])-1;
//$randomarray=array();
print "<div id='photos' style='width:760px;height:428px;'>";
for ($i = 0; $i <=$maxtrove; $i++)
{
//	if ($linecount==4)
//	{
//		$linecount=0;
//	}
//	$random=rand(0,$maxtrove);
//	while (array_search($random,$randomarray))
//	{
//		$random=rand(0,$maxtrove);
//	}
//	$randomarray[]=$random;
//	print "<img src='" . $trove->zone[0]->records[0]->work[$random]->identifier[1] . "'>";
//	$linecount++;
	print "<img src='" . $trove->zone[0]->records[0]->work[$i]->identifier[1] . "'>";
}
print "</div>";
?>
