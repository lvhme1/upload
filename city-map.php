<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];
?>
<div class="col-md-12 card bg-light card-body">
    
	<center><h4><i class="far fa-map"></i> <?php
echo lang_key("city-map");
?></h4><br />
	
	<img src="assets/img/city.png" style="width: 70%; height: auto;" usemap="#city-map"></center>

<map name="city-map">
    <area target="" alt="Hospital" title="<?php
echo lang_key("hospital");
?>" href="hospital.php" coords="14,9,16,41,88,75,118,58,159,80,192,64,221,2,33,0" shape="poly">
    <area target="" alt="Shop" title="<?php
echo lang_key("shop");
?>" href="shop.php" coords="320,304,320,334,380,367,445,334,448,304,382,271" shape="poly">
    <area target="" alt="Bank" title="<?php
echo lang_key("bank");
?>" href="bank.php" coords="61,257,85,250,112,280,128,336,2,398,1,288" shape="poly">
    <area target="" alt="Work" title="<?php
echo lang_key("work");
?>" href="jobs.php" coords="59,94,118,59,179,94,182,205,119,237,59,208" shape="poly">
    <area target="" alt="Properties" title="<?php
echo lang_key("properties");
?>" href="properties.php" coords="73,373,96,363,242,288,267,324,278,409,136,480,71,447,71,450,71,418,71,411" shape="poly">
    <area target="" alt="Vehicles" title="<?php
echo lang_key("vehicles");
?>" href="vehicles.php" coords="454,408,451,322,520,288,639,348,638,445,580,474" shape="poly">
    <area target="" alt="Pets" title="<?php
echo lang_key("pets");
?>" href="pets.php" coords="121,249,219,297,314,254,214,204" shape="poly">
    <area target="" alt="School" title="<?php
echo lang_key("school");
?>" href="school.php" coords="341,43,517,138,609,97,613,40,538,0,367,1" shape="poly">
    <area target="" alt="Gym" title="<?php
echo lang_key("gym");
?>" href="gym.php" coords="438,274,461,193,480,158,494,188,586,142,609,193,611,248,531,289,509,290,488,299" shape="poly">
    <area target="" alt="Leaderboard" title="<?php
echo lang_key("leaderboard");
?>" href="leaderboard.php" coords="290,193,291,96,321,34,383,67,413,96,412,192,353,224" shape="poly">
    <area target="" alt="Street Races" title="<?php
echo lang_key("street-races");
?>" href="races.php" coords="236,166,241,85,277,19,318,40,291,93,287,191" shape="poly">
    <area target="" alt="Fights" title="<?php
echo lang_key("fights");
?>" href="fight-arena.php" coords="189,142,235,166,239,84,275,21,223,0,193,61,193,59" shape="poly">
</map>

</div>

<script type="text/javascript">
    $('map').imageMapResize();
</script>
<?php
footer();
?>