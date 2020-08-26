<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_POST['save'])) {
    $email       = $_POST['email'];
    $avatar      = $_POST['avatar'];
    $password    = $_POST['password'];
    $description = $_POST['description'];
    
    $emused = 'No';
    
    $susere  = mysqli_query($connect, "SELECT * FROM `players` WHERE email='$email' && id != $player_id LIMIT 1");
    $countue = mysqli_num_rows($susere);
    if ($countue > 0) {
        $emused = 'Yes';
    }
    
    if ($_FILES['avafile']['name'] != '') {
        $target_dir    = "images/avatars/";
        $target_file   = $target_dir . basename($_FILES["avafile"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $filename      = $uname . '.' . $imageFileType;
        
        $uploadOk = 1;
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["avafile"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES["avafile"]["size"] > 1000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        if ($uploadOk == 1) {
            move_uploaded_file($_FILES["avafile"]["tmp_name"], "images/avatars/" . $filename);
            $avatar = "images/avatars/" . $filename;
        }
    }
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && $emused == 'No') {
        
        if ($password != null) {
            $password = hash('sha256', $_POST['password']);
            $querysd  = mysqli_query($connect, "UPDATE `players` SET email='$email', avatar='$avatar', description='$description', password='$password' WHERE id='$player_id'");
        } else {
            $querysd = mysqli_query($connect, "UPDATE `players` SET email='$email', avatar='$avatar', description='$description' WHERE id='$player_id'");
        }
        
    }
    
    echo '<meta http-equiv="refresh" content="0;url=settings.php">';
}
?>
<div class="col-md-12 card bg-light card-body">

    <center><h4><i class="fa fa-cog"></i> <?php
echo lang_key("account-settings");
?></h4><br />

    <div class="row justify-content-center">
		    
			<form action="" method="post" style="width: 80%;" enctype="multipart/form-data">
			    <div class="form-group">
 			       <label for="email" style="width: 100%;"><i class="fa fa-envelope"></i> <?php
echo lang_key("email-address");
?></span>
                   <input type="email" class="form-control" id="email" name="email" value="<?php
echo $rowu['email'];
?>" required>
 			    </div>
				<div class="form-group">
 			       <label for="description" style="width: 100%;"><i class="fas fa-align-justify"></i> <?php
echo lang_key("description");
?></span>
                   <input type="text" class="form-control" id="description" name="description" value="<?php
echo $rowu['description'];
?>">
 			    </div>
				<div class="form-group">
 			       <label for="avatar" style="width: 100%;"><i class="fa fa-user"></i> <?php
echo lang_key("avatar");
?></span>
                   <input type="text" class="form-control" id="avatar" name="avatar" placeholder="URL" value="<?php
echo $rowu['avatar'];
?>">

                   <div class="custom-file">
                     <input type="file" class="custom-file-input" name="avafile" accept="image/*" id="avatarfile">
                     <label class="custom-file-label" for="avatarfile">Choose file</label>
                   </div><br /><br />

				   <center><div class="well" style="width: 10%;"><img src="<?php
echo $rowu['avatar'];
?>" width="100%"></div></center>
 			    </div>
				<div class="form-group">
 			       <label for="password" style="width: 100%;"><i class="fa fa-key"></i> <?php
echo lang_key("new-password");
?></span>
                   <input type="password" class="form-control" id="password" name="password" value="">
				   <i><?php
echo lang_key("password-message");
?></i><br />
 			    </div>
 			    <button type="submit" name="save" class="btn btn-primary btn-block"><i class="far fa-floppy"></i>&nbsp; <?php
echo lang_key("save");
?></button>
			</form>

    </div></center>
</div>
<script>
$('#avatarfile').on('change',function(){
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
})
</script>
<?php
footer();
?>