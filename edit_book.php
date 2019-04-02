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
        $book = Book::find($id);
        $publishers = Publisher::all();
        $categories = Category::all();
        $authors = Author::all();

        $book_authors = Book::getAuthors($book->id);
        $book_authors_ids = array_map(function ($book) {
            return $book->id;
        }, $book_authors);

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

        if ($validated_data === false) {
            $errors = $validator->get_errors_array();
        } else {
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

        $id = $sanitized_data['id'];
        $book = Book::find($id);
        $publishers = Publisher::all();
        $categories = Category::all();
        $authors = Author::all();

        if (isset($request['author_ids'])) {
            $book->setAuthors($sanitized_data['author_ids']);
        } else {
            $book->setAuthors(array());
        }

        $book_authors = Book::getAuthors($book->id);
        $book_authors_ids = array_map(function ($book) {
            return $book->id;
        }, $book_authors);

        $book->title = $validated_data['title'];
        $book->synopsis = $validated_data['synopsis'];
        $book->isbn = $validated_data['isbn'];
        $book->year = $validated_data['year'];
        $book->price = $validated_data['price'];
        $book->length = $validated_data['length'];
        $book->publisher_id = $validated_data['publisher_id'];
        $book->category_id = $validated_data['category_id'];

        try {
            $coverImageFile = imageFileUpload('cover', true, 1000000, array('jpg', 'jpeg', 'png', 'gif'));
        } catch (Exception $ex) {
            $coverImageFile = null;
        }

        if ($coverImageFile != null) {
            if ($book->cover != null && $book->cover != 'uploads/book_default.png' && file_exists($book->cover)) {
                unlink($book->cover);
            }
            $book->cover = $coverImageFile;
        }

        if (!empty($errors)) {
            throw new Exception();
        }

        $book->save();

        // book saved with no errors, back to index
        header('location: books.php');
        exit();
    } catch (Exception $ex) {
        include 'views/admin/' . basename(__FILE__);
        exit();
    }
}
not_found();

?>