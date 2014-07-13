<html>
<head>
<title>
</title>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<style>
      body {
        font-family: 'Lato', sans-serif;
        font-size: 36px;
        color: #767676;
      }
    </style>
<script type="text/javascript" src="jquery-latest.js"></script>
<script type="text/javascript" src="jQueryRotate.js"></script>
<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
<?php
include 'db.php';
$stmt = $db->query('SELECT * FROM users where fbid="' . mysql_real_escape_string($_GET['fbid']) . '" limit 1');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$name=$row['name'];
$age=$row['age'];
$sex=$row['gender'];
$stmt = $db->query('SELECT sum(ratio) from popprofile where agemax < ' . $age);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$popratio=$row['sum(ratio)'];
$citizennumber=(((100-$popratio)/100)*22700000)-rand(1,1000000);
$stmt = $db->query('SELECT * FROM babyname where year="1976" and gender="male" order by ranks asc limit 1');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$babyname=$row['name'];
$stmt = $db->query('select *  from babyname WHERE name like "Dan%" and gender="male" order by ranks asc limit 1');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$babyyear=$row['year'];
list($incomeyear,$incomeage)=pickhistoricyear(1976,1978,2002);
$stmt = $db->query('select * from income where year=' . $incomeyear);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$income=$row['averageincome'];
$stmt = $db->query('select factor from health where minage<=37 and maxage>=37 and risk="Overweight"');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$overweight=$row['factor'];
$stmt = $db->query('select factor from health where minage<=37 and maxage>=37 and risk="High blood pressure"');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$bloodpressure=$row['factor'];


        print '<div style="width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;background-color:#faf7ee">';
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
        print '<div id="thisisyou" style="position:absolute;width:720px;height:50px;left:20px;top:164px;opacity:0;text-align:center;">This is you</div>';

	print '<div id="name" style="position:absolute;width:710px;height:70px;left:20px;top:20px;opacity:0;text-align:center;">' . $name . '</div>';
	print '<div id="citizennumber" style="position:absolute;width:710px;height:70px;left:20px;top:350px;opacity:0;text-align:center;">#' . number_format($citizennumber) . '</div>';
        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;background-color:#faf7ee;opacity:0;" id="scene3">';
	print '<div style="position:absolute;left:50px;top:70px;"><img src=' . $sex . '.png height=270></div><div style="position:absolute;left:200px;top:150px;width:500px;height:328px;">Based on your date of birth you are Australian resident number:<br>' . number_format($citizennumber) . '</div>';
	print '</div>';

        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;background-color:#faf7ee;opacity:0;" id="scene6">';
//	print '<div style="width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;background-color:#faf7ee;opacity:1;" id="scene6">';
	print '<div style="position:absolute;left:20px;top:20px;"><canvas id="mentalhealth" width="400" height="400"></canvas></div>';
	print '<div style="position:absolute; left:440px;top:20px;"><img src=mentalhealth.png width=65px></div>';
	print '<div style="position:absolute; left:440px;top:105px;width:300px;">Were you aware that in 2011 there were over 345,000 instances of mental health issues.</div>';
        print '</div>';


	
	print '<div id="mentalhealthicon" style="position:absolute;left:0px;top:38px;width:205px;opacity:0;text-align:center;min-width:205px;"><img src="mentalhealth.png" width=65px><br>345,000</div>';

        print '<div id="babynameicon" style="position:absolute;left:550px;top:38px;width:205px;opacity:0;text-align:center;min-width:205px;"><img src="babyname.png" height=88px><br>1979</div>';

        print '<div id="overweighticon" style="position:absolute;left:0px;top:302px;width:205px;opacity:0;text-align:center;min-width:205px;"><img src="overweight.png" height=44px><br>68.1%</div>';

        print '<div id="incomeicon" style="position:absolute;left:550px;top:302px;width:205px;opacity:0;text-align:center;min-width:205px;"><img src="income.png" height=44px><br>$' . number_format($income) . '</div>';

        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;background-color:#faf7ee;opacity:0;" id="scene8">';
//      print '<div style="width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;background-color:#faf7ee;opacity:1;" id="scene8">';
        print '<div style="position:absolute;left:50px;top:70px;"><img src=' . $sex . '.png height=270></div><div style="position:absolute;left:200px;top:100px;width:500px;height:328px;">The most popular baby name in the year you were born was ' . $babyname . '.<br><br>Your name was most popular in ' . $babyyear . '.</div>';
        print '</div>';

        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;background-color:#faf7ee;opacity:0;" id="scene12">';
//      print '<div style="width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;background-color:#faf7ee;opacity:1;" id="scene12">';
        print '<div style="position:absolute;left:50px;top:70px;"><img src=' . $sex . '.png height=270></div><div style="position:absolute;left:200px;top:100px;width:500px;height:328px;">In ' . $incomeyear . ' you were ' . $incomeage . ' years old and the average annual income was $' . number_format($income) . '.</div>';
        print '</div>';


        print '<div style="width:1px;height:1px;min-height:1px;min-width:1px;position:absolute;left:380px;top:214px;background-color:#faf7ee;opacity:0;" id="scene15">';
//      print '<div style="width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;background-color:#faf7ee;opacity:1;" id="scene15">';
        print '<div style="position:absolute;left:50px;top:70px;"><img src=' . $sex . '.png height=270></div><div style="position:absolute;left:200px;top:100px;width:500px;height:328px;">Based on your age, you have a ' . $overweight . '% chance of being obese, but only ' . $bloodpressure . '% of high blood pressure.</div>';
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
$(document).ready(function(){
	$("#earth").animate({left:'284px',top:'118px',width:'192px',height:'192px',opacity:'1'},'slow',function(){
	$("#ring1").animate({left:'279px',top:'113px',width:'202px',height:'202px',opacity:'1'},'slow',function(){
	$("#ring2").animate({left:'274px',top:'108px',width:'213px',height:'213px',opacity:'1'},'slow',function(){
	$("#ring3").animate({left:'268px',top:'102px',width:'224px',height:'224px',opacity:'1'},'slow',function(){
	$("#ring4").animate({left:'262px',top:'96px',width:'236px',height:'236px',opacity:'1'},'slow',function(){
	$("#ring5").animate({left:'257px',top:'91px',width:'245px',height:'245px',opacity:'1'},'slow',function(){
	$("#welcome").animate({opacity:'1',fontSize:'140px',top:'100px'},4000,function(){
	$("#welcome").animate({opacity:'0'},'slow',function(){
	$("#name").animate({opacity:'1'},'slow',startspin())})})})})})})})});
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

setTimeout(function(){scene2()},12000);
setTimeout(function(){scene3()},23000);
setTimeout(function(){scene4()},28000);
setTimeout(function(){scene5()},30000);
setTimeout(function(){scene6()},38000);
setTimeout(function(){scene7()},48000);
setTimeout(function(){scene8()},50000);
setTimeout(function(){scene9()},55000);
setTimeout(function(){scene10()},60000);
setTimeout(function(){scene11()},62000);
setTimeout(function(){scene12()},65000);
setTimeout(function(){scene13()},75000);
setTimeout(function(){scene14()},77000);
setTimeout(function(){scene15()},80000);
setTimeout(function(){scene16()},90000);

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
function startspin() {




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
function scene2() {
clearInterval(ring1timerid);
clearInterval(ring2timerid);
clearInterval(ring3timerid);
clearInterval(ring4timerid);
clearInterval(ring5timerid);
sendtoangle(180);
}
function sendtoangle(angle) {
angle1 = angle1 % 360;
angle2 = angle2 % 360;
angle3 = angle3 % 360;
angle4 = angle4 % 360;
angle5 = angle5 % 360;
ring1timerid=setInterval(function(){
        if (angle1 == angle )
	{
		clearInterval(ring1timerid);
	}
	else
	{
		angle1+=1;
                if (angle1 > 360)
                {
                        angle1=-361;
                }
        	$("#ring1").rotate(angle1);
	}
},1);
ring2timerid=setInterval(function(){
        if (angle2 == angle)
        {
                clearInterval(ring2timerid);
        }
        else
        {
                angle2+=1;
                if (angle2 > 360)
                {
                        angle2=-361;
                }
                $("#ring2").rotate(angle2);
        }
},1);
ring3timerid=setInterval(function(){
        if (angle3 == angle)
        {
                clearInterval(ring3timerid);
        }
        else
        {
                angle3+=1;
                if (angle3 > 360)
                {
                        angle3=-361;
                }
                $("#ring3").rotate(angle3);
        }
},1);
ring4timerid=setInterval(function(){
        if (angle4 == angle)
        {
                clearInterval(ring4timerid);
        }
        else
        {
                angle4+=1;
                if (angle4 > 360)
                {
                        angle4=-361;
                }
                $("#ring4").rotate(angle4);
        }
},1);
ring5timerid=setInterval(function(){
        if (angle5 == angle)
        {
                clearInterval(ring5timerid);
        }
        else
        {
                angle5+=1;
		if (angle5 > 360)
		{
			angle5=-361;
		}
                $("#ring5").rotate(angle5);
        }
},1);
}
function scene3() {
$("#scene3").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);
}
function scene4() {
$("#scene3").animate({opacity:'0'},1000);
$("#citizennumber").animate({opacity:'1'},3000);
startspin();
}
function scene5() {
clearInterval(ring1timerid);
clearInterval(ring2timerid);
clearInterval(ring3timerid);
clearInterval(ring4timerid);
clearInterval(ring5timerid);
sendtoangle(315);
}
function scene8() {
clearInterval(ring1timerid);
clearInterval(ring2timerid);
clearInterval(ring3timerid);
clearInterval(ring4timerid);
clearInterval(ring5timerid);
sendtoangle(45);
}
function scene6() {
$("#scene6").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);
}
function scene9() {
$("#scene8").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);
}
function scene7() {
$("#scene6").animate({opacity:'0'},1000);
$("#mentalhealthicon").animate({opacity:'1'},3000);
clearinterval(ring1timerid);
clearInterval(ring2timerid);
clearInterval(ring3timerid);
clearInterval(ring4timerid);
clearInterval(ring5timerid);
startspin();
}
function scene10() {
$("#scene8").animate({opacity:'0'},1000);
$("#babynameicon").animate({opacity:'1'},3000);
startspin();
}
function scene11() {
clearInterval(ring1timerid);
clearInterval(ring2timerid);
clearInterval(ring3timerid);
clearInterval(ring4timerid);
clearInterval(ring5timerid);
sendtoangle(135);
}
function scene12() {
$("#scene12").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);
}
function scene13() {
$("#scene12").animate({opacity:'0'},1000);
$("#incomeicon").animate({opacity:'1'},3000);
startspin();
}
function scene14() {
clearInterval(ring1timerid);
clearInterval(ring2timerid);
clearInterval(ring3timerid);
clearInterval(ring4timerid);
clearInterval(ring5timerid);
sendtoangle(180);
}
function scene15() {
$("#scene15").animate({left:'0px',top:'0px',width:'760px',height:'428px',opacity:'1'},1000);
}
function scene16() {
$("#scene15").animate({opacity:'0'},1000);
$("#overweighticon").animate({opacity:'1'},3000);
startspin();
}

</script>
</body>
</html>
