<?php
require "config.php";

if (basename($_SERVER['SCRIPT_NAME']) != 'paypal-ipn.php') {
  $_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
}

function percent($num_amount, $num_total)
{
    @$count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    $count  = number_format($count2, 0);
    return $count;
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

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu  = mysqli_fetch_assoc($suser);
    $count = mysqli_num_rows($suser);
    if ($count <= 0) {
        exit;
    }

    include 'languages/' . $rowu['language'] . '.php';

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
?>

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

<?php
    $timeon  = time() - 60;
    $queryop = mysqli_query($connect, "SELECT * FROM `players` WHERE timeonline>$timeon");
    $countop = mysqli_num_rows($queryop);
?>

                <div id="online">
                    <a href="leaderboard.php?tab=onlineplayers" class="btn btn-success btn-block float-right"><i class="fa fa-users"></i> <?php
    echo lang_key("online-players");
?> &nbsp;&nbsp;<span class="badge badge-primary"><?php
    echo $countop;
?></span></a>
                </div>

<?php

    //Global Chat - Message Insert
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $chat_message = $_POST['chatmessage'];
        $player_id    = $rowu['id'];
        $date         = date('d F Y');
        $time         = date('H:i');

        $querygcm = mysqli_query($connect, "SELECT * FROM `global_chat` WHERE player_id='$player_id' AND message='$chat_message' AND date='$date' LIMIT 1");
        $countgcm = mysqli_num_rows($querygcm);
        if ($countgcm == 0 && $chat_message != "") {
            $post_gcmessage = mysqli_query($connect, "INSERT INTO `global_chat` (player_id, message, date, time) VALUES ('$player_id', '$chat_message', '$date', '$time')");
        }
    }

}
?>
