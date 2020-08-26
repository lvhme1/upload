<?php
require "config.php";

$queryls = mysqli_query($connect, "SELECT * FROM `languages` WHERE default_language='Yes'");
$rowls   = mysqli_fetch_assoc($queryls);

$lang = isset($_GET['lang']) ? $_GET['lang'] : "";

if (!empty($lang)) {
    $curr_lang = $_SESSION['curr_lang'] = $lang;
} else if (isset($_SESSION['curr_lang'])) {
    $curr_lang = $_SESSION['curr_lang'];
} else {
    $curr_lang = $rowls['langcode'];
}

if (file_exists("languages/" . $curr_lang . ".php")) {
    include "languages/" . $curr_lang . ".php";
} else {
    include 'languages/' . $rowls['langcode'] . '.php';
}

// Returns language key
function lang_key($key)
{
    global $arrLang;
    $output = "";
    
    if (isset($arrLang[$key])) {
        $output = $arrLang[$key];
    } else {
        $output = str_replace("_", " ", $key);
    }
    return $output;
}

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $count = mysqli_num_rows($suser);
    if ($count > 0) {
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
}

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$dirname   = $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
$vcity_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$dirname";

$query = mysqli_query($connect, "SELECT * FROM `settings` LIMIT 1");
$row   = mysqli_fetch_assoc($query);

$timeon  = time() - 60;
$queryop = mysqli_query($connect, "SELECT * FROM `players` WHERE timeonline>$timeon");
$countop = mysqli_num_rows($queryop);

$querytp = mysqli_query($connect, "SELECT * FROM `players`");
$counttp = mysqli_num_rows($querytp);
$queryf  = mysqli_query($connect, "SELECT * FROM `fights`");
$countf  = mysqli_num_rows($queryf);
$queryr  = mysqli_query($connect, "SELECT * FROM `races`");
$countr  = mysqli_num_rows($queryr);
$queryi  = mysqli_query($connect, "SELECT * FROM `items`");
$counti  = mysqli_num_rows($queryi);
$queryv  = mysqli_query($connect, "SELECT * FROM `vehicles`");
$countv  = mysqli_num_rows($queryv);

$querybp = mysqli_query($connect, "SELECT * FROM `players` ORDER BY respect DESC LIMIT 1");
$countbp = mysqli_num_rows($querybp);
if ($countbp > 0) {
    $rowbp       = mysqli_fetch_assoc($querybp);
    $best_player = $rowbp['username'];
} else {
    $best_player = "-";
}

$querynp = mysqli_query($connect, "SELECT * FROM `players` ORDER BY id DESC LIMIT 1");
$countnp = mysqli_num_rows($querynp);
if ($countnp > 0) {
    $rownp         = mysqli_fetch_assoc($querynp);
    $newest_player = $rownp['username'];
} else {
    $newest_player = "-";
}

$chusername_modal = "No";

$querytd = mysqli_query($connect, "SELECT * FROM `themes` WHERE default_theme='Yes' LIMIT 1");
$rowtd   = mysqli_fetch_assoc($querytd);
if ($rowtd['navbar_colorscheme'] == 1) {
    $navbar_cscheme = 'navbar-dark bg-dark';
} elseif ($rowtd['navbar_colorscheme'] == 2) {
    $navbar_cscheme = 'navbar-dark bg-primary';
} elseif ($rowtd['navbar_colorscheme'] == 3) {
    $navbar_cscheme = 'navbar-light bg-light';
} else {
    $navbar_cscheme = 'navbar-light';
}

$queryld = mysqli_query($connect, "SELECT * FROM `languages` WHERE default_language='Yes'");
$rowld   = mysqli_fetch_assoc($queryld);

// Facebook Login
/*if(!session_id()){
    @session_start();
}*/
if (isset($accessToken)) {
    if (isset($_SESSION['facebook_access_token'])) {
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    } else {
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        
        // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken              = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    
    // Redirect the user back to the same page if url has "code" parameter in query string
    if (isset($_GET['code'])) {
        header('Location: ./');
    }
    
    // Getting user's profile info from Facebook
    try {
        $graphResponse = $fb->get('/me?fields=email,picture');
        $fbUser        = $graphResponse->getGraphUser();
    }
    catch (FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        // Redirect user back to app login page
        header("Location: ./");
        exit;
    }
    catch (FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    
    // Getting user's profile data
    $fbUserData              = array();
    $fbUserData['oauth_uid'] = !empty($fbUser['id']) ? $fbUser['id'] : '';
    $fbUserData['email']     = !empty($fbUser['email']) ? $fbUser['email'] : '';
    $fbUserData['picture']   = !empty($fbUser['picture']['url']) ? $fbUser['picture']['url'] : '';
    
    $fb_uid    = $fbUserData['oauth_uid'];
    $fb_email  = $fbUserData['email'];
    $fb_avatar = $fbUserData['picture'];
    // Insert or update user data to the database
    // Check if FB_OID -> Login
    // Else if email -> Login + Update FB_OID
    
    $sqlfbid = mysqli_query($connect, "SELECT username, facebook_uid FROM `players` WHERE facebook_uid='$fb_uid'");
    $sqlfbem = mysqli_query($connect, "SELECT username, email FROM `players` WHERE email='$fb_email'");
    if (mysqli_num_rows($sqlfbid) > 0) {
        $rowfbid              = mysqli_fetch_assoc($sqlfbid);
        $_SESSION['username'] = $rowfbid['username'];
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
    } else if (mysqli_num_rows($sqlfbem) > 0) {
        $rowfbem = mysqli_fetch_assoc($sqlfbem);
        $fb_plid = $rowfbem['id'];
        $querysd = mysqli_query($connect, "UPDATE `players` SET facebook_uid='$fb_uid' WHERE id='$fb_plid'");
        
        $_SESSION['username'] = $rowfbem['username'];
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
    } else {
        $chusername_modal = "Yes";
        $errorcu          = 'No';
        
        if (isset($_POST['choose_username'])) {
            
            $alphabet    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass        = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n      = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $genpassword = implode($pass); //turn the array into a string
            
            $username = $_POST['cusername'];
            $password = hash('sha256', $genpassword);
            
            $sql = mysqli_query($connect, "SELECT username FROM `players` WHERE username='$username'");
            if (mysqli_num_rows($sql) > 0) {
                echo '<br /><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' . lang_key("username_taken") . '</div>';
            } else {
				$chusername_modal = "No";
				
                $money    = $row['startmoney'];
                $gold     = $row['startgold'];
                $langcode = $rowld['langcode'];
                
                $insert = mysqli_query($connect, "INSERT INTO `players` (`username`, `password`, `email`, `facebook_uid`, `avatar`, `money`, `gold`, `language`) VALUES ('$username', '$password', '$fb_email', '$fb_uid', '$fb_avatar', '$money', '$gold', '$langcode')");
                
                $subject = 'Welcome at ' . $row['title'] . '';
                $message = '
                                    <center>
                					<a href="' . $vcity_url . '" title="Visit ' . $row['title'] . '" target="_blank">
                					<h1>' . $row['title'] . '</h1>
                					</a><br />

                					<h2>You have successfully registered at ' . $row['title'] . '</h2><br /><br />

                					<b>Registration details:</b><br />
                					Username: ' . $username . '<b></b><br />
									Password: ' . $genpassword . '<b></b><br />
                					</center>
                				    ';
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= 'To: ' . $fb_email . ' <' . $fb_email . '>' . "\r\n";
                $headers .= 'From: vcity@mail.com <vcity@mail.com>' . "\r\n";
                @mail($fb_email, $subject, $message, $headers);
                
                $_SESSION['username'] = $username;
                echo '<meta http-equiv="refresh" content="0;url=home.php">';
            }
            
        }
    }
    
    // Storing user data in the session
    $_SESSION['userData'] = $fbUserData;
    
    // Get logout url
    $logoutURL = $helper->getLogoutUrl($accessToken, FB_REDIRECT_URL . 'logout.php');
    
    // Render Facebook profile data
    if (!empty($fbUserData)) {
        $fbUserData['oauth_uid'];
        $fbUserData['email'];
        $fbUserData['picture'];
        
    } else {
        //echo '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
    
    $permissions = ['email'];
    $loginURL = $helper->getLoginUrl(FB_REDIRECT_URL, $permissions);
} else {
    // Get login url
    $permissions = ['email']; // Optional permissions
    $loginURL = $helper->getLoginUrl(FB_REDIRECT_URL, $permissions);
}
?>
<!DOCTYPE html>
<html lang="en">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?php
echo $row['description'];
?>">
    <meta name="keywords" content="<?php
echo $row['keywords'];
?>">
    <meta name="author" content="Antonov_WEB">
    <link rel="icon" href="assets/img/favicon.png">

    <title><?php
echo $row['title'];
?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Skin -->
    <link href="<?php
echo $rowtd["csspath"];
?>" rel="stylesheet">

    <!-- Game CSS -->
    <link href="assets/css/game.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" rel="stylesheet">

	<!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<?php
// Choose username modal
if ($chusername_modal == "Yes") {
    echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#choose-username").modal(\'show\');
            });
        </script>

        <div id="choose-username" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">' . lang_key("choose") . ' ' . lang_key("username") . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label style="width:100%;">' . lang_key("username") . '</span>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><em class="fa fa-fw fa-user"></em></div>
									</div>
                                    <input name="cusername" type="text" placeholder="' . lang_key("username") . '" class="form-control"
';
    if ($errorcu == "Yes") {
        echo 'autofocus';
    }
    echo ' required>
                                </div>
                            </div>
                            <div class="btn-toolbar">
                                <button type="submit" name="choose_username" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-in-alt"></i> ' . lang_key("save") . '</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
}
?>

    <center>
        <nav class="navbar <?php
echo $navbar_cscheme;
?> navbar-expand-md">
            <a class="navbar-brand" href="#"><i class="fa fa-building"></i> <i class="fa fa-car"></i> <i class="fa fa-users"></i> <?php
echo $row['title'];
?></a>
                    <button type="button" class="navbar-toggler collapsed" data-toggle="collapse"
                data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only"><?php
echo lang_key("navigation");
?></span>
&#x2630;</button>
                    <a class="navbar-brand d-block d-sm-none" href="index.php"><?php
echo $row['title'];
?></a>
                <div id="navbar" class="navbar-collapse collapse justify-content-md-center">
                    <ul class="nav navbar-nav">
                        <li class="active nav-item"><a href="#home" class="nav-link"><i class="fa fa-home fa-2x"></i><br /> <?php
echo lang_key("home");
?></a></li>
                        <li><a href="#about" class="nav-link"><i class="fa fa-info-circle fa-2x"></i><br /> <?php
echo lang_key("about");
?></a></li>
                        <li><a href="#screenshots" class="nav-link"><i class="fa fa-images fa-2x"></i><br /> <?php
echo lang_key("screenshots");
?></a></li>
                        <li><a href="#gamelogin" class="nav-link btn btn-outline-primary"><i class="fa fa-sign-in-alt fa-2x"></i><br /> <?php
echo lang_key("signin");
?></a></li>
                    </ul>
			   </div>
        </nav>
    </center>
<div class="nav-scroller bg-info shadow-sm">
  <nav class="nav nav-underline">
 <?php
$runcp = mysqli_query($connect, "SELECT * FROM `custom_pages` WHERE logged = 'No'");
while ($rowcp = mysqli_fetch_assoc($runcp)) {
    echo '<li class="nav-item mx-auto">
        <a class="nav-link text-white" href="page.php?pageid=' . $rowcp['id'] . '"><i class="fas ' . $rowcp['fa_icon'] . '"></i> ' . $rowcp['title'] . '</a>
      </li>';
}
?>
	<li class="nav-item dropdown ml-auto">
        <a class="nav-link dropdown-toggle bg-primary text-white" href="#" id="dlang" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-globe"></i> <?php
echo lang_key("languages");
?>
        </a>
		<div class="dropdown-menu" aria-labelledby="dlang">
<?php
$queryl = mysqli_query($connect, "SELECT * FROM `languages`");
while ($rowl = mysqli_fetch_assoc($queryl)) {
?>
                    <a class="dropdown-item" href="?lang=<?php
    echo $rowl['langcode'];
?>"><?php
    echo $rowl['language'];
?></a>
<?php
}
?>
                 </div>
      </li>
  </nav>
</div>

        <div class="jumbotron" id="indbgr" width="100%">
            <div class="row">
                <div class="col-md-8" style="color: white; text-shadow: 1px 1px #000000;">
                    <h2><i class="fa fa-building"></i> <i class="fa fa-car"></i> <i class="fa fa-users"></i> <?php
echo $row['title'];
?></h2>
                    <h5><?php
echo $row['description'];
?></h5>
                </div>
                <div class="col-lg-4 col-12" id="gamelogin">
                    <div class="card bg-light card-body mb-3">
                        <ul class="nav nav-tabs nav-justified" id="sign" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true"><i class="fa fa-sign-in-alt"></i> <?php
echo lang_key("signin");
?></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="singup" aria-selected="false"><i class="fa fa-user-plus"></i> <?php
echo lang_key("register");
?></a>
                          </li>
                        </ul><br />
<div class="tab-content" id="signContent">
  <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
<?php
$error = "No";

if (isset($_POST['signin'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = hash('sha256', $_POST['password']);
    $check    = mysqli_query($connect, "SELECT username, password FROM `players` WHERE `username`='$username' AND password='$password'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['username'] = $username;
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
    } else {
        echo '<br />
		<div class="alert alert-danger">
              <i class="fa fa-exclamation-circle"></i> ' . lang_key("userpass_incorrect") . '
        </div>';
        $error = "Yes";
    }
}
?>
                        <form action="" method="post">
                            <div class="form-group">
                                <span style="width:100%;"><?php
echo lang_key("username");
?></span>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><em class="fa fa-fw fa-user"></em></div>
									</div>
                                    <input name="username" type="text" placeholder="<?php
echo lang_key("username");
?>" class="form-control" <?php
if ($error == "Yes") {
    echo 'autofocus';
}
?> required>
                                </div>
                            </div>
                            <div class="form-group">
                                <span style="width:100%;"><?php
echo lang_key("password");
?></span>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text"><em class="fa fa-fw fa-key"></em></div>
									</div>
                                    <input name="password" type="password" placeholder="<?php
echo lang_key("password");
?>" class="form-control" required>
                                </div>
                            </div>
                            <center><a id="forgotpass-tab" data-toggle="tab" href="#forgotpass" role="tab" aria-controls="forgotpass" aria-selected="false"><?php
echo lang_key("forgot_password");
?></a></center>
							<br />
                            <div class="btn-toolbar">
                                <button type="submit" name="signin" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-in-alt"></i> <?php
echo lang_key("signin");
?></button>
                            </div>
							<center>
								<a href="<?php
echo htmlspecialchars($loginURL);
?>"><img src="assets/img/fb-login-btn.png" width="100%"></a>
							</center>
                        </form>
						</div>
						  <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
<?php
if (isset($_POST['register'])) {
	$captcha;
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);
    $email    = $_POST['email'];
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    if ($captcha) {
        $url          = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($row['gcaptcha_secretkey']) . '&response=' . urlencode($captcha);
        $response     = file_get_contents($url);
        $responseKeys = json_decode($response, true);
        //if ($responseKeys["success"]) { // Causing issues on some hosts
            
            $sql = mysqli_query($connect, "SELECT username FROM `players` WHERE username='$username'");
            if (mysqli_num_rows($sql) > 0) {
                echo '<br /><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' . lang_key("username_taken") . '</div>';
            } else {
                
                $sql2 = mysqli_query($connect, "SELECT email FROM `players` WHERE email='$email'");
                if (mysqli_num_rows($sql2) > 0) {
                    echo '<br /><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>  ' . lang_key("email_taken") . '</div>';
                } else {
                    $money    = $row['startmoney'];
                    $gold     = $row['startgold'];
                    $langcode = $rowld['langcode'];
                    
                    $insert = mysqli_query($connect, "INSERT INTO `players` (`username`, `password`, `email`, `money`, `gold`, `language`) VALUES ('$username', '$password', '$email', '$money', '$gold', '$langcode')");
                    
                    $subject = 'Welcome at ' . $row['title'] . '';
                    $message = '
                                    <center>
                					<a href="' . $vcity_url . '" title="Visit ' . $row['title'] . '" target="_blank">
                					<h1>' . $row['title'] . '</h1>
                					</a><br />

                					<h2>You have successfully registered at ' . $row['title'] . '</h2><br /><br />

                					<b>Registration details:</b><br />
                					Username: ' . $username . '<b></b><br />
                					</center>
                				    ';
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                    $headers .= 'To: ' . $email . ' <' . $email . '>' . "\r\n";
                    $headers .= 'From: vcity@mail.com <vcity@mail.com>' . "\r\n";
                    @mail($email, $subject, $message, $headers);
                    
                    $_SESSION['username'] = $username;
                    echo '<meta http-equiv="refresh" content="0;url=home.php">';
                }
            }
        //}
    }
}
?>
                <form action="" method="post">
                    <div class="form-group">
                        <span style="width:100%;"><?php
echo lang_key("username");
?></span>
                <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><em class="fa fa-fw fa-user"></em></div>
  </div>
                            <input name="username" type="text" placeholder="<?php
echo lang_key("username");
?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <span style="width:100%;"><?php
echo lang_key("email");
?></span>
                <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><em class="fa fa-fw fa-envelope"></em></div>
  </div>
                            <input name="email" type="email" placeholder="<?php
echo lang_key("email");
?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <span style="width:100%;"><?php
echo lang_key("password");
?></span>
                 <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><em class="fa fa-fw fa-key"></em></div>
  </div>
                            <input name="password" type="password" placeholder="<?php
echo lang_key("password");
?>" class="form-control" required>
                        </div>
                    </div>
					<div class="g-recaptcha" data-sitekey="<?php
echo $row['gcaptcha_sitekey'];
?>"></div><br />
                    <div class="btn-toolbar">
                        <button type="submit" name="register" class="btn btn-success btn-md btn-block"><i class="fa fa-pen-square"></i> <?php
echo lang_key("register");
?></button>
                    </div>
                </form>
						  </div>
						  <div class="tab-pane fade" id="forgotpass" role="tabpanel" aria-labelledby="forgotpass-tab">
                <?php
$error = "No";

if (isset($_POST['forgpass'])) {
    $emailf = filter_var($_POST['emailf'], FILTER_SANITIZE_EMAIL);
    $emailf = filter_var($_POST['emailf'], FILTER_VALIDATE_EMAIL);
    $check  = mysqli_query($connect, "SELECT email FROM `players` WHERE `email`='$emailf'");
    if (mysqli_num_rows($check) <= 0) {
        $error = "Yes";
    } else {
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
        $expDate   = date("Y-m-d H:i:s", $expFormat);
        @$key = md5(2418 * 2 + $emailf);
        $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
        $key    = $key . $addKey;
        mysqli_query($connect, "INSERT INTO `password_reset` (`email`, `resetkey`, `expiry_date`)
VALUES ('" . $emailf . "', '" . $key . "', '" . $expDate . "');");
        
        $subject = '' . $row['title'] . ' - Reset Password';
        $message = '
                                    <center>
                					<a href="' . $vcity_url . '" title="Visit ' . $row['title'] . '" target="_blank">
                					<h1>' . $row['title'] . ' - Reset Password</h1>
                					</a><br />

                					<h2>Please click on the following link to reset your password: </h2>
		<p><a href="' . $vcity_url . '/reset-password.php?key=' . $key . '">' . $vcity_url . '/reset-password.php?key=' . $key . '</a></p>
                					</center>
                				    ';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'To: ' . $emailf . ' <' . $emailf . '>' . "\r\n";
        $headers .= 'From: vcity@mail.com <vcity@mail.com>' . "\r\n";
        @mail($emailf, $subject, $message, $headers);
        
        echo '<br />
                		<div class="alert alert-primary">
                              <i class="fa fa-envelope"></i> ' . lang_key("message_sent") . '
                        </div>';
        
    }
}
?>
                <form action="" method="post">
                    <div class="form-group">
                        <span style="width:100%;"><?php
echo lang_key("email");
?></span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><em class="fa fa-fw fa-envelope"></em></div>
          </div>
                            <input name="emailf" type="text" placeholder="<?php
echo lang_key("email");
?>" class="form-control" <?php
if ($error == "Yes") {
    echo 'autofocus';
}
?> required>
                        </div><br />
						<div class="btn-toolbar">
                                <button type="submit" name="forgpass" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-in-alt"></i> <?php
echo lang_key("reset_password");
?></button>
                            </div>
                            </form>
                    </div>
						  </div>
						</div>
                    </div>
                </div>
            </div>
        </div>

	<div class="container-fluid">
                <div class="row">
                    <div class="col-md-4" id="screenshots">
                        <div class="card bg-light card-body mb-3">
                            <center>
                                <h5><i class="fa fa-images"></i> <?php
echo lang_key("screenshots_full");
?></h5>
                                <hr />
                            </center>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-body mb-3">
                                        <a href="images/screenshots/1.png" target="_blank">
                                            <img src="images/screenshots/1.png" width="100%" height="150" style="border:1px solid #BFBFBF;" />
                                        </a>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="card card-body mb-3">
                                        <a href="images/screenshots/2.png" target="_blank">
                                            <img src="images/screenshots/2.png" width="100%" height="150" style="border:1px solid #BFBFBF;" />
                                        </a>
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">
                                    <div class="card card-body mb-3">
                                        <a href="images/screenshots/3.png" target="_blank">
                                            <img src="images/screenshots/3.png" width="100%" height="150" style="border:1px solid #BFBFBF;" />
                                        </a>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="card card-body mb-3">
                                        <a href="images/screenshots/4.png" target="_blank">
                                            <img src="images/screenshots/4.png" width="100%" height="150" style="border:1px solid #BFBFBF;" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" id="join">
                        <div class="card bg-light card-body mb-3">
						<center>
							<h5><i class="fa fa-chart-bar"></i> <?php
echo lang_key("stats");
?></h5>
						</center>
                                <hr />    
<h6><i class="fas fa-check-circle"></i> <?php
echo lang_key("online_players");
?>: <span class="badge badge-success"><?php
echo $countop;
?></span></h6>
                    <h6><i class="fa fa-users"></i> <?php
echo lang_key("total_players");
?>: <span class="badge badge-primary"><?php
echo $counttp;
?></span></h6>
                    <h6><i class="fa fa-trophy"></i> <?php
echo lang_key("best_player");
?>: <span class="badge badge-danger"><?php
echo $best_player;
?></span></h6>
                    <h6><i class="fa fa-user-plus"></i> <?php
echo lang_key("newest_player");
?>: <span class="badge badge-warning"><?php
echo $newest_player;
?></span></h6>
<br />
<h6><i class="fas fa-crosshairs"></i> <?php
echo lang_key("fights");
?>: <span class="badge badge-danger"><?php
echo $countf;
?></span></h6>
                    <h6><i class="fa fa-flag-checkered"></i> <?php
echo lang_key("street-races");
?>: <span class="badge badge-warning"><?php
echo $countr;
?></span></h6>
                    <h6><i class="fa fa-store"></i> <?php
echo lang_key("items");
?>: <span class="badge badge-success"><?php
echo $counti;
?></span></h6>
                    <h6><i class="fa fa-car"></i> <?php
echo lang_key("vehicles");
?>: <span class="badge badge-primary"><?php
echo $countv;
?></span></h6>
                        </div>
                    </div>

                    <div class="col-md-4" id="about">
                        <div class="card bg-light card-body mb-3">
                            <center>
                                <h5><i class="far fa-file-alt"></i> <?php
echo lang_key("about");
?></h5>
                                <hr />
                            </center>
                            <?php
echo html_entity_decode($row['about']);
?>
                        </div>
                    </div>
                </div>

<?php
    $queryaf = mysqli_query($connect, "SELECT * FROM `ads` WHERE position='Footer' ORDER BY RAND() LIMIT 1");
    while ($rowaf = mysqli_fetch_array($queryaf)) {
        echo html_entity_decode($rowaf['code']);
    }
?>

    </div>
    <!-- /container -->

    <footer class="footer">
        <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

            <div class="float-right">&copy; <?php
echo date("Y");
?> <?php
echo $row['title'];
?></div>
            <a href="#" class="go-top"><i class="fa fa-arrow-up"></i></a>

			</div>
		</div>
        </div>
    </footer>

    <!-- JavaScript Libraries
    ================================================== -->    

    <!-- Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <!-- Game JS -->
    <script src="assets/js/game.js"></script>

</body>
</html>