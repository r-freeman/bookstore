<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

try {
    if (is_authorised(2)) {
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

            $authors = Author::all($sortby, $order);
        } else {
            $authors = Author::all('name', 'ASC');
        }

        include 'views/admin/' . basename(__FILE__);
        exit();
    }

    if(!isset($authors) || $authors == null) {
        $authors = Author::all('name', 'ASC');
        $featuredAuthors = Author::all('name', 'ASC', true, 8);
    }

} catch (Exception $ex) {
    die($ex->getMessage());
}

// displsy user view
include 'views/user/' . basename(__FILE__);
exit();

?>