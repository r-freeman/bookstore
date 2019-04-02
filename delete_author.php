<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

if(!is_authorised(2)) {
    not_found();
}

try {
    if(!empty($_GET)) {
        $validator = new GUMP();

        $sanitized_data = $validator->sanitize($_GET);

        $validation_rules = array(
            'id' => 'required|integer|min_numeric,1'
        );
        $filter_rules = array(
            'id' => 'trim|sanitize_numbers'
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

        $id = $validated_data['id'];
        $author = Author::find($id);

        if(!$author) {
            throw new Exception();
        }

        if(file_exists($author->photo)) {
            unlink($author->photo);
        }

        $author->delete();

        // author deleted with no errors, back to index
        header('location: authors.php');
        exit();
    }
}
catch (Exception $ex) {
    var_dump($ex);
//    not_found();
}