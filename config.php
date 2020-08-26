<?php
//Fill this information
$host     = "localhost"; // Database Host
$user     = "root"; // Database Username
$password = "5PTLvKnNCNLCLZmLbsRSdQVqur9sZs"; // Database's user Password
$database = "city"; // Database Name

// Facebook App codes
@define('FB_APP_ID', 'Insert_Facebook_App_ID');
@define('FB_APP_SECRET', 'Insert_Facebook_App_Secret');
@define('FB_REDIRECT_URL', 'http://yourwebsite.com/index.php');

//------------------------------------------------------------

$connect = mysqli_connect($host, $user, $password, $database);

// Checking Connection
if (mysqli_connect_errno()) {
    echo "Failed to connect with MySQL: " . mysqli_connect_error();
}

mysqli_set_charset($connect, "utf8mb4");

if(!session_id()){
    @session_start([
		'cookie_lifetime' => 86400,
	]);
}

require_once __DIR__ . '/facebook-sdk/autoload.php';

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

// Call Facebook API
$fb = new Facebook(array(
    'app_id' => FB_APP_ID,
    'app_secret' => FB_APP_SECRET,
    'default_graph_version' => 'v3.2',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
          $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
}

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $count = mysqli_num_rows($suser);
    if ($count > 0) {
        //Set Online
        $prow    = mysqli_fetch_assoc($suser);
        $timenow = time();
        $update  = mysqli_query($connect, "UPDATE `players` SET timeonline='$timenow' WHERE username='$uname'");
        
        //Level Up
        $playerrespect = $prow['respect'];
        $playerlevel   = $prow['level'];
        $querylv       = mysqli_query($connect, "SELECT * FROM `levels` WHERE level='$playerlevel'");
        $lvrow         = mysqli_fetch_assoc($querylv);
        $minrespect    = $lvrow['min_respect'];
        $queryblv      = mysqli_query($connect, "SELECT * FROM levels WHERE level='$playerlevel'+1");
        $rowblv        = mysqli_fetch_assoc($queryblv);
        $blevel        = $rowblv['level'];
        $bminrespect   = $rowblv['min_respect'];
        $queryllv      = mysqli_query($connect, "SELECT * FROM levels ORDER BY min_respect DESC LIMIT 1");
        $rowllv        = mysqli_fetch_assoc($queryllv);
        $llvminrespect = $rowllv['min_respect'];
        $llevel        = $rowllv['level'];
        
        if ($playerrespect > $llvminrespect) {
            $update = mysqli_query($connect, "UPDATE `players` SET level='$llevel' WHERE username='$uname'");
        } else {
            
            if ($playerrespect > $bminrespect OR $playerrespect == $bminrespect) {
                $update = mysqli_query($connect, "UPDATE `players` SET level='$blevel', energy='100', money=money+'1000', gold=gold+'2' WHERE username='$uname'");
            }
            if ($playerrespect < $minrespect) {
                $update = mysqli_query($connect, "UPDATE `players` SET level=level-1 WHERE username='$uname'");
            }
            
        }
        
        if ($prow['money'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET money=0 WHERE username='$uname'");
        }
        
        if ($prow['gold'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET gold=0 WHERE username='$uname'");
        }
        
        if ($prow['energy'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET energy=0 WHERE username='$uname'");
        }
        
        if ($prow['energy'] > 100) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET energy=100 WHERE username='$uname'");
        }
        
        if ($prow['health'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET health=0 WHERE username='$uname'");
        }
        
        if ($prow['health'] > 100) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET health=100 WHERE username='$uname'");
        }
        
        if ($prow['respect'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET respect=0 WHERE username='$uname'");
        }
        
        if ($prow['bank'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET bank=0 WHERE username='$uname'");
        }
        
        if ($prow['power'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET power=0 WHERE username='$uname'");
        }
        
        if ($prow['power'] > 250) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET power=250 WHERE username='$uname'");
        }
        
        if ($prow['agility'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET agility=0 WHERE username='$uname'");
        }
        
        if ($prow['agility'] > 250) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET agility=250 WHERE username='$uname'");
        }
        
        if ($prow['endurance'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET endurance=0 WHERE username='$uname'");
        }
        
        if ($prow['endurance'] > 250) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET endurance=250 WHERE username='$uname'");
        }
        
        if ($prow['intelligence'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET intelligence=0 WHERE username='$uname'");
        }
        
        if ($prow['intelligence'] > 250) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET intelligence=250 WHERE username='$uname'");
        }
		
    }
}
?>