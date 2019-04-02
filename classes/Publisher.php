<?php

class Publisher {
    public $id;
    public $name;
    public $address;
    public $phone;
    public $email;
    public $website;

    public function __construct() {
    }

    public function save() {
        $params = array(
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO publishers(
                        name, address, phone, email, website
                    ) VALUES (
                        :name, :address, :phone, :email, :website
                    )";
        }
        else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE publishers SET
                        name = :name,
                        address = :address,
                        phone = :phone,
                        email = :email,
                        website = :website
                    WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save publisher");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
//                throw new Exception("Error saving publisher");
                return;
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('publishers');
            }
        }
    }

    public function delete() {
        if (empty($this->id)) {
            throw new Exception("Unsaved publisher cannot be deleted");
        }
        $params = array(
            'id' => $this->id
        );
        $sql = 'DELETE FROM publishers WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete publisher");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error deleting publisher");
            }
        }
    }

    /**
     * List all publishers, sort by given column and order
     * @param string $sortby
     * @param string $order
     * @return array
     * @throws Exception
     */
    public static function all($column = 'name', $order = 'ASC') {
        $sql = "SELECT *
                FROM publishers
                ORDER BY " . $column . " " . $order;

        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve publishers");
        }
        else {
            $publishers = $stmt->fetchAll(PDO::FETCH_CLASS, 'Publisher');
            return $publishers;
        }
    }

    public static function find($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT * FROM publishers WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve publisher");
        }
        else {
            $publisher = $stmt->fetchObject('Publisher');
            return $publisher;
        }
    }


    /**
     * Return books published by publisher
     * @param $id
     * @return array
     * @throws Exception
     */
    public static function getBooksPublished($id) {
        $params = array(
            'id'    => $id
        );
        $sql = "SELECT b.*
                FROM books b
                INNER JOIN publishers p
                ON b.publisher_id = p.id
                WHERE p.id = :id";
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to get publisher books");
        }
        else {
            $books = $stmt->fetchAll(PDO::FETCH_CLASS, 'Book');
            return $books;
        }
    }
}
?>
