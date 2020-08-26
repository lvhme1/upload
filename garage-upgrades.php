<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['buygarage-id'])) {
    
    $buygarage_id = (int) $_GET['buygarage-id'];
    
    $querygc = mysqli_query($connect, "SELECT * FROM `garages` WHERE id = '$buygarage_id' LIMIT 1");
    $countgc = mysqli_num_rows($querygc);
    if ($countgc > 0) {
        $rowgc = mysqli_fetch_assoc($querygc);
        
        if ($rowu['garage_id'] == $buygarage_id) {
            $owned = 'Yes';
        } else {
            $owned = 'No';
        }
        
        $money   = $rowgc['money'];
        $gold    = $rowgc['gold'];
        $respect = $rowgc['respect'];
		$vip     = $rowgc['vip'];
		
		if ($vip == "Yes" && $rowu['role'] != "VIP") {
			$vippr = "Yes";
		} else {
			$vippr = "No";
		}
        
        if ($rowu['money'] >= $rowgc['money'] && $rowu['gold'] >= $rowgc['gold'] && $rowu['level'] >= $rowgc['min_level'] && $owned == 'No' && $vippr == 'No') {
            
            $garage_upgrade = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', garage_id = $buygarage_id WHERE id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#garage-upgrade").modal(\'show\');
            });
        </script>

        <div id="garage-upgrade" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">' . lang_key("garage-up") . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h4><span class="badge badge-info">' . lang_key("success-upgarage") . '</span></h4><br /><br />
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="images/icons/money.png" width="25%"><br />
                                    <h5>' . lang_key("money") . ': <br /><hr /><span class="badge badge-secondary">- ' . $money . '</span></h5>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/gold1.png" width="25%"><br />
                                    <h5>' . lang_key("gold") . ': <br /><hr /><span class="badge badge-secondary">- ' . $gold . '</span></h5>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/respect.png" width="25%"><br />
                                    <h5>' . lang_key("respect") . ': <br /><hr /><span class="badge badge-secondary">+ ' . $respect . '</span></h5>
                                </div>
                            </div><br /><br />
                            <button type="button" class="btn btn-success btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fab fa-get-pocket"></i> ' . lang_key("okay") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
            
        }
        
    }
}
?>
<div class="col-md-12 card bg-light card-body">

    <center><h4><i class="fa fa-arrow-circle-up"></i> <?php
echo lang_key("garage-upgrades");
?></h4></center><br />

<?php
$querygu = mysqli_query($connect, "SELECT * FROM garages ORDER BY money ASC");
while ($rowgu = mysqli_fetch_assoc($querygu)) {
?>
    <div class="row">
        <div class="col-md-4">
		    <div class="card">
                <div class="card-header text-white bg-primary">
                    <i class="fa fa-car"></i> <?php
    echo lang_key("garage");
?> #<?php
    echo $rowgu['id'];
?> <?php
    if ($rowgu['vip'] == 'Yes') {
        echo '<span class="badge badge-warning float-right"><i class="fa fa-star" aria-hidden="true"></i>  ' . lang_key("vip-only") . '</span>';
    }
?>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="fa fa-dollar-sign"></i>&nbsp;&nbsp; <?php
    echo lang_key("money");
?><span class="badge badge-primary float-right">- <?php
    echo $rowgu['money'];
?></span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-inbox"></i>&nbsp;&nbsp; <?php
    echo lang_key("gold");
?><span class="badge badge-warning float-right">- <?php
    echo $rowgu['gold'];
?></span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-server"></i>&nbsp;&nbsp; <?php
    echo lang_key("min-level");
?><span class="badge badge-info float-right"><?php
    echo $rowgu['min_level'];
?></span>
                        </li>
						<li class="list-group-item">
                            <i class="fa fa-star"></i>&nbsp;&nbsp; <?php
    echo lang_key("respect");
?><span class="badge badge-success float-right">+ <?php
    echo $rowgu['respect'];
?></span>
                        </li>
						<li class="list-group-item">
                            <i class="fa fa-car"></i>&nbsp;&nbsp; <?php
    echo lang_key("max-vehicles");
?><span class="badge badge-danger float-right"><?php
    echo $rowgu['max_vehicles'];
?></span>
                        </li>
                    </ul><br />
<?php
    if ($rowu['garage_id'] == $rowgu['id']) {
        echo '<button class="btn btn-primary btn-md btn-block" disabled><em class="fa fa-fw fa-check"></em>' . lang_key("owned") . '</button>';
    } else if ($rowu['money'] < $rowgu['money'] || $rowu['gold'] < $rowgu['gold'] || $rowu['level'] < $rowgu['min_level'] || $rowgu['vip'] == 'Yes' && $rowu['role'] != 'VIP') {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-dollar-sign"></em>' . lang_key("buy") . '</button>';
    } else {
        echo '<a href="?buygarage-id=' . $rowgu['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-dollar-sign"></i> ' . lang_key("buy") . '</a>';
    }
?>
					
                </div>
            </div><br />
		</div>
		
		<div class="col-md-8">
		    <div class="card text-white bg-primary">
                <div class="card-header">
                    <i class="fa fa-eye"></i> <?php
    echo lang_key("preview");
?>
                </div>
<div class="card-body" style="background-image: url(<?php
    echo $rowgu['image'];
?>);  background-size: 100% 100%; background-repeat: no-repeat; height: 500px;">
                
                </div>
            </div><br />
		</div>
    </div>
<?php
}
?>
</div>
<?php
footer();
?>