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
</head>
<body>
<?php
include 'facebookinit.php';
include 'db.php';
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\Entities\AccessToken;
use Facebook\Entities\SignedRequest;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
if ( isset( $session ) ) {
  
  // save the session
  $_SESSION['fb_token'] = $session->getToken();
  // create a session using saved token or the new one we generated at login
  $session = new FacebookSession( $session->getToken() );
  
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject()->asArray();
  
  // print profile data
//  echo '<pre>' . print_r( $graphObject, 1) . '</pre>';

        $town=$graphObject['location']->name;
	$townarray=explode(", ", $town);
	$stmt = $db->query('SELECT state FROM postcode_db where suburb="' . mysql_real_escape_string($townarray[0]) . '" limit 1');
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$state=$row['state'];
	$gender=$graphObject['gender'];   
	$birthday=$graphObject['birthday'];  
	$fbid=$graphObject['id'];
	$name=$graphObject['name'];
	if ($gender=="male")
	{
		$gender="man";
	}
	elseif ($gender=="female")
	{
		$gender="woman";
	}
	else
	{
		$gender="person";
	}
	$age = date_diff(date_create($birthday), date_create('now'))->y;
//	print "You are a " . $age . " year old " . $gender . " from " . $state . ".<br>";
	$birthdaytext=$birthday;
	$birthday=explode("/",$birthday);
	$sqlbirthday=$birthday[2] . "-" . $birthday[0] . "-" .$birthday[1];
	$stmt = $db->query('replace into users set fbid="' . mysql_real_escape_string($fbid) . '", name="' . mysql_real_escape_string($name) . '", first_name="' . mysql_real_escape_string($graphObject['first_name']) . '", last_name="' . mysql_real_escape_string($graphObject['last_name']) . '", birthday="' . mysql_real_escape_string($sqlbirthday) . '", gender="' . mysql_real_escape_string($gender) . '", hometown="' . mysql_real_escape_string($town) . '", suburb="' . mysql_real_escape_string($townarray[0]) . '", country="' . mysql_real_escape_string($townarray[1]) . '", state="' . mysql_real_escape_string($state) . '", age="' . mysql_real_escape_string($age) . '"');
$stmt->fetch(PDO::FETCH_ASSOC);
	print '<div style="width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;background-color:#faf7ee">';
	print '<div style="left:20px; width:720px; top: 20px;position:absolute;font-size:20px;">';	
	print 'Facebook has provided us with these details about you, please correct any that are wrong, or change them.  For the purpose of this app you will need to provide an Australian location.<br><br>';
	print '<form name="myform" action="https://govhack2014.p84d.com/start.php?fbid=' . $fbid . '" method=post>Name <input type=text style="font-size:20px;" value="' . $name . '" name=name><br><br>';
        print 'Date of Birth <input type=text style="font-size:20px;" value="' . $birthdaytext . '" name=dob><br><br>';
	if ($townarray[1]=="Australia")
	{
	        print 'Location <input type=text style="font-size:20px;" value="' . $townarray[0] . '" name=town><br><br>';
	}
	else
	{
                print 'Location <input type=text style="font-size:20px;" name=town><br><br>';
	}
	print 'When did you arrive in Australia? <input type=text style="font-size:20px;" value="' . $birthdaytext . '" name=arrival><br><br>';
	print '<div style="position:absolute;left:645px;"><input type=submit></div>';
	print '</form></div></div>';
// Find the friends of the current user
//  $request = new FacebookRequest( $session, 'GET', '/me/friends' );
//  $response = $request->execute();
//  $graphObject = $response->getGraphObject()->asArray();
//$start=0;
//foreach ($graphObject['data'] as $friend)
//{
//	if ($start==0)
//	{
//		print "You are friends with:<br>";
//		$start=1;
//	}
//	$stmt = $db->query('select * from users where fbid="' . mysql_real_escape_string($friend->id) . '"');
//	$row = $stmt->fetch(PDO::FETCH_ASSOC);
//	print $row['name'] . ", a " . $row['age'] . " year old " . $gender . " from " . $row['state'] . ".<br>";
//}
// Show income details
//list($chosenyear,$ageatyear)=pickhistoricyear($birthday[2],1978,2002);
//$stmt = $db->query('select * from income where year=' . $chosenyear);
//$row = $stmt->fetch(PDO::FETCH_ASSOC);
//print "In " . $row['year'] . ", you were " . $ageatyear . ", and the average income was $" . $row['averageincome'] . " and the average tax paid was $" . $row['averagetax'] . " (" . $row['averagetaxpercent'] . "%)<br>";
// Mental health details
//list($chosenyear,$ageatyear)=pickhistoricyear($birthday[2],1978,2002);
//$stmt = $db->query('select * from mentalhealth where year=' . $chosenyear);
//$row = $stmt->fetch(PDO::FETCH_ASSOC);
//print "In " . $row['year'] . ", you were " . $ageatyear . ", and there were " . $row['mentalhealthcases'] . " recorded instances of mental health cases.  If you or anyone ....<br>";

  // print logout url using session and redirect_uri (logout.php page should destroy the session)
//  echo '<a href="' . $helper->getLogoutUrl( $session, 'http://govhack2014.p84d.com' ) . '">Logout</a>';
  
} else {
  // show login url
	
  echo '<div style="width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;background-color:#faf7ee">';
echo '<div style="left:20px; width:720px; top: 20px;position:absolute;">This is the intro text, need to replace with real words</div>';

echo '<div style="position:absolute;top:275px;left:180px;"><a href="' . $helper->getLoginUrl( array( 'user_friends', 'user_birthday', 'user_location' ) ) . '"><img src=fblogin.png border=0 width=400px></a></div>';
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
</body>
</html>
