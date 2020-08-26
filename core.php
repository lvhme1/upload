<?php
require "config.php";

if (basename($_SERVER['SCRIPT_NAME']) != 'paypal-ipn.php') {
    $_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
}

if (basename($_SERVER['SCRIPT_NAME']) != 'paypal-ipn.php' AND basename($_SERVER['SCRIPT_NAME']) != 'page.php') {
    if (isset($_SESSION['username'])) {
        $uname = $_SESSION['username'];
        $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
        $rowu  = mysqli_fetch_assoc($suser);
        $count = mysqli_num_rows($suser);
        if ($count <= 0) {
            echo '<meta http-equiv="refresh" content="0; url=index.php" />';
            exit;
        }
    } else {
        echo '<meta http-equiv="refresh" content="0; url=index.php" />';
        exit;
    }
}

if (isset($_GET['lang'])) {
    $langcode = $_GET["lang"];
    $queryls  = mysqli_query($connect, "SELECT * FROM `languages` WHERE langcode='$langcode'");
    $rowls    = mysqli_fetch_assoc($queryls);
    $countls  = mysqli_num_rows($queryls);
    if ($countls > 0) {
        $querytu = mysqli_query($connect, "UPDATE `players` SET language='$langcode' WHERE username='$uname'");
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
    }
}

@include 'languages/' . $rowu['language'] . '.php';

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

if (isset($_GET['delchat_id'])) {
    $id        = (int) $_GET["delchat_id"];
    $querychd  = mysqli_query($connect, "SELECT * FROM `global_chat` WHERE id='$id'");
    $rowchd    = mysqli_fetch_assoc($querychd);
    $author_id = $rowchd['player_id'];
    $countchd  = mysqli_num_rows($querychd);
    if ($countchd > 0 && ($rowu['id'] == $author_id || $rowu['role'] == 'Admin')) {
        $query = mysqli_query($connect, "DELETE FROM `global_chat` WHERE id='$id'");
    }
}

function percent($num_amount, $num_total)
{
    @$count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    $count  = number_format($count2, 0);
    return $count;
}

function secondsToWords($seconds)
{
    $ret = "";
    
    //Days
    $mdays = intval(intval($seconds) / (3600 * 24));
    if ($mdays > 0) {
        $ret .= "$mdays days ";
    }
    
    //Hours
    $mhours = (intval($seconds) / 3600) % 24;
    if ($mhours > 0) {
        $ret .= "$mhours hours ";
    }
    
    //Minutes
    $mminutes = (intval($seconds) / 60) % 60;
    if ($mminutes > 0) {
        $ret .= "$mminutes minutes ";
    }
    
    /*
    //Seconds
    $seconds = intval($seconds) % 60;
    if ($seconds > 0) {
    $ret .= "$seconds seconds";
    }*/
    
    return $ret;
}

function emoticons($text)
{
    $icons = array(
        ':)' => '🙂',
        ':-)' => '🙂',
        ':}' => '🙂',
        ':D' => '😀',
        ':d' => '😁',
        ':-D ' => '😂',
        ';D' => '😂',
        ';d' => '😂',
        ';)' => '😉',
        ';-)' => '😉',
        ':P' => '😛',
        ':-P' => '😛',
        ':-p' => '😛',
        ':p' => '😛',
        ':-b' => '😛',
        ':-Þ' => '😛',
        ':(' => '🙁',
        ';(' => '😓',
        ':\'(' => '😓',
        ':o' => '😮',
        ':O' => '😮',
        ':0' => '😮',
        ':-O' => '😮',
        ':|' => '😐',
        ':-|' => '😐',
        ' :/' => ' 😕',
        ':-/' => '😕',
        ':X' => '😷',
        ':x' => '😷',
        ':-X' => '😷',
        ':-x' => '😷',
        '8)' => '😎',
        '8-)' => '😎',
        'B-)' => '😎',
        ':3' => '😊',
        '^^' => '😊',
        '^_^' => '😊',
        '<3' => '😍',
        ':*' => '😘',
        'O:)' => '😇',
        '3:)' => '😈',
        'o.O' => '😵',
        'O_o' => '😵',
        'O_O' => '😵',
        'o_o' => '😵',
        '0_o' => '😵',
        'T_T' => '😵',
        '-_-' => '😑',
        '>:O' => '😆',
        '><' => '😆',
        '>:(' => '😣',
        ':v' => '🙃',
        '(y)' => '👍',
        ':poop:' => '💩',
        ':|]' => '🤖'
    );
    return strtr($text, $icons);
}

function headind()
{
    require "config.php";
    
    $query = mysqli_query($connect, "SELECT * FROM `settings` WHERE id='1' LIMIT 1");
    $row   = mysqli_fetch_assoc($query);
    
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>

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
                    <ul class="nav navbar-nav mr-sm-2">
                        <li><a href="index.php" class="nav-link btn btn-outline-success"><i class="fas fa-arrow-alt-circle-left"></i> Back to index</a></li>
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
  </nav>
</div><br />
<?php
}

function head()
{
    require "config.php";
    
    $query = mysqli_query($connect, "SELECT * FROM `settings` WHERE id='1' LIMIT 1");
    $row   = mysqli_fetch_assoc($query);
    
    $uname     = $_SESSION['username'];
    $suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu      = mysqli_fetch_assoc($suser);
    $player_id = $rowu['id'];
    
    $querypc      = mysqli_query($connect, "SELECT character_id FROM `players` WHERE username='$uname' LIMIT 1");
    $rowpc        = mysqli_fetch_assoc($querypc);
    $character_id = $rowpc['character_id'];
    $queryc       = mysqli_query($connect, "SELECT * FROM `characters` WHERE id='$character_id' LIMIT 1");
    $countc       = mysqli_num_rows($queryc);
    $rowc         = mysqli_fetch_assoc($queryc);
    if ($countc == 0 && basename($_SERVER['SCRIPT_NAME']) != 'choose-character.php') {
        echo '<meta http-equiv="refresh" content="0; url=choose-character.php" />';
        exit;
    }
    if ($countc > 0 && basename($_SERVER['SCRIPT_NAME']) == 'choose-character.php') {
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
    
    @include 'languages/' . $rowu['language'] . '.php';
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

<?php
    $querytg = mysqli_query($connect, "SELECT * FROM `themes` WHERE default_theme='Yes' LIMIT 1");
    $rowtg   = mysqli_fetch_assoc($querytg);
    if ($rowtg['navbar_colorscheme'] == 1) {
        $navbar_cscheme = 'navbar-dark bg-dark';
    } elseif ($rowtg['navbar_colorscheme'] == 2) {
        $navbar_cscheme = 'navbar-dark bg-primary';
    } elseif ($rowtg['navbar_colorscheme'] == 3) {
        $navbar_cscheme = 'navbar-light bg-light';
    } else {
        $navbar_cscheme = 'navbar-light';
    }
?>
    <!-- Skin -->
    <link href="<?php
    echo $rowtg['csspath'];
?>" rel="stylesheet">

    <!-- Game CSS -->
    <link href="assets/css/game.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" rel="stylesheet">

    <!-- Right Sidebar - Chat -->
    <link href="assets/css/sidebar.css" rel="stylesheet">
	
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'leaderboard.php' OR basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- DataTables -->
    <link href="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/datatables.min.css" rel="stylesheet">';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">';
    }
?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'casino.php' OR basename($_SERVER['SCRIPT_NAME']) == 'travelling.php') {
        echo '
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.4/TweenMax.min.js">';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'city-map.php') {
        echo '
	<!-- Image Map Resizer -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js">';
    }
?>
	
<script>
setInterval(function () {
    $("#playerstats").load("ajax.php #stats");
    $("#playerstats2").load('ajax.php #stats2');
    $("#playerskills").load('ajax.php #skills');
    $("#globalchat").load('ajax.php #chat');
    $("#onlineplayers").load('ajax.php #online');
}, 2000);
</script>
    
</head>

<body>
    <center>
        <nav class="navbar <?php
    echo $navbar_cscheme;
?> navbar-expand-md">
    <button type="button" class="navbar-toggler collapsed" data-toggle="collapse"
    data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only"><?php
    echo lang_key("navigation");
?></span>
&#x2630;</button>
                    <a class="navbar-brand d-block d-sm-none" href="home.php"><?php
    echo $row['title'];
?></a>
                <div id="navbar" class="navbar-collapse collapse justify-content-md-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'home.php') {
        echo 'active';
    }
?>"><a href="home.php" class="nav-link"><i class="fa fa-home fa-2x"></i><br /> <?php
    echo lang_key("home");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'vehicles.php') {
        echo 'class="active"';
    }
?>><a href="vehicles.php" class="nav-link"><i class="fa fa-car fa-2x"></i><br /> <?php
    echo lang_key("vehicles");
?></span></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'properties.php') {
        echo 'class="active"';
    }
?>><a href="properties.php" class="nav-link"><i class="fa fa-building fa-2x"></i><br /> <?php
    echo lang_key("properties");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'pets.php') {
        echo 'class="active"';
    }
?>><a href="pets.php" class="nav-link"><i class="fa fa-paw fa-2x"></i><br /> <?php
    echo lang_key("pets");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'shop.php') {
        echo 'class="active"';
    }
?>><a href="shop.php" class="nav-link"><i class="fa fa-shopping-cart fa-2x"></i><br /> <?php
    echo lang_key("shop");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'jobs.php') {
        echo 'class="active"';
    }
?>><a href="jobs.php" class="nav-link"><i class="fa fa-briefcase fa-2x"></i><br /> <?php
    echo lang_key("work");
?> 
<?php
    $querygt = mysqli_query($connect, "SELECT `job_type` FROM `jobs`");
    while ($rowgt = mysqli_fetch_assoc($querygt)) {
        $type = $rowgt['job_type'];
        
        $querypas = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpas = mysqli_num_rows($querypas);
        $rowpas   = mysqli_fetch_assoc($querypas);
        
        if ($countpas > 0) {
            if (time() >= $rowpas['finishtime']) {
                echo '<span class="badge"><i class="fa fa-check"></i></span>';
            } else {
                echo '<span class="badge"><i class="fas fa-clock"></i></span>';
            }
        }
    }
?>
</a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'gym.php') {
        echo 'class="active"';
    }
?>><a href="gym.php" class="nav-link"><i class="fa fa-male fa-2x"></i><br /> <?php
    echo lang_key("gym");
?> 
<?php
    $querygt = mysqli_query($connect, "SELECT `workout_type` FROM `gym`");
    while ($rowgt = mysqli_fetch_assoc($querygt)) {
        $type = $rowgt['workout_type'];
        
        $querypas = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpas = mysqli_num_rows($querypas);
        $rowpas   = mysqli_fetch_assoc($querypas);
        
        if ($countpas > 0) {
            if (time() >= $rowpas['finishtime']) {
                echo '<span class="badge"><i class="fa fa-check"></i></span>';
            } else {
                echo '<span class="badge"><i class="fas fa-clock"></i></span>';
            }
        }
    }
?>
</a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'school.php') {
        echo 'class="active"';
    }
?>><a href="school.php" class="nav-link"><i class="fa fa-graduation-cap fa-2x"></i><br /> <?php
    echo lang_key("school");
?> 
<?php
    $querygt = mysqli_query($connect, "SELECT `subject` FROM `school`");
    while ($rowgt = mysqli_fetch_assoc($querygt)) {
        $type = $rowgt['subject'];
        
        $querypas = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpas = mysqli_num_rows($querypas);
        $rowpas   = mysqli_fetch_assoc($querypas);
        
        if ($countpas > 0) {
            if (time() >= $rowpas['finishtime']) {
                echo '<span class="badge"><i class="fa fa-check"></i></span>';
            } else {
                echo '<span class="badge"><i class="fas fa-clock"></i></span>';
            }
        }
    }
?>
</a></li>

                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'city-map.php') {
        echo 'class="active"';
    }
?>><a href="city-map.php" class="nav-link"><i class="far fa-map fa-2x"></i><br /> <?php
    echo lang_key("city-map");
?></a></li>

                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bank.php') {
        echo 'class="active"';
    }
?>><a href="bank.php" class="nav-link"><i class="fa fa-university fa-2x"></i><br /> <?php
    echo lang_key("bank");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'hospital.php') {
        echo 'class="active"';
    }
?>><a href="hospital.php" class="nav-link"><i class="fa fa-hospital fa-2x"></i><br /> <?php
    echo lang_key("hospital");
?> 
<?php
    $querygt = mysqli_query($connect, "SELECT `treatment_type` FROM `hospital`");
    while ($rowgt = mysqli_fetch_assoc($querygt)) {
        $type = $rowgt['treatment_type'];
        
        $querypas = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE type = '$type' AND player_id='$player_id' LIMIT 1");
        $countpas = mysqli_num_rows($querypas);
        $rowpas   = mysqli_fetch_assoc($querypas);
        
        if ($countpas > 0) {
            if (time() >= $rowpas['finishtime']) {
                echo '<span class="badge"><i class="fa fa-check"></i></span>';
            } else {
                echo '<span class="badge"><i class="fas fa-clock"></i></span>';
            }
        }
    }
?>
</a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'street-races.php') {
        echo 'class="active"';
    }
?>><a href="races.php" class="nav-link"><i class="fa fa-flag-checkered fa-2x"></i><br /> <?php
    echo lang_key("street-races");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'fight-arena.php') {
        echo 'class="active"';
    }
?>><a href="fight-arena.php" class="nav-link"><i class="fa fa-crosshairs fa-2x"></i><br /> <?php
    echo lang_key("fights");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'leaderboard.php') {
        echo 'class="active"';
    }
?>><a href="leaderboard.php" class="nav-link"><i class="fa fa-trophy fa-2x"></i><br /> <?php
    echo lang_key("leaderboard");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'resources.php') {
        echo 'class="active"';
    }
?>><a href="resources.php" class="nav-link"><i class="fa fa-dollar-sign fa-2x"></i><br /> <?php
    echo lang_key("resources");
?></a></li>
                    </ul>
			   </div>
        </nav>
    </center>
	
	<div class="nav-scroller bg-info shadow-sm">
  <nav class="nav nav-underline">
<?php
    $runcp = mysqli_query($connect, "SELECT * FROM `custom_pages`");
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
	
	<br />

    <div class="container-fluid">

        <div class="row">
             <div class="col-lg-3 user-stats">
            <div class="card bg-light card-body mb-3">
                    <h6><i class="fa fa-user"></i> <?php
    echo $rowu['username'];
?> 
<?php
    if ($rowu['role'] == "Admin") {
        echo '<span class="badge badge-danger"><i class="fa fa-bookmark"></i> ' . $rowu['role'] . '</span> ';
    }
    
    if ($rowu['role'] == "VIP") {
        echo '<span class="badge badge-warning"><i class="fa fa-star"></i> ' . $rowu['role'] . '</span> ';
    }
?>
                    </h6>
                    <hr />
                    <div class="row">
                        <div class="col-md-5">
                            <center><img src="<?php
    echo $rowu['avatar'];
?>" width="100%" /></center>
                        </div>
                        <div class="col-md-7" id="playerstats">
                            <div id="stats">
<h6><i class="far fa-money-bill-alt"></i> <?php
    echo lang_key("money");
?>: <span class="badge badge-success"><?php
    echo $rowu['money'];
?></span></h6>
                            <h6><i class="fa fa-inbox"></i> <?php
    echo lang_key("gold");
?>: <span class="badge badge-warning"><?php
    echo $rowu['gold'];
?></span></h6>
                            <h6><i class="fa fa-server"></i> <?php
    echo lang_key("level");
?>: <span class="badge badge-secondary"><?php
    echo $rowu['level'];
?></span></h6>
                            <h6><i class="fa fa-star"></i> <?php
    echo lang_key("respect");
?>: <span class="badge badge-primary"><?php
    echo $rowu['respect'];
?></span></h6>
<?php
    $userid  = $rowu['id'];
    $queryum = mysqli_query($connect, "SELECT * FROM `messages` WHERE toid='$rowu[id]' AND viewed='No'");
    $countum = mysqli_num_rows($queryum);
?>
                            <h6><i class="fa fa-envelope"></i> <?php
    echo lang_key("messages");
?>: <a href="messages.php"><?php
    echo $countum;
?></a></h6>
</div>
                        </div>
                    </div>
                    <hr />
                    <h6>
                    <a href="settings.php" class="btn btn-primary float-left" title="<?php
    echo lang_key("account-settings");
?>"><i class="fa fa-cogs"></i></a>&nbsp;
                    <a href="messages.php" class="btn btn-success"><i class="fa fa-envelope"></i> <?php
    echo lang_key("messages");
?></a>
<?php
    if ($rowu['role'] == 'Admin') {
?>
                    <a href="admin" class="btn btn-info"><i class="fa fa-cogs"></i> <?php
        echo lang_key("admin-panel");
?></a>
<?php
    }
?>
                    <a href="logout.php" class="btn btn-danger float-right" title="<?php
    echo lang_key("logout");
?>"><i class="fa fa-sign-out-alt"></i></a>
                </h6>
                </div>
            </div>

            <div class="col-md-6 text-center page-header">
			<br />
                <h4 class="game-name">
                <strong><i class="fa fa-building"></i> <i class="fa fa-car"></i> <i class="fa fa-users"></i> <?php
    echo $row['title'];
?></strong>
                <small><br /><?php
    echo $row['description'];
?></small>
                </h4>
                <hr />
                <div class="col-lg-12" id="playerstats2">
                    <div id="stats2">
					<div class="row">
                    <div class="col-lg-6">
                        <h6><i class="fa fa-heart"></i> <?php
    echo lang_key("health");
?></h6>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: <?php
    echo $rowu['health'];
?>%;">
                                <span><?php
    echo $rowu['health'];
?> / 100</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h6><i class="fa fa-bolt"></i> <?php
    echo lang_key("energy");
?></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?php
    echo $rowu['energy'];
?>%;">
                                <span><?php
    echo $rowu['energy'];
?> / 100</span>
                            </div>
                        </div>
                    </div>
</div>             </div>
                </div>
            </div>

            <div class="col-lg-3 user-stats">
            <div class="card bg-light card-body mb-3" id="playerskills">
                    <div id="skills">
                <h6><i class="fa fa-child"></i> <?php
    echo lang_key("power");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-warning" style="width: <?php
    echo percent($rowu['power'], 250);
?>%;">
                        <span><?php
    echo $rowu['power'];
?> / 250</span>
                    </div>
                </div>
                <h6><i class="fa fa-retweet"></i> <?php
    echo lang_key("agility");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-danger" style="width: <?php
    echo percent($rowu['agility'], 250);
?>%;">
                        <span><?php
    echo $rowu['agility'];
?> / 250</span>
                    </div>
                </div>
                <h6><i class="fa fa-heartbeat"></i> <?php
    echo lang_key("endurance");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-success" style="width: <?php
    echo percent($rowu['endurance'], 250);
?>%;">
                        <span><?php
    echo $rowu['endurance'];
?> / 250</span>
                    </div>
                </div>
                <h6><i class="fab fa-usb"></i> <?php
    echo lang_key("intelligence");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-info" style="width: <?php
    echo percent($rowu['intelligence'], 250);
?>%;">
                        <span><?php
    echo $rowu['intelligence'];
?> / 250</span>
                    </div>
                </div>
</div>
                </div>
            </div>
        </div>
	</div>
        
    <div class="container-fluid">
        <div class="row card-body bg-light">
            <div class="col-md-1">
                <h6><span class="badge badge-danger"><i class="fa fa-info-circle"></i> <?php
    echo lang_key("useful-tips");
?>: </span></h6>
            </div>
            <div class="col-md-8">
<?php
    if ($row['tips_effect'] == 1) {
?>
                <marquee behavior="scroll" direction="left" scrollamount="12">
                    <h6>
<?php
        $querygt = mysqli_query($connect, "SELECT * FROM `tips` ORDER BY rand()");
        while ($rowgt = mysqli_fetch_assoc($querygt)) {
            echo $rowgt['tip'];
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
?>
                    </h6>
                </marquee>
<?php
    } else {
?>
                <div id="random_text"></div>
				<script>
				var textarray = [
<?php
        $querygt  = mysqli_query($connect, "SELECT * FROM `tips` ORDER BY rand()");
        $querygtc = mysqli_num_rows($querygt);
        $i        = 0;
        while ($rowgt = mysqli_fetch_assoc($querygt)) {
            echo '"';
            echo $rowgt['tip'];
            echo '"';
            
            if ($i + 1 != $querygtc) {
                echo ',';
            }
            
            $i++;
        }
?>
];

function RndText() 
{
    var rannum = Math.floor(Math.random() * textarray.length);
    
    $('#random_text').fadeOut('fast', function() { 
        $(this).text(textarray[rannum]).fadeIn('fast');
    });
}

$(function() {
    RndText(); 
});
var inter = setInterval(function() { RndText(); }, 4000);
				</script>
<?php
    }
?>
            </div>
<?php
    $timeon  = time() - 60;
    $queryop = mysqli_query($connect, "SELECT * FROM `players` WHERE timeonline>$timeon");
    $countop = mysqli_num_rows($queryop);
?>
            <div class="col-md-2" id="onlineplayers">
                <div id="online">
                    <a href="leaderboard.php?tab=onlineplayers" class="btn btn-success btn-block float-right"><i class="fa fa-users"></i> <?php
    echo lang_key("online-players");
?> &nbsp;&nbsp;<span class="badge badge-primary"><?php
    echo $countop;
?></span></a>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-primary btn-block float-right" data-toggle="sidebar" data-target=".sidebar-right"><i class="fa fa-comments"></i> <?php
    echo lang_key("chat");
?></button>
            </div>
        </div>
    </div>
	
	<br />

    <div class="col-md-2 sidebar sidebar-right sidebar-animate">
        <div class="row">
            <div class="col-md-10">
                <h4><i class="fa fa-comments"></i> <?php
    echo lang_key("chat");
?> </h4>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger float-right" data-toggle="sidebar" data-target=".sidebar-right"><i class="fa fa-times"></i></button>&nbsp;
            </div>
        </div>
        <hr />
        
        <form id="gchat" action="ajax.php" method="post">
            <textarea placeholder="Write a message" name="chatmessage" class="form-control" required></textarea>
            <br /><button type="submit" name="post_chatmessage" class="btn btn-primary btn-md btn-block float-right"><i class="fa fa-paper-plane"></i>&nbsp; <?php
    echo lang_key("send");
?></button>
        </form><br /><br /><br />
        
<script type="text/javascript">
    var frm = $('#gchat');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                document.getElementById("gchat").reset();
            }
        });

        ev.preventDefault();
    });
</script>

<div id="globalchat">
<div id="chat">
<?php
    $gtday   = date("d");
    $gtmonth = date("n");
    $gtyear  = date("Y");
    
    $gthour   = date("H");
    $gtminute = date("i");
    
    $querygc = mysqli_query($connect, "SELECT * FROM `global_chat` ORDER BY id DESC LIMIT 15");
    while ($rowgc = mysqli_fetch_assoc($querygc)) {
        $author_id = $rowgc['player_id'];
        $querygcp  = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$author_id' LIMIT 1");
        $rowgcp    = mysqli_fetch_assoc($querygcp);
?>
        <div class="card">
            <div class="card-header">
                <img src="<?php
        echo $rowgcp['avatar'];
?>" width="8%">&nbsp;&nbsp;<strong><a href="player.php?id=<?php
        echo $author_id;
?>"><?php
        echo $rowgcp['username'];
?></a></strong>
<?php
        if ($rowgc['player_id'] == $rowu['id'] OR $rowu['role'] == 'Admin') {
?>
            <a href="?delchat_id=<?php
            echo $rowgc['id'];
?>" class="btn btn-danger btn-sm float-right" title="Delete this message"><i class="fa fa-trash"></i></a>
<?php
        }
?>
			</div>
            <div class="card-body"><?php
        echo emoticons($rowgc['message']);
?></div>
            <div class="card-footer">
                <i class="fas fa-clock"></i> 
<?php
        $mgetdate = date_parse_from_format("d F Y", $rowgc['date']);
        $mgettime = date_parse_from_format("H:i", $rowgc['time']);
        $mday     = $mgetdate["day"];
        $mmonth   = $mgetdate["month"];
        $myear    = $mgetdate["year"];
        $mhour    = $mgettime["hour"];
        $mminute  = $mgettime["minute"];
        
        if ($myear != $gtyear) {
            $d_year = $gtyear - $myear;
            if ($d_year == 1) {
                $gsymbol = '';
            } else {
                $gsymbol = 's';
            }
            echo '' . $d_year . ' year' . $gsymbol . ' ago';
        } else {
            if ($mmonth != $gtmonth) {
                $d_month = $gtmonth - $mmonth;
                if ($d_month == 1) {
                    $gsymbol = '';
                } else {
                    $gsymbol = 's';
                }
                echo '' . $d_month . ' month' . $gsymbol . ' ago';
            } else {
                if ($mday != $gtday) {
                    $d_day = $gtday - $mday;
                    if ($d_day == 1) {
                        $gsymbol = '';
                    } else {
                        $gsymbol = 's';
                    }
                    echo '' . $d_day . ' day' . $gsymbol . ' ago';
                } else {
                    if ($mhour != $gthour) {
                        $d_hour = $gthour - $mhour;
                        if ($d_hour == 1) {
                            $gsymbol = '';
                        } else {
                            $gsymbol = 's';
                        }
                        echo '' . $d_hour . ' hour' . $gsymbol . ' ago';
                    } else {
                        if ($mminute != $gtminute) {
                            $d_minute = $gtminute - $mminute;
                            if ($d_minute == 1) {
                                $gsymbol = '';
                            } else {
                                $gsymbol = 's';
                            }
                            echo '' . $d_minute . ' minute' . $gsymbol . ' ago';
                        } else {
                            echo 'Just Now';
                        }
                    }
                }
            }
        }
        
?>
            </div>
        </div><br />
<?php
    }
?> 
</div>
</div>

    </div>
	
<?php
if ($rowu['role'] != 'VIP') {
    $queryah = mysqli_query($connect, "SELECT * FROM `ads` WHERE position='Header' ORDER BY RAND() LIMIT 1");
    while ($rowah = mysqli_fetch_array($queryah)) {
        echo html_entity_decode($rowah['code']);
    }
}
?>
<?php
}

function footer()
{
    require "config.php";
    
    $query = mysqli_query($connect, "SELECT * FROM `settings` WHERE id='1'");
    $rowst = mysqli_fetch_assoc($query);
	
	$uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu  = mysqli_fetch_assoc($suser);
?>

<?php
if ($rowu['role'] != 'VIP') {
    $queryaf = mysqli_query($connect, "SELECT * FROM `ads` WHERE position='Footer' ORDER BY RAND() LIMIT 1");
    while ($rowaf = mysqli_fetch_array($queryaf)) {
        echo html_entity_decode($rowaf['code']);
    }
}
?>

    </div>
    <!-- /container -->
	
    <footer class="footer clearfix">
        <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
			
            <div class="float-right">&copy; <?php
    echo date("Y");
?> <?php
    echo $rowst['title'];
?></div>
            <a href="#" class="go-top"><i class="fa fa-arrow-up"></i></a>
			
			</div>
		</div>
        </div>
    </footer>

    <!-- JavaScript Libraries
    ================================================== -->

    <!-- Bootstrap -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	
    <!-- Right Sidebar - Chat -->
    <script src="assets/js/sidebar.js"></script>
    
    <!-- Game JS -->
    <script src="assets/js/game.js"></script>
	
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'leaderboard.php' OR basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- DataTables -->
    <script src="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/datatables.min.js"></script>';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>';
    }
?>

</body>
</html>
<?php
}
?>