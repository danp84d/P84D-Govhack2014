<html>
<head>
<title>
</title>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<style>
      body {
        font-family: 'Lato', sans-serif;
        font-size: 48px;
        color: #faf7ee;
      }
    </style>
<script type="text/javascript" src="jquery-latest.js"></script>
<script type="text/javascript" src="jQueryRotate.js"></script>
<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
<?php
include 'db.php';
$fbid=$_GET['fbid'];
$stmt = $db->query('SELECT * FROM users where fbid="' . mysql_real_escape_string($fbid) . '" limit 1');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$name=$row['name'];
$age=$row['age'];
$sex=$row['gender'];
$birthday=$row['birthday'];
$birthdayarray=explode("-",$birthday);
$namearray=explode(" ",$name);
$citizennumber=$row['citizennumber'];
$lga=$row['lga'];
$suburb=$row['suburb'];
list($mentalyear,$mentalage)=pickhistoricyear($birthdayarray[0],1993,2011);
$stmt = $db->query('SELECT mentalhealthcases from mentalhealth where year=' . $mentalyear);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$mentalhealthcases=$row['mentalhealthcases'];
$stmt = $db->query('SELECT * FROM babyname where year="' . $birthdayarray[0] . '" and gender="' . $sex . '" order by ranks asc limit 1');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$babyname=$row['name'];
$stmt = $db->query('select *  from babyname WHERE name like "' . $namearray[0] . '%" and gender="' . $sex . '" order by ranks asc limit 1');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$babyyear=$row['year'];
list($incomeyear,$incomeage)=pickhistoricyear($birthdayarray[0],1978,2002);
$stmt = $db->query('select * from income where year=' . $incomeyear);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$income=$row['averageincome'];
$stmt = $db->query('select factor, risk, description, image from health where minage<=' . $age . ' and maxage>=' . $age . ' and gender="' . $sex . '" order by factor desc');
$risk=array();
$factor=array();
$description=array();
$image=array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	$risk[]=$row['risk'];
	$factor[]=$row['factor'];
	$description[]=$row['description'];
	$image[]=$row['image'];
}
$color=rand(1,5);
$stmt = $db->query('SELECT incomemin, incomemax from incomebylga where agemin <= ' . $age . ' and agemax >= ' . $age . ' and lga="' . $lga . '" and sex="' . $sex . '" order by value desc limit 1');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$incomemin=$row['incomemin'];
$incomemax=$row['incomemax'];

	print '<img src="https://graph.facebook.com/' . $fbid . '/picture?type=large" style="min-height:200px;min-width:200px;position:absolute;left:281px;top:119px;opacity:0" id="photo">';
        print '<div id="background" style="background-image: url(background.png);background-size: 100% 100%;width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;">';
        print '<div id="earth" style="width:1px; height:1px; left:380px; top:214px;position:absolute;opacity:0;">';
        print '<img src="earth.png" style="max-width:100%; max-height:100%;">';
        print '</div>';

	print '<div id="ring1" style="position:absolute;width:1px;left:380px;top:214px;opacity:0;"><img src="ring1.png" style="max-width:100%; max-height:100%;"></div>';
        print '<div id="ring2" style="position:absolute;width:1px;left:380px;top:214px;opacity:0;"><img src="ring2.png" style="max-width:100%; max-height:100%;"></div>';
        print '<div id="ring3" style="position:absolute;width:1px;left:380px;top:214px;opacity:0;"><img src="ring3.png" style="max-width:100%; max-height:100%;"></div>';
        print '<div id="ring4" style="position:absolute;width:1px;left:380px;top:214px;opacity:0;"><img src="ring4.png" style="max-width:100%; max-height:100%;"></div>';
        print '<div id="ring5" style="position:absolute;width:1px;left:380px;top:214px;opacity:0;"><img src="ring5.png" style="max-width:100%; max-height:100%;"></div>';
	print '<div id="welcome" style="position:absolute;width:720px;height:50px;left:20px;top:164px;opacity:0;text-align:center;">Welcome</div>';
        print '<div id="thisisyou" style="position:absolute;width:720px;height:50px;left:20px;top:164px;opacity:0;text-align:center;">This is you</div>';
        print '<div id="thisisyourworld" style="position:absolute;width:720px;height:50px;left:20px;top:164px;opacity:0;text-align:center;">This is your world</div>';
	print '<div id="thisisyouraustralia" style="position:absolute;width:720px;height:50px;left:20px;top:164px;opacity:0;text-align:center;">This is your Australia</div>';
	print '<div id="name" style="position:absolute;width:710px;height:70px;left:20px;top:20px;opacity:0;text-align:center;">' . $name . '</div>';
	print '<div id="citizennumber" style="position:absolute;width:710px;height:70px;left:20px;top:350px;opacity:0;text-align:center;">#' . number_format($citizennumber) . '</div>';
        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;font-size:36px;background-image: url(background.png);background-size: 100% 100%;opacity:0;" id="scene3">';
	print '<div style="position:absolute;left:50px;top:70px;"><img src=' . $sex . '.png height=270></div><div style="position:absolute;left:200px;top:100px;width:500px;height:328px;">Based on your date of arrival you are Australian resident number:<br>' . number_format($citizennumber) . '</div>';
	print '</div>';

        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;font-size:36px;background-image: url(background.png);background-size: 100% 100%;opacity:0;" id="scene6">';
	print '<div style="position:absolute;left:20px;top:20px;"><canvas id="mentalhealth" width="400" height="400"></canvas></div>';
	print '<div style="position:absolute; left:440px;top:90px;width:300px;">When you were ' . $mentalage . ', in ' . $mentalyear . ', there were ' . number_format($mentalhealthcases) . ' instances of mental health issues.</div>';
        print '</div>';
	print '<div id="mentalhealthicon" style="position:absolute;left:0px;top:10px;width:205px;opacity:0;text-align:center;min-width:205px;"><img src="mentalhealth' . $color . '.png" width=100px><br>' . number_format($mentalhealthcases) . '</div>';
	$color=$color+1;
	if ($color > 5)
	{
		$color=1;
	}
        print '<div id="babynameicon" style="position:absolute;left:550px;top:10px;width:205px;opacity:0;text-align:center;min-width:205px;"><img src="babyname' . $color . '.png" height=100px><br>' . $babyyear . '</div>';
        $color=$color+1;
        if ($color > 5)
        {
                $color=1;
        }
        print '<div id="overweighticon" style="position:absolute;left:0px;top:272px;width:205px;opacity:0;text-align:center;min-width:205px;"><img src="' . $image[0] . $color . '.png" height=100px><br>' . $factor[0] . '%</div>';
        $color=$color+1;
        if ($color > 5)
        {
                $color=1;
        }
        print '<div id="incomeicon" style="position:absolute;left:550px;top:272px;width:205px;opacity:0;text-align:center;min-width:205px;"><img src="income' . $color . '.png" height=100px><br>$' . number_format($income) . '</div>';
        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;font-size:36px;background-image: url(background.png);background-size: 100% 100%;opacity:0;" id="scene8">';
        print '<div style="position:absolute;left:50px;top:70px;"><img src=' . $sex . '.png height=270></div><div style="position:absolute;left:200px;top:90px;width:500px;height:328px;">The most popular baby name in the year you were born was ' . $babyname . '.<br><br>Your name was most popular in ' . $babyyear . '.</div>';
        print '</div>';

        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;font-size:36px;background-image: url(background.png);background-size: 100% 100%;opacity:0;" id="scene12">';
        print '<div style="position:absolute;left:50px;top:70px;"><img src=' . $sex . '.png height=270></div><div style="position:absolute;left:200px;top:50px;width:500px;height:328px;">In ' . $incomeyear . ' you were ' . $incomeage . ' years old and the average annual income was $' . number_format($income) . '.<br><br>Today the average income for a ' . $sex . ' your age in ' . $suburb . ' is ';
	if ($incomemin==0)
	{
		print "$0.";
	}
	else if ($incomemax==520000)
	{
		print "over $" . number_format($incomemin) . ".";
	}
	else
	{
		print "between $" . number_format($incomemin) . " and $" . number_format($incomemax) . ".";
	}
	print '</div>';
        print '</div>';
        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;font-size:36px;background-image: url(background.png);background-size: 100% 100%;opacity:0;" id="scene15">';
	print '<div style="position:absolute;left:20px;top:20px;"><canvas id="healthrisks" width="400" height="400"></canvas></div>';
        print '<div style="position:absolute; left:440px;top:50px;width:300px;">Based on your age, you have a ' . $factor[0] . '% chance of ' . $description[0] . ', but only a ' . $factor[8] . '% chance of ' . $description[8] . '.</div>';
        print '</div>';

print "</div>";

print "</div>";




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
<script>
var ring1timerid = 0;
var ring2timerid = 0;
var ring3timerid = 0;
var ring4timerid = 0;
var ring5timerid = 0;
var angle1 = 0;
var angle2 = 0;
var angle3 = 0;
var angle4 = 0;
var angle5 = 0;
var angle = 0;
var spindest = 0;
var nextscene = 0;
var mp3snd = "music.mp3";
var oggsnd = "music.ogg";
document.write('<audio autoplay="autoplay">');
document.write('<source src="'+mp3snd+'" type="audio/mpeg">');
document.write('<source src="'+oggsnd+'" type="audio/ogg">');
document.write('<!--[if lt IE 9]>');
document.write('<bgsound src="'+mp3snd+'" loop="1">');
document.write('<![endif]-->');
document.write('</audio>');
$(document).ready(function(){
$("#earth").animate({left:'284px',top:'118px',width:'192px',height:'192px',opacity:'1'},'slow');
setTimeout(function(){gotoscene(2)},1000);
setTimeout(function(){gotoscene(3)},2000);
setTimeout(function(){gotoscene(4)},3000);
setTimeout(function(){gotoscene(5)},4000);
setTimeout(function(){gotoscene(6)},5000);
setTimeout(function(){gotoscene(7)},6000);
setTimeout(function(){gotoscene(8)},8000);
setTimeout(function(){gotoscene(9)},10000);
setTimeout(function(){gotoscene(10)},12000);
setTimeout(function(){gotoscene(11)},14000);
setTimeout(function(){gotoscene(12)},18000);
setTimeout(function(){gotoscene(44)},20000);
setTimeout(function(){gotoscene(13)},28000);
setTimeout(function(){gotoscene(14)},29000);
setTimeout(function(){gotoscene(15)},31000);
setTimeout(function(){gotoscene(16)},33000);
setTimeout(function(){gotoscene(17)},37000);
setTimeout(function(){gotoscene(18)},47000);
setTimeout(function(){gotoscene(19)},48000);
setTimeout(function(){gotoscene(20)},50000);
setTimeout(function(){gotoscene(21)},53000);
setTimeout(function(){gotoscene(22)},58000);
setTimeout(function(){gotoscene(23)},68000);
setTimeout(function(){gotoscene(24)},69000);
setTimeout(function(){gotoscene(25)},71000);
setTimeout(function(){gotoscene(26)},74000);
setTimeout(function(){gotoscene(27)},79000);
setTimeout(function(){gotoscene(28)},89000);
setTimeout(function(){gotoscene(29)},90000);
setTimeout(function(){gotoscene(30)},92000);
setTimeout(function(){gotoscene(31)},95000);
setTimeout(function(){gotoscene(32)},100000);
setTimeout(function(){gotoscene(33)},110000);
setTimeout(function(){gotoscene(34)},111000);
setTimeout(function(){gotoscene(35)},113000);
setTimeout(function(){gotoscene(36)},116000);
setTimeout(function(){gotoscene(37)},119000);
setTimeout(function(){gotoscene(38)},121000);
setTimeout(function(){gotoscene(39)},122000);
setTimeout(function(){gotoscene(40)},124000);
setTimeout(function(){gotoscene(41)},125000);
setTimeout(function(){gotoscene(42)},127000);
setTimeout(function(){gotoscene(43)},128000);
});
var ctx = $("#mentalhealth").get(0).getContext("2d");
var mentalhealthdata = {
	labels: ["1993","1994","1995","1996","1997","1998","1999","2000","2001","2002","2003","2004","2005","2006","2007","2008","2009","2010","2011"],
	datasets: [
		{
			label: "Mental health cases",
			fillColor: "rgba(98,200,189,1)",
            		strokeColor: "rgba(98,200,189,1)",
            		highlightFill: "rgba(219,40,62,1)",
            		highlightStroke: "rgba(219,40,62,1)",
            		data: [134763,137649,191183,204431,234956,239088,244717,254794,264472,278829,287059,291984,297362,304977,307060,324064,341581,329028,345107]
        	}
	]
};
var mentalhealthchart = new Chart(ctx).Bar(mentalhealthdata);


var ctx2 = $("#healthrisks").get(0).getContext("2d");
var healthriskdata = [
	{
		value:<?php print $factor[0]; ?>,
		color:"#db283e",
		highlight:"#FFA7BD",
		label:"<?php print $risk[0]; ?>"
	},
        {
                value:<?php print $factor[1]; ?>,
                color:"#62c8bd",
                highlight:"#E1FFFF",
                label:"<?php print $risk[1]; ?>"
        },
        {
                value:<?php print $factor[2]; ?>,
                color:"#e3ce19",
                highlight:"#FFFF98",
                label:"<?php print $risk[2]; ?>"
        },
        {
                value:<?php print $factor[3]; ?>,
                color:"#ed5722",
                highlight:"#FFD6A1",
                label:"<?php print $risk[3]; ?>"
        },
        {
                value:<?php print $factor[4]; ?>,
                color:"#623619",
                highlight:"#E1B598",
                label:"<?php print $risk[4]; ?>"
        }
];
var healthriskschart = new Chart(ctx2).PolarArea(healthriskdata);

function gotoscene(sceneno) {
switch (sceneno) {
	case 2:
		$("#ring1").animate({left:'279px',top:'113px',width:'202px',height:'202px',opacity:'1'},'slow');
		break;
	case 3:
		$("#ring2").animate({left:'274px',top:'108px',width:'213px',height:'213px',opacity:'1'},'slow');
		break;
	case 4:
		$("#ring3").animate({left:'268px',top:'102px',width:'224px',height:'224px',opacity:'1'},'slow');
		break;
	case 5:
		$("#ring4").animate({left:'262px',top:'96px',width:'236px',height:'236px',opacity:'1'},'slow');
		break;
	case 6:
		$("#ring5").animate({left:'257px',top:'91px',width:'245px',height:'245px',opacity:'1'},'slow');
		break;
	case 7:
		$("#welcome").animate({opacity:'1',fontSize:'140px',top:'100px'},4000);
		break;
	case 8:
		$("#welcome").animate({opacity:'0'},'slow');
		break;
	case 9:
		$("#name").animate({opacity:'1'},'slow');
		break;
	case 10:
		startspin();
		break;
	case 11:
		sendtoangle(180);
		break;
	case 12:
		$("#scene3").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);
		break;
	case 44:
		document.getElementById("background").style.backgroundImage = "url('backgroundhole.png')";
		document.getElementById("photo").style.opacity = 1;
		break;
	case 13:
		$("#scene3").animate({opacity:'0'},1000);
		break;
	case 14:
		$("#citizennumber").animate({opacity:'1'},2000);
		break;
        case 15:
		startspin();
                break;
        case 16:
		sendtoangle(315);
                break;
        case 17:
		$("#scene6").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);	
                break;
        case 18:
		$("#scene6").animate({opacity:'0'},1000);
                break;
        case 19:
		$("#mentalhealthicon").animate({opacity:'1'},2000);
                break;
        case 20:
		startspin();
                break;
        case 21:
		sendtoangle(45);
                break;
        case 22:
		$("#scene8").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);
                break;
        case 23:
		$("#scene8").animate({opacity:'0'},1000);
                break;
        case 24:
		$("#babynameicon").animate({opacity:'1'},2000);
                break;
        case 25:
		startspin();
                break;
        case 26:
		sendtoangle(135);
                break;
        case 27:
		$("#scene12").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);
                break;
        case 28:
		$("#scene12").animate({opacity:'0'},1000);
                break;
        case 29:
		$("#incomeicon").animate({opacity:'1'},2000);
                break;
        case 30:
		startspin();
                break;
        case 31:
		sendtoangle(225);
                break;
        case 32:
		$("#scene15").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);
                break;
        case 33:
		$("#scene15").animate({opacity:'0'},1000);
                break;
        case 34:
		$("#overweighticon").animate({opacity:'1'},2000);
                break;
        case 35:
		startspin();
                break;
        case 36:
		$("#earth").animate({opacity:'0'},3000);
                break;
        case 37:
		$("#thisisyou").animate({opacity:'1',fontSize:'140px',top:'120px'},2000);
                break;
        case 38:
		$("#thisisyou").animate({opacity:'0'},'slow');
                break;
        case 39:
		$("#thisisyourworld").animate({opacity:'1',fontSize:'80px',top:'170px'},2000);
                break;
        case 40:
		$("#thisisyourworld").animate({opacity:'0'},'slow');
                break;
        case 41:
		$("#thisisyouraustralia").animate({opacity:'1',fontSize:'70px',top:'170px'},2000);
                break;
        case 42:
		$("#thisisyouraustralia").animate({opacity:'0'},'slow');
                break;
        case 43:
                break;
	default:
		break;
}
};


function startspin() {
clearInterval(ring1timerid);
clearInterval(ring2timerid);
clearInterval(ring3timerid);
clearInterval(ring4timerid);
clearInterval(ring5timerid);
ring1timerid=setInterval(function(){
	angle1+=3;
	$("#ring1").rotate(angle1);
},50);
ring2timerid=setInterval(function(){
	angle2-=4;
	$("#ring2").rotate(angle2);
},50);
ring3timerid=setInterval(function(){
    angle3+=5;
    $("#ring3").rotate(angle3);
},50);
ring4timerid=setInterval(function(){
            angle4-=6;
            $("#ring4").rotate(angle4);
},50);
ring5timerid=setInterval(function(){
            angle5+=7;
            $("#ring5").rotate(angle5);
},50);
};
function sendtoangle(stopangle) {
spindest=0;
angle=stopangle;
clearInterval(ring1timerid);
clearInterval(ring2timerid);
clearInterval(ring3timerid);
clearInterval(ring4timerid);
clearInterval(ring5timerid);
angle1 = angle1 % 360;
angle2 = angle2 % 360;
angle3 = angle3 % 360;
angle4 = angle4 % 360;
angle5 = angle5 % 360;
if (angle1 % 2 == 1)
{
	angle1+=1;
}
if (angle2 % 2 == 1)
{
        angle2+=1;
}
if (angle3 % 2 == 1)
{
        angle3+=1;
}
if (angle4 % 2 == 1)
{
        angle4+=1;
}
if (angle5 % 2 == 1)
{
        angle5+=1;
}
if (angle % 2 ==1)
{
	angle+=1;
}
ring1timerid=setInterval(function(){
        if (angle1 == angle )
	{
		clearInterval(ring1timerid);
	}
	else
	{
		angle1+=2;
                if (angle1 == 360)
                {
                        angle1=0;
                }
        	$("#ring1").rotate(angle1);
	}
},10);
ring2timerid=setInterval(function(){
        if (angle2 == angle)
        {
                clearInterval(ring2timerid);
        }
        else
        {
                angle2+=2;
                if (angle2 == 360)
                {
                        angle2=0;
                }
                $("#ring2").rotate(angle2);
        }
},10);
ring3timerid=setInterval(function(){
        if (angle3 == angle)
        {
                clearInterval(ring3timerid);
        }
        else
        {
                angle3+=2;
                if (angle3 == 360)
                {
                        angle3=0;
                }
                $("#ring3").rotate(angle3);
        }
},10);
ring4timerid=setInterval(function(){
        if (angle4 == angle)
        {
                clearInterval(ring4timerid);
        }
        else
        {
                angle4+=2;
                if (angle4 == 360)
                {
                        angle4=0;
                }
                $("#ring4").rotate(angle4);
        }
},10);
ring5timerid=setInterval(function(){
        if (angle5 == angle)
        {
                clearInterval(ring5timerid);
        }
        else
        {
                angle5+=2;
		if (angle5 == 360)
		{
			angle5=0;
		}
                $("#ring5").rotate(angle5);
        }
},10);
}
</script>
</body>
</html>
