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

if (isset($_GET['theme'])) {
    $id      = (int) $_GET["theme"];
    $queryts = mysqli_query($connect, "SELECT * FROM `themes` WHERE id='$id'");
    $rowts   = mysqli_fetch_assoc($queryts);
    $countts = mysqli_num_rows($queryts);
    if ($countts > 0) {
        $_SESSION["csspath"] = $rowts['csspath'];
    }
}

if (isset($_GET["key"])) {
    $key     = $_GET["key"];
    $curDate = date("Y-m-d H:i:s");
    $query   = mysqli_query($connect, "SELECT * FROM `password_reset` WHERE `resetkey`='" . $key . "' LIMIT 1");
    $rowrr   = mysqli_num_rows($query);
    if ($rowrr <= 0) {
        echo '<meta http-equiv="refresh" content="0;url=' . $vcity_url . '" />';
        exit;
    } else {
        $rowrr   = mysqli_fetch_assoc($query);
        $email   = $rowrr['email'];
        $expDate = $rowrr['expiry_date'];
        if ($expDate < $curDate) {
            echo '<meta http-equiv="refresh" content="0;url=' . $vcity_url . '" />';
            exit;
        }
    }
} else {
    echo '<meta http-equiv="refresh" content="0;url=' . $vcity_url . '" />';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Skin -->
<?php
if (isset($_SESSION["csspath"])) {
?>
    <link href="<?php
    echo $_SESSION["csspath"];
?>" rel="stylesheet">
<?php
} else {
    $querytd = mysqli_query($connect, "SELECT * FROM `themes` WHERE `default_theme`='Yes'");
    $rowtd   = mysqli_fetch_assoc($querytd);
?>
    <link href="<?php
    echo $rowtd["csspath"];
?>" rel="stylesheet">
<?php
}
?>

    <!-- Game CSS -->
    <link href="assets/css/game.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" rel="stylesheet">

    <style type="text/css">
    .indbgr {
  background: url(assets/img/city2.jpg) no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
  </style>
</head>

<body>

    <center>
        <nav class="navbar navbar-dark bg-dark navbar-expand-md">
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
                        <li><a href="#gamelogin" class="nav-link"><i class="fa fa-sign-in-alt fa-2x"></i><br /> <?php
echo lang_key("signin");
?></a></li>
                        <li><a href="#join" class="nav-link"><i class="fa fa-user-plus fa-2x"></i><br /> <?php
echo lang_key("register");
?></a></li>
                    </ul>
			   </div>
        </nav>
    </center>

    <div class="container-fluid">

        <div class="jumbotron indbgr">
            <div class="row">
                <div class="col-md-7" style="color: black; text-shadow: 1px 1px #ffffff;">
                    <h2><i class="fa fa-building"></i> <i class="fa fa-car"></i> <i class="fa fa-users"></i> <?php
echo $row['title'];
?></h2>
                    <h5><?php
echo $row['description'];
?></h5>
                </div>
                <div class="col-lg-5 col-12" id="gamelogin">
                    <div class="card bg-light card-body mb-3">
                <?php
$error = "No";

if (isset($_POST['newpass'])) {
    $password = hash('sha256', $_POST['password']);
    $check    = mysqli_query($connect, "SELECT username, email FROM `players` WHERE `email`='$email'");
    if (mysqli_num_rows($check) <= 0) {
        $error = "Yes";
    } else {
        $querysd = mysqli_query($connect, "UPDATE `players` SET password='$password' WHERE `email`='$email'");
        $queryrd = mysqli_query($connect, "DELETE FROM `password_reset` WHERE email='$email'");
        
        $rowpusn              = mysqli_fetch_assoc($check);
        $pusname              = $rowpusn['username'];
        $_SESSION['username'] = $pusname;
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
    }
}
?>
                <form action="reset-password.php?key=<?php
echo $key;
?>" method="post">
					<center>
                                <h5><i class="fa fa-key"></i> <?php
echo lang_key("reset_password");
?></h5>
                                <hr />
                            </center>
                    <div class="form-group">
                        <label style="width:100%;"><?php
echo lang_key("new_password");
?></span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><em class="fa fa-fw fa-key"></em></div>
          </div>
                            <input name="password" type="password" placeholder="<?php
echo lang_key("password");
?>" class="form-control" <?php
if ($error == "Yes") {
    echo 'autofocus';
}
?> required>
                        </div><br />
						<div class="btn-toolbar">
                                <button type="submit" name="newpass" class="btn btn-info btn-md btn-block"><i class="fa fa-floppy"></i> <?php
echo lang_key("save");
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
    <!-- /container -->

    <footer class="footer">
        <div class="container-fluid">
		<div class="row">
            <div class="col-md-6">

		    <div class="btn-group dropup">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dlang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php
echo lang_key("languages");
?></button>
                <div class="dropdown-menu" aria-labelledby="dlang">
                    <a class="dropdown-item" href="?lang=<?php
echo $rowld['langcode'];
?>"><?php
echo $rowld['language'];
?> [<?php
echo lang_key("default");
?>]</a>
                    <div class="dropdown-divider"></div>
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
			</div>
			</div>
			<div class="btn-group dropup">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dthemes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php
echo lang_key("themes");
?></button>
                <div class="dropdown-menu" aria-labelledby="dthemes">
                    <a class="dropdown-item" href="?theme=<?php
echo $rowtd['id'];
?>"><?php
echo $rowtd['name'];
?> [<?php
echo lang_key("default");
?>]</a></li>
                    <div class="dropdown-divider"></div>
<?php
$queryt = mysqli_query($connect, "SELECT * FROM `themes`");
while ($rowt = mysqli_fetch_assoc($queryt)) {
?>
                    <a class="dropdown-item" href="?theme=<?php
    echo $rowt['id'];
?>"><?php
    echo $rowt['name'];
?></a></li>
<?php
}
?>
                </div>
            </div>
			</div>

			</div>
			<div class="col-md-6">

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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

    <!-- Game JS -->
    <script src="assets/js/game.js"></script>

</body>
</html>