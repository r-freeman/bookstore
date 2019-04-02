<?php

class Book
{
    public $id;
    public $title;
    public $synopsis;
    public $isbn;
    public $year;
    public $price;
    public $length;
    public $cover;
    public $publisher_id;
    public $category_id;

    public function __construct() {
    }

    public function save() {
        $params = array(
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'isbn' => $this->isbn,
            'year' => $this->year,
            'price' => $this->price,
            'length'=> $this->length,
            'cover' => $this->cover,
            'publisher_id' => $this->publisher_id,
            'category_id' => $this->category_id
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO books(
                        title, synopsis, isbn, year, price, length, cover, publisher_id, category_id
                    ) VALUES (
                        :title, :synopsis, :isbn, :year, :price, :length, :cover, :publisher_id, :category_id
                    )";
        }
        else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE books SET
                        title = :title,
                        synopsis = :synopsis,
                        isbn = :isbn,
                        year = :year,
                        price = :price,
                        length = :length,
                        cover = :cover,
                        publisher_id = :publisher_id,
                        category_id = :category_id
                    WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save book");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
//                throw new Exception("Error saving book");
                return;
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('books');
            }
        }
    }

    public function delete()
    {
        if (empty($this->id)) {
            throw new Exception("Unsaved book cannot be deleted");
        }
        $params = array(
            'id' => $this->id
        );
        $sql = 'DELETE FROM books WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete book");
        } else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error deleting book");
            }
        }
    }

    /**
     * List all books, sort by given column and order
     * @param string $sortby
     * @param string $order
     * @return array
     * @throws Exception
     */
    public static function all($column = null, $order = null, $limit = null, $random = false)
    {
        $sql = "SELECT *
                FROM books";

        if ($random) {
            $sql .= " ORDER BY rand()";
        } else {
            // append sorting to query if not nul
            if ($column != null && $order != null) {
                $sql .= " ORDER BY " . $column . " " . $order;
            }
        }

        // append limit to the query if not null
        if ($limit != null) {
            $sql .= " LIMIT " . $limit;
        };

        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve books");
        } else {
            $books = $stmt->fetchAll(PDO::FETCH_CLASS, 'Book');
            return $books;
        }
    }

    public static function find($id)
    {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT * FROM books WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve book");
        } else {
            $book = $stmt->fetchObject('Book');
            return $book;
        }
    }

    /**
     * Set the book authors
     * @param $authorIds
     * @throws Exception
     */
    public function setAuthors($authorIds)
    {
        $connection = Connection::getInstance();
        $params = array(
            'book_id' => $this->id
        );
        $sql = 'DELETE FROM book_authors WHERE book_id = :book_id';
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete book authors");
        } else {
            if ($authorIds != null) {
                $sql = "INSERT INTO book_authors (
                            book_id, author_id
                        ) VALUES (
                            :book_id, :author_id
                        )";
                $stmt = $connection->prepare($sql);
                foreach ($authorIds as $authorId) {
                    $params['author_id'] = $authorId;
                    $success = $stmt->execute($params);
                    if (!$success) {
                        throw new Exception("Failed to store book authors");
                    }
                }
            }
        }
    }

    /**
     * Returns the authors of a given book id
     * @param $id
     * @return array
     * @throws Exception
     */
    public static function getAuthors($id)
    {
        $params = array(
            'id' => $id
        );
        $sql = "SELECT a.*
                FROM authors a
                INNER JOIN book_authors ba
                ON a.id = ba.author_id
                INNER JOIN books b
                ON b.id = ba.book_id
                WHERE b.id = :id";

        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve book authors");
        } else {
            $authors = $stmt->fetchAll(PDO::FETCH_CLASS, 'Author');
            return $authors;
        }
    }
}

