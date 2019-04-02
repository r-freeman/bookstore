<?php

function is_logged_in()
{
    start_session();
    return (isset($_SESSION['uid']));
}

function is_authorised($roleId)
{
    global $user;
    return isset($user) && $user->role_id <= $roleId ? true : false;
}

function start_session()
{
    $id = session_id();
    if ($id === "") {
        session_start();
    }
}

function format_price($price)
{
    return explode('.', $price);
}

function not_found()
{
    header("HTTP/1.1 404 Not Found");
    exit();
}

/**
 * Returns an a-z listing of authors
 * @param $authors
 * @return string
 */
function list_authors($authors)
{
    $letters = range("A", "Z");
    $arr = array();
    $output = "";

    // put the first letter of each authors first name in an array
    foreach ($authors as $key => $val) {
        array_push($arr, $val->name[0]);
    }

    // remove non matching letters from range
    $letters = array_intersect($letters, $arr);

    foreach ($letters as $letter) {
        $output .= "<div class='col-6 col-sm-4 col-md-4 col-xl-3 mb-3'><h5>" . $letter . "</h5>";
        foreach ($authors as $author) {
            if ($letter == $author->name[0]) {
                $output .= "<a href='author.php?id=$author->id' title='$author->name'>" . $author->name . "</a>";
            }
        }
        $output .= "</div>";
    }
    return $output;
}

function old($index, $default = null)
{
    if (isset($_POST) && is_array($_POST) && array_key_exists($index, $_POST)) {
        return $_POST[$index];
    } else if ($default !== null) {
        return $default;
    }
}

function error($index)
{
    global $errors;

    if (isset($errors) && is_array($errors) && array_key_exists($index, $errors)) {
        return $errors[$index];
    }
}

function dd($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    exit();
}

function imageFileUpload($name, $required, $maxSize, $allowedTypes)
{
    if ($_SERVER['REQUEST_METHOD'] !== "POST") {
        throw new Exception('Invalid request');
    }

    if ($required && !isset($_FILES[$name])) {
        throw new Exception("File " . $name . " required");
    } else if (!$required && isset($_FILES[$name]) && $_FILES[$name]['error'] == 4) {
        return null;
    }

    if ($_FILES[$name]['error'] !== 0) {
        throw new Exception('File upload error');
    }

    if (!is_uploaded_file($_FILES[$name]["tmp_name"])) {
        throw new Exception("Filename is not an uploaded file");
    }

    $imageInfo = getimagesize($_FILES[$name]["tmp_name"]);
    if ($imageInfo === false) {
        throw new Exception("File is not an image.");
    }

    $width = $imageInfo[0];
    $height = $imageInfo[1];
    $sizeString = $imageInfo[3];
    $mime = $imageInfo['mime'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES[$name]["name"]);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    if (file_exists($target_file)) {
        throw new Exception("Sorry, file already exists.");
    }

    if ($_FILES[$name]["size"] > $maxSize) {
        throw new Exception("Sorry, your file is too large.");
    }

    if (!in_array($imageFileType, $allowedTypes)) {
        throw new Exception("Sorry, only " . implode(',', $allowedTypes) . " files are allowed.");
    }

    if (!move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
        throw new Exception("Sorry, there was an error moving your uploaded file.");
    }

    return $target_file;
}

