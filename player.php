<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu  = mysqli_fetch_assoc($suser);

if (isset($_GET['id'])) {
    $uid     = $_GET['id'];
    $querypl = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$uid' LIMIT 1");
    @$countpl = mysqli_num_rows($querypl);
    if ($countpl == 0) {
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
    $rowpl = mysqli_fetch_assoc($querypl);
} else {
    echo '<meta http-equiv="refresh" content="0; url=home.php" />';
    exit;
}

if (isset($_POST['postcomment'])) {
    $comment   = $_POST['comment'];
    $player_id = $rowpl['id'];
    $author_id = $rowu['id'];
    $date      = date('d F Y');
    $time      = date('H:i');
    
    $querycpc = mysqli_query($connect, "SELECT * FROM `player_comments` WHERE author_id='$author_id' AND player_id='$player_id' AND comment='$comment' AND date='$date' LIMIT 1");
    $countcpc = mysqli_num_rows($querycpc);
    if ($countcpc == 0) {
        $post_comment = mysqli_query($connect, "INSERT INTO `player_comments` (player_id, author_id, comment, date, time) VALUES ('$player_id', '$author_id', '$comment', '$date', '$time')");
    }
}
?>
        <div class="col-md-12 card bg-light card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card"><div class="card-header text-white bg-primary">
                            <i class="fa fa-chart-bar"></i> <?php
echo $rowpl['username'];
?><?php
echo lang_key("s-statistics");
?>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <img src="<?php
echo $rowpl['avatar'];
?>" width="100%" />
                                </div>
                                <div class="col-md-8">
                                    <h5><i class="fa fa-user"></i> <?php
echo $rowpl['username'];
?> <font size="3px">
<?php
if ($rowpl['role'] == "Admin") {
    echo '<span class="badge badge-danger"><i class="fa fa-bookmark"></i> ' . $rowpl['role'] . '</span> ';
}

if ($rowpl['role'] == "VIP") {
    echo '<span class="badge badge-warning"><i class="fa fa-star"></i> ' . $rowpl['role'] . '</span> ';
}

$timeonline = time() - 60;
if ($rowpl['timeonline'] > $timeonline) {
    echo '<span class="badge badge-success"><i class="fa fa-circle"></i> Online</span>';
}
?>
</font></h5>
                                    <hr />
                                    <h6><i class="far fa-money-bill-alt"></i> <?php
echo lang_key("money");
?>: <span class="badge badge-success"><?php
echo $rowpl['money'];
?></span></h6>
                                    <h6><i class="fa fa-inbox"></i> <?php
echo lang_key("gold");
?>: <span class="badge badge-warning"><?php
echo $rowpl['gold'];
?></span></h6>
                                    <h6><i class="fa fa-star"></i> <?php
echo lang_key("respect");
?>: <span class="badge badge-primary"><?php
echo $rowpl['respect'];
?></span></h6>
                                </div>
<div class="col-md-12">
<hr />			
<center><?php
echo $rowpl['description'];
?></center>
</div>
                            </div>
                            <hr />

                            <b><i class="fa fa-star"></i> <?php
echo lang_key("level");
?>:</b> <?php
echo $rowpl['level'];
?>
<?php
$level   = $rowpl['level'];
$querycl = mysqli_query($connect, "SELECT min_respect, description FROM `levels` WHERE level='$level'");
$rowcl   = mysqli_fetch_assoc($querycl);
$querynl = mysqli_query($connect, "SELECT min_respect FROM `levels` WHERE level='$level'+1");
$rownl   = mysqli_fetch_assoc($querynl);

$levelpercent = (($rowpl['respect'] - $rowcl['min_respect']) / ($rownl['min_respect'] - $rowcl['min_respect'])) * 100;
?>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: <?php
echo '' . round($levelpercent) . '';
?>%"></div>
                            </div>
							<p class="text-muted"><em><?php
echo $rowcl['description'];
?></em></p>
                            <hr>
<?php
$querypfw = mysqli_query($connect, "SELECT * FROM `fights` WHERE winner_id='$uid'");
$countpfw = mysqli_num_rows($querypfw);
$queryprw = mysqli_query($connect, "SELECT * FROM `races` WHERE winner_id='$uid'");
$countprw = mysqli_num_rows($queryprw);
$queryppt = mysqli_query($connect, "SELECT * FROM `player_properties` WHERE player_id='$uid'");
$countppt = mysqli_num_rows($queryppt);
$income   = 0;
while ($rowppt = mysqli_fetch_assoc($queryppt)) {
    $property_id = $rowppt['property_id'];
    $queryppi    = mysqli_query($connect, "SELECT * FROM `properties` WHERE id='$property_id'");
    $rowppi      = mysqli_fetch_assoc($queryppi);
    $income      = $income + $rowppi['income'];
}
?>
                            <div class="row">
                                <div class="col-md-3"><b><i class="fa fa-bolt"></i> <?php
echo $countpfw;
?></b>
                                    <br/><small><?php
echo lang_key("fight-wins");
?></small>
                                </div>
                                <div class="col-md-3"><b><i class="fa fa-flag-checkered"></i> <?php
echo $countprw;
?></b>
                                    <br/><small><?php
echo lang_key("race-wins");
?></small>
                                </div>
                                <div class="col-md-3"><b><i class="fa fa-building"></i> <?php
echo $countppt;
?></b>
                                    <br/><small><?php
echo lang_key("properties");
?></small>
                                </div>
                                <div class="col-md-3"><b><i class="fa fa-dollar-sign"></i> <?php
echo $income;
?></b>
                                    <br/><small><?php
echo lang_key("income");
?></small>
                                </div>
                            </div>

                        </div>
                    </div><br />

                    <div class="card"><div class="card-header text-white bg-primary">
                            <i class="fa fa-wrench"></i> <?php
echo $rowpl['username'];
?>'s Skills
                        </div>
                        <div class="card-body">
                            <h6><i class="fa fa-child"></i> <?php
    echo lang_key("power");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-warning" style="width: <?php
    echo percent($rowpl['power'], 250);
?>%;">
                        <span><?php
    echo $rowpl['power'];
?> / 250</span>
                    </div>
                </div>
                <h6><i class="fa fa-retweet"></i> <?php
    echo lang_key("agility");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-danger" style="width: <?php
    echo percent($rowpl['agility'], 250);
?>%;">
                        <span><?php
    echo $rowpl['agility'];
?> / 250</span>
                    </div>
                </div>
                <h6><i class="fa fa-heartbeat"></i> <?php
    echo lang_key("endurance");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-success" style="width: <?php
    echo percent($rowpl['endurance'], 250);
?>%;">
                        <span><?php
    echo $rowpl['endurance'];
?> / 250</span>
                    </div>
                </div>
                <h6><i class="fab fa-usb"></i> <?php
    echo lang_key("intelligence");
?></h6>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped bg-info" style="width: <?php
    echo percent($rowpl['intelligence'], 250);
?>%;">
                        <span><?php
    echo $rowpl['intelligence'];
?> / 250</span>
                    </div>
                </div>
                        </div>
                    </div><br />

                    <div class="card"><div class="card-header text-white bg-primary">
                            <i class="far fa-hand-paper"></i> <?php
echo $rowpl['username'];
?><?php
echo lang_key("s-items");
?>
                        </div>
                        <div class="card-body">
						<div class="row">
<?php
$player_id = $rowpl['id'];
$querypi   = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$player_id' LIMIT 12");
$querypin  = mysqli_query($connect, "SELECT * FROM `player_items` WHERE player_id='$player_id'");
$countpi   = mysqli_num_rows($querypi);

if ($countpi > 0) {
    while ($rowpi = mysqli_fetch_assoc($querypi)) {
        
        $item_id = $rowpi['item_id'];
        $queryi  = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$item_id'");
        $rowi    = mysqli_fetch_assoc($queryi);
?>
                            <div class="col-md-3">
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
	     <h5 class="modal-title"><i class="fa fa-archive"></i> ' . $rowpl['username'] . '\'s Items</h5>
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
    echo '<div class="alert alert-info mx-auto"><i class="fa fa-info-circle"></i> ' . lang_key("pno-items") . '</div>';
}
?>
                        </div></div>
                    </div><br />
                    
                    <div class="card"><div class="card-header text-white bg-primary">
                            <i class="fa fa-comments"></i> <?php
echo lang_key("comments");
?>
                        </div>
                        <div class="card-body">
<?php
$tday   = date("d");
$tmonth = date("n");
$tyear  = date("Y");

$thour   = date("H");
$tminute = date("i");

$querycp = mysqli_query($connect, "SELECT * FROM `player_comments` WHERE player_id='$uid' ORDER BY id DESC LIMIT 6");
$countcp = mysqli_num_rows($querycp);
if ($countcp > 0) {
    while ($rowcp = mysqli_fetch_assoc($querycp)) {
        $author_id = $rowcp['author_id'];
        $querycpd  = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$author_id' LIMIT 1");
        $rowcpd    = mysqli_fetch_assoc($querycpd);
?>
                            <div class="card">
                                <div class="card-header">
                                    <img src="<?php
        echo $rowcpd['avatar'];
?>" width="8%">&nbsp;&nbsp;<strong><a href="player.php?id=<?php
        echo $author_id;
?>"><?php
        echo $rowcpd['username'];
?></a></strong>
                                </div>
                                <div class="card-body comment-emoticons">
                                    <?php
        echo $rowcp['comment'];
?>
                                </div>
                                <div class="card-footer">
                                    <i class="fas fa-clock"></i> 
<?php
        $getdate = date_parse_from_format("d F Y", $rowcp['date']);
        $gettime = date_parse_from_format("H:i", $rowcp['time']);
        $day     = $getdate["day"];
        $month   = $getdate["month"];
        $year    = $getdate["year"];
        $hour    = $gettime["hour"];
        $minute  = $gettime["minute"];
        
        if ($year != $tyear) {
            $c_year = $tyear - $year;
            if ($c_year == 1) {
                $ssymbol = '';
            } else {
                $ssymbol = 's';
            }
            echo '' . $c_year . ' year' . $ssymbol . ' ago';
        } else {
            if ($month != $tmonth) {
                $c_month = $tmonth - $month;
                if ($c_month == 1) {
                    $ssymbol = '';
                } else {
                    $ssymbol = 's';
                }
                echo '' . $c_month . ' month' . $ssymbol . ' ago';
            } else {
                if ($day != $tday) {
                    $c_day = $tday - $day;
                    if ($c_day == 1) {
                        $ssymbol = '';
                    } else {
                        $ssymbol = 's';
                    }
                    echo '' . $c_day . ' day' . $ssymbol . ' ago';
                } else {
                    if ($hour != $thour) {
                        $c_hour = $thour - $hour;
                        if ($c_hour == 1) {
                            $ssymbol = '';
                        } else {
                            $ssymbol = 's';
                        }
                        echo '' . $c_hour . ' hour' . $ssymbol . ' ago';
                    } else {
                        if ($minute != $tminute) {
                            $c_minute = $tminute - $minute;
                            if ($c_minute == 1) {
                                $ssymbol = '';
                            } else {
                                $ssymbol = 's';
                            }
                            echo '' . $c_minute . ' minute' . $ssymbol . ' ago';
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
} else {
    echo '<div class="alert alert-info"><i class="fa fa-info-circle"></i> ' . lang_key("no-comments") . '</div>';
}
?>
				            <form action="" method="post">
								<br /><textarea placeholder="<?php
echo lang_key("write-a-comment");
?>" name="comment" class="form-control" required></textarea>
								<br /><button type="submit" name="postcomment" class="btn btn-success float-right"><i class="fa fa-share"></i> <?php
echo lang_key("comment");
?></button>
				            </form>
                            
                        </div>
                    </div>
                </div><br />

                <div class="col-md-8">
                    <div class="card"><div class="card-header text-white bg-primary">
                            <i class="fa fa-home"></i> <?php
echo $rowpl['username'];
?><?php
echo lang_key("s-home");
?>
                        </div>
<?php
$queryph = mysqli_query($connect, "SELECT home_id FROM `players` WHERE id='$uid' LIMIT 1");
$rowph   = mysqli_fetch_assoc($queryph);
$home_id = $rowph['home_id'];
$queryh  = mysqli_query($connect, "SELECT * FROM `homes` WHERE id='$home_id' LIMIT 1");
$counth  = mysqli_num_rows($queryh);
$rowh    = mysqli_fetch_assoc($queryh);
if ($counth > 0) {
    echo '<div class="card-body" style="background-image: url(' . $rowh['image'] . ');  background-size: 100% 100%; background-repeat: no-repeat; height: auto;">';
} else {
    echo '<div class="card-body">
             <div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> ' . lang_key("yno-home") . '</strong></div>';
}
?>
                            <center>
<?php
if ($counth > 0) {
    $querypc      = mysqli_query($connect, "SELECT character_id FROM `players` WHERE id='$uid' LIMIT 1");
    $rowpc        = mysqli_fetch_assoc($querypc);
    $character_id = $rowpc['character_id'];
    $queryc       = mysqli_query($connect, "SELECT * FROM `characters` WHERE id='$character_id' LIMIT 1");
    $countc       = mysqli_num_rows($queryc);
    $rowc         = mysqli_fetch_assoc($queryc);
    if ($countc > 0) {
        echo '<img src="' . $rowc['image'] . '" width="32%" />';
    }
    
    $querypp = mysqli_query($connect, "SELECT pet_id FROM `player_pets` WHERE player_id='$uid'");
    while ($rowpp = mysqli_fetch_assoc($querypp)) {
        $pet_id  = $rowpp['pet_id'];
        $querypt = mysqli_query($connect, "SELECT * FROM `pets` WHERE id='$pet_id' LIMIT 1");
        $countpt = mysqli_num_rows($querypt);
        if ($countpt > 0) {
            $rowpt = mysqli_fetch_assoc($querypt);
            echo '<img src="' . $rowpt['image'] . '" width="20%" style="padding-top: 28%;" />';
        }
    }
}
?>
                            </center>
                        </div>
                    </div><br />

<?php
$querypg   = mysqli_query($connect, "SELECT garage_id FROM `players` WHERE id='$uid' LIMIT 1");
$rowpg     = mysqli_fetch_assoc($querypg);
$garage_id = $rowpg['garage_id'];
$queryg    = mysqli_query($connect, "SELECT * FROM `garages` WHERE id='$garage_id' LIMIT 1");
$countg    = mysqli_num_rows($queryg);
$rowg      = mysqli_fetch_assoc($queryg);
if ($countg > 0) {
?>
                    <div class="card"><div class="card-header text-white bg-primary">
                            <i class="fa fa-car"></i> <?php
    echo $rowpl['username'];
?><?php
    echo lang_key("s-garage");
?>
                        </div>
<?php
    $countergv = 0;
    $querypv   = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id'");
    while ($rowpv = mysqli_fetch_assoc($querypv)) {
        
        $vehicle_id = $rowpv['vehicle_id'];
        $querygv    = mysqli_query($connect, "SELECT * FROM `vehicles` INNER JOIN `vehicle_categories` ON vehicles.category_id=vehicle_categories.id WHERE vehicles.id='$vehicle_id' AND vehicle_categories.type = 'Garage' LIMIT 1");
        $countgv    = mysqli_num_rows($querygv);
        
        if ($countgv > 0) {
            $countergv = $countergv + 1;
        }
        
    }
?>
                        <div id="cars" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
<?php
    $firstv   = true;
    $querypgv = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id'");
    while ($rowpgv = mysqli_fetch_assoc($querypgv)) {
        
        $gvehicle_id = $rowpgv['vehicle_id'];
        $querygvc    = mysqli_query($connect, "SELECT * FROM `vehicles` INNER JOIN `vehicle_categories` ON vehicles.category_id=vehicle_categories.id WHERE vehicles.id='$gvehicle_id' AND vehicle_categories.type = 'Garage'");
        $rowgvc      = mysqli_fetch_assoc($querygvc);
        
        if ($rowgvc['type'] == 'Garage') {
?>
                                <div class="carousel-item <?php
            if ($firstv) {
                $firstv = false;
                echo 'active';
            }
?>">
                                    <div class="card-body" style="background-image: url(<?php
            echo $rowg['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
                                        <center><img src="<?php
            echo $rowgvc['image'];
?>" width="60%" style="position: absolute; left: 19%; bottom: 22%;" /></center>
                                    </div>
                                    <div class="card-footer">
                                        <?php
            echo lang_key("speed");
?>: <span class="badge badge-primary"><?php
            echo $rowpgv['speed'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("acceleration");
?>: <span class="badge badge-danger"><?php
            echo $rowpgv['acceleration'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("stability");
?>: <span class="badge badge-warning"><?php
            echo $rowpgv['stability'];
?></span>
                                    </div>
                                </div>
<?php
        }
    }
?>

                            </div>

                            <a class="left carousel-control-prev" href="#cars" role="button" data-slide="prev" style="height: 90%;">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a class="right carousel-control-next" href="#cars" role="button" data-slide="next" style="height: 90%;">
                                <i class="fas fa-chevron-right"></i>
                            </a>
<?php
    if ($countergv == 0) {
?>
    <div class="card-body" style="background-image: url(<?php
        echo $rowg['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
        <div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> <?php
        echo lang_key("pno-vehicles");
?></strong></div>
    </div>
<?php
    }
?>
                        </div>
                    </div><br />
<?php
}
?>
                
<?php
$queryph   = mysqli_query($connect, "SELECT hangar_id FROM `players` WHERE id='$uid' LIMIT 1");
$rowph     = mysqli_fetch_assoc($queryph);
$hangar_id = $rowph['hangar_id'];
$queryh    = mysqli_query($connect, "SELECT * FROM `hangars` WHERE id='$hangar_id' LIMIT 1");
$counth    = mysqli_num_rows($queryh);
$rowh      = mysqli_fetch_assoc($queryh);
if ($counth > 0) {
?>
                    <div class="card"><div class="card-header text-white bg-primary">
                            <i class="fa fa-plane"></i> <?php
    echo $rowpl['username'];
?><?php
    echo lang_key("s-hangar");
?>
                        </div>
<?php
    $counterhv = 0;
    $querypvh  = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id'");
    while ($rowpvh = mysqli_fetch_assoc($querypvh)) {
        
        $vehicle_id = $rowpvh['vehicle_id'];
        $queryhv    = mysqli_query($connect, "SELECT * FROM `vehicles` INNER JOIN `vehicle_categories` ON vehicles.category_id=vehicle_categories.id WHERE vehicles.id='$vehicle_id' AND vehicle_categories.type = 'Hangar' LIMIT 1");
        $counthv    = mysqli_num_rows($queryhv);
        
        if ($counthv > 0) {
            $counterhv = $counterhv + 1;
        }
        
    }
?>
                        <div id="planes" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
<?php
    $firstp   = true;
    $queryphv = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id'");
    while ($rowphv = mysqli_fetch_assoc($queryphv)) {
        
        $hvehicle_id = $rowphv['vehicle_id'];
        $queryhvc    = mysqli_query($connect, "SELECT * FROM `vehicles` INNER JOIN `vehicle_categories` ON vehicles.category_id=vehicle_categories.id WHERE vehicles.id='$hvehicle_id' AND vehicle_categories.type = 'Hangar'");
        $rowhvc      = mysqli_fetch_assoc($queryhvc);
        
        if ($rowhvc['type'] == 'Hangar') {
?>
                                <div class="carousel-item <?php
            if ($firstp) {
                $firstp = false;
                echo 'active';
            }
?>">
                                    <div class="card-body" style="background-image: url(<?php
            echo $rowh['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
                                        <center><img src="<?php
            echo $rowhvc['image'];
?>" width="90%" style="position: absolute; left: 7%; bottom: 20%;" /></center>
                                    </div>
                                    <div class="card-footer">
                                        <?php
            echo lang_key("speed");
?>: <span class="badge badge-primary"><?php
            echo $rowphv['speed'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("acceleration");
?>: <span class="badge badge-danger"><?php
            echo $rowphv['acceleration'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("stability");
?>: <span class="badge badge-warning"><?php
            echo $rowphv['stability'];
?></span> 
                                    </div>
                                </div>
<?php
        }
    }
?>

                            </div>

                            <a class="left carousel-control-prev" href="#planes" role="button" data-slide="prev" style="height: 90%;">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a class="right carousel-control-next" href="#planes" role="button" data-slide="next" style="height: 90%;">
                                <i class="fas fa-chevron-right"></i>
                            </a>
<?php
    if ($counterhv == 0) {
?>
    <div class="card-body" style="background-image: url(<?php
        echo $rowh['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
        <div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> <?php
        echo lang_key("pno-planes");
?></strong></div>
    </div>
<?php
    }
?>
                        </div>
                    </div><br />
<?php
}
?>

<?php
$querypq = mysqli_query($connect, "SELECT quay_id FROM `players` WHERE id='$uid' LIMIT 1");
$rowpq   = mysqli_fetch_assoc($querypq);
$quay_id = $rowpq['quay_id'];
$queryq  = mysqli_query($connect, "SELECT * FROM `quays` WHERE id='$quay_id' LIMIT 1");
$countq  = mysqli_num_rows($queryq);
$rowq    = mysqli_fetch_assoc($queryq);
if ($countq > 0) {
?>
                    <div class="card"><div class="card-header text-white bg-primary">
                            <i class="fa fa-ship"></i> <?php
    echo $rowpl['username'];
?><?php
    echo lang_key("s-quay");
?>
                        </div>
<?php
    $counterqv = 0;
    $querypvq  = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id'");
    while ($rowpvq = mysqli_fetch_assoc($querypvq)) {
        
        $vehicle_id = $rowpvq['vehicle_id'];
        $queryqv    = mysqli_query($connect, "SELECT * FROM `vehicles` INNER JOIN `vehicle_categories` ON vehicles.category_id=vehicle_categories.id WHERE vehicles.id='$vehicle_id' AND vehicle_categories.type = 'Quay' LIMIT 1");
        $countqv    = mysqli_num_rows($queryqv);
        
        if ($countqv > 0) {
            $counterqv = $counterqv + 1;
        }
        
    }
?>
                        <div id="boats" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
<?php
    $firstq   = true;
    $querypqv = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id'");
    while ($rowpqv = mysqli_fetch_assoc($querypqv)) {
        
        $qvehicle_id = $rowpqv['vehicle_id'];
        $queryqvc    = mysqli_query($connect, "SELECT * FROM `vehicles` INNER JOIN `vehicle_categories` ON vehicles.category_id=vehicle_categories.id WHERE vehicles.id='$qvehicle_id' AND vehicle_categories.type = 'Quay'");
        $rowqvc      = mysqli_fetch_assoc($queryqvc);
        
        if ($rowqvc['type'] == 'Quay') {
?>
                                <div class="carousel-item <?php
            if ($firstq) {
                $firstq = false;
                echo 'active';
            }
?>">
                                    <div class="card-body" style="background-image: url(<?php
            echo $rowq['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
                                        <center><img src="<?php
            echo $rowqvc['image'];
?>" width="70%" style="position: absolute; left: 15%; bottom: 22%;" /></center>
                                    </div>
                                    <div class="card-footer">
                                        <?php
            echo lang_key("speed");
?>: <span class="badge badge-primary"><?php
            echo $rowpqv['speed'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("acceleration");
?>: <span class="badge badge-danger"><?php
            echo $rowpqv['acceleration'];
?></span>&nbsp;&nbsp;&nbsp; <?php
            echo lang_key("stability");
?>: <span class="badge badge-warning"><?php
            echo $rowpqv['stability'];
?></span> 
                                    </div>
                                </div>
<?php
        }
    }
?>

                            </div>

                            <a class="left carousel-control-prev" href="#boats" role="button" data-slide="prev" style="height: 90%;">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a class="right carousel-control-next" href="#boats" role="button" data-slide="next" style="height: 90%;">
                                <i class="fas fa-chevron-right"></i>
                            </a>
<?php
    if ($counterqv == 0) {
?>
    <div class="card-body" style="background-image: url(<?php
        echo $rowq['image'];
?>); background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
        <div class="alert alert-info"><strong><i class="fa fa-info-circle"></i> <?php
        echo lang_key("pno-boats");
?></strong></div>
    </div>
<?php
    }
?>
                        </div>
                    </div>
<?php
}
?>

                </div>
            </div>

        </div>
<?php
footer();
?>