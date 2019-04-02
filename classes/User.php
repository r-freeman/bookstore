<?php

class User {
    public $id;
    public $username;
    public $password;
    public $role_id;
    public $role_title;

    public function __construct() {
    }

    public function save() {
        $params = array(
            'username' => $this->username,
            'password' => $this->password,
            'role_id' => $this->role_id
        );

        if ($this->id === NULL) {
            $sql = "INSERT INTO users(
                        username, password, role_id
                    ) VALUES (
                        :username, :password, :role_id
                    )";
        }
        else if ($this->id !== NULL) {
            $params["id"] = $this->id;

            $sql = "UPDATE users SET
                        username = :username,
                        password = :password,
                        role_id = :role_id
                    WHERE id = :id";
        }

        $conn = Connection::getInstance();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to save user");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
//                throw new Exception("Error saving user");
                return;
            }
            if ($this->id === NULL) {
                $this->id = $conn->lastInsertId('users');
            }
        }
    }

    public function delete() {
        if (empty($this->id)) {
            throw new Exception("Unsaved user cannot be deleted");
        }
        $params = array(
            'id' => $this->id
        );
        $sql = 'DELETE FROM users WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to delete user");
        }
        else {
            $rowCount = $stmt->rowCount();
            if ($rowCount !== 1) {
                throw new Exception("Error deleting user");
            }
        }
    }

    /**
     * Return all users and their roles
     * @return array
     * @throws Exception
     */
    public static function all() {
        $sql = 'SELECT u.id, u.username, u.password, ur.id as role_id, ur.title as role_title
                FROM users u
                INNER JOIN user_roles ur
                ON u.role_id = ur.id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve users");
        }
        else {
            $users = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
            return $users;
        }
    }

    /**
     * Return a user object including user role with a given user id
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public static function find($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT u.id, u.username, u.password, ur.id as role_id, ur.title as role_title
                FROM users u
                INNER JOIN user_roles ur
                ON u.role_id = ur.id
                WHERE u.id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve user");
        }
        else {
            $user = $stmt->fetchObject('User');
            return $user;
        }
    }

    public static function findByUsername($username) {
        $params = array(
            'username' => $username
        );
        $sql = 'SELECT * FROM users WHERE username = :username';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve user");
        }
        else {
            $user = $stmt->fetchObject('User');
            return $user;
        }
    }
}
?>
