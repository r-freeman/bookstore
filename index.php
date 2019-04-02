<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

try {
    // get nine random books
    $books = Book::all(null, null, 9, true);
} catch (Exception $ex) {
    die($ex->getMessage());
}

if (is_authorised(2)) {
    $books = Book::all('title', 'ASC');
    // user is admin or manager, show dashboard
    include 'views/admin/books.php';
    exit();
}

include 'views/user/' . basename(__FILE__);
exit();

?>
