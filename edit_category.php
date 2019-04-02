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
        $category = Category::find($id);

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
            'id' => 'required|integer|min_numeric,1',
            'name' => 'required|min_len,3|max_len,50'
        );
        $filter_rules = array(
            'id' => 'trim|sanitize_numbers',
            'name' => 'trim|sanitize_string'
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
        $category = Category::find($id);
        $category->name = $validated_data['name'];

        if (!empty($errors)) {
            throw new Exception();
        }

        $category->save();

        header('location: categories.php');
        exit();
    } catch (Exception $ex) {
        include 'views/admin/' . basename(__FILE__);
        exit();
    }
}
not_found();

?>