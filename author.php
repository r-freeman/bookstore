<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

if(is_authorised(2)) {
    not_found();
}

try {
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

    if ($validated_data === false) {
        $errors = $validator->get_errors_array();
        throw new Exception("Invalid author id: " . $errors['id']);
    }

    $id = $validated_data['id'];
    $author = Author::find($id);

    if(!$author) {
        throw new Exception();
    }

    $booksWritten = Author::getBooksWritten($author->id);

} catch (Exception $ex) {
    not_found();
}

include 'views/user/' . basename(__FILE__ );
exit();

?>
