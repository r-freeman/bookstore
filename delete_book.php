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
        $book = Book::find($id);

        if(!$book) {
            throw new Exception();
        }

        if(file_exists($book->cover)) {
            unlink($book->cover);
        }

        $book->delete();

        // book deleted with no errors, back to index
        header('location: books.php');
        exit();
    }
}
catch (Exception $ex) {
    not_found();
}