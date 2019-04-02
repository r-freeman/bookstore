<?php

class Role {
    public $id;
    public $title;

    /**
     * Return all roles
     * @return array
     * @throws Exception
     */
    public static function all() {
        $sql = 'SELECT *
                FROM user_roles
                WHERE id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Failed to retrieve roles");
        }
        else {
            $roles = $stmt->fetchAll(PDO::FETCH_CLASS, 'Role');
            return $roles;
        }
    }

    /**
     * Find a role with given id
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public static function find($id) {
        $params = array(
            'id' => $id
        );
        $sql = 'SELECT *
                FROM user_roles
                WHERE id = :id';
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);
        $success = $stmt->execute($params);
        if (!$success) {
            throw new Exception("Failed to retrieve role");
        }
        else {
            $role = $stmt->fetchObject('Role');
            return $role;
        }
    }
}

?>
