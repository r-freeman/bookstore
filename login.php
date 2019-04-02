<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

if(!empty($_POST)) {
    try {
        $validator = new GUMP();

        $sanitized_data = $validator->sanitize($_POST);

        $validation_rules = array(
            'username' => 'required|alpha_numeric|max_len,50|min_len,3',
            'password' => 'required|min_len,6'
        );
        $filter_rules = array(
            'username' => 'trim|sanitize_string',
            'password' => 'trim'
        );

        $validator->validation_rules($validation_rules);
        $validator->filter_rules($filter_rules);

        $validated_data = $validator->run($sanitized_data);

        if($validated_data === false) {
            $errors = $validator->get_errors_array();
        }
        else {
            $errors = array();

            $username = $validated_data['username'];
            $password = $validated_data['password'];

            $user = User::findByUsername($username);
            if ($user === false) {
                $errors['username'] = "Username not valid";
            }
            else {
                $hash = $user->password;
                if (!password_verify($password, $hash)) {
                    $errors['password'] = "Password is incorrect";
                }
            }
        }

        if (!empty($errors)) {
            throw new Exception("There were errors. Please fix them.");
        }

        $_SESSION['uid'] = $user->id;
        header('Location: index.php');
        exit();

    } catch (Exception $ex) {
        include 'views/user/login.php';
        exit();
    }
}

if(is_logged_in()) {
    // user is already logged in, send back home
    header('Location: index.php');
} else {
    include 'views/user/login.php';
}

exit();

?>
