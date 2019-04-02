<?php

class Author {
    public $id;
    public $name;
    public $born;
    public $bio;
    public $featured;
    public $photo;

    public function __construct() {
    }

    public function save() {
        $params = array(
            'name' => $this->name,
            'born' => $this->born,
            'bio'  => $this->bio,
            'featured'  => $this->featured,
            'photo'     => $this->photo
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO authors(
                        name, born, bio, featured, photo
                    ) VALUES (
                        :name, :born, :bio, :featured, :photo
                    )";
        }
        else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE authors SET
                        name = :name,
                        born = :born,
                        bio = :bio,
                        featured = :featured,
                        photo = :photo
                    WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save author");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
//                throw new Exception("Error saving author");
                return;
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('authors');
            }
        }
    }

    public function delete() {
        if (empty($this->id)) {
            throw new Exception("Unsaved author cannot be deleted");
        }
        $params = array(
            'id' => $this->id
        );
        $sql = 'DELETE FROM authors WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete author");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                return;
//                throw new Exception("Error deleting author");
            }
        }
    }

    /**
     * List all authors, sort by given column and order
     * @param string $sortby
     * @param string $order
     * @return array
     * @throws Exception
     */
    public static function all($column = 'name', $order = 'ASC', $featured = false, $limit = null) {
        $sql = "SELECT *
                FROM authors";

        if($featured) {
            $sql .= " WHERE featured ";
        }

        if ($column != null && $order != null) {
            $sql .= " ORDER BY " . $column . " " . $order;
        }

        if ($limit != null) {
            $sql .= " LIMIT " . $limit;
        };

        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve authors");
        }
        else {
            $authors = $stmt->fetchAll(PDO::FETCH_CLASS, 'Author');
            return $authors;
        }
    }

    public static function find($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT * FROM authors WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve author");
        }
        else {
            $author = $stmt->fetchObject('Author');
            return $author;
        }
    }

    /**
     * Return books written by a particular author
     * @param $id
     * @return array
     * @throws Exception
     */
    public static function getBooksWritten($id) {
        $params = array(
            'id'    => $id
        );
        $sql = "SELECT b.*
                FROM books b
                INNER JOIN book_authors ba
                ON b.id = ba.book_id
                INNER JOIN authors a
                ON a.id = ba.author_id
                WHERE a.id = :id";
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to get author books");
        }
        else {
            $books = $stmt->fetchAll(PDO::FETCH_CLASS, 'Book');
            return $books;
        }
    }
}

?>
