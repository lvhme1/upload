<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];
$levelu    = $rowu['level'];
$mlevel    = $levelu - 6;
$levelm    = $levelu + 6;

$date = date('d F Y');
$time = date('H:i');

if (isset($_GET['opponent'])) {
    
    $opponent_id = (int) $_GET['opponent'];
    
    $queryuo = mysqli_query($connect, "SELECT * FROM `players` WHERE username!='$uname' AND character_id>0 AND level>'$mlevel' AND level<'$levelm' AND health>=10 AND id='$opponent_id' LIMIT 1");
    
} else {
    $queryuo = mysqli_query($connect, "SELECT * FROM `players` WHERE username!='$uname' AND character_id>0 AND level>'$mlevel' AND level<'$levelm' AND health>=10 ORDER BY rand() LIMIT 1");
}

$rowuo   = mysqli_fetch_assoc($queryuo);
$countuo = mysqli_num_rows($queryuo);

$playero_id  = $rowuo['id'];
$characteru  = $rowu['character_id'];
$characteruo = $rowuo['character_id'];

$querypc  = mysqli_query($connect, "SELECT * FROM `characters` WHERE id='$characteru' LIMIT 1");
$rowpc    = mysqli_fetch_assoc($querypc);
$querypoc = mysqli_query($connect, "SELECT * FROM `characters` WHERE id='$characteruo' LIMIT 1");
$rowpoc   = mysqli_fetch_assoc($querypoc);

$querypac = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
$countpac = mysqli_num_rows($querypac);

$querypof = mysqli_query($connect, "SELECT * FROM `fights` WHERE playera_id='$player_id' AND playerb_id='$playero_id' AND date='$date'");
$countpof = mysqli_num_rows($querypof);

//Round 1 - Power
if ($rowu['power'] < $rowuo['power']) {
    $round1u  = 0;
    $round1uo = 1;
}
if ($rowu['power'] > $rowuo['power']) {
    $round1u  = 1;
    $round1uo = 0;
}
if ($rowu['power'] == $rowuo['power']) {
    $round1u  = 1;
    $round1uo = 1;
}

//Round 2 - Agility
if ($rowu['agility'] < $rowuo['agility']) {
    $round2u  = 0;
    $round2uo = 1;
}
if ($rowu['agility'] > $rowuo['agility']) {
    $round2u  = 1;
    $round2uo = 0;
}
if ($rowu['agility'] == $rowuo['agility']) {
    $round2u  = 1;
    $round2uo = 1;
}

//Round 3 - Endurance
if ($rowu['endurance'] < $rowuo['endurance']) {
    $round3u  = 0;
    $round3uo = 1;
}
if ($rowu['endurance'] > $rowuo['endurance']) {
    $round3u  = 1;
    $round3uo = 0;
}
if ($rowu['endurance'] == $rowuo['endurance']) {
    $round3u  = 1;
    $round3uo = 1;
}

//Round 4 - Intelligence
if ($rowu['intelligence'] < $rowuo['intelligence']) {
    $round4u  = 0;
    $round4uo = 1;
}
if ($rowu['intelligence'] > $rowuo['intelligence']) {
    $round4u  = 1;
    $round4uo = 0;
}
if ($rowu['intelligence'] == $rowuo['intelligence']) {
    $round4u  = 1;
    $round4uo = 1;
}

//Round 5 - Final (Calculations)
$round5u  = $round1u + $round2u + $round3u + $round4u;
$round5uo = $round1uo + $round2uo + $round3uo + $round4uo;

if ($round5u < $round5uo) {
    $winchance = 1;
}
if ($round5u == $round5uo) {
    $winchance = 2;
}
if ($round5u > $round5uo) {
    $winchance = 3;
}

if (isset($_GET['opponent'])) {
    
    if ($countpof > 2) {
        echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("cant-fightmore") . '</strong></center>
</div>';
    }
    
    if ($opponent_id != $player_id && $rowu['energy'] >= 10 && $rowu['health'] >= 10 && $rowuo['health'] >= 10 && $countuo > 0 && $countpac == 0 && $countpof < 3) {
        
        //Loss
        if ($winchance == 1) {
            $winner_id = $opponent_id;
        }
        
        //Last Chance
        if ($winchance == 2) {
            
            $lastchance = mt_rand(0, 1);
            
            if ($lastchance == 1) {
                $winner_id = $player_id;
            } else {
                $winner_id = $opponent_id;
            }
            
        }
        
        //Win
        if ($winchance == 3) {
            $winner_id = $player_id;
        }
        
        //Query
        if ($winner_id == $player_id) {
            
            $log_fight       = mysqli_query($connect, "INSERT INTO `fights` (playera_id, playerb_id, winner_id, date, time)
VALUES ('$player_id', '$opponent_id', '$winner_id', '$date', '$time')");
            $player_update   = mysqli_query($connect, "UPDATE `players` SET money=money+500, gold=gold+2, energy=energy-10, health=health-5, respect=respect+325 WHERE id='$player_id'");
            $opponent_update = mysqli_query($connect, "UPDATE `players` SET money=money-250, health=health-10 WHERE id='$opponent_id'");
            
            $content = '' . $rowu['username'] . ' challenged you to fight and he win the fight. You lost $250.';
            $message = mysqli_query($connect, "INSERT INTO `messages` (fromid, toid, date, time, content)
VALUES ('$player_id', '$opponent_id', '$date', '$time', '$content')");
            
            echo '
<div class="alert alert-success">
  <center><strong><i class="fa fa-trophy"></i> ' . lang_key("you-winf") . ' <br />' . lang_key("reward") . ': <span class="badge badge-success">$ 500</span> ' . lang_key("and") . ' <span class="badge badge-warning">2 ' . lang_key("gold") . '</span></strong></center>
</div>';
        } else {
            
            $log_fight       = mysqli_query($connect, "INSERT INTO `fights` (playera_id, playerb_id, winner_id, date, time)
VALUES ('$player_id', '$opponent_id', '$winner_id', '$date', '$time')");
            $player_update   = mysqli_query($connect, "UPDATE `players` SET money=money-250, energy=energy-10, health=health-10 WHERE id='$player_id'");
            $opponent_update = mysqli_query($connect, "UPDATE `players` SET money=money+500, gold=gold+2, health=health-5, respect=respect+325 WHERE id='$opponent_id'");
            
            $content = '' . $rowu['username'] . ' challenged you to fight and you win the fight. You earned $500 and 2 gold.';
            $message = mysqli_query($connect, "INSERT INTO `messages` (fromid, toid, date, time, content)
VALUES ('$player_id', '$opponent_id', '$date', '$time', '$content')");
            
            echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-trophy"></i> ' . lang_key("you-losef") . '</strong></center>
</div>';
        }
        
    }
}
?>
<div class="card"><div class="card-header text-white bg-primary"><i class="fa fa-crosshairs"></i> <?php
echo lang_key("fight-arena");
?></div>
	<div class="card-body">
	
    <center><h4><i class="fa fa-crosshairs"></i> <?php
echo lang_key("fight-arena");
?></h4></center><br />
	
<?php
if ($countpac > 0) {
    echo '
<div class="alert alert-warning">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("busy") . '</strong></center>
</div>';
}

if ($rowu['energy'] < 10) {
    echo '
<div class="alert alert-info">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("no-energytf") . '</strong></center>
</div>';
}

if ($rowu['health'] < 10) {
    echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("no-healthtf1") . ' <a href="hospital.php"><i class="fa fa-hospital"></i> ' . lang_key("hospital") . '</a> ' . lang_key("no-health2") . '</strong></center>
</div>';
}

if ($countuo <= 0) {
    echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("no-fighters") . '</strong></center>
</div>';
}
?>

    <div class="col-md-12">
	
	    <div class="row">
	        <div class="col-md-3">
			
			<img src="<?php
echo $rowpc['image'];
?>" width="100%" style="border:8px solid #ccc; border-radius:15px;" />
			<br /><br />
			<div class="card">
            <div class="card-header text-white bg-primary"><center><i class="fa fa-archive"></i> <?php
echo lang_key("your-items");
?></center></div>
                <div class="card-body">
				<div class="row">
<?php
$querypi  = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$player_id' LIMIT 9");
$querypin = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$player_id'");
$countpi  = mysqli_num_rows($querypi);

if ($countpi > 0) {
    while ($rowpi = mysqli_fetch_assoc($querypi)) {
        
        $item_id = $rowpi['item_id'];
        $queryi  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$item_id'");
        $rowi    = mysqli_fetch_assoc($queryi);
?>
                            <div class="col-md-4">
                                <center>
                                    <img src="<?php
        echo $rowi['image'];
?>" class="item-border" width="98%" data-toggle="tooltip" data-placement="top" title="<?php
        echo $rowi['item'];
?>" />
                                <hr /></center>
                            </div>
<?php
    }
    echo '
<div id="myitems" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-archive"></i> ' . lang_key("your-items") . '</h5>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
	  <div class="row">
';
    while ($rowpin = mysqli_fetch_assoc($querypin)) {
        
        $itemn_id = $rowpin['item_id'];
        $queryin  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$itemn_id'");
        $rowin    = mysqli_fetch_assoc($queryin);
        echo '
                            <div class="col-md-3">
                                <center>
                                    <img src="' . $rowin['image'] . '" class="item-border" width="100%" data-toggle="tooltip" data-placement="top" title="' . $rowin['item'] . '" />
                                    <span class="badge badge-primary">+ ' . $rowin['bonusvalue'] . ' ' . $rowin['bonustype'] . '</span>
                                <hr /></center>
                            </div>
';
    }
    echo '
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
      </div>
    </div>

  </div>
</div>
	';
    echo '<br /><a href="#" class="btn btn-secondary mx-auto" data-toggle="modal" data-target="#myitems"><i class="fa fa-search"></i> ' . lang_key("view-all-items") . '</a>';
} else {
    echo '<center><div class="alert alert-info mx-auto"><i class="fa fa-info-circle"></i> ' . lang_key("yno-items") . '</div>
          <div class="alert alert-success mx-auto"><center><a href="shop.php" class="btn btn-success btn-md"><i class="fa fa-cart-plus"></i>&nbsp;&nbsp;' . lang_key("buy-items") . '</a></center></div>';
}
?>
			    </div></div>
            </div>
			
			</div>
			<div class="col-md-6">
			
			<div class="row">
			    <div class="col-md-6">
				<div class="well">
				<center>
				    <h3><a href="player.php?id=<?php
echo $player_id;
?>" style="text-decoration: none;"><span class="badge badge-secondary"><img src="<?php
echo $rowu['avatar'];
?>" width="9%" />&nbsp; <?php
echo $rowu['username'];
?></span></a></h3><br />
					<h5><i class="fa fa-server"></i> <?php
echo lang_key("level");
?>: <span class="badge badge-primary"><?php
echo $levelu;
?></span></h5><hr /><br />
				</center>
				
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
				
				<div class="col-md-6">
				<div class="well">
<?php
if ($countuo > 0) {
?>
				<center>
				    <h3><a href="player.php?id=<?php
    echo $playero_id;
?>" style="text-decoration: none;"><span class="badge badge-secondary"><img src="<?php
    echo $rowuo['avatar'];
?>" width="9%" />&nbsp; <?php
    echo $rowuo['username'];
?></span></a></h3><br />
					<h5><i class="fa fa-server"></i> <?php
    echo lang_key("level");
?>: <span class="badge badge-primary"><?php
    echo $rowuo['level'];
?></span></h5><hr /><br />
				</center>
				
				<h6><i class="fa fa-child"></i> <?php
    echo lang_key("power");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-warning" style="width: <?php
    echo percent($rowuo['power'], 250);
?>%;">
                        <span><?php
    echo $rowuo['power'];
?> / 250</span>
                    </div>
                </div>
                <h6><i class="fa fa-retweet"></i> <?php
    echo lang_key("agility");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-danger" style="width: <?php
    echo percent($rowuo['agility'], 250);
?>%;">
                        <span><?php
    echo $rowuo['agility'];
?> / 250</span>
                    </div>
                </div>
                <h6><i class="fa fa-heartbeat"></i> <?php
    echo lang_key("endurance");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-success" style="width: <?php
    echo percent($rowuo['endurance'], 250);
?>%;">
                        <span><?php
    echo $rowuo['endurance'];
?> / 250</span>
                    </div>
                </div>
                <h6><i class="fab fa-usb"></i> <?php
    echo lang_key("intelligence");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-info" style="width: <?php
    echo percent($rowuo['intelligence'], 250);
?>%;">
                        <span><?php
    echo $rowuo['intelligence'];
?> / 250</span>
                    </div>
                </div>
<?php
} else {
    echo '<center><i class="fa fa-question-circle fa-5x"></i></center>';
}
?>
				</div>
				</div>
			</div><br />
			
			<div class="col-md-12 card-body bg-light">
			<div class="row">
			<div class="col-md-4">
			    <h5><i class="fa fa-cube fa-fw"></i> <?php
echo lang_key("chance-win");
?>:</h5>
			</div>
			<div class="col-md-8">
				<h4>
<?php
if ($winchance == 1) {
    echo '<span class="badge badge-danger">' . lang_key("little") . '</span> &nbsp;&nbsp;/&nbsp;&nbsp; ';
} else {
    echo '<span class="badge badge-default">' . lang_key("little") . '</span> &nbsp;&nbsp;/&nbsp;&nbsp; ';
}

if ($winchance == 2) {
    echo '<span class="badge badge-warning">' . lang_key("average") . '</span> &nbsp;&nbsp;/&nbsp;&nbsp; ';
} else {
    echo '<span class="badge badge-default">' . lang_key("average") . '</span> &nbsp;&nbsp;/&nbsp;&nbsp; ';
}

if ($winchance == 3) {
    echo '<span class="badge badge-success">' . lang_key("big") . '</span>';
} else {
    echo '<span class="badge badge-default">' . lang_key("big") . '</span>';
}
?>
				</h4>
			</div>
			</div>
			</div><br />

			<div class="col-lg-12 card-body bg-light">
			<center>
			    <div class="row">
			    <div class="col-md-6">
<?php
if ($rowu['energy'] < 10 || $rowu['health'] < 10 || $countuo <= 0 || $countpac > 0) {
    echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-bolt"></em>' . lang_key("fight") . '</button>';
} else {
    echo '<a href="#/" class="btn btn-danger btn-md btn-block" onclick="countdownaction();"><i class="fa fa-bolt"></i> ' . lang_key("fight") . '</a>';
}
?>    
				</div>
				<div class="col-md-6">
				    <a href="fight-arena.php" class="btn btn-primary btn-md btn-block"><i class="fa fa-arrow-circle-right"></i> <?php
echo lang_key("find-another");
?></a>
				</div>
			    </div>
			</center>
			</div>
			
			</div>
			<div class="col-md-3">
			
<?php
if ($countuo > 0) {
?>
			<img src="<?php
    echo $rowpoc['image'];
?>" width="100%" style="border:8px solid #ccc; border-radius:15px;" />
			<br /><br />
			<div class="card">
            <div class="card-header text-white bg-primary"><center><i class="fa fa-archive"></i> <?php
    echo $rowuo['username'];
?><?php
    echo lang_key("s-items");
?></center></div>
                <div class="card-body">
				<div class="row">
<?php
    $queryoi  = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$playero_id' LIMIT 9");
    $queryoin = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$playero_id'");
    $countoi  = mysqli_num_rows($queryoi);
    
    if ($countoi > 0) {
        while ($rowoi = mysqli_fetch_assoc($queryoi)) {
            
            $itemo_id = $rowoi['item_id'];
            $queryio  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$itemo_id'");
            $rowio    = mysqli_fetch_assoc($queryio);
?>
                            <div class="col-md-4">
                                <center>
                                    <img src="<?php
            echo $rowio['image'];
?>" class="item-border" width="98%" data-toggle="tooltip" data-placement="top" title="<?php
            echo $rowio['item'];
?>" />
                                <hr /></center>
                            </div>
<?php
        }
        echo '
<div id="enemyitems" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-archive"></i> ' . $rowuo['username'] . '' . lang_key("s-items") . '</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
	  </div>
      <div class="modal-body">
	  <div class="row">
';
        while ($rowoin = mysqli_fetch_assoc($queryoin)) {
            
            $itemno_id = $rowoin['item_id'];
            $queryino  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$itemno_id'");
            $rowino    = mysqli_fetch_assoc($queryino);
            echo '
                            <div class="col-md-3">
                                <center>
                                    <img src="' . $rowino['image'] . '" class="item-border" width="100%" data-toggle="tooltip" data-placement="top" title="' . $rowino['item'] . '" />
                                    <span class="badge badge-primary">+ ' . $rowino['bonusvalue'] . ' ' . $rowino['bonustype'] . '</span>
                                <hr /></center>
                            </div>
';
        }
        echo '
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info btn-block" data-dismiss="modal"><i class="fa fa-times-circle"></i> ' . lang_key("close") . '</button>
      </div>
    </div>

  </div>
</div>
	';
        echo '<br /><a href="#" class="btn btn-secondary mx-auto" data-toggle="modal" data-target="#enemyitems"><i class="fa fa-search"></i> ' . lang_key("view-all-items") . '</a>';
    } else {
        echo '<div class="alert alert-info mx-auto"><i class="fa fa-info-circle"></i> ' . lang_key("pno-items") . '</div>';
    }
?>
			    </div></div>
            </div>
<?php
}
?>
			
			</div>
		</div>
		
    </div>
	</div>
	
</div>

<div id="action-modal" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php
echo lang_key("fight");
?></h5>
                    </div>
                    <div class="modal-body">
                        <center>
                            <div class="col-md-6 bd-example-container-sidebar" style="margin: auto;">
                                 <h2 id="count_num" class="alert alert-dismissible alert-info">3</h2>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
</div>

<script>
function countdownaction() {
   $("#action-modal").modal('show');

$(function(){
var timer = setInterval(function(){
$("#count_num").html(function(i,html){
   
if(parseInt(html)>0) {
   if(parseInt(html-1)==0) {
	  window.setTimeout(function () {
        window.location = "?opponent=<?php
echo $rowuo['id'];
?>";
      }, 700);
      return "<?php
echo lang_key("fight");
?>";
      clearTimeout(timer);
	  $("#action-modal").modal('hide');
   } else {
      return parseInt(html)-1;
   }
}
});

},1000);
});

}
</script>
<?php
footer();
?>