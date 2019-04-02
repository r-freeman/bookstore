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
            'address' => 'required|min_len,3|max_len,255',
            'phone' => 'required|numeric|min_len,10|max_len,20',
            'email' => 'required|valid_email',
            'website' => 'required'
        );
        $filter_rules = array(
            'name' => 'trim|sanitize_string',
            'address' => 'trim|sanitize_string',
            'phone' => 'trim|sanitize_numbers',
            'email' => 'trim|sanitize_email',
            'website' => 'trim|sanitize_string'
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

        $publisher = new Publisher();
        $publisher->name = $validated_data['name'];
        $publisher->address = $validated_data['address'];
        $publisher->phone = $validated_data['phone'];
        $publisher->email = $validated_data['email'];
        $publisher->website = $validated_data['website'];
        $publisher->save();

        // publisher saved with no errors, back to index
        header('location: publishers.php');
        exit();
    }

    include 'views/admin/' . basename(__FILE__);
    exit();
}
catch (Exception $ex) {
    include 'views/admin/' . basename(__FILE__);
    exit();
}