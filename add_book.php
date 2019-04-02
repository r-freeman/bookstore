<?php
require_once 'autoload.php';
require_once 'utils/functions.php';
require_once 'utils/session.php';

if(!is_authorised(2)) {
    not_found();
}

$publishers = Publisher::all();
$categories = Category::all();
$authors = Author::all();

try {
    if(!empty($_POST)) {
        $validator = new GUMP();

        $sanitized_data = $validator->sanitize($_POST);

        $validation_rules = array(
            'title' => 'required|min_len,1|max_len,100',
            'synopsis' => 'required|min_len,10',
            'isbn' => 'required|numeric|exact_len,13|min_numeric,0',
            'year' => 'required|numeric|exact_len,4|min_numeric,1900',
            'price' => 'required|float|min_numeric,0',
            'length' => 'required|numeric|min_numeric,2',
            'publisher_id' => 'required|integer|min_numeric,1',
            'category_id' => 'required|integer|min_numeric,1'
        );
        $filter_rules = array(
            'title' => 'trim|sanitize_string',
            'synopsis' => 'trim|sanitize_string',
            'isbn' => 'trim|sanitize_numbers',
            'year' => 'trim|sanitize_numbers',
            'price' => 'trim|sanitize_floats',
            'length' => 'trim|sanitize_numbers',
            'publisher_id' => 'trim|sanitize_numbers',
            'category_id' => 'trim|sanitize_numbers'
        );

        $validator->validation_rules($validation_rules);
        $validator->filter_rules($filter_rules);

        $validated_data = $validator->run($sanitized_data);

        if($validated_data === false) {
            $errors = $validator->get_errors_array();
        }
        else {
            $errors = array();

            // validate publisher
            $publisher_id = $validated_data['publisher_id'];
            $publisher = Publisher::find($publisher_id);
            if ($publisher === false) {
                $errors['publisher_id'] = "Invalid publisher";
            }

            // validate category
            $category_id = $validated_data['category_id'];
            $category = Category::find($category_id);
            if ($category === false) {
                $errors['category_id'] = "Invalid category";
            }
        }

        try {
            $coverImageFile = imageFileUpload('cover', true, 1000000, array('jpg', 'jpeg', 'png', 'gif'));
        }
        catch (Exception $ex) {
            $errors['cover'] = $ex->getMessage();
        }

        if (!empty($errors)) {
            throw new Exception("There were errors. Please fix them.");
        }

        $book = new Book();
        $book->title = $validated_data['title'];
        $book->synopsis = $validated_data['synopsis'];
        $book->isbn = $validated_data['isbn'];
        $book->year = $validated_data['year'];
        $book->price = $validated_data['price'];
        $book->length = $validated_data['length'];
        $book->cover = $coverImageFile;
        $book->publisher_id = $validated_data['publisher_id'];
        $book->category_id = $validated_data['category_id'];
        $book->save();

        if (isset($_POST['author_ids'])) {
            $book->setAuthors($_POST['author_ids']);
        } else {
            $book->setAuthors(array());
        }

        // book saved with no errors, back to index
        header('location: books.php');
        exit();
    }

    include 'views/admin/' . basename(__FILE__);
    exit();
}
catch (Exception $ex) {
    include 'views/admin/' . basename(__FILE__);
    exit();
} ?>