<?php


namespace Ngotr\Thithu1\Models;

use Ngotr\Thithu1\Commons\Model;

class Teacher extends Model
{
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM teacher";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }

    public function getByID($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return $stmt->fetch();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }

    public function insert($name, $email, $password, $avartar = null)
    {
        try {
            $sql = "
                INSERT INTO users(name, email, password, avartar) 
                VALUES (:name, :email, :password, :avartar)
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':avartar', $avartar);

            $stmt->execute();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }

    public function update($id, $name, $email, $password, $role, $avartar = null)
    {
        try {
            $sql = "
                UPDATE users 
                                SET name = :name,
                                    email = :email,
                                    password = :password,
                                    avartar = :avartar,
                                    role = :role

                WHERE id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':avartar', $avartar);
            $stmt->bindParam(':role', $role);

            $stmt->execute();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }

    public function deleteByID($id)
    {
        try {
            $sql = "DELETE FROM users WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);

            $stmt->execute();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }
}
