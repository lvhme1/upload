<?php
include "../config.php";

//Energy Refill (by default every 10 minutes)
$sqlusers = mysqli_query($connect, "SELECT * FROM `players`");
while ($rowuser = mysqli_fetch_assoc($sqlusers)) {
    if ($rowuser['energy'] < 100) {
        $userenergyrefill = mysqli_query($connect, "UPDATE `players` SET energy=energy+10 WHERE id='$rowuser[id]'");
    }
}

$sqlusers = mysqli_query($connect, "SELECT id, money, gold FROM `players` WHERE money<0 OR gold<0");
while ($rowuser = mysqli_fetch_assoc($sqlusers)) {
    if ($rowuser['money'] < 0) {
        $fix = mysqli_query($connect, "UPDATE `players` SET money='0' WHERE id='$rowuser[id]'");
    }
	if ($rowuser['gold'] < 0) {
        $fix = mysqli_query($connect, "UPDATE `players` SET gold='0' WHERE id='$rowuser[id]'");
    }
}
?>