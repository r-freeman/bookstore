<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

// only admin can edit user
if (!is_authorised(1)) {
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
        $_user = User::find($id);
        $roles = Role::all();

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
            'username' => 'required|min_len,4|max_len,50',
            'role_id' => 'required|integer|min_numeric,1'
        );
        $filter_rules = array(
            'id' => 'trim|sanitize_numbers',
            'username' => 'trim|sanitize_string',
            'role_id' => 'trim|sanitize_numbers'
        );

        $validator->validation_rules($validation_rules);
        $validator->filter_rules($filter_rules);
        $validated_data = $validator->run($sanitized_data);

        if ($validated_data === false) {
            $errors = $validator->get_errors_array();
        } else {
            $errors = array();

            // validate user role
            $role_id = $validated_data['role_id'];
            $role = Role::find($role_id);
            if ($role === false) {
                $errors['role_id'] = "Invalid role";
            }
        }

        $id = $sanitized_data['id'];
        $_user = User::find($id);
        $roles = Role::all();
        $_user->username = $validated_data['username'];
        $_user->role_id = $validated_data['role_id'];

        if (!empty($errors) || !($_user)) {
            throw new Exception();
        }

        $_user->save();

        header('location: users.php');
        exit();
    } catch (Exception $ex) {
        include 'views/admin/' . basename(__FILE__);
        exit();
    }
}
not_found();

?>