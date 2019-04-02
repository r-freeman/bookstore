<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

if(!is_authorised(2)) {
    not_found();
}

try {
    if(!empty($_POST)) {
        $validator = new GUMP();

        $sanitized_data = $validator->sanitize($_POST);

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

        if($validated_data === false) {
            $errors = $validator->get_errors_array();
        }
        else {
            $errors = array();
        }

        try {
            $photoImageFile = imageFileUpload('photo', true, 1000000, array('jpg', 'jpeg', 'png', 'gif'));
        }
        catch (Exception $ex) {
            $errors['photo'] = $ex->getMessage();
        }

        if (!empty($errors)) {
            throw new Exception();
        }

        $author = new Author();
        $author->name = $validated_data['name'];
        $author->born = $validated_data['born'];
        $author->bio = $validated_data['bio'];

        if(!isset($validated_data['featured'])) {
            $author->featured = 0;
        } else {
            $author->featured = 1;
        }

        $author->photo = $photoImageFile;
        $author->save();

        // book saved with no errors, back to index
        header('location: authors.php');
        exit();
    }

    include 'views/admin/' . basename(__FILE__);
    exit();
}
catch (Exception $ex) {
    include 'views/admin/' . basename(__FILE__);
    exit();
} ?>