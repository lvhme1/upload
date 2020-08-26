<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['buyquay-id'])) {
    
    $buyquay_id = (int) $_GET['buyquay-id'];
    
    $queryqc = mysqli_query($connect, "SELECT * FROM `quays` WHERE id = '$buyquay_id' LIMIT 1");
    $countqc = mysqli_num_rows($queryqc);
    if ($countqc > 0) {
        $rowqc = mysqli_fetch_assoc($queryqc);
        
        if ($rowu['quay_id'] == $buyquay_id) {
            $owned = 'Yes';
        } else {
            $owned = 'No';
        }
        
        $money   = $rowqc['money'];
        $gold    = $rowqc['gold'];
        $respect = $rowqc['respect'];
        $vip     = $rowqc['vip'];
		
		if ($vip == "Yes" && $rowu['role'] != "VIP") {
			$vippr = "Yes";
		} else {
			$vippr = "No";
		}
		
        if ($rowu['money'] >= $rowqc['money'] && $rowu['gold'] >= $rowqc['gold'] && $rowu['level'] >= $rowqc['min_level'] && $owned == 'No' && $vippr == 'No') {
            
            $quay_upgrade = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', quay_id = $buyquay_id WHERE id='$player_id'");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#quay-upgrade").modal(\'show\');
            });
        </script>

        <div id="quay-upgrade" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">' . lang_key("quay-up") . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h4><span class="badge badge-info">' . lang_key("success-upquay") . '</span></h4><br /><br />
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
echo lang_key("quay-upgrades");
?></h4></center><br />

<?php
$queryqu = mysqli_query($connect, "SELECT * FROM quays ORDER BY money ASC");
while ($rowqu = mysqli_fetch_assoc($queryqu)) {
?>
    <div class="row">
        <div class="col-md-4">
		    <div class="card">
                <div class="card-header text-white bg-primary">
                    <i class="fa fa-ship"></i> <?php
    echo lang_key("quay");
?> #<?php
    echo $rowqu['id'];
?> <?php
    if ($rowqu['vip'] == 'Yes') {
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
    echo $rowqu['money'];
?></span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-inbox"></i>&nbsp;&nbsp; <?php
    echo lang_key("gold");
?><span class="badge badge-warning float-right">- <?php
    echo $rowqu['gold'];
?></span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-server"></i>&nbsp;&nbsp; <?php
    echo lang_key("min-level");
?><span class="badge badge-info float-right"><?php
    echo $rowqu['min_level'];
?></span>
                        </li>
						<li class="list-group-item">
                            <i class="fa fa-star"></i>&nbsp;&nbsp; <?php
    echo lang_key("respect");
?><span class="badge badge-success float-right">+ <?php
    echo $rowqu['respect'];
?></span>
                        </li>
						<li class="list-group-item">
                            <i class="fa fa-plane"></i>&nbsp;&nbsp; <?php
    echo lang_key("max-vehicles");
?><span class="badge badge-danger float-right"><?php
    echo $rowqu['max_vehicles'];
?></span>
                        </li>
                    </ul><br />
<?php
    if ($rowu['quay_id'] == $rowqu['id']) {
        echo '<button class="btn btn-primary btn-md btn-block" disabled><em class="fa fa-fw fa-check"></em>' . lang_key("owned") . '</button>';
    } else if ($rowu['money'] < $rowqu['money'] || $rowu['gold'] < $rowqu['gold'] || $rowu['level'] < $rowqu['min_level'] || $rowqu['vip'] == 'Yes' && $rowu['role'] != 'VIP') {
        echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-dollar-sign"></em>' . lang_key("buy") . '</button>';
    } else {
        echo '<a href="?buyquay-id=' . $rowqu['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-dollar-sign"></i> ' . lang_key("buy") . '</a>';
    }
?>
					
                </div>
            </div><br />
		</div>
		
		<div class="col-md-8">
		    <div class="card">
                <div class="card-header text-white bg-primary">
                    <i class="fa fa-eye"></i> <?php
    echo lang_key("preview");
?>
                </div>
<div class="card-body" style="background-image: url(<?php
    echo $rowqu['image'];
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