<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

if (!is_authorised(2)) {
    not_found();
}

$_SERVER['REQUEST_METHOD'] == 'GET' ? $request = $_GET : $request = $_POST;

if ($request == $_GET) {
    try {
        $validator = new GUMP();
        $sanitized_data = $validator->sanitize($request);

        $validation_rules = array(
            'id' => 'required|integer|min_numeric,1'
        );
        $filter_rules = array(
            'id' => 'trim|sanitize_numbers'
        );

        $validator->validation_rules($validation_rules);
        $validator->filter_rules($filter_rules);
        $validated_data = $validator->run($sanitized_data);

        if ($validated_data === false) {
            $errors = $validator->get_errors_array();
        } else {
            $errors = array();
        }

        $id = $validated_data['id'];
        $author = Author::find($id);

        if (!empty($errors)) {
            throw new Exception();
        }

        include 'views/admin/' . basename(__FILE__);
        exit();
    } catch (Exception $ex) {
        not_found();
    }
} else {
    try {
        $validator = new GUMP();

        $sanitized_data = $validator->sanitize($request);

        $validation_rules = array(
            'name' => 'required|min_len,3|max_len,50',
            'born' => 'min_len,3|max_len,50',
            'bio' => 'required|min_len,10',
            'featured' => 'max_len,2',
        );
        $filter_rules = array(
            'name' => 'trim|sanitize_string',
            'born' => 'trim|sanitize_string',
            'bio' => 'trim|sanitize_string',
            'featured' => 'trim|sanitize_string'
        );

        $validator->validation_rules($validation_rules);
        $validator->filter_rules($filter_rules);
        $validated_data = $validator->run($sanitized_data);

        if ($validated_data === false) {
            $errors = $validator->get_errors_array();
        } else {
            $errors = array();
        }

        $id = $sanitized_data['id'];
        $author = Author::find($id);


        $author->name = $validated_data['name'];
        $author->born = $validated_data['born'];
        $author->bio = $validated_data['bio'];

        if(!isset($validated_data['featured'])) {
            $author->featured = 0;
        } else {
            $author->featured = 1;
        }

        try {
            $coverImageFile = imageFileUpload('photo', true, 1000000, array('jpg', 'jpeg', 'png', 'gif'));
        } catch (Exception $ex) {
            $coverImageFile = null;
        }

        if ($coverImageFile != null) {
            if ($author->cover != null && $author->cover != 'uploads/book_default.png' && file_exists($author->cover)) {
                unlink($author->cover);
            }
            $author->cover = $coverImageFile;
        }

        if (!empty($errors)) {
            throw new Exception();
        }

        $author->save();

        // author saved with no errors, back to index
        header('location: authors.php');
        exit();
    } catch (Exception $ex) {
        include 'views/admin/' . basename(__FILE__);
        exit();
    }
}
not_found();

?>