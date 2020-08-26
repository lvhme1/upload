<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['vehicleid'])) {
    
    $veh_id = (int) $_GET['vehicleid'];
    
    $queryvpc = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE vehicle_id = '$veh_id' LIMIT 1");
    $countvpc = mysqli_num_rows($queryvpc);
    if ($countvpc > 0) {
        $rowvpc = mysqli_fetch_assoc($queryvpc);
        
        if (isset($_GET['speed'])) {
            $part = 'speed';
        } elseif (isset($_GET['acceleration'])) {
            $part = 'acceleration';
        } elseif (isset($_GET['stability'])) {
            $part = 'stability';
        } else {
            $part = '';
        }
        
        if ($part != '') {
            
            $part_upgrade = intval($rowvpc[$part] + ($rowvpc[$part] * 7));
            $respect      = 50;
            
            if ($rowu['money'] >= $part_upgrade && $rowvpc[$part] + 1 <= 500) {
                $part_pay    = mysqli_query($connect, "UPDATE `players` SET `money` = `money` - '$part_upgrade', respect=respect+'$respect' WHERE id='$player_id'");
                $veh_upgrade = mysqli_query($connect, "UPDATE `player_vehicles` SET $part = $part + 1 WHERE player_id='$player_id' AND vehicle_id='$veh_id'");
                
                echo '<div class="alert alert-success"><strong><i class="fa fa-cog" aria-hidden="true"></i>&nbsp; ' . lang_key("success-upvehicle") . '</strong></div>';
                
            }
            
        }
        
    }
}
?>
<div class="col-md-12 card bg-light card-body">

    <center><h4><i class="fa fa-wrench"></i> <?php
echo lang_key("vehicle-upgrades");
?></h4></center><br />

<?php
$querypv = mysqli_query($connect, "SELECT * FROM `player_vehicles` WHERE player_id='$player_id' ORDER BY vehicle_id ASC");
while ($rowpv = mysqli_fetch_assoc($querypv)) {
    
    $vehicle_id = $rowpv['vehicle_id'];
    $querygv    = mysqli_query($connect, "SELECT * FROM `vehicles` WHERE id='$vehicle_id' LIMIT 1");
    $countgv    = mysqli_num_rows($querygv);
    
    if ($countgv > 0) {
        $rowgv       = mysqli_fetch_assoc($querygv);
        $category_id = $rowgv['category_id'];
        
        $speed_upgrade        = intval($rowpv['speed'] + ($rowpv['speed'] * 7));
        $acceleration_upgrade = intval($rowpv['acceleration'] + ($rowpv['acceleration'] * 7));
        $stability_upgrade    = intval($rowpv['stability'] + ($rowpv['stability'] * 7));
        
        $querygvc = mysqli_query($connect, "SELECT * FROM `vehicle_categories` WHERE id='$category_id' LIMIT 1");
        $rowgvc   = mysqli_fetch_assoc($querygvc);
?>
        <div class="col-md-12 jumbotron" id="<?php
        echo $rowpv['id'];
?>">
        <center>
		    <h5><span class="fa-stack fa-md"><i class="fa fa-circle fa-stack-2x"></i><i class="fa <?php
        echo $rowgvc['fa_icon'];
?> fa-stack-1x fa-inverse"></i></span> <?php
        echo $rowgvc['category'];
?></h5>
		</center>
		<hr><br>
		<div class="row">
            <div class="col-md-6">
                <center><img src="<?php
        echo $rowgv['image'];
?>" width="65%"></center>
            </div>
            <div class="col-md-6">
                <div class="row">
				    <div class="col-md-6">
					    <h6><i class="fa fa-bolt"></i> <?php
        echo lang_key("speed");
?> </h6>
					</div>
					<div class="col-md-6">
					    <div class="float-right">
<?php
        if (($rowpv['speed'] + 1) > 500) {
            echo '<button class="btn btn-primary btn-sm btn-block" disabled><em class="fa fa-fw fa-check"></em>' . lang_key("maxed") . '</button>';
        } elseif ($rowu['money'] < $speed_upgrade) {
            echo '<button class="btn btn-danger btn-sm btn-block" disabled><i class="fa fa-wrench"></i> ' . lang_key("upgrade") . ' &nbsp;[ <b>$ ' . $speed_upgrade . '</b> ]</button>';
        } else {
            echo '<a href="?vehicleid=' . $vehicle_id . '&speed#' . $rowpv['id'] . '" class="btn btn-sm btn-success"><i class="fa fa-wrench"></i> ' . lang_key("upgrade") . ' &nbsp;[ <b>$ ' . $speed_upgrade . '</b> ]</a>';
        }
?>
						</div>
					</div>
				</div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-primary" style="width: <?php
        echo percent($rowpv['speed'], 500);
?>%;">
                        <span><?php
        echo $rowpv['speed'];
?> / 500</span>
                    </div><div class="progress-bar bg-info" style="width: 1%;"></div>
                </div><br />
				
				<div class="row">
				    <div class="col-md-6">
					    <h6><i class="fa fa-tachometer-alt"></i> <?php
        echo lang_key("acceleration");
?></h6>
					</div>
					<div class="col-md-6">
					    <div class="float-right">
<?php
        if (($rowpv['acceleration'] + 1) > 500) {
            echo '<button class="btn btn-primary btn-sm btn-block" disabled><em class="fa fa-fw fa-check"></em>' . lang_key("maxed") . '</button>';
        } elseif ($rowu['money'] < $acceleration_upgrade) {
            echo '<button class="btn btn-danger btn-sm btn-block" disabled><i class="fa fa-wrench"></i> ' . lang_key("upgrade") . ' &nbsp;[ <b>$ ' . $acceleration_upgrade . '</b> ]</button>';
        } else {
            echo '<a href="?vehicleid=' . $vehicle_id . '&acceleration#' . $rowpv['id'] . '" class="btn btn-sm btn-success"><i class="fa fa-wrench"></i> ' . lang_key("upgrade") . ' &nbsp;[ <b>$ ' . $acceleration_upgrade . '</b> ]</a>';
        }
?>
						</div>
					</div>
				</div>
                
				<div class="progress mb-3">
                    <div class="progress-bar bg-danger" style="width: <?php
        echo percent($rowpv['acceleration'], 500);
?>%;">
                        <span><?php
        echo $rowpv['acceleration'];
?> / 500</span>
                    </div><div class="progress-bar bg-info" style="width: 1%;"></div>
                </div><br />
				
				<div class="row">
				    <div class="col-md-6">
					    <h6><i class="fa fa-snowflake"></i> <?php
        echo lang_key("stability");
?></h6>
					</div>
					<div class="col-md-6">
					    <div class="float-right">
<?php
        if (($rowpv['stability'] + 1) > 500) {
            echo '<button class="btn btn-primary btn-sm btn-block" disabled><em class="fa fa-fw fa-check"></em>' . lang_key("maxed") . '</button>';
        } elseif ($rowu['money'] < $stability_upgrade) {
            echo '<button class="btn btn-danger btn-sm btn-block" disabled><i class="fa fa-wrench"></i> ' . lang_key("upgrade") . ' &nbsp;[ <b>$ ' . $stability_upgrade . '</b> ]</button>';
        } else {
            echo '<a href="?vehicleid=' . $vehicle_id . '&stability#' . $rowpv['id'] . '" class="btn btn-sm btn-success"><i class="fa fa-wrench"></i> ' . lang_key("upgrade") . ' &nbsp;[ <b>$ ' . $stability_upgrade . '</b> ]</a>';
        }
?>
						</div>
					</div>
				</div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-warning" style="width: <?php
        echo percent($rowpv['stability'], 500);
?>%;">
                        <span><?php
        echo $rowpv['stability'];
?> / 500</span>
                    </div>
                    <div class="progress-bar bg-info" style="width: 1%;"></div>
                </div>
            </div>
			</div>
		</div>
<?php
    }
}
?>
</div>
<?php
footer();
?>