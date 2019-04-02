<?php
if(is_logged_in()) {
    $uid = $_SESSION['uid'];
    $user = User::find($uid);
}
?>