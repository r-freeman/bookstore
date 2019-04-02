<?php
require_once 'utils/functions.php';

if (!is_logged_in()) {
    header("Location: login.php");
} else {
    unset($_SESSION['uid']);
    header("Location: index.php");
}

exit();

?>
