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
            $sql = "SELECT * FROM teacher WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return $stmt->fetch();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }

    public function insert($name, $email, $salary, $school)
    {
        try {

            $sql = "
            INSERT INTO `teacher` (`name`, `email`, `salary`, `school`) 
            VALUES (:name, :email, :salary, :school)
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':salary', $salary);
            $stmt->bindParam(':school', $school);

            $stmt->execute();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }

    public function update($id, $name, $email, $salary, $school)
    {
        try {
            $sql = "
                UPDATE teacher 
                                SET name = :name,
                                    email = :email,
                                    salary = :salary,
                                    school = :school
                WHERE id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':salary', $salary);
            $stmt->bindParam(':school', $school);

            $stmt->execute();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM teacher WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);

            $stmt->execute();
        } catch (\Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            die;
        }
    }
}
