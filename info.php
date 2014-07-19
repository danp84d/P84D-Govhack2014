<html>
<head>
<title>
</title>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="jquery-ui.css">
<script src="jquery-latest.js"></script>
  <script src="jquery-ui.js"></script>
<style>
      body, table.details th, table.details td {
        font-family: 'Lato', sans-serif;
        font-size: 20px;
	color: #faf7ee;
	vertical-align: middle;
      }
	.input {     border: 1px solid #006; }
      a:link {
	color: #db283e;
      }
      a:visited {
        color: #db283e;
      }
      .ui-datepicker{
        font-size:14px;
      }
      .ui-autocomplete{
	font-size:14px;
	}
    </style>
  <script>
  $(function() {
    $( "#datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
	    yearRange: '1901:2001',
            maxDate: '12/31/2001',
            minDate: '01/01/1901' 
        });
    $( "#datepicker2" ).datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange: '1901:2014',
            minDate: '01/01/1901' 
       });
	$("#autocomplete").autocomplete({
		source: "searchsuburb.php",
		minLength: 2,//search after two characters
		select: function(event,ui){
		    //do something
   	 }
});
  });
  </script>
</head>
<body>
<?php
include 'db.php';
$fbid=$_GET['fbid'];
$suburberror=$_GET['suburberror'];
$nameerror=$_GET['nameerror'];
$arrivalerror=$_GET['arrivalerror'];
$stmt = $db->query('SELECT * FROM users where fbid="' . mysql_real_escape_string($fbid) . '"');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$country=$row['country'];
$state=$row['state'];
	$suburb=$row['suburb'];
	$gender=$row['gender'];   
	$birthday=$row['birthday'];  
	$name=$row['name'];
	$age = $row['age'];
	$birthday=explode("-",$birthday);
	$birthdaytext=$birthday[1] . "/" . $birthday[2] . "/" . $birthday[0];
	print '<div style="width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;background-image: url(background.png);background-size: 100% 100%;">';
	print '<div style="left:20px; width:720px; top: 60px;position:absolute;font-size:20px;">';	
	print 'Facebook has provided us with these details about you, please correct any that are wrong, or change them.  For the purpose of this app you will need to provide an Australian suburb.  If you are not from Australia, we have selected a suburb for you.<br><br>';
	print '<form name="myform" action="https://govhack2014.p84d.com/updateinfo.php?fbid=' . $fbid . '" method=post><table class=details border=0><tr><td>Name</td><td><input type=text style="font-size:20px;" value="' . $name . '" name=name></td>';
	if ($nameerror==1)
	{
		print '<td><font color=red size=2>Your name must contain at least two characters</font></td></tr>';
	}
	else
	{
		print '<td>&nbsp;</td></tr>';
	}
        print '<tr><td>Date of Birth</td><td><input type=text style="font-size:20px;" value="' . $birthdaytext . '" name=dob readonly=true id=datepicker1></td></tr>';
	if ($country=="Australia")
	{
	        print '<tr><td>Suburb</td><td><input type=text style="font-size:20px;" value="' . $suburb . '" name=suburb id=autocomplete></td>';
        	if ($suburberror==1)
        	{
			print '<td><font color=red size=2>Must select a valid Australian suburb</font></td></tr>';
        	}
       		else
        	{
                	print '<td>&nbsp;</td></tr>';
        	}
	}
	else
	{
                print '<tr><td>Suburb</td><td><input type=text style="font-size:20px;" name=suburb value=Sydney></td></tr>';
        	if ($suburberror==1)
        	{
                        print '<td><font color=red size=2>Must select a valid Australian suburb</font></td></tr>';	
       	 	}
        	else
        	{
                	print '<td>&nbsp;</td></tr>';
        	}
	}
	print '<tr><td>When did you arrive in Australia?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type=text style="font-size:20px;" value="' . $birthdaytext . '" name=arrival readonly=true id=datepicker2></td>';
        if ($arrivalerror==1)
        {
                        print '<td><font color=red size=2>Your arrival date cannot be before your date of birth</font></td></tr>';
        }
        else
        {
                print '<td>&nbsp;</td></tr>';
        }
	print '</table>';
	print '<div style="position:absolute;left:645px;top:300px;"><input type=submit class=input></div>';

	print '</form></div></div>';



?>
</body>
</html>
