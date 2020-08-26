<?php
@session_start();

// Remove access token from session
//@unset($_SESSION['facebook_access_token']);

// Remove user data from session
//@unset($_SESSION['userData']);

@session_destroy();
echo '<meta http-equiv="refresh" content="0; url=index.php" />';
?>