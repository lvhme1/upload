<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

$date = date('d F Y');
$time = date('H:i');

if (isset($_GET['oppveh_id'])) {
    
    $oppveh_id = (int) $_GET['oppveh_id'];
    
    $queryuo = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id!='$player_id' AND id='$oppveh_id' LIMIT 1");
    
} else {
    $queryuo = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id!='$player_id' ORDER BY rand() LIMIT 1");
}

$countuo = mysqli_num_rows($queryuo);
$rowuo   = mysqli_fetch_assoc($queryuo);

$playero_id  = $rowuo['player_id'];
$vehicleo_id = $rowuo['vehicle_id'];

$queryuop = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$playero_id' AND username!='$uname' LIMIT 1");
$rowuop   = mysqli_fetch_assoc($queryuop);
$countuop = mysqli_num_rows($queryuop);

$queryuov = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$vehicleo_id' LIMIT 1");
$rowuov   = mysqli_fetch_assoc($queryuov);
$countuov = mysqli_num_rows($queryuov);

$querypac = mysqli_query($connect, "SELECT * FROM `player_actions` WHERE player_id='$player_id' LIMIT 1");
$countpac = mysqli_num_rows($querypac);

$querypof = mysqli_query($connect, "SELECT * FROM `races` WHERE playera_id='$player_id' AND playerb_id='$playero_id' AND date='$date'");
$countpof = mysqli_num_rows($querypof);

if (isset($_GET['vehicle_id'])) {
    
    $sveh_id = (int) $_GET['vehicle_id'];
    
    $queryvpo = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$sveh_id' LIMIT 1");
    $countvpo = mysqli_num_rows($queryvpo);
    
    $queryvpc = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE vehicle_id = '$sveh_id' and player_id = '$player_id' LIMIT 1");
    $countvpc = mysqli_num_rows($queryvpc);
    
    if ($countvpo > 0 && $countvpc > 0) {
        $rowvpc = mysqli_fetch_assoc($queryvpc);
        
        $rowvpo = mysqli_fetch_assoc($queryvpo);
        
        //Round 1 - Speed
        if ($rowvpc['speed'] < $rowuo['speed']) {
            $round1u  = 0;
            $round1uo = 1;
        }
        if ($rowvpc['speed'] > $rowuo['speed']) {
            $round1u  = 1;
            $round1uo = 0;
        }
        if ($rowvpc['speed'] == $rowuo['speed']) {
            $round1u  = 1;
            $round1uo = 1;
        }
        
        //Round 2 - Acceleration
        if ($rowvpc['acceleration'] < $rowuo['acceleration']) {
            $round2u  = 0;
            $round2uo = 1;
        }
        if ($rowvpc['acceleration'] > $rowuo['acceleration']) {
            $round2u  = 1;
            $round2uo = 0;
        }
        if ($rowvpc['acceleration'] == $rowuo['acceleration']) {
            $round2u  = 1;
            $round2uo = 1;
        }
        
        //Round 3 - Stability
        if ($rowvpc['stability'] < $rowuo['stability']) {
            $round3u  = 0;
            $round3uo = 1;
        }
        if ($rowvpc['stability'] > $rowuo['stability']) {
            $round3u  = 1;
            $round3uo = 0;
        }
        if ($rowvpc['stability'] == $rowuo['stability']) {
            $round3u  = 1;
            $round3uo = 1;
        }
        
        //Round 4 - Final (Calculations)
        $round4u  = $round1u + $round2u + $round3u;
        $round4uo = $round1uo + $round2uo + $round3uo;
        
        if ($round4u < $round4uo) {
            $winchance = 1;
        }
        if ($round4u == $round4uo) {
            $winchance = 2;
        }
        if ($round4u > $round4uo) {
            $winchance = 3;
        }
        
        //Start Race
        if (isset($_GET['oppveh_id'])) {
            
            $opponent_id = $playero_id;
            
            if ($countpof > 2) {
                echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("cant-racemore") . '</strong></center>
</div>';
            }
            
            if ($rowu['energy'] >= 10 && $rowu['health'] >= 10 && $countuo > 0 && $countuop > 0 && $countuov > 0 && $countpac == 0 && $countpof < 3) {
                
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
                    
                    $log_race        = mysqli_query($connect, "INSERT INTO `races` (playera_id, playerb_id, winner_id, date, time)
VALUES ('$player_id', '$opponent_id', '$winner_id', '$date', '$time')");
                    $player_update   = mysqli_query($connect, "UPDATE `players` SET money=money+500, gold=gold+2, energy=energy-10, respect=respect+325 WHERE id='$player_id'");
                    $opponent_update = mysqli_query($connect, "UPDATE `players` SET money=money-250 WHERE id='$opponent_id'");
                    
                    $content = '' . $rowu['username'] . ' challenged you to race and he win the race. You lost $250.';
                    $message = mysqli_query($connect, "INSERT INTO `messages` (fromid, toid, date, time, content)
VALUES ('$player_id', '$opponent_id', '$date', '$time', '$content')");
                    
                    echo '
<div class="alert alert-success">
  <center><strong><i class="fa fa-trophy"></i> ' . lang_key("you-win") . ' <br />' . lang_key("reward") . ': <span class="badge badge-success">$ 500</span> ' . lang_key("and") . ' <span class="badge badge-warning">2 ' . lang_key("gold") . '</span></strong></center>
</div>';
                } else {
                    
                    $log_race        = mysqli_query($connect, "INSERT INTO `races` (playera_id, playerb_id, winner_id, date, time)
VALUES ('$player_id', '$opponent_id', '$winner_id', '$date', '$time')");
                    $player_update   = mysqli_query($connect, "UPDATE `players` SET money=money-250, energy=energy-10 WHERE id='$player_id'");
                    $opponent_update = mysqli_query($connect, "UPDATE `players` SET money=money+500, gold=gold+2, respect=respect+325 WHERE id='$opponent_id'");
                    
                    $content = '' . $rowu['username'] . ' challenged you to race and you win the race. You earned $500 and 2 gold.';
                    $message = mysqli_query($connect, "INSERT INTO `messages` (fromid, toid, date, time, content)
VALUES ('$player_id', '$opponent_id', '$date', '$time', '$content')");
                    
                    echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-trophy"></i> ' . lang_key("you-lose") . '</strong></center>
</div>';
                }
                
            }
            
        }
        
    }
}
?>
<style>
a:link {text-decoration: none;}
</style>

<div class="card"><div class="card-header text-white bg-primary"><i class="fa fa-flag-checkered"></i> <?php
echo lang_key("street-races");
?></div>
	<div class="card-body">

    <center><h4><i class="fa fa-flag-checkered"></i> <?php
echo lang_key("street-races");
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
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("no-energy") . '</strong></center>
</div>';
}

if ($rowu['health'] < 10) {
    echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("no-health1") . ' <a href="hospital.php"><i class="fa fa-hospital"></i> ' . lang_key("hospital") . '</a> ' . lang_key("no-health2") . '</strong></center>
</div>';
}

if ($countuo <= 0 || $countuop <= 0 || $countuov <= 0) {
    echo '
<div class="alert alert-danger">
  <center><strong><i class="fa fa-exclamation-circle"></i> ' . lang_key("no-racers") . '</strong></center>
</div>';
}
?>
	
    <div class="col-md-12">
        <div class="row">
        <div class="col-md-2">
		
		    <center><strong><h5><?php
echo lang_key("select-vehicle");
?></h5></strong><center><hr />
<?php
$querypv = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id' ORDER BY vehicle_id ASC");
while ($rowpv = mysqli_fetch_assoc($querypv)) {
    
    $vehicle_id = $rowpv['vehicle_id'];
    $querygv    = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$vehicle_id' LIMIT 1");
    $countgv    = mysqli_num_rows($querygv);
    $rowgv      = mysqli_fetch_assoc($querygv);
    
    if ($countgv > 0) {
        
?>
        <a href="?vehicle_id=<?php
        echo $rowgv['id'];
?>" style="color: inherit; text-decoration: inherit;">
		<div class="well" <?php
        if (isset($sveh_id) && $sveh_id == $rowgv['id']) {
            echo 'style="background-color: slategrey;"';
        }
?>>
		    <img src="<?php
        echo $rowgv['image'];
?>" width="100%"><br /><br />
		</div>
		</a>
<?php
    }
}
?>
		
		</div>
		
		<div class="col-md-10">
		<div class="row">
		<div class="col-md-6">

			<center>
				<div class="row">
				<div class="col-md-6">
					<a href="player.php?id=<?php
echo $player_id;
?>" class="btn btn-sm btn-primary btn-block">
					    <img src="<?php
echo $rowu['avatar'];
?>" width="12%">&nbsp; <?php
echo $rowu['username'];
?>
					</a>
		        </div>
			    <div class="col-md-6">
					<h5><i class="fa fa-server"></i> <?php
echo lang_key("level");
?>: <span class="badge badge-primary"><?php
echo $rowu['level'];
?></span></h5>
			    </div>
				</div>
			</center><hr /><br />
<?php
if (isset($_GET['vehicle_id']) && $countvpo > 0 && $countvpc > 0) {
?>
			<div class="well">
			    <center><img src="<?php
    echo $rowvpo['image'];
?>" width="80%"></center><hr /><br />
			
				<h6><i class="fa fa-bolt"></i> <?php
    echo lang_key("speed");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-primary" style="width: <?php
    echo percent($rowvpc['speed'], 500);
?>%;">
                        <span><?php
    echo $rowvpc['speed'];
?> / 500</span>
                    </div>
                </div><br />
				
				<h6><i class="fa fa-tachometer-alt"></i> <?php
    echo lang_key("acceleration");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-danger" style="width: <?php
    echo percent($rowvpc['acceleration'], 500);
?>%;">
                        <span><?php
    echo $rowvpc['acceleration'];
?> / 500</span>
                    </div>
                </div><br />
				
                <h6><i class="fa fa-snowflake"></i> <?php
    echo lang_key("stability");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-warning" style="width: <?php
    echo percent($rowvpc['stability'], 500);
?>%;">
                        <span><?php
    echo $rowvpc['stability'];
?> / 500</span>
                    </div>
                </div>

			</div>
<?php
} else {
    echo '<i class="fa fa-hand-o-up"></i> &nbsp;&nbsp;&nbsp;' . lang_key("select-vehicle2") . '';
}
?>
		</div>
		<div class="col-md-6">
<?php
if ($countuo > 0 && $countuop > 0 && $countuov > 0) {
?>
		    <center>
				<div class="row">
				<div class="col-md-6">
					<a href="player.php?id=<?php
    echo $rowuop['id'];
?>" class="btn btn-sm btn-primary btn-block">
					    <img src="<?php
    echo $rowuop['avatar'];
?>" width="12%">&nbsp; <?php
    echo $rowuop['username'];
?>
					</a>
		        </div>
			    <div class="col-md-6">
					<h5><i class="fa fa-server"></i> <?php
    echo lang_key("level");
?>: <span class="badge badge-primary"><?php
    echo $rowuop['level'];
?></span></h5>
			    </div>
				</div>
			</center><hr /><br />
				
			<div class="well">
			    <center><img src="<?php
    echo $rowuov['image'];
?>" width="80%"></center><hr /><br />
			
				<h6><i class="fa fa-child"></i> <?php
    echo lang_key("speed");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-primary" style="width: <?php
    echo percent($rowuo['speed'], 500);
?>%;">
                        <span><?php
    echo $rowuo['speed'];
?> / 500</span>
                    </div>
                </div><br>
				
                <h6><i class="fa fa-tachometer-alt"></i> <?php
    echo lang_key("acceleration");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-danger" style="width: <?php
    echo percent($rowuo['acceleration'], 500);
?>%;">
                        <span><?php
    echo $rowuo['acceleration'];
?> / 500</span>
                    </div>
                </div><br>
				
				<h6><i class="fa fa-snowflake"></i> <?php
    echo lang_key("stability");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-warning" style="width: <?php
    echo percent($rowuo['stability'], 500);
?>%;">
                        <span><?php
    echo $rowuo['stability'];
?> / 500</span>
                    </div>
                </div>

			</div>
<?php
}
?>
		</div>
		</div>
		
		<br />

<?php
if (isset($_GET['vehicle_id']) && $countvpo > 0 && $countvpc > 0 && $countuo > 0 && $countuop > 0 && $countuov > 0) {
?>
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
			
			<div class="card-body bg-light">
			<center>
			    <div class="row">
			    <div class="col-md-6">
<?php
    if ($rowu['energy'] < 10 || $rowu['health'] < 10 || $countuo <= 0 || $countpac > 0) {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-flag-checkered"></em> ' . lang_key("race") . '</button>';
    } else {
        echo '<a href="#/" class="btn btn-success btn-md btn-block" onclick="countdownaction();"><i class="fa fa-flag-checkered"></i> ' . lang_key("race") . '</a>';
    }
?>    
				</div>
				<div class="col-md-6">
				    <a href="races.php?vehicle_id=<?php
    echo @$_GET['vehicle_id'];
?>" class="btn btn-primary btn-md btn-block"><i class="fa fa-arrow-circle-right"></i> <?php
    echo lang_key("find-another");
?></a>
				</div>
				</div>
			</center>
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
echo lang_key("race");
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
        window.location = "?vehicle_id=<?php
echo '' . @$_GET['vehicle_id'] . '&oppveh_id=' . $rowuo['id'] . '';
?>";
      }, 700);
      return "<?php
echo lang_key("start");
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