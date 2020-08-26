<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['adopt-id'])) {
    $pet_id = (int) $_GET['adopt-id'];
    
    $queryps = mysqli_query($connect, "SELECT * FROM `pets` WHERE id = '$pet_id' LIMIT 1");
    $countps = mysqli_num_rows($queryps);
    if ($countps > 0) {
        $rowps = mysqli_fetch_assoc($queryps);
        
        $money      = $rowps['money'];
        $gold       = $rowps['gold'];
        $respect    = $rowps['respect'];
        $bonustype  = $rowps['bonustype'];
        $bonusvalue = $rowps['bonusvalue'];
        $vip        = $rowps['vip'];
		
		if ($vip == "Yes" && $rowu['role'] != "VIP") {
			$vippr = "Yes";
		} else {
			$vippr = "No";
		}
		
        $home_id = $rowu['home_id'];
        
        $queryfs = mysqli_query($connect, "SELECT * FROM `homes` WHERE id='$home_id' LIMIT 1");
        $rowfs   = mysqli_fetch_assoc($queryfs);
        
        $ppets    = 0;
        $adopted  = 'No';
        $queryppp = mysqli_query($connect, "SELECT * FROM `player_pets` WHERE player_id = '$player_id'");
        while ($rowppp = mysqli_fetch_assoc($queryppp)) {
            $ppets = $ppets + 1;
            
            if ($pet_id == $rowppp['pet_id']) {
                $adopted = 'Yes';
            }
        }
        
        $max_pets   = $rowfs['max_pets'];
        $free_slots = $max_pets - $ppets;
        
        if ($free_slots == 0) {
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#no-space").modal(\'show\');
            });
        </script>

        <div id="no-space" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">' . lang_key("adoption") . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h4><span class="badge badge-danger">' . lang_key("adopt-nospace") . '</span></h4><br /><br />
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <img src="' . $rowps['image'] . '" width="30%"><br />
                                </div>                               
                                <div class="col-md-2"></div>
                            </div><br /><br />
                            <button type="button" class="btn btn-primary btn-md btn-block" data-dismiss="modal" aria-hidden="true"><i class="fab fa-get-pocket"></i> ' . lang_key("okay") . '</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
            
        }
        
        if ($rowu['money'] >= $rowps['money'] && $rowu['gold'] >= $rowps['gold'] && $rowu['level'] >= $rowps['min_level'] && $free_slots > 0 && $adopted == 'No' && $vippr == 'No') {
            
            if ($bonustype == 'power') {
                $pet_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', power=power+'$bonusvalue' WHERE id='$player_id'");
            }
            if ($bonustype == 'agility') {
                $pet_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', agility=agility+'$bonusvalue' WHERE id='$player_id'");
            }
            if ($bonustype == 'endurance') {
                $pet_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', endurance=endurance+'$bonusvalue' WHERE id='$player_id'");
            }
            if ($bonustype == 'intelligence') {
                $pet_pay = mysqli_query($connect, "UPDATE `players` SET money=money-'$money', gold=gold-'$gold', respect=respect+'$respect', intelligence=intelligence+'$bonusvalue' WHERE id='$player_id'");
            }
            
            $pet_adopt = mysqli_query($connect, "INSERT INTO `player_pets` (player_id, pet_id)
VALUES ('$player_id', '$pet_id')");
            
            echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#adopt-pet").modal(\'show\');
            });
        </script>

        <div id="adopt-pet" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">' . lang_key("adoption") . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h4><span class="badge badge-info">' . lang_key("adopt-success") . '</span></h4><br /><br />
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <img src="' . $rowps['image'] . '" width="45%"><br />
                                    <h5>' . ucfirst($bonustype) . ': <br /><hr /><span class="badge badge-secondary">+ ' . $bonusvalue . '</span></h5>
                                </div>                               
                                <div class="col-md-2"></div>
                            </div><br /><br />
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="images/icons/money.png" width="30%"><br />
                                    <h5>' . lang_key("money") . ': <br /><hr /><span class="badge badge-secondary">- ' . $money . '</span></h5>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/gold1.png" width="30%"><br />
                                    <h5>' . lang_key("gold") . ': <br /><hr /><span class="badge badge-secondary">- ' . $gold . '</span></h5>
                                </div>
                                <div class="col-md-4">
                                    <img src="images/icons/respect.png" width="30%"><br />
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

if (isset($_GET['return-id'])) {
    $petfr_id = (int) $_GET["return-id"];
    
    $queryspp = mysqli_query($connect, "SELECT * FROM `player_pets` WHERE pet_id='$petfr_id' and player_id='$player_id' LIMIT 1");
    $countspp = mysqli_num_rows($queryspp);
    
    if ($countspp > 0) {
        
        $querypfrc = mysqli_query($connect, "SELECT * FROM `pets` WHERE id='$petfr_id' LIMIT 1");
        $rowpfrc   = mysqli_fetch_assoc($querypfrc);
        
        $money_back   = $rowpfrc['money'] / 2;
        $gold_back    = $rowpfrc['gold'] / 2;
        $respect_back = $rowpfrc['respect'] / 2;
        $bonustypeg   = $rowpfrc['bonustype'];
        $bonusvalueg  = $rowpfrc['bonusvalue'];
        
        $return_pet = mysqli_query($connect, "DELETE FROM `player_pets` WHERE pet_id='$petfr_id' AND player_id='$player_id'");
        
        if ($bonustypeg == 'power') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', respect=respect-'$respect_back', power=power-'$bonusvalueg' WHERE id='$player_id'");
        }
        if ($bonustypeg == 'agility') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', respect=respect-'$respect_back', agility=agility-'$bonusvalueg' WHERE id='$player_id'");
        }
        if ($bonustypeg == 'endurance') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', respect=respect-'$respect_back', endurance=endurance-'$bonusvalueg' WHERE id='$player_id'");
        }
        if ($bonustypeg == 'intelligence') {
            $values_back = mysqli_query($connect, "UPDATE `players` SET money=money+'$money_back', gold=gold+'$gold_back', respect=respect-'$respect_back', intelligence=intelligence-'$bonusvalueg' WHERE id='$player_id'");
        }
        
        echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#pet-return").modal(\'show\');
            });
        </script>

        <div id="pet-return" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">' . lang_key("adoption") . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h4><span class="badge badge-info">' . lang_key("pet-return") . '</span></h4><br /><br />
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <img src="' . $rowpfrc['image'] . '" width="45%"><br />
                                    <h5>' . ucfirst($bonustypeg) . ': <br /><hr /><span class="badge badge-secondary">- ' . $bonusvalueg . '</span></h5>
                                </div>                               
                                <div class="col-md-2"></div>
                            </div><br /><br />
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="images/icons/money.png" width="25%"><br />
                                    <h5>' . lang_key("money") . ': <br /><hr /><span class="badge badge-secondary">+ ' . $money_back . '</span></h5>
                                </div>
                                <div class="col-md-6">
                                    <img src="images/icons/gold1.png" width="25%"><br />
                                    <h5>' . lang_key("gold") . ': <br /><hr /><span class="badge badge-secondary">+ ' . $gold_back . '</span></h5>
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
?>
        <div class="col-md-12 card bg-light card-body">
            
            <center><h4><i class="fa fa-paw"></i> <?php
echo lang_key("pets-shop");
?></h4></center><br />

<?php
$i       = 0;
$querypp = mysqli_query($connect, "SELECT * FROM `pets` ORDER BY min_level ASC");
$countpp = mysqli_num_rows($querypp);
while ($rowpp = mysqli_fetch_assoc($querypp)) {
    
    $pet_id   = $rowpp['id'];
    $queryppc = mysqli_query($connect, "SELECT * FROM `player_pets` WHERE pet_id='$pet_id' AND player_id='$player_id' LIMIT 1");
    $rowppc   = mysqli_fetch_assoc($queryppc);
    $countppc = mysqli_num_rows($queryppc);
    
    ++$i;
    if ($i == 1) {
        echo '<div class="row">';
    }
?>
        <div class="col-md-4">
            <center>
                <ul class="breadcrumb"><li class="active"><h6><?php
    echo $rowpp['name'];
?> <?php
    if ($rowpp['vip'] == 'Yes') {
        echo '<span class="badge badge-warning">' . lang_key("vip-only") . '</span>';
    }
?></h6></li></ul>
            </center>
            <div class="row">
                <div class="col-md-7">
                    <center><img src="<?php
    echo $rowpp['image'];
?>" width="90%"></center>
                </div>
                <div class="col-md-5">
                    <ul class="list-group">
                        <li class="list-group-item active">
                            <center><?php
    echo lang_key("pet-details");
?></center>
                        </li>
                        <li class="list-group-item"><i class="far fa-money-bill-alt"></i> <?php
    echo lang_key("money");
?><span class="badge badge-success float-right"><?php
    echo $rowpp['money'];
?></span></li>
                        <li class="list-group-item"><i class="fa fa-inbox"></i> <?php
    echo lang_key("gold");
?><span class="badge badge-warning float-right"><?php
    echo $rowpp['gold'];
?></span></li>
                        <li class="list-group-item"><i class="fa fa-server"></i> <?php
    echo lang_key("required-level");
?><span class="badge badge-info float-right"><?php
    echo $rowpp['min_level'];
?></span></li>
                        <li class="list-group-item"><i class="fa fa-life-ring"></i> <?php
    echo lang_key("bonus");
?><span class="badge badge-danger float-right">+ <?php
    echo '' . $rowpp['bonusvalue'] . ' ' . ucfirst($rowpp['bonustype']) . '';
?></span></li>
                    </ul><br />
<?php
    if ($countppc > 0) {
        echo '<a href="?return-id=' . $rowpp['id'] . '" class="btn btn-danger btn-md btn-block"><i class="fa fa-reply"></i> ' . lang_key("return-back") . '</a>';
    } else if ($rowu['money'] < $rowpp['money'] || $rowu['gold'] < $rowpp['gold'] || $rowu['level'] < $rowpp['min_level'] || $rowpp['vip'] == 'Yes' && $rowu['role'] != 'VIP') {
        echo '<button class="btn btn-warning btn-md btn-block" disabled><em class="fa fa-fw fa-paw"></em>' . lang_key("adopt") . '</button>';
    } else {
        echo '<a href="?adopt-id=' . $rowpp['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-paw"></i> ' . lang_key("adopt") . '</a>';
    }
?>
                </div>
            </div>
            <hr />
        </div>
<?php
    if ($i == $countpp) {
        echo '</div>';
    } else if (($i % 3) == 0) {
        echo '</div><div class="row">';
    }
}
?>
        </div>
<?php
footer();
?>