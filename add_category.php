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
            'name' => 'required|min_len,3|max_len,50'
        );
        $filter_rules = array(
            'name' => 'trim|sanitize_string'
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

        if (!empty($errors)) {
            throw new Exception("There were errors. Please fix them.");
        }

        $category = new Category();
        $category->name = $validated_data['name'];
        $category->save();

        // category saved with no errors, back to index
        header('location: categories.php');
        exit();
    }

    include 'views/admin/' . basename(__FILE__);
    exit();
}
catch (Exception $ex) {
    include 'views/admin/' . basename(__FILE__);
    exit();
}