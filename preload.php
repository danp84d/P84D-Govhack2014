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
	$fbid=$_GET['fbid'];
	print '<img src="https://graph.facebook.com/' . $fbid . '/picture?type=large" style="min-height:200px;min-width:200px;position:absolute;left:281px;top:119px;opacity:0" id="photo">';
        print '<div id="background" style="opacity:1;background-image: url(background.png);background-size: 100% 100%;width:760px;height:428px;min-height:428px;min-width:760px;position:absolute;left:0px;top:0px;text-align:center;"><br><br><br>Loading, please wait.';
	print '<div id="backgroundhole" style="opacity:0;"><img src=backgroundhole.png></div>';
        print '<div id="earth" style="width:1px; height:1px; left:380px; top:214px;position:absolute;opacity:0;">';
        print '<img src="earth.png" style="max-width:100%; max-height:100%;">';
        print '</div>';
	print "</div>";
?>
<script>
var mp3snd = "music.mp3";
var oggsnd = "music.ogg";
document.write('<audio autoplay="autoplay" id=player>');
document.write('<source src="'+mp3snd+'" type="audio/mpeg">');
document.write('<source src="'+oggsnd+'" type="audio/ogg">');
document.write('<!--[if lt IE 9]>');
document.write('<bgsound src="'+mp3snd+'" loop="1" volume="-10000">');
document.write('<![endif]-->');
document.write('</audio>');
player=document.getElementById("player");
player.volume=0;
setTimeout(function(){window.location.replace("https://govhack2014.p84d.com/start.php?fbid=<?php print $fbid; ?>")}, 10000);
</script>
</body>
</html>
