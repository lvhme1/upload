<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];


if (isset($_GET['player_id'])) {
    $uid     = $_GET['player_id'];
    $querypl = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$uid' LIMIT 1");
    @$countpl = mysqli_num_rows($querypl);
    if ($countpl == 0) {
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
    echo '<meta http-equiv="refresh" content="1.5; url=player.php?id='.$uid.'" />';
} else {
    echo '<meta http-equiv="refresh" content="0; url=home.php" />';
    exit;
}
?>
<div class="col-md-12 card bg-light card-body">
         
<xml version="1.0" encoding="utf-8">
<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 400 250" style="enable-background:new 0 0 400 250;" xml:space="preserve" id="focus">
<g id="background">
	<rect id="XMLID_1_" style="fill:#83D1DB;" width="400" height="250"/>
</g>
<g id="city">
	<g id="XMLID_19_">
		<g id="city_1_">
			<circle id="sun" style="fill:#FFC808;" cx="203.8" cy="0.2" r="13.8"/>
			<circle id="moon" style="fill:#F7E4BA;" cx="203.2" cy="249.2" r="13.8"/>
			<g id="clouds">
				<path id="cloudLeftTop" style="opacity:0.9;fill:#FFFFFF;" d="M46.4,91.3h4.3c0.8,0,1.5-0.7,1.5-1.5c0-0.8-0.7-1.5-1.5-1.5h0.1
					c-2.6,0-4.6-2.1-4.6-4.7c0-2.6,2.1-4.7,4.6-4.7h28.9c2.6,0,4.6,2.1,4.6,4.7c0,2.6-2.1,4.7-4.6,4.7H79c-0.8,0-1.5,0.7-1.5,1.5
					c0,0.8,0.7,1.5,1.5,1.5h18.1c3,0,5.4,2.3,5.4,5.2c0,2.9-2.4,5.2-5.4,5.2H46.4c-3,0-5.4-2.3-5.4-5.2
					C41.1,93.6,43.5,91.3,46.4,91.3z"/>
				<path id="cloudMiddleTop" style="opacity:0.9;fill:#FFFFFF;" d="M236.4,85.7c0,2.5,2,4.5,4.5,4.5h27.5c2.5,0,4.5-2,4.5-4.5l0,0
					c0-2.5-2-4.5-4.5-4.5h-27.5C238.4,81.2,236.4,83.2,236.4,85.7L236.4,85.7z"/>
				<path id="cloudRightTop" style="opacity:0.9;fill:#FFFFFF;" d="M329.1,97.8h17.8c0.8,0,1.5-0.7,1.5-1.5c0-0.8-0.7-1.5-1.5-1.5
					h-0.7c-2.5,0-4.5-2-4.5-4.6c0-2.5,2-4.6,4.5-4.6h28.4c2.5,0,4.5,2,4.5,4.6c0,2.5-2,4.6-4.5,4.6h0.1c-0.8,0-1.5,0.7-1.5,1.5
					c0,0.8,0.7,1.5,1.5,1.5h4.2c2.9,0,5.3,2.3,5.3,5.1c0,2.8-2.4,5.1-5.3,5.1h-49.8c-2.9,0-5.3-2.3-5.3-5.1
					C323.8,100.1,326.2,97.8,329.1,97.8z"/>
				<path id="cloudLeftBottom" style="opacity:0.9;fill:#FFFFFF;" d="M22.1,140.4h14.4c0.7,0,1.2-0.5,1.2-1.2c0-0.7-0.5-1.2-1.2-1.2
					h-0.6c-2,0-3.7-1.7-3.7-3.7c0-2,1.7-3.7,3.7-3.7h23c2,0,3.7,1.7,3.7,3.7c0,2-1.6,3.7-3.7,3.7H59c-0.7,0-1.2,0.5-1.2,1.2
					c0,0.7,0.5,1.2,1.2,1.2h3.4c2.4,0,4.3,1.8,4.3,4.1c0,2.3-1.9,4.1-4.3,4.1H22.1c-2.4,0-4.3-1.8-4.3-4.1
					C17.8,142.2,19.7,140.4,22.1,140.4z"/>
				<path id="cloudMiddleBottom" style="opacity:0.9;fill:#FFFFFF;" d="M173.6,114.9H188c0.7,0,1.2-0.5,1.2-1.2
					c0-0.7-0.5-1.2-1.2-1.2h-0.6c-2,0-3.7-1.7-3.7-3.7c0-2,1.6-3.7,3.7-3.7h23c2,0,3.7,1.7,3.7,3.7c0,2-1.6,3.7-3.7,3.7h0.1
					c-0.7,0-1.2,0.5-1.2,1.2c0,0.7,0.5,1.2,1.2,1.2h3.4c2.4,0,4.3,1.8,4.3,4.1c0,2.3-1.9,4.1-4.3,4.1h-40.4c-2.4,0-4.3-1.8-4.3-4.1
					C169.3,116.8,171.2,114.9,173.6,114.9z"/>
			</g>
			<g id="buildings">
				<g id="buildingsYellowMiddle">
					<g id="XMLID_1280_">
						<g id="XMLID_1300_">
							<g id="XMLID_1302_">
								<rect id="XMLID_503_" x="182.9" y="169.7" style="fill:#F7E4BA;" width="32.9" height="57.8"/>
								<rect id="XMLID_502_" x="210.5" y="169.7" style="fill:#F8E0A9;" width="5.1" height="57.8"/>
							</g>
							<rect id="XMLID_501_" x="181.5" y="165.9" style="fill:#6B7273;" width="35.7" height="3.7"/>
						</g>
						<g id="yellowMiddleWindows">
							<g id="XMLID_1297_">
								<rect id="XMLID_500_" x="203.3" y="174.1" style="fill:#057399;" width="5.7" height="9.6"/>
								<polygon id="XMLID_499_" style="fill:#055F86;" points="203.3,183.8 209,183.8 203.3,174.1 								"/>
							</g>
							<g id="XMLID_1294_">
								<rect id="XMLID_498_" x="192" y="174.1" style="fill:#057399;" width="5.7" height="9.6"/>
								<polygon id="XMLID_497_" style="fill:#055F86;" points="192,183.8 197.8,183.8 192,174.1 								"/>
							</g>
							<g id="XMLID_1291_">
								<rect id="XMLID_496_" x="203.3" y="204.1" style="fill:#057399;" width="5.7" height="9.6"/>
								<polygon id="XMLID_495_" style="fill:#055F86;" points="203.3,213.7 209,213.7 203.3,204.1 								"/>
							</g>
							<g id="XMLID_1288_">
								<rect id="XMLID_494_" x="192" y="204.1" style="fill:#057399;" width="5.7" height="9.6"/>
								<polygon id="XMLID_493_" style="fill:#055F86;" points="192,213.7 197.8,213.7 192,204.1 								"/>
							</g>
							<g id="XMLID_1285_">
								<rect id="XMLID_492_" x="203.3" y="188.6" style="fill:#057399;" width="5.7" height="9.6"/>
								<polygon id="XMLID_491_" style="fill:#055F86;" points="203.3,198.2 209,198.2 203.3,188.6 								"/>
							</g>
							<g id="XMLID_1282_">
								<rect id="XMLID_490_" x="192" y="188.6" style="fill:#057399;" width="5.7" height="9.6"/>
								<polygon id="XMLID_489_" style="fill:#055F86;" points="192,198.2 197.8,198.2 192,188.6 								"/>
							</g>
						</g>
					</g>
					<g id="XMLID_1277_">
						<rect id="XMLID_488_" x="194" y="148.9" style="fill:#C33C32;" width="10.7" height="7.1"/>
						<rect id="XMLID_487_" x="193.5" y="148.9" style="fill:#343F49;" width="0.8" height="16.8"/>
					</g>
				</g>
				<g id="buildingsBlueLeft">
					<g id="XMLID_1272_">
						<rect id="XMLID_486_" x="71.4" y="186.4" style="fill:#055670;" width="42.3" height="19.3"/>
						<rect id="XMLID_485_" x="71.4" y="207.8" style="fill:#055670;" width="42.3" height="18.5"/>
						<rect id="XMLID_484_" x="70.7" y="205.2" style="fill:#74253E;" width="43.8" height="3"/>
					</g>
					<g id="XMLID_1268_">
						<rect id="XMLID_483_" x="89.9" y="219.1" style="fill:#916A28;" width="5.5" height="7.2"/>
						<polygon id="XMLID_482_" style="fill:#6E5E35;" points="89.9,219.1 95.3,226.3 89.9,226.3 						"/>
						<circle id="XMLID_481_" style="fill:#FAA31A;" cx="90.8" cy="222.7" r="0.3"/>
					</g>
					<g id="blueLeftWindows">
						<g id="XMLID_1251_">
							<g id="XMLID_1264_">
								<g id="XMLID_1265_">
									<rect id="XMLID_480_" x="87.7" y="190.9" style="fill:#9FCCD8;" width="9.2" height="3.5"/>
									<polygon id="XMLID_479_" style="fill:#85BCC8;" points="87.7,194.4 96.9,194.4 87.7,190.9 									"/>
								</g>
							</g>
							<g id="XMLID_1260_">
								<g id="XMLID_1261_">
									<rect id="XMLID_478_" x="74.4" y="190.9" style="fill:#9FCCD8;" width="9.2" height="3.5"/>
									<polygon id="XMLID_477_" style="fill:#85BCC8;" points="74.4,194.4 83.7,194.4 74.4,190.9 									"/>
								</g>
							</g>
							<g id="XMLID_1256_">
								<g id="XMLID_1257_">
									<rect id="XMLID_476_" x="87.7" y="198.6" style="fill:#9FCCD8;" width="9.2" height="3.5"/>
									<polygon id="XMLID_475_" style="fill:#85BCC8;" points="87.7,202.1 96.9,202.1 87.7,198.6 									"/>
								</g>
							</g>
							<g id="XMLID_1252_">
								<g id="XMLID_1253_">
									<rect id="XMLID_474_" x="74.4" y="198.6" style="fill:#9FCCD8;" width="9.2" height="3.5"/>
									<polygon id="XMLID_473_" style="fill:#85BCC8;" points="74.4,202.1 83.7,202.1 74.4,198.6 									"/>
								</g>
							</g>
						</g>
						<g id="XMLID_1247_">
							<g id="XMLID_1248_">
								<rect id="XMLID_472_" x="79.4" y="212.4" style="fill:#9FCCD8;" width="9.2" height="3.5"/>
								<polygon id="XMLID_471_" style="fill:#85BCC8;" points="79.4,215.8 88.7,215.8 79.4,212.4 								"/>
							</g>
						</g>
					</g>
					<g id="XMLID_1238_">
						<g id="XMLID_1243_">
							<polygon id="XMLID_470_" style="fill:#C33C32;" points="113.8,183.8 92.6,170.6 71.4,183.8 							"/>
							<polygon id="XMLID_469_" style="fill:#CE5346;" points="113.8,183.8 92.6,170.6 102.7,183.8 							"/>
						</g>
						<rect id="XMLID_468_" x="70.7" y="183.4" style="fill:#74253E;" width="43.8" height="3"/>
						<g id="XMLID_1239_">
							<ellipse id="XMLID_467_" style="fill:#9FCCD8;" cx="92.6" cy="177.6" rx="2.6" ry="2.7"/>
							<path id="XMLID_466_" style="fill:#85BCC8;" d="M90.7,175.7l3.7,3.8c-0.5,0.5-1.1,0.8-1.9,0.8c-1.5,0-2.6-1.2-2.6-2.7
								C90,176.9,90.2,176.2,90.7,175.7z"/>
						</g>
					</g>
				</g>
				<g id="buidlingsYellowRight">
					<g id="XMLID_1233_">
						<rect id="XMLID_465_" x="328.9" y="170.4" style="fill:#F7E4BA;" width="57.8" height="56.6"/>
						<rect id="XMLID_464_" x="328.9" y="158.7" style="fill:#F7E4BA;" width="57.8" height="10.2"/>
						<rect id="XMLID_463_" x="328.9" y="147" style="fill:#F7E4BA;" width="57.8" height="10.2"/>
					</g>
					<g id="yellowRightWindows">
						<g id="XMLID_1230_">
							<rect id="XMLID_462_" x="332.7" y="161.8" style="fill:#057399;" width="50.2" height="3.9"/>
							<polygon id="XMLID_461_" style="fill:#055F86;" points="332.7,165.7 382.9,165.7 332.7,161.8 							"/>
						</g>
						<g id="XMLID_1227_">
							<rect id="XMLID_460_" x="332.7" y="150.2" style="fill:#057399;" width="50.2" height="3.9"/>
							<polygon id="XMLID_459_" style="fill:#055F86;" points="332.7,154 382.9,154 332.7,150.2 							"/>
						</g>
						<g id="XMLID_1142_">
							<g id="XMLID_1224_">
								<rect id="XMLID_458_" x="377" y="174.2" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_457_" style="fill:#055F86;" points="377,180.6 380.8,180.6 377,174.2 								"/>
							</g>
							<g id="XMLID_1221_">
								<rect id="XMLID_456_" x="370" y="174.2" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_455_" style="fill:#055F86;" points="370,180.6 373.8,180.6 370,174.2 								"/>
							</g>
							<g id="XMLID_1218_">
								<rect id="XMLID_454_" x="362.9" y="174.2" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_453_" style="fill:#055F86;" points="362.9,180.6 366.7,180.6 362.9,174.2 								"/>
							</g>
							<g id="XMLID_1215_">
								<rect id="XMLID_452_" x="355.9" y="174.2" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_451_" style="fill:#055F86;" points="355.9,180.6 359.7,180.6 355.9,174.2 								"/>
							</g>
							<g id="XMLID_1212_">
								<rect id="XMLID_450_" x="377" y="192.3" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_449_" style="fill:#055F86;" points="377,198.7 380.8,198.7 377,192.3 								"/>
							</g>
							<g id="XMLID_1209_">
								<rect id="XMLID_448_" x="370" y="192.3" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_447_" style="fill:#055F86;" points="370,198.7 373.8,198.7 370,192.3 								"/>
							</g>
							<g id="XMLID_1206_">
								<rect id="XMLID_446_" x="362.9" y="192.3" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_445_" style="fill:#055F86;" points="362.9,198.7 366.7,198.7 362.9,192.3 								"/>
							</g>
							<g id="XMLID_1203_">
								<rect id="XMLID_444_" x="355.9" y="192.3" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_443_" style="fill:#055F86;" points="355.9,198.7 359.7,198.7 355.9,192.3 								"/>
							</g>
							<g id="XMLID_1200_">
								<rect id="XMLID_442_" x="377" y="183.4" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_441_" style="fill:#055F86;" points="377,189.7 380.8,189.7 377,183.4 								"/>
							</g>
							<g id="XMLID_1197_">
								<rect id="XMLID_440_" x="370" y="183.4" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_439_" style="fill:#055F86;" points="370,189.7 373.8,189.7 370,183.4 								"/>
							</g>
							<g id="XMLID_1194_">
								<rect id="XMLID_438_" x="362.9" y="183.4" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_437_" style="fill:#055F86;" points="362.9,189.7 366.7,189.7 362.9,183.4 								"/>
							</g>
							<g id="XMLID_1191_">
								<rect id="XMLID_436_" x="355.9" y="183.4" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_435_" style="fill:#055F86;" points="355.9,189.7 359.7,189.7 355.9,183.4 								"/>
							</g>
							<g id="XMLID_1188_">
								<rect id="XMLID_434_" x="348.8" y="174.2" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_433_" style="fill:#055F86;" points="348.8,180.6 352.6,180.6 348.8,174.2 								"/>
							</g>
							<g id="XMLID_1185_">
								<rect id="XMLID_432_" x="348.8" y="192.3" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_431_" style="fill:#055F86;" points="348.8,198.7 352.6,198.7 348.8,192.3 								"/>
							</g>
							<g id="XMLID_1182_">
								<rect id="XMLID_430_" x="348.8" y="183.4" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_429_" style="fill:#055F86;" points="348.8,189.7 352.6,189.7 348.8,183.4 								"/>
							</g>
							<g id="XMLID_1179_">
								<rect id="XMLID_428_" x="341.8" y="174.2" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_427_" style="fill:#055F86;" points="341.8,180.6 345.6,180.6 341.8,174.2 								"/>
							</g>
							<g id="XMLID_1176_">
								<rect id="XMLID_426_" x="341.8" y="192.3" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_425_" style="fill:#055F86;" points="341.8,198.7 345.6,198.7 341.8,192.3 								"/>
							</g>
							<g id="XMLID_1173_">
								<rect id="XMLID_424_" x="341.8" y="183.4" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_423_" style="fill:#055F86;" points="341.8,189.7 345.6,189.7 341.8,183.4 								"/>
							</g>
							<g id="XMLID_1170_">
								<rect id="XMLID_422_" x="334.8" y="174.2" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_421_" style="fill:#055F86;" points="334.8,180.6 338.5,180.6 334.8,174.2 								"/>
							</g>
							<g id="XMLID_1167_">
								<rect id="XMLID_420_" x="334.8" y="192.3" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_419_" style="fill:#055F86;" points="334.8,198.7 338.5,198.7 334.8,192.3 								"/>
							</g>
							<g id="XMLID_1164_">
								<rect id="XMLID_418_" x="377" y="201" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_417_" style="fill:#055F86;" points="377,207.4 380.8,207.4 377,201 								"/>
							</g>
							<g id="XMLID_1161_">
								<rect id="XMLID_416_" x="370" y="201" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_415_" style="fill:#055F86;" points="370,207.4 373.8,207.4 370,201 								"/>
							</g>
							<g id="XMLID_1158_">
								<rect id="XMLID_414_" x="362.9" y="201" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_413_" style="fill:#055F86;" points="362.9,207.4 366.7,207.4 362.9,201 								"/>
							</g>
							<g id="XMLID_1155_">
								<rect id="XMLID_412_" x="355.9" y="201" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_411_" style="fill:#055F86;" points="355.9,207.4 359.7,207.4 355.9,201 								"/>
							</g>
							<g id="XMLID_1152_">
								<rect id="XMLID_410_" x="348.8" y="201" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_409_" style="fill:#055F86;" points="348.8,207.4 352.6,207.4 348.8,201 								"/>
							</g>
							<g id="XMLID_1149_">
								<rect id="XMLID_408_" x="341.8" y="201" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_407_" style="fill:#055F86;" points="341.8,207.4 345.6,207.4 341.8,201 								"/>
							</g>
							<g id="XMLID_1146_">
								<rect id="XMLID_406_" x="334.8" y="201" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_405_" style="fill:#055F86;" points="334.8,207.4 338.5,207.4 334.8,201 								"/>
							</g>
							<g id="XMLID_1143_">
								<rect id="XMLID_404_" x="334.8" y="183.4" style="fill:#057399;" width="3.8" height="6.3"/>
								<polygon id="XMLID_403_" style="fill:#055F86;" points="334.8,189.7 338.5,189.7 334.8,183.4 								"/>
							</g>
						</g>
					</g>
					<g id="XMLID_1133_">
						<rect id="XMLID_402_" x="327.3" y="168.8" style="fill:#74253E;" width="60.9" height="1.5"/>
						<rect id="XMLID_401_" x="327.3" y="157.1" style="fill:#74253E;" width="60.9" height="1.5"/>
						<g id="XMLID_1134_">
							<rect id="XMLID_400_" x="327.3" y="145.4" style="fill:#74253E;" width="60.9" height="1.5"/>
							<g id="XMLID_1135_">
								<polygon id="XMLID_399_" style="fill:#C33C32;" points="328.7,145.4 340.1,136.8 375.5,136.8 386.9,145.4 								"/>
								<polygon id="XMLID_398_" style="fill:#CC4D41;" points="375,145.4 368.6,136.8 375.5,136.8 386.9,145.4 								"/>
							</g>
						</g>
					</g>
				</g>
				<g id="buildingsblueMiddle">
					<rect id="XMLID_397_" x="214.1" y="150.1" style="fill:#055670;" width="40" height="77.2"/>
					<rect id="XMLID_396_" x="249.1" y="150.1" style="fill:#2F7289;" width="2.3" height="77.2"/>
					<g id="XMLID_1121_">
						<path class="pole" style="fill:#828D97;" d="M232.5,142c0,0.5,0.4,0.9,1,0.9l0,0c0.5,0,1-0.4,1-0.9v-22
							c0-0.5-0.4-0.9-1-0.9l0,0c-0.5,0-1,0.4-1,0.9V142z"/>
						<ellipse class="ball" style="fill:#618186;" cx="233.6" cy="120.6" rx="2.3" ry="2.3"/>
						<g id="XMLID_1122_">
							<path id="XMLID_393_" style="fill:#C33C32;" d="M214.1,148.1c2.3-5.9,9-13.9,20-13.9c11,0,17.6,7.9,20,13.9H214.1z"/>
							<path id="XMLID_392_" style="fill:#D86B5C;" d="M233,134.3c0.4,0,0.7,0,1.1,0c11,0,17.6,7.9,20,13.9h-2.1
								C249.6,142.4,243.4,134.8,233,134.3z"/>
							<rect id="XMLID_391_" x="212.1" y="146.1" style="fill:#7B242F;" width="44" height="4"/>
						</g>
					</g>
					<g id="blueMiddleWindows">
						<g id="XMLID_1084_">
							<g id="XMLID_1118_">
								<rect id="XMLID_390_" x="241.3" y="154.2" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_389_" style="fill:#85BCC8;" points="241.3,158.5 250.7,158.5 241.3,154.2 								"/>
							</g>
							<g id="XMLID_1115_">
								<rect id="XMLID_388_" x="229.4" y="154.2" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_387_" style="fill:#85BCC8;" points="229.4,158.5 238.7,158.5 229.4,154.2 								"/>
							</g>
							<g id="XMLID_1112_">
								<rect id="XMLID_386_" x="217.4" y="154.2" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_385_" style="fill:#85BCC8;" points="217.4,158.5 226.8,158.5 217.4,154.2 								"/>
							</g>
							<g id="XMLID_1109_">
								<rect id="XMLID_384_" x="241.3" y="161.9" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_383_" style="fill:#85BCC8;" points="241.3,166.3 250.7,166.3 241.3,161.9 								"/>
							</g>
							<g id="XMLID_1106_">
								<rect id="XMLID_382_" x="229.4" y="161.9" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_381_" style="fill:#85BCC8;" points="229.4,166.3 238.7,166.3 229.4,161.9 								"/>
							</g>
							<g id="XMLID_1103_">
								<rect id="XMLID_380_" x="217.4" y="161.9" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_379_" style="fill:#85BCC8;" points="217.4,166.3 226.8,166.3 217.4,161.9 								"/>
							</g>
							<g id="XMLID_1100_">
								<rect id="XMLID_378_" x="241.3" y="169.7" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_377_" style="fill:#85BCC8;" points="241.3,174 250.7,174 241.3,169.7 								"/>
							</g>
							<g id="XMLID_1097_">
								<rect id="XMLID_376_" x="229.4" y="169.7" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_375_" style="fill:#85BCC8;" points="229.4,174 238.7,174 229.4,169.7 								"/>
							</g>
							<g id="XMLID_1094_">
								<rect id="XMLID_374_" x="217.4" y="169.7" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_373_" style="fill:#85BCC8;" points="217.4,174 226.8,174 217.4,169.7 								"/>
							</g>
							<g id="XMLID_1091_">
								<rect id="XMLID_372_" x="241.3" y="177.4" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_371_" style="fill:#85BCC8;" points="241.3,181.7 250.7,181.7 241.3,177.4 								"/>
							</g>
							<g id="XMLID_1088_">
								<rect id="XMLID_370_" x="229.4" y="177.4" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_369_" style="fill:#85BCC8;" points="229.4,181.7 238.7,181.7 229.4,177.4 								"/>
							</g>
							<g id="XMLID_1085_">
								<rect id="XMLID_368_" x="217.4" y="177.4" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_367_" style="fill:#85BCC8;" points="217.4,181.7 226.8,181.7 217.4,177.4 								"/>
							</g>
						</g>
						<g id="XMLID_1065_">
							<g id="XMLID_1081_">
								<rect id="XMLID_366_" x="241.3" y="205.4" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_365_" style="fill:#85BCC8;" points="241.3,209.8 250.7,209.8 241.3,205.4 								"/>
							</g>
							<g id="XMLID_1078_">
								<rect id="XMLID_364_" x="229.4" y="205.4" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_363_" style="fill:#85BCC8;" points="229.4,209.8 238.7,209.8 229.4,205.4 								"/>
							</g>
							<g id="XMLID_1075_">
								<rect id="XMLID_362_" x="217.4" y="205.4" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_361_" style="fill:#85BCC8;" points="217.4,209.8 226.8,209.8 217.4,205.4 								"/>
							</g>
							<g id="XMLID_1072_">
								<rect id="XMLID_360_" x="241.3" y="213.2" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_359_" style="fill:#85BCC8;" points="241.3,217.5 250.7,217.5 241.3,213.2 								"/>
							</g>
							<g id="XMLID_1069_">
								<rect id="XMLID_358_" x="229.4" y="213.2" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_357_" style="fill:#85BCC8;" points="229.4,217.5 238.7,217.5 229.4,213.2 								"/>
							</g>
							<g id="XMLID_1066_">
								<rect id="XMLID_356_" x="217.4" y="213.2" style="fill:#9FCCD8;" width="9.3" height="4.3"/>
								<polygon id="XMLID_355_" style="fill:#85BCC8;" points="217.4,217.5 226.8,217.5 217.4,213.2 								"/>
							</g>
						</g>
					</g>
					<g id="XMLID_1057_">
						<rect id="XMLID_354_" x="212.1" y="184.6" style="fill:#74253E;" width="44" height="1.3"/>
						<g id="XMLID_1058_">
							<g id="XMLID_536_">
								<polygon id="XMLID_537_" style="fill:#F7F8F8;" points="246,202 233.6,197.5 221.1,202 221.1,186 246,186 								"/>
							</g>
						</g>
					</g>
				</g>
				<g id="buildingsGreyLeft">
					<rect id="XMLID_352_" x="97.7" y="124.5" style="fill:#A0AAB3;" width="57.4" height="100.5"/>
					<g id="greyLeftWindows">
						<g id="XMLID_1018_">
							<g id="XMLID_1052_">
								<rect id="XMLID_351_" x="145.3" y="131.6" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_350_" style="fill:#055F86;" points="145.3,140.3 150.5,140.3 145.3,131.6 								"/>
							</g>
							<g id="XMLID_1049_">
								<rect id="XMLID_349_" x="131" y="131.6" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_348_" style="fill:#055F86;" points="131,140.3 136.2,140.3 131,131.6 								"/>
							</g>
							<g id="XMLID_1046_">
								<rect id="XMLID_347_" x="116.7" y="131.6" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_346_" style="fill:#055F86;" points="116.7,140.3 121.9,140.3 116.7,131.6 								"/>
							</g>
							<g id="XMLID_1043_">
								<rect id="XMLID_345_" x="102.4" y="131.6" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_344_" style="fill:#055F86;" points="102.4,140.3 107.6,140.3 102.4,131.6 								"/>
							</g>
							<g id="XMLID_1040_">
								<rect id="XMLID_343_" x="145.3" y="144.8" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_342_" style="fill:#055F86;" points="145.3,153.5 150.5,153.5 145.3,144.8 								"/>
							</g>
							<g id="XMLID_1037_">
								<rect id="XMLID_341_" x="131" y="144.8" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_340_" style="fill:#055F86;" points="131,153.5 136.2,153.5 131,144.8 								"/>
							</g>
							<g id="XMLID_1034_">
								<rect id="XMLID_339_" x="116.7" y="144.8" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_338_" style="fill:#055F86;" points="116.7,153.5 121.9,153.5 116.7,144.8 								"/>
							</g>
							<g id="XMLID_1031_">
								<rect id="XMLID_337_" x="102.4" y="144.8" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_336_" style="fill:#055F86;" points="102.4,153.5 107.6,153.5 102.4,144.8 								"/>
							</g>
							<g id="XMLID_1028_">
								<rect id="XMLID_335_" x="145.3" y="158" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_334_" style="fill:#055F86;" points="145.3,166.7 150.5,166.7 145.3,158 								"/>
							</g>
							<g id="XMLID_1025_">
								<rect id="XMLID_333_" x="131" y="158" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_332_" style="fill:#055F86;" points="131,166.7 136.2,166.7 131,158 								"/>
							</g>
							<g id="XMLID_1022_">
								<rect id="XMLID_331_" x="116.7" y="158" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_330_" style="fill:#055F86;" points="116.7,166.7 121.9,166.7 116.7,158 								"/>
							</g>
							<g id="XMLID_1019_">
								<rect id="XMLID_329_" x="102.4" y="158" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_328_" style="fill:#055F86;" points="102.4,166.7 107.6,166.7 102.4,158 								"/>
							</g>
						</g>
						<g id="XMLID_981_">
							<g id="XMLID_1015_">
								<rect id="XMLID_327_" x="145.3" y="171.2" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_326_" style="fill:#055F86;" points="145.3,179.9 150.5,179.9 145.3,171.2 								"/>
							</g>
							<g id="XMLID_1012_">
								<rect id="XMLID_325_" x="131" y="171.2" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_324_" style="fill:#055F86;" points="131,179.9 136.2,179.9 131,171.2 								"/>
							</g>
							<g id="XMLID_1009_">
								<rect id="XMLID_323_" x="116.7" y="171.2" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_322_" style="fill:#055F86;" points="116.7,179.9 121.9,179.9 116.7,171.2 								"/>
							</g>
							<g id="XMLID_1006_">
								<rect id="XMLID_321_" x="102.4" y="171.2" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_320_" style="fill:#055F86;" points="102.4,179.9 107.6,179.9 102.4,171.2 								"/>
							</g>
							<g id="XMLID_1003_">
								<rect id="XMLID_319_" x="145.3" y="184.4" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_318_" style="fill:#055F86;" points="145.3,193.1 150.5,193.1 145.3,184.4 								"/>
							</g>
							<g id="XMLID_1000_">
								<rect id="XMLID_317_" x="131" y="184.4" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_316_" style="fill:#055F86;" points="131,193.1 136.2,193.1 131,184.4 								"/>
							</g>
							<g id="XMLID_997_">
								<rect id="XMLID_315_" x="116.7" y="184.4" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_314_" style="fill:#055F86;" points="116.7,193.1 121.9,193.1 116.7,184.4 								"/>
							</g>
							<g id="XMLID_994_">
								<rect id="XMLID_313_" x="102.4" y="184.4" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_312_" style="fill:#055F86;" points="102.4,193.1 107.6,193.1 102.4,184.4 								"/>
							</g>
							<g id="XMLID_991_">
								<rect id="XMLID_311_" x="145.3" y="197.6" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_310_" style="fill:#055F86;" points="145.3,206.3 150.5,206.3 145.3,197.6 								"/>
							</g>
							<g id="XMLID_988_">
								<rect id="XMLID_309_" x="131" y="197.6" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_308_" style="fill:#055F86;" points="131,206.3 136.2,206.3 131,197.6 								"/>
							</g>
							<g id="XMLID_985_">
								<rect id="XMLID_307_" x="116.7" y="197.6" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_306_" style="fill:#055F86;" points="116.7,206.3 121.9,206.3 116.7,197.6 								"/>
							</g>
							<g id="XMLID_982_">
								<rect id="XMLID_305_" x="102.4" y="197.6" style="fill:#057399;" width="5.2" height="8.7"/>
								<polygon id="XMLID_304_" style="fill:#055F86;" points="102.4,206.3 107.6,206.3 102.4,197.6 								"/>
							</g>
						</g>
					</g>
					<g id="XMLID_968_">
						<rect id="XMLID_303_" x="95.8" y="168.4" style="fill:#618186;" width="62.4" height="1.1"/>
						<g id="XMLID_969_">
							<rect id="XMLID_302_" x="95.8" y="121.2" style="fill:#618186;" width="62.4" height="3.3"/>
							<path id="XMLID_301_" style="fill:#A0AAB3;" d="M107.1,111.1c2.8-8,10.4-13.8,19.3-13.8c8.9,0,16.5,5.8,19.3,13.8h9.4v10.1
								H97.7v-10.1H107.1z"/>
							<path id="XMLID_300_" style="fill:#618186;" d="M111.1,117.8c0-8.5,6.9-15.4,15.3-15.4c8.5,0,15.3,6.9,15.3,15.4"/>
						</g>
					</g>
					<g id="XMLID_964_">
						<rect id="XMLID_299_" x="152" y="111.1" style="fill:#828D97;" width="3.1" height="10.1"/>
						<rect id="XMLID_298_" x="152" y="124.5" style="fill:#828D97;" width="3.1" height="43.9"/>
						<rect id="XMLID_297_" x="152" y="169.5" style="fill:#828D97;" width="3.1" height="55.5"/>
					</g>
				</g>
				<g id="buildingsGreyRight">
					<g id="XMLID_954_">
						<g id="XMLID_956_">
							<rect id="XMLID_296_" x="257" y="104.5" style="fill:#828D97;" width="54" height="13.8"/>
							<rect id="XMLID_295_" x="273" y="97.2" style="fill:#828D97;" width="22.1" height="10"/>
							<path id="XMLID_294_" style="fill:#828D97;" d="M283,101.4c0,0.5,0.4,0.9,1,0.9l0,0c0.5,0,1-0.4,1-0.9v-22
								c0-0.5-0.4-0.9-1-0.9l0,0c-0.5,0-1,0.4-1,0.9V101.4z"/>
							<ellipse id="XMLID_293_" style="fill:#618186;" cx="284" cy="80" rx="2.3" ry="2.3"/>
						</g>
						<rect id="XMLID_292_" x="252.3" y="116.7" style="fill:#A0AAB3;" width="63.4" height="108.3"/>
					</g>
					<g id="greyRightWindows">
						<g id="XMLID_938_">
							<g id="XMLID_951_">
								<rect id="XMLID_291_" x="298.8" y="109.4" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_290_" style="fill:#055F86;" points="298.8,113.2 306.1,113.2 298.8,109.4 								"/>
							</g>
							<g id="XMLID_948_">
								<rect id="XMLID_289_" x="289.3" y="109.4" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_288_" style="fill:#055F86;" points="289.3,113.2 296.7,113.2 289.3,109.4 								"/>
							</g>
							<g id="XMLID_945_">
								<rect id="XMLID_287_" x="279.9" y="109.4" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_286_" style="fill:#055F86;" points="279.9,113.2 287.2,113.2 279.9,109.4 								"/>
							</g>
							<g id="XMLID_942_">
								<rect id="XMLID_285_" x="270.1" y="109.4" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_284_" style="fill:#055F86;" points="270.1,113.2 277.4,113.2 270.1,109.4 								"/>
							</g>
							<g id="XMLID_939_">
								<rect id="XMLID_283_" x="260.6" y="109.4" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_282_" style="fill:#055F86;" points="260.6,113.2 268,113.2 260.6,109.4 								"/>
							</g>
						</g>
						<g id="XMLID_935_">
							<rect id="XMLID_281_" x="266.9" y="207.4" style="fill:#057399;" width="34.3" height="17.6"/>
							<polygon id="XMLID_280_" style="fill:#055F86;" points="266.9,225 301.3,225 266.9,207.4 							"/>
						</g>
						<g id="XMLID_714_">
							<g id="XMLID_932_">
								<rect id="XMLID_279_" x="285.5" y="129.7" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_278_" style="fill:#055F86;" points="285.5,133.4 292.8,133.4 285.5,129.7 								"/>
							</g>
							<g id="XMLID_929_">
								<rect id="XMLID_277_" x="294.9" y="143.2" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_276_" style="fill:#055F86;" points="294.9,147 302.3,147 294.9,143.2 								"/>
							</g>
							<g id="XMLID_926_">
								<rect id="XMLID_275_" x="275.6" y="129.7" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_274_" style="fill:#055F86;" points="275.6,133.4 283,133.4 275.6,129.7 								"/>
							</g>
							<g id="XMLID_923_">
								<rect id="XMLID_273_" x="266.2" y="129.7" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_272_" style="fill:#055F86;" points="266.2,133.4 273.6,133.4 266.2,129.7 								"/>
							</g>
							<g id="XMLID_920_">
								<rect id="XMLID_271_" x="256.7" y="129.7" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_270_" style="fill:#055F86;" points="256.7,133.4 264.1,133.4 256.7,129.7 								"/>
							</g>
							<g id="XMLID_917_">
								<rect id="XMLID_269_" x="304.4" y="122.5" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_268_" style="fill:#055F86;" points="304.4,126.2 311.7,126.2 304.4,122.5 								"/>
							</g>
							<g id="XMLID_914_">
								<rect id="XMLID_267_" x="294.9" y="122.5" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_266_" style="fill:#055F86;" points="294.9,126.2 302.3,126.2 294.9,122.5 								"/>
							</g>
							<g id="XMLID_911_">
								<rect id="XMLID_265_" x="285.5" y="122.5" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_264_" style="fill:#055F86;" points="285.5,126.2 292.8,126.2 285.5,122.5 								"/>
							</g>
							<g id="XMLID_908_">
								<rect id="XMLID_263_" x="304.4" y="129.2" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_262_" style="fill:#055F86;" points="304.4,133 311.7,133 304.4,129.2 								"/>
							</g>
							<g id="XMLID_905_">
								<rect id="XMLID_261_" x="294.9" y="129.2" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_260_" style="fill:#055F86;" points="294.9,133 302.3,133 294.9,129.2 								"/>
							</g>
							<g id="XMLID_902_">
								<rect id="XMLID_259_" x="304.4" y="136" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_258_" style="fill:#055F86;" points="304.4,139.8 311.7,139.8 304.4,136 								"/>
							</g>
							<g id="XMLID_899_">
								<rect id="XMLID_257_" x="294.9" y="136" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_256_" style="fill:#055F86;" points="294.9,139.8 302.3,139.8 294.9,136 								"/>
							</g>
							<g id="XMLID_896_">
								<rect id="XMLID_255_" x="285.5" y="136" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_254_" style="fill:#055F86;" points="285.5,139.8 292.8,139.8 285.5,136 								"/>
							</g>
							<g id="XMLID_893_">
								<rect id="XMLID_253_" x="304.4" y="142.8" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_252_" style="fill:#055F86;" points="304.4,146.6 311.7,146.6 304.4,142.8 								"/>
							</g>
							<g id="XMLID_890_">
								<rect id="XMLID_251_" x="285.5" y="142.8" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_250_" style="fill:#055F86;" points="285.5,146.6 292.8,146.6 285.5,142.8 								"/>
							</g>
							<g id="XMLID_887_">
								<rect id="XMLID_249_" x="275.6" y="122.5" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_248_" style="fill:#055F86;" points="275.6,126.2 283,126.2 275.6,122.5 								"/>
							</g>
							<g id="XMLID_884_">
								<rect id="XMLID_247_" x="266.2" y="122.5" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_246_" style="fill:#055F86;" points="266.2,126.2 273.6,126.2 266.2,122.5 								"/>
							</g>
							<g id="XMLID_881_">
								<rect id="XMLID_245_" x="256.7" y="122.5" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_244_" style="fill:#055F86;" points="256.7,126.2 264.1,126.2 256.7,122.5 								"/>
							</g>
							<g id="XMLID_878_">
								<rect id="XMLID_243_" x="275.6" y="136" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_242_" style="fill:#055F86;" points="275.6,139.8 283,139.8 275.6,136 								"/>
							</g>
							<g id="XMLID_875_">
								<rect id="XMLID_241_" x="266.2" y="136" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_240_" style="fill:#055F86;" points="266.2,139.8 273.6,139.8 266.2,136 								"/>
							</g>
							<g id="XMLID_872_">
								<rect id="XMLID_239_" x="256.7" y="136" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_238_" style="fill:#055F86;" points="256.7,139.8 264.1,139.8 256.7,136 								"/>
							</g>
							<g id="XMLID_869_">
								<rect id="XMLID_237_" x="275.6" y="142.8" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_236_" style="fill:#055F86;" points="275.6,146.6 283,146.6 275.6,142.8 								"/>
							</g>
							<g id="XMLID_866_">
								<rect id="XMLID_235_" x="266.2" y="142.8" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_234_" style="fill:#055F86;" points="266.2,146.6 273.6,146.6 266.2,142.8 								"/>
							</g>
							<g id="XMLID_863_">
								<rect id="XMLID_233_" x="256.7" y="142.8" style="fill:#057399;" width="7.4" height="3.8"/>
								<polygon id="XMLID_232_" style="fill:#055F86;" points="256.7,146.6 264.1,146.6 256.7,142.8 								"/>
							</g>
							<g id="XMLID_826_">
								<g id="XMLID_860_">
									<rect id="XMLID_231_" x="304.4" y="150.5" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_230_" style="fill:#055F86;" points="304.4,154.2 311.7,154.2 304.4,150.5 									"/>
								</g>
								<g id="XMLID_857_">
									<rect id="XMLID_229_" x="294.9" y="150.5" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_228_" style="fill:#055F86;" points="294.9,154.2 302.3,154.2 294.9,150.5 									"/>
								</g>
								<g id="XMLID_854_">
									<rect id="XMLID_227_" x="285.5" y="150.5" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_226_" style="fill:#055F86;" points="285.5,154.2 292.8,154.2 285.5,150.5 									"/>
								</g>
								<g id="XMLID_851_">
									<rect id="XMLID_225_" x="304.4" y="157.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_224_" style="fill:#055F86;" points="304.4,161 311.7,161 304.4,157.2 									"/>
								</g>
								<g id="XMLID_848_">
									<rect id="XMLID_223_" x="294.9" y="157.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_222_" style="fill:#055F86;" points="294.9,161 302.3,161 294.9,157.2 									"/>
								</g>
								<g id="XMLID_845_">
									<rect id="XMLID_221_" x="285.5" y="157.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_220_" style="fill:#055F86;" points="285.5,161 292.8,161 285.5,157.2 									"/>
								</g>
								<g id="XMLID_842_">
									<rect id="XMLID_219_" x="304.4" y="164" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_218_" style="fill:#055F86;" points="304.4,167.8 311.7,167.8 304.4,164 									"/>
								</g>
								<g id="XMLID_839_">
									<rect id="XMLID_217_" x="294.9" y="164" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_216_" style="fill:#055F86;" points="294.9,167.8 302.3,167.8 294.9,164 									"/>
								</g>
								<g id="XMLID_836_">
									<rect id="XMLID_215_" x="285.5" y="164" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_214_" style="fill:#055F86;" points="285.5,167.8 292.8,167.8 285.5,164 									"/>
								</g>
								<g id="XMLID_833_">
									<rect id="XMLID_213_" x="304.4" y="170.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_212_" style="fill:#055F86;" points="304.4,174.5 311.7,174.5 304.4,170.8 									"/>
								</g>
								<g id="XMLID_830_">
									<rect id="XMLID_211_" x="294.9" y="170.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_210_" style="fill:#055F86;" points="294.9,174.5 302.3,174.5 294.9,170.8 									"/>
								</g>
								<g id="XMLID_827_">
									<rect id="XMLID_209_" x="285.5" y="170.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_208_" style="fill:#055F86;" points="285.5,174.5 292.8,174.5 285.5,170.8 									"/>
								</g>
							</g>
							<g id="XMLID_789_">
								<g id="XMLID_823_">
									<rect id="XMLID_207_" x="275.6" y="150.5" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_206_" style="fill:#055F86;" points="275.6,154.2 283,154.2 275.6,150.5 									"/>
								</g>
								<g id="XMLID_820_">
									<rect id="XMLID_205_" x="266.2" y="150.5" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_204_" style="fill:#055F86;" points="266.2,154.2 273.6,154.2 266.2,150.5 									"/>
								</g>
								<g id="XMLID_817_">
									<rect id="XMLID_203_" x="256.7" y="150.5" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_202_" style="fill:#055F86;" points="256.7,154.2 264.1,154.2 256.7,150.5 									"/>
								</g>
								<g id="XMLID_814_">
									<rect id="XMLID_201_" x="275.6" y="157.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_200_" style="fill:#055F86;" points="275.6,161 283,161 275.6,157.2 									"/>
								</g>
								<g id="XMLID_811_">
									<rect id="XMLID_199_" x="266.2" y="157.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_198_" style="fill:#055F86;" points="266.2,161 273.6,161 266.2,157.2 									"/>
								</g>
								<g id="XMLID_808_">
									<rect id="XMLID_197_" x="256.7" y="157.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_196_" style="fill:#055F86;" points="256.7,161 264.1,161 256.7,157.2 									"/>
								</g>
								<g id="XMLID_805_">
									<rect id="XMLID_195_" x="275.6" y="164" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_194_" style="fill:#055F86;" points="275.6,167.8 283,167.8 275.6,164 									"/>
								</g>
								<g id="XMLID_802_">
									<rect id="XMLID_193_" x="266.2" y="164" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_192_" style="fill:#055F86;" points="266.2,167.8 273.6,167.8 266.2,164 									"/>
								</g>
								<g id="XMLID_799_">
									<rect id="XMLID_191_" x="256.7" y="164" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_190_" style="fill:#055F86;" points="256.7,167.8 264.1,167.8 256.7,164 									"/>
								</g>
								<g id="XMLID_796_">
									<rect id="XMLID_189_" x="275.6" y="170.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_188_" style="fill:#055F86;" points="275.6,174.5 283,174.5 275.6,170.8 									"/>
								</g>
								<g id="XMLID_793_">
									<rect id="XMLID_187_" x="266.2" y="170.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_186_" style="fill:#055F86;" points="266.2,174.5 273.6,174.5 266.2,170.8 									"/>
								</g>
								<g id="XMLID_790_">
									<rect id="XMLID_185_" x="256.7" y="170.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_184_" style="fill:#055F86;" points="256.7,174.5 264.1,174.5 256.7,170.8 									"/>
								</g>
							</g>
							<g id="XMLID_752_">
								<g id="XMLID_786_">
									<rect id="XMLID_183_" x="304.4" y="178.4" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_182_" style="fill:#055F86;" points="304.4,182.2 311.7,182.2 304.4,178.4 									"/>
								</g>
								<g id="XMLID_783_">
									<rect id="XMLID_181_" x="294.9" y="178.4" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_180_" style="fill:#055F86;" points="294.9,182.2 302.3,182.2 294.9,178.4 									"/>
								</g>
								<g id="XMLID_780_">
									<rect id="XMLID_179_" x="285.5" y="178.4" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_178_" style="fill:#055F86;" points="285.5,182.2 292.8,182.2 285.5,178.4 									"/>
								</g>
								<g id="XMLID_777_">
									<rect id="XMLID_177_" x="304.4" y="185.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_176_" style="fill:#055F86;" points="304.4,189 311.7,189 304.4,185.2 									"/>
								</g>
								<g id="XMLID_774_">
									<rect id="XMLID_175_" x="294.9" y="185.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_174_" style="fill:#055F86;" points="294.9,189 302.3,189 294.9,185.2 									"/>
								</g>
								<g id="XMLID_771_">
									<rect id="XMLID_173_" x="285.5" y="185.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_172_" style="fill:#055F86;" points="285.5,189 292.8,189 285.5,185.2 									"/>
								</g>
								<g id="XMLID_768_">
									<rect id="XMLID_171_" x="304.4" y="192" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_170_" style="fill:#055F86;" points="304.4,195.8 311.7,195.8 304.4,192 									"/>
								</g>
								<g id="XMLID_765_">
									<rect id="XMLID_169_" x="294.9" y="192" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_168_" style="fill:#055F86;" points="294.9,195.8 302.3,195.8 294.9,192 									"/>
								</g>
								<g id="XMLID_762_">
									<rect id="XMLID_167_" x="285.5" y="192" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_166_" style="fill:#055F86;" points="285.5,195.8 292.8,195.8 285.5,192 									"/>
								</g>
								<g id="XMLID_759_">
									<rect id="XMLID_165_" x="304.4" y="198.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_164_" style="fill:#055F86;" points="304.4,202.5 311.7,202.5 304.4,198.8 									"/>
								</g>
								<g id="XMLID_756_">
									<rect id="XMLID_163_" x="294.9" y="198.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_162_" style="fill:#055F86;" points="294.9,202.5 302.3,202.5 294.9,198.8 									"/>
								</g>
								<g id="XMLID_753_">
									<rect id="XMLID_161_" x="285.5" y="198.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_160_" style="fill:#055F86;" points="285.5,202.5 292.8,202.5 285.5,198.8 									"/>
								</g>
							</g>
							<g id="XMLID_715_">
								<g id="XMLID_749_">
									<rect id="XMLID_159_" x="275.6" y="178.4" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_158_" style="fill:#055F86;" points="275.6,182.2 283,182.2 275.6,178.4 									"/>
								</g>
								<g id="XMLID_746_">
									<rect id="XMLID_157_" x="266.2" y="178.4" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_156_" style="fill:#055F86;" points="266.2,182.2 273.6,182.2 266.2,178.4 									"/>
								</g>
								<g id="XMLID_743_">
									<rect id="XMLID_155_" x="256.7" y="178.4" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_154_" style="fill:#055F86;" points="256.7,182.2 264.1,182.2 256.7,178.4 									"/>
								</g>
								<g id="XMLID_740_">
									<rect id="XMLID_153_" x="275.6" y="185.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_152_" style="fill:#055F86;" points="275.6,189 283,189 275.6,185.2 									"/>
								</g>
								<g id="XMLID_737_">
									<rect id="XMLID_151_" x="266.2" y="185.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_150_" style="fill:#055F86;" points="266.2,189 273.6,189 266.2,185.2 									"/>
								</g>
								<g id="XMLID_734_">
									<rect id="XMLID_149_" x="256.7" y="185.2" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_148_" style="fill:#055F86;" points="256.7,189 264.1,189 256.7,185.2 									"/>
								</g>
								<g id="XMLID_731_">
									<rect id="XMLID_147_" x="275.6" y="192" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_146_" style="fill:#055F86;" points="275.6,195.8 283,195.8 275.6,192 									"/>
								</g>
								<g id="XMLID_728_">
									<rect id="XMLID_145_" x="266.2" y="192" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_144_" style="fill:#055F86;" points="266.2,195.8 273.6,195.8 266.2,192 									"/>
								</g>
								<g id="XMLID_725_">
									<rect id="XMLID_143_" x="256.7" y="192" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_142_" style="fill:#055F86;" points="256.7,195.8 264.1,195.8 256.7,192 									"/>
								</g>
								<g id="XMLID_722_">
									<rect id="XMLID_141_" x="275.6" y="198.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_140_" style="fill:#055F86;" points="275.6,202.5 283,202.5 275.6,198.8 									"/>
								</g>
								<g id="XMLID_719_">
									<rect id="XMLID_139_" x="266.2" y="198.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_138_" style="fill:#055F86;" points="266.2,202.5 273.6,202.5 266.2,198.8 									"/>
								</g>
								<g id="XMLID_716_">
									<rect id="XMLID_137_" x="256.7" y="198.8" style="fill:#057399;" width="7.4" height="3.8"/>
									<polygon id="XMLID_136_" style="fill:#055F86;" points="256.7,202.5 264.1,202.5 256.7,198.8 									"/>
								</g>
							</g>
						</g>
					</g>
					<g id="XMLID_702_">
						<g id="XMLID_708_">
							<g id="XMLID_711_">
								<path id="XMLID_135_" style="fill:#32B77C;" d="M304,225c0,0-2.4-6.3,4.7-8.6c7.1,2.3,4.7,8.6,4.7,8.6"/>
							</g>
							<g id="XMLID_709_" style="opacity:0.1;">
								<path id="XMLID_134_" style="fill:#0D0E0E;" d="M313.3,225c0,0,2.4-6.3-4.7-8.6v8.6"/>
							</g>
						</g>
						<g id="XMLID_703_">
							<g id="XMLID_706_">
								<path id="XMLID_133_" style="fill:#32B77C;" d="M254.2,225c0,0-2.4-6.3,4.7-8.6c7.1,2.3,4.7,8.6,4.7,8.6"/>
							</g>
							<g id="XMLID_704_" style="opacity:0.1;">
								<path id="XMLID_132_" style="fill:#0D0E0E;" d="M263.6,225c0,0,2.4-6.3-4.7-8.6v8.6"/>
							</g>
						</g>
					</g>
				</g>
				<g id="buildingsredShop">
					<g id="base">
						<rect id="XMLID_131_" x="2.6" y="189.3" style="fill:#C33C32;" width="44.7" height="33.4"/>
						<g id="XMLID_667_">
							<path id="XMLID_130_" style="fill:#981B1E;" d="M48.7,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H48.7z"/>
							<path id="XMLID_129_" style="fill:#B6BBBF;" d="M44.4,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H44.4z"/>
							<path id="XMLID_128_" style="fill:#981B1E;" d="M40.1,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H40.1z"/>
							<path id="XMLID_127_" style="fill:#B6BBBF;" d="M35.7,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H35.7z"/>
							<path id="XMLID_126_" style="fill:#981B1E;" d="M31.4,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H31.4z"/>
							<path id="XMLID_125_" style="fill:#B6BBBF;" d="M27.1,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H27.1z"/>
							<path id="XMLID_124_" style="fill:#981B1E;" d="M22.8,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H22.8z"/>
							<path id="XMLID_123_" style="fill:#B6BBBF;" d="M18.5,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H18.5z"/>
							<path id="XMLID_122_" style="fill:#981B1E;" d="M14.2,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H14.2z"/>
							<path id="XMLID_121_" style="fill:#B6BBBF;" d="M9.9,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H9.9z"/>
							<path id="XMLID_120_" style="fill:#981B1E;" d="M5.6,188.2v2.6c0,1.2-1,2.2-2.2,2.2c-1.2,0-2.2-1-2.2-2.2v-2.6H5.6z"/>
							<polygon id="XMLID_119_" style="fill:#C33C32;" points="43.2,180.1 48.7,188.2 44.4,188.2 39.7,180.1 							"/>
							<polygon id="XMLID_118_" style="fill:#E6E5E7;" points="39.7,180.1 44.4,188.2 40.1,188.2 36.3,180.1 							"/>
							<polygon id="XMLID_117_" style="fill:#C33C32;" points="36.5,180.1 40.1,188.2 35.7,188.2 32.7,180.1 							"/>
							<polygon id="XMLID_116_" style="fill:#E6E5E7;" points="32.7,180.1 35.7,188.2 31.4,188.2 29.9,180.1 							"/>
							<polygon id="XMLID_115_" style="fill:#C33C32;" points="29.9,180.1 31.4,188.2 27.1,188.2 26.7,180.1 							"/>
							<polygon id="XMLID_114_" style="fill:#E6E5E7;" points="26.7,180.1 27.1,188.2 22.8,188.2 23.4,180.1 							"/>
							<polygon id="XMLID_113_" style="fill:#C33C32;" points="23.4,180.1 22.8,188.2 18.5,188.2 20.2,180.1 							"/>
							<polygon id="XMLID_112_" style="fill:#E6E5E7;" points="20.2,180.1 18.5,188.2 14.2,188.2 16.9,180.1 							"/>
							<polygon id="XMLID_111_" style="fill:#C33C32;" points="17.2,180.1 14.2,188.2 9.9,188.2 13.5,180.1 							"/>
							<polygon id="XMLID_110_" style="fill:#E6E5E7;" points="13.5,180.1 9.9,188.2 5.6,188.2 9.7,180.1 							"/>
							<polygon id="XMLID_109_" style="fill:#C33C32;" points="9.7,180.1 5.6,188.2 1.3,188.2 5.7,180.1 							"/>
						</g>
						
							<rect id="XMLID_108_" x="5.5" y="203.8" style="fill:#A11D21;stroke:#981B1E;stroke-width:0.8594;stroke-miterlimit:10;" width="11.9" height="18.9"/>
						<rect id="XMLID_107_" x="-1.3" y="222.3" style="fill:#A11D21;" width="52.5" height="2.7"/>
						<rect id="XMLID_106_" x="17.7" y="219.5" style="fill:#A11D21;" width="29.6" height="1.3"/>
						<circle id="XMLID_101_" style="fill:#B6BBBF;" cx="15.7" cy="213" r="0.6"/>
					</g>
					<g id="redShopWindow">
						<g id="XMLID_654_">
							<rect id="XMLID_100_" x="24.2" y="198.5" style="fill:#9FCCD8;" width="21.4" height="19"/>
							<polygon id="XMLID_99_" style="fill:#85BCC8;" points="24.2,217.5 45.6,217.5 24.2,198.5 							"/>
						</g>
						<g id="XMLID_659_">
							<path id="XMLID_105_" style="fill:#85BCC8;" d="M12.2,199v-4c2.8,0.1,5.5,0.9,5.5,2.4v1.6H12.2z"/>
							<path id="XMLID_104_" style="fill:#85BCC8;" d="M10.6,199H5.1v-1.6c0-1.5,2.7-2.3,5.5-2.4V199z"/>
							<rect id="XMLID_103_" x="5.1" y="199.6" style="fill:#85BCC8;" width="5.5" height="2.7"/>
							<rect id="XMLID_102_" x="12.2" y="199.6" style="fill:#85BCC8;" width="5.5" height="2.7"/>
						</g>
					</g>
				</g>
			</g>
			<g id="street">
				<rect id="XMLID_98_" x="-1.5" y="225" style="fill:#F0EDED;" width="401.6" height="10.3"/>
				<polygon id="XMLID_97_" style="fill:#7E8B8A;" points="400.1,233.2 400.1,241.7 400.1,250.2 -1.5,250.2 -1.5,241.7 -1.5,233.2 
									"/>
			</g>
			<g id="trees">
				<g id="treeRight">
					<rect id="XMLID_91_" x="324.1" y="217.2" style="fill:#B76C57;" width="1.7" height="9.4"/>
					<path id="XMLID_90_" style="fill:#32B77C;" d="M318.2,202.2c0-3.7,3-6.7,6.7-6.7c3.7,0,6.7,3,6.7,6.7v10c0,3.7-3,6.7-6.7,6.7
						c-3.7,0-6.7-3-6.7-6.7V202.2z"/>
					<path id="XMLID_89_" style="opacity:0.1;fill:#0D0E0E;" d="M331.6,202.2v10c0,3.7-3,6.7-6.7,6.7v-23.4
						C328.6,195.5,331.6,198.5,331.6,202.2z"/>
				</g>
				<g id="treeMiddle">
					<rect id="XMLID_88_" x="167.2" y="218.2" style="fill:#B76C57;" width="1.7" height="9.4"/>
					<path id="XMLID_87_" style="fill:#32B77C;" d="M161.4,203.2c0-3.7,3-6.7,6.7-6.7c3.7,0,6.7,3,6.7,6.7v10c0,3.7-3,6.7-6.7,6.7
						c-3.7,0-6.7-3-6.7-6.7V203.2z"/>
					<path id="XMLID_86_" style="opacity:0.1;fill:#0D0E0E;" d="M174.7,203.2v10c0,3.7-3,6.7-6.7,6.7v-23.4
						C171.8,196.5,174.7,199.5,174.7,203.2z"/>
				</g>
				<g id="treeLeft">
					<rect id="XMLID_85_" x="58.4" y="218.2" style="fill:#B76C57;" width="1.7" height="9.4"/>
					<path id="XMLID_84_" style="fill:#32B77C;" d="M52.5,203.2c0-3.7,3-6.7,6.7-6.7c3.7,0,6.7,3,6.7,6.7v10c0,3.7-3,6.7-6.7,6.7
						c-3.7,0-6.7-3-6.7-6.7V203.2z"/>
					<path id="XMLID_83_" style="opacity:0.1;fill:#0D0E0E;" d="M65.9,203.2v10c0,3.7-3,6.7-6.7,6.7v-23.4
						C62.9,196.5,65.9,199.5,65.9,203.2z"/>
				</g>
			</g>
			<g id="cars">
				<g id="blueCar">
					<path id="XMLID_82_" style="fill:#F7F07F;" d="M317,239.4c0,0.3-0.2,0.6-0.5,0.6h-0.7c-0.3,0-0.7-0.3-0.7-0.6v-1.7
						c0-0.3,0.4-0.6,0.7-0.6h0.7c0.3,0,0.5,0.3,0.5,0.6V239.4z"/>
					<path id="XMLID_81_" style="fill:#E82128;" d="M359,236.9c0.1,0.5-0.2,0.9-0.6,1l-0.8,0.2c-0.5,0.1-0.9-0.2-1-0.6l0,0
						c-0.1-0.5,0.2-0.9,0.6-1l0.8-0.2C358.4,236.1,358.9,236.4,359,236.9L359,236.9z"/>
					<path id="XMLID_80_" style="fill:#057399;" d="M347.1,227c-3.1,0-11.1,0-11.1,0c-3.9,0-7,4-8.2,6h-8.7c-1.9,0-4.1,1.1-4.1,3v4
						h12.4h18.2h3.4h9.9C356.1,225,348,227,347.1,227z"/>
					<path id="XMLID_79_" style="fill:#B0B0B0;" d="M361,239.3c0,0.4-0.5,0.7-0.9,0.7h-43.2c-0.4,0-0.9-0.3-0.9-0.7v-0.5
						c0-0.4,0.4-0.7,0.9-0.7h43.2c0.4,0,0.9,0.3,0.9,0.7V239.3z"/>
					<g id="XMLID_621_">
						<ellipse id="XMLID_78_" style="fill:#333333;" cx="323.8" cy="240.1" rx="3.7" ry="3.8"/>
						<path id="XMLID_77_" style="fill:#B0B0B0;" d="M326.3,240.1c0,1.4-1.1,2.5-2.5,2.5c-1.4,0-2.5-1.1-2.5-2.5
							c0-1.4,1.1-2.5,2.5-2.5C325.2,237.6,326.3,238.7,326.3,240.1z"/>
						<ellipse id="XMLID_76_" style="fill:#C8C8C8;" cx="323.8" cy="240.1" rx="1.9" ry="1.9"/>
					</g>
					<g id="XMLID_617_">
						<ellipse id="XMLID_75_" style="fill:#333333;" cx="351.2" cy="240.1" rx="3.7" ry="3.8"/>
						<path id="XMLID_74_" style="fill:#B0B0B0;" d="M353.7,240.1c0,1.4-1.1,2.5-2.5,2.5c-1.4,0-2.5-1.1-2.5-2.5
							c0-1.4,1.1-2.5,2.5-2.5C352.6,237.6,353.7,238.7,353.7,240.1z"/>
						<ellipse id="XMLID_73_" style="fill:#C8C8C8;" cx="351.2" cy="240.1" rx="1.9" ry="1.9"/>
					</g>
					<path id="XMLID_72_" style="fill:#A8CEDE;" d="M329.4,233h24.8c0,0-2.6-4.5-7.1-4.5c0,0-8.2,0-11.2,0
						C334.6,228.5,332.1,230,329.4,233z"/>
					<rect id="XMLID_71_" x="340" y="228" style="fill:#057399;" width="1" height="5"/>
					<path id="XMLID_70_" style="fill:#055F86;" d="M340,235.2c0,0.4-0.4,0.8-0.9,0.8h-1.4c-0.4,0-0.8-0.4-0.8-0.8v-0.4
						c0-0.4,0.3-0.8,0.8-0.8h1.4c0.4,0,0.9,0.4,0.9,0.8V235.2z"/>
					<path id="XMLID_69_" style="fill:#055F86;" d="M343,235c0,0.6-0.4,1-1,1l0,0c-0.6,0-1-0.4-1-1l0,0c0-0.6,0.4-1,1-1l0,0
						C342.6,234,343,234.4,343,235L343,235z"/>
					<path id="XMLID_68_" style="fill:#055F86;" d="M333,231.8c0-0.4-0.3-0.7-0.6-0.7l-3.8,0.3c-0.4,0-1.6,0.3-1.6,0.7v1.1
						c0,0.4,1.3,0.6,1.6,0.6l3.2-0.3c0.4,0,1.1-0.2,1.1-0.6V231.8z"/>
				</g>
				<g id="greenCar">
					<path id="XMLID_67_" style="fill:#F7F07F;" d="M53,235.9c0,0.3-0.6,1.1-1.1,1.1h-0.1c-0.5,0-0.8-0.7-0.8-1.1v-1.6
						c0-0.3,0.3-0.3,0.8-0.3h0.1c0.5,0,1.1,0,1.1,0.3V235.9z"/>
					<path id="XMLID_66_" style="fill:#E82128;" d="M96.3,235c0.1,0.5-0.2,0.9-0.6,1l-0.8,0.2c-0.5,0.1-0.9-0.2-1-0.6l0,0
						c-0.1-0.5,0.2-0.9,0.6-1l0.8-0.2C95.7,234.3,96.2,234.6,96.3,235L96.3,235z"/>
					<path id="XMLID_65_" style="fill:#088F46;" d="M84.4,225c-3.1,0-11.1,0-11.1,0c-3.9,0-7,5-8.2,6h-8.7c-1.9,0-5.4,1.3-5.4,3.2
						v3.8h13.7h18.2h3.4h9.9C93.3,225,85.3,225,84.4,225z"/>
					<path id="XMLID_64_" style="fill:#B0B0B0;" d="M97,237.8c0,0.4-0.8,0.2-1.4,0.2H52.9c-0.6,0-0.9,0.2-0.9-0.2v-0.4
						c0-0.4,0.3-0.3,0.9-0.3h42.7c0.6,0,1.4-0.1,1.4,0.3V237.8z"/>
					<g id="XMLID_603_">
						<ellipse id="XMLID_63_" style="fill:#333333;" cx="61.1" cy="238.3" rx="3.7" ry="3.8"/>
						<ellipse id="XMLID_62_" style="fill:#B0B0B0;" cx="61.1" cy="238.3" rx="2.5" ry="2.5"/>
						<ellipse id="XMLID_61_" style="fill:#C8C8C8;" cx="61.1" cy="238.3" rx="1.9" ry="1.9"/>
					</g>
					<g id="XMLID_599_">
						<ellipse id="XMLID_60_" style="fill:#333333;" cx="88.5" cy="238.3" rx="3.7" ry="3.8"/>
						<ellipse id="XMLID_59_" style="fill:#B0B0B0;" cx="88.5" cy="238.3" rx="2.5" ry="2.5"/>
						<ellipse id="XMLID_58_" style="fill:#C8C8C8;" cx="88.5" cy="238.3" rx="1.9" ry="1.9"/>
					</g>
					<path id="XMLID_57_" style="fill:#A8CEDE;" d="M66.7,231h24.8c0,0-2.6-4.4-7.1-4.4c0,0-8.2,0-11.2,0
						C71.8,226.5,69.3,228,66.7,231z"/>
					<rect id="XMLID_56_" x="77" y="225" style="fill:#088F46;" width="2" height="6"/>
					<path id="XMLID_55_" style="fill:#046937;" d="M73,233.1c0-0.3,1.3-1.1,1.6-1.1h2c0.3,0,0.4,0.8,0.4,1.1v0.4
						c0,0.3-0.1,0.5-0.4,0.5h-2c-0.3,0-1.6-0.2-1.6-0.5V233.1z"/>
					<path id="XMLID_54_" style="fill:#046937;" d="M82,233c0,0.6-0.4,1-1,1h-1c-0.6,0-1-0.4-1-1l0,0c0-0.6,0.4-1,1-1h1
						C81.6,232,82,232.4,82,233L82,233z"/>
					<path id="XMLID_53_" style="fill:#046937;" d="M71,230c0-0.4-0.6-0.7-1-0.7l-3.1,0.3c-0.4,0-0.9,0.3-0.9,0.7v1.1
						c0,0.4,0.4,0.6,0.8,0.6l3.1-0.3c0.4,0,1.1-0.2,1.1-0.6V230z"/>
				</g>
				<g id="redJeep">
					<g id="XMLID_577_">
						<path id="XMLID_52_" style="fill:#BE292E;" d="M202.7,229.5c0,0-0.3-2.5-2.2-2.5c-1.9,0-15.3,0-16.4,0c-0.7,0-1.2-0.1-2.3,1.2
							c-1.4,1.8-3.2,3.8-3.2,3.8s-7,0.9-9,1.8c-1.4,0.6-1.6,2.4-1.6,4c0,2.4,1.7,2.1,1.7,2.1s23.6,0,31.7,0c0.7,0,2.2,0.2,2.2-1.3
							C203.7,237.3,202.7,229.5,202.7,229.5z"/>
						<g id="XMLID_590_">
							<path id="XMLID_51_" style="fill:#801A1A;" d="M203.7,238c0,1.5-1.5,2-2.2,2c-8.1,0-31.7,0-31.7,0s-1.6,0-1.7-3h35.6
								C203.7,238,203.7,237.9,203.7,238z"/>
						</g>
						<path id="XMLID_50_" style="fill:#333333;" d="M178.7,232l3.2-4h10.6c0.1,0,0.5,0.1,0.5,0.2v3.5c0,0.1-0.2,0.3-0.4,0.3
							L178.7,232z"/>
						<path id="XMLID_49_" style="fill:#333333;" d="M194.1,228h6c0.7,0,1.3,0.5,1.3,1.3l0.2,2.4c0,0.2-0.1,0.3-0.2,0.3h-7.3
							c-0.1,0-0.1-0.1-0.1-0.2v-3.5C194,228.1,194,228,194.1,228z"/>
						<path id="XMLID_48_" style="fill:#333333;" d="M192,232.3c0-0.2-0.1-0.3-0.3-0.3h-2.4c-0.2,0-0.4,0.1-0.4,0.3v0.4
							c0,0.2,0.2,0.3,0.4,0.3h2.4c0.2,0,0.3-0.1,0.3-0.3V232.3z"/>
						<path id="XMLID_47_" style="fill:#333333;" d="M202,235.5c0,0.8,1.2,1.5,2,1.5h0.2c0.8,0,0.8-0.7,0.8-1.5v-3.7
							c0-0.8,0-0.8-0.8-0.8H204c-0.8,0-2,0.1-2,0.8V235.5z"/>
						<path id="XMLID_46_" style="fill:#333333;" d="M200.8,240c0-3-2.1-4.8-4.8-4.8c-2.7,0-4.8,1.8-4.8,4.8H200.8z"/>
						<path id="XMLID_45_" style="fill:#333333;" d="M181,240c0-3-2.2-4.8-4.8-4.8c-2.7,0-4.8,1.8-4.8,4.8H181z"/>
						<ellipse id="XMLID_44_" style="fill:#333333;" cx="196" cy="240.7" rx="3.6" ry="3.6"/>
						<ellipse id="XMLID_43_" style="fill:#C8C8C8;" cx="196" cy="240.7" rx="2.7" ry="2.8"/>
						<ellipse id="XMLID_42_" style="fill:#333333;" cx="176.2" cy="240.7" rx="3.6" ry="3.6"/>
						<ellipse id="XMLID_41_" style="fill:#C8C8C8;" cx="176.2" cy="240.7" rx="2.7" ry="2.8"/>
						<g id="XMLID_578_">
							<path id="XMLID_40_" style="fill:#F7F07F;" d="M169,234c0.6,0,1,1.3,1,2v0.1c0,0.7-0.4,0.9-1,0.9h-0.9c0.1,0,0.2,0,0.7-3H169
								z"/>
						</g>
					</g>
					<rect id="XMLID_39_" x="182" y="228" style="fill:#BE292E;" width="1" height="4"/>
					<path id="XMLID_38_" style="fill:#801A1A;" d="M185,231.2c0-0.1-0.1-0.2-0.2-0.2h-2.6c-0.1,0-0.2,0.1-0.2,0.2v0.6
						c0,0.1,0.1,0.2,0.2,0.2h2.6c0.1,0,0.2-0.1,0.2-0.2V231.2z"/>
				</g>
				<g id="yellowCar">
					<path id="XMLID_37_" style="fill:#FFC808;" d="M147.7,225h-4.2c-7.5,0-8.9,4.1-11.8,6c-2,1.3-3.7,1.6-4.8,1.8
						c-1.6,0.4-2.5,1.5-2.9,2.3c-0.4,0.8-0.6,2.6-0.6,3.5c0,1,0.7,1.4,1.4,1.4h31.5c0.7,0,1-0.7,1.1-1.4c0.1-1.1,0.2-3.2,0-4.3
						C156.5,230.8,153.7,225,147.7,225z"/>
					<g id="XMLID_571_">
						<path id="XMLID_36_" style="fill:#B0B0B0;" d="M123.3,238.6c0-0.1,0-0.2,0-0.4l34-0.4c0,0.3,0,0.5-0.1,0.8
							c-0.1,0.7-0.4,1.4-1.1,1.4h-31.5C124,240,123.3,239.7,123.3,238.6z"/>
					</g>
					<path id="XMLID_35_" style="fill:#EBA322;" d="M154.6,240c0-3-2-4.6-4.5-4.6c-2.5,0-4.5,1.6-4.5,4.6H154.6z"/>
					<ellipse id="XMLID_34_" style="fill:#333333;" cx="150.1" cy="240.3" rx="3.6" ry="3.6"/>
					<ellipse id="XMLID_33_" style="fill:#B0B0B0;" cx="150.1" cy="240.3" rx="2.4" ry="2.4"/>
					<path id="XMLID_32_" style="fill:#EBA322;" d="M135.5,240c0-3-2-4.6-4.5-4.6c-2.5,0-4.5,1.6-4.5,4.6H135.5z"/>
					<ellipse id="XMLID_31_" style="fill:#333333;" cx="131" cy="240.3" rx="3.6" ry="3.6"/>
					<ellipse id="XMLID_30_" style="fill:#B0B0B0;" cx="131" cy="240.3" rx="2.4" ry="2.4"/>
					<g id="XMLID_562_">
						<path id="XMLID_29_" style="fill:#E82128;" d="M157.6,235.4c0.3,0.1,0.9,0.4,0.9,0.8v0.1c0,0.4-0.4,0.7-0.7,0.8
							C157.8,236.6,157.7,236,157.6,235.4z"/>
						<path id="XMLID_28_" style="fill:#F7F07F;" d="M125.3,234.1c0.4,0.2,0.6,0.8,0.3,1.2l-0.3,0.6c-0.2,0.4-0.8,0.6-1.2,0.3
							l-0.1,0c-0.2-0.1-0.3-0.3-0.4-0.4c0.1-0.2,0.1-0.5,0.2-0.6c0.2-0.4,0.5-0.8,0.9-1.2C125,233.9,125.1,234,125.3,234.1
							L125.3,234.1z"/>
					</g>
					<path id="XMLID_27_" style="fill:#A8CEDE;" d="M139,226.4c0,0-3.5,0.6-6,5.6h6V226.4z"/>
					<rect id="XMLID_26_" x="140" y="227" style="fill:#A8CEDE;" width="8" height="5"/>
					<path id="XMLID_25_" style="fill:#A8CEDE;" d="M149,226.4v5.6c0,0,3.3,0,5.3,0C156.4,232,153,226.5,149,226.4z"/>
					<path id="XMLID_24_" style="fill:#333333;" d="M139.3,233c0,0.2,0.1,0.3,0.3,0.3h1c0.2,0,0.3-0.1,0.3-0.3v-0.2
						c0-0.2-0.1-0.3-0.3-0.3h-1c-0.2,0-0.3,0.1-0.3,0.3V233z"/>
					<path id="XMLID_23_" style="fill:#333333;" d="M146.9,233c0,0.2,0.1,0.3,0.3,0.3h1c0.2,0,0.3-0.1,0.3-0.3v-0.2
						c0-0.2-0.1-0.3-0.3-0.3h-1c-0.2,0-0.3,0.1-0.3,0.3V233z"/>
					<path id="XMLID_22_" style="fill:#EBA322;" d="M131,231.6c0-0.2,1.6-0.6,1.8-0.6h2.5c0.2,0-2.3,0.4-2.3,0.6v1
						c0,0.2,2.5,0.4,2.3,0.4h-2.5c-0.2,0-1.8-0.2-1.8-0.4V231.6z"/>
				</g>
				<g id="orangeJeep">
					<path id="XMLID_21_" style="fill:#ED7823;" d="M298,225c-5.1,0-15.4,0-20.2,0c-3.1,0-5.3,6-7.1,6c-1.2,0-4.4,0-4.4,0
						c-2.3,0-3.4,2.7-3.4,5c0,0.6,0,2.7,0,2.7c0,0.8-0.1-0.7,0.7-0.7h2.7h37.2c0.8,0,1.4,1.5,1.4,0.7c0,0,0-4.5,0-6.3
						C305,229,300.5,225,298,225z"/>
					<path id="XMLID_18_" style="fill:#E82128;" d="M305,234.8c0,0-1-0.1-1,0.9v0.6c0,0.6,0,0.8,1,0.8l0,0V234.8L305,234.8z"/>
					<g id="XMLID_551_">
						<path id="XMLID_17_" style="fill:#F7F07F;" d="M265,234.6V233c0-0.1-0.2-0.2-0.2-0.3c-1,0.8-1.8,2-1.8,3.3c0,0.2,0-0.3,0,0.2
							c0,0,0.3,0,0.3,0C264.2,236.2,265,235.5,265,234.6z"/>
					</g>
					<path id="XMLID_15_" style="fill:#A8CEDE;" d="M293,232c0,0.6-0.2,1-0.7,1h-7.9c-0.5,0-1.4-0.4-1.4-1v-4c0-0.6,0.8-1,1.4-1h7.9
						c0.5,0,0.7,0.4,0.7,1V232z"/>
					<path id="XMLID_14_" style="fill:#A8CEDE;" d="M303.7,231.3c0.1,0.5-0.4,0.7-1,0.7H296c-0.5,0-2-0.3-2-0.9v-3.7
						c0-0.6,1.5-0.5,2-0.5c0,0,1.8,0,2.7,0C300.8,227,303.3,229.8,303.7,231.3z"/>
					<path id="XMLID_13_" style="fill:#A8CEDE;" d="M282,231.1c0,0.6,1,0.9,0.4,0.9h-7.6c-0.5,0-1-0.1-1-0.7c0-1.7,2.5-4.3,4.3-4.3
						h4.3c0.5,0-0.4-0.1-0.4,0.5V231.1z"/>
					<g id="XMLID_546_">
						<path id="XMLID_12_" style="fill:#C86628;" d="M263.7,238h2.7h37.2c0.8,0,1.4,1.5,1.4,0.7c0,0,0-0.7,0-1.7h-42
							c0,1,0,1.7,0,1.7C263,239.5,262.9,238,263.7,238z"/>
					</g>
					<g id="XMLID_539_">
						<path id="XMLID_11_" style="fill:#C86628;" d="M265,238c0-1,1.9-4.2,4.2-4.2c2.3,0,4.2,3.2,4.2,4.2H265z"/>
						<ellipse id="XMLID_10_" style="fill:#333333;" cx="269.2" cy="240.4" rx="3.3" ry="3.3"/>
						<ellipse id="XMLID_9_" style="fill:#B0B0B0;" cx="269.2" cy="240.4" rx="2.2" ry="2.2"/>
					</g>
					<g id="XMLID_533_">
						<path id="XMLID_8_" style="fill:#C86628;" d="M292.5,238c0-1,1.9-4.2,4.2-4.2c2.3,0,4.2,3.2,4.2,4.2H292.5z"/>
						<ellipse id="XMLID_7_" style="fill:#333333;" cx="296.7" cy="240.4" rx="3.3" ry="3.3"/>
						<ellipse id="XMLID_6_" style="fill:#B0B0B0;" cx="296.7" cy="240.4" rx="2.2" ry="2.2"/>
					</g>
					<path id="XMLID_5_" style="fill:#333333;" d="M283.4,233.5c0,0.2-0.1,0.5-0.3,0.5h-2.3c-0.2,0-0.3-0.3-0.3-0.5l0,0
						c0-0.2,0.1-0.5,0.3-0.5h2.3C283.2,233,283.4,233.3,283.4,233.5L283.4,233.5z"/>
					<path id="XMLID_4_" style="fill:#333333;" d="M292,233.7c0,0.2-0.1,0.3-0.3,0.3h-2.3c-0.2,0-0.3-0.1-0.3-0.3v-0.3
						c0-0.2,0.1-0.3,0.3-0.3h2.3c0.2,0,0.3,0.1,0.3,0.3V233.7z"/>
					<path id="XMLID_3_" style="fill:#C86628;" d="M272,231.2c0-0.4,1.1-0.7,1.5-0.7l2.8,0c0.4,0,0.7,0.3,0.7,0.7v1
						c0,0.4,0.1,0.6-0.3,0.6l-3.3,0c-0.4,0-1.3-0.2-1.3-0.6V231.2z"/>
				</g>
			</g>
		</g>
	</g>
</g>
<g id="Layer_4">
</g>
<g id="Layer_3">
</g>
</svg>
  
<script>
var clouds = document.getElementById('clouds')
    sun = document.getElementById('sun')
    sky = document.getElementById('XMLID_1_')
    cars = document.getElementById('cars')
    trees = document.getElementById('trees')
    travelTime = 1
    changeTime = 0
    positionTop = 30
    positionBottom = 200;
    

var sunTl = new TimelineMax({repeat:-1})
    carsTl = new TimelineMax({repeat:-1})
    skyTl = new TimelineMax({repeat:-1})
    cloudsTl = new TimelineMax({repeat:-1})
    treesTl = new TimelineMax({repeat:-1})


sunTl.fromTo(sun, travelTime, {y:positionTop,scaleY:0.8, scaleX:1}, {ease: Power1.easeIn, y:positionBottom, scaleY: 1,scaleX:0.4})
     .to(sun, changeTime, {fill:"#f7e4ba"})
     .to(sun, travelTime, {y:positionTop, scaleY:0.8, scaleX:1})
     .to(sun, travelTime, {ease: Power1.easeIn, y:positionBottom, scaleX:0.4})
     .to(sun, changeTime, {fill:"#ffc808"})
     .to(sun, travelTime, {y:positionTop, scaleY:0.8, scaleX:1});

skyTl.to(sky, travelTime/1, {fill:"#83D1DB"})
     .to(sky, travelTime/1, {fill:"#091730"})
     .to(sky, travelTime/1, {fill:"#091730"})
     .to(sky, travelTime/1, {fill:"#83D1DB"})   

cloudsTl.fromTo(clouds, 1, {x:-500, ease: Power0.easeNone}, {x: 500, ease: Power0.easeNone});

carsTl.fromTo(cars, 0.15, {x:500, ease: Power0.easeNone}, {x:-500, ease: Power0.easeNone});

treesTl.to(trees,1,{scaleY:0.4, transformOrigin:"50% 100%"})
       .to(trees, 1, {scaleY:1, transformOrigin:"50% 100%"})
</script>

</div>
<?php
footer();
?>