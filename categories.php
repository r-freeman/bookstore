<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

try {
    if (is_authorised(2)) {
        // user is admin or manager
        if (isset($_GET['sortby']) && isset($_GET['order'])) {
            $validator = new GUMP();

            $sanitized_data = $validator->sanitize($_GET);

            $validation_rules = array(
                'sortby' => 'required|alpha',
                'order' => 'required|alpha'
            );
            $filter_rules = array(
                'sortby' => 'trim|sanitize_string',
                'order' => 'trim|sanitize_string'
            );

            $validator->validation_rules($validation_rules);
            $validator->filter_rules($filter_rules);
            $validated_data = $validator->run($sanitized_data);

            if ($validated_data === false) {
                $errors = $validator->get_errors_array();
            } else {
                $errors = array();
            }

            if (!empty($errors)) {
                throw new Exception("There were errors. Please fix them.");
            }

            $sortby = $validated_data['sortby'];
            $order = $validated_data['order'];

            $categories = Category::all($sortby, $order);
        } else {
            $categories = Category::all('name', 'ASC');
        }

        // display the admin view
        include 'views/admin/' . basename(__FILE__);
        exit();
    }
} catch (Exception $ex) {
    die($ex->getMessage());
}

// only admin or manager can access categories page
not_found();

?>