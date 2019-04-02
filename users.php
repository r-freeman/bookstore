<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

// only admin access this page
if(!is_authorised(1)) {
    not_found();
}

try {
    $users = User::all();

    include 'views/admin/' . basename(__FILE__);
    exit();

} catch (Exception $ex) {
    die($ex->getMessage());
}

?>