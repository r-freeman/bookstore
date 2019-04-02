<?php

class Category
{
    public $id;
    public $name;

    public function __construct()
    {
    }

    public function save()
    {
        $params = array(
            'name' => $this->name,
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO categories(
                        name
                    ) VALUES (
                        :name
                    )";
        } else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE categories SET
                        name = :name
                    WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save category");
        } else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
//                throw new Exception("Error saving category");
                return;
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('categories');
            }
        }
    }

    public function delete()
    {
        if (empty($this->id)) {
            throw new Exception("Unsaved category cannot be deleted");
        }
        $params = array(
            'id' => $this->id
        );
        $sql = 'DELETE FROM categories WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete category");
        } else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error deleting category");
            }
        }
    }

    /**
     * List all categories, sort by given column and order
     * @param string $sortby
     * @param string $order
     * @return array
     * @throws Exception
     */
    public static function all($column = 'name', $order = 'ASC', $hasBooks = false)
    {
        if($hasBooks) {
            // list only categories which contain at least one book
            $sql = "SELECT DISTINCT(c.name), c.id
                FROM categories c
                INNER JOIN books b
                ON b.category_id = c.id";
        } else {
            $sql = "SELECT *
                    FROM categories c";
        }

        if ($column != null && $order != null) {
            $sql .= " ORDER BY " . 'c.'.$column . " " . $order;
        }

        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve categories");
        } else {
            $categories = $stmt->fetchAll(PDO::FETCH_CLASS, 'Category');
            return $categories;
        }
    }

    public static function find($id)
    {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT * FROM categories WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve category");
        } else {
            $category = $stmt->fetchObject('Category');
            return $category;
        }
    }

    /**
     * Get list of books in a given category
     * @param $id
     * @return array
     * @throws Exception
     */
    public static function getCategoryBooks($id, $limit = null, $exclude = null, $random = false)
    {
        $params = array(
            'id' => $id
        );
        $sql = "SELECT b.*
                FROM books b
                INNER JOIN categories c
                ON b.category_id = c.id
                WHERE c.id = :id";

        if ($exclude != null) {
            $sql .= ' AND NOT b.id = ' . $exclude;
        };

        if ($random) {
            $sql .= ' ORDER BY rand()';
        }

        if ($limit != null) {
            $sql .= ' LIMIT ' . $limit;
        };

        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to books in category");
        } else {
            $books = $stmt->fetchAll(PDO::FETCH_CLASS, 'Book');
            return $books;
        }
    }
}

?>
