<?php
namespace Models;

include_once "../../Config/Database.php";

use Config\Database;

class User {
    private $connection;

    public function __construct() {
        $this->connection = new Database();
        $this->connection = $this->connection->connect();
    }

    public function create($firstname, $lastname, $email, $image_path, $contactno, $address) {
        $sql = "INSERT INTO User (firstname, lastname, email, image_path, contactno, address) 
                VALUES (:firstname, :lastname, :email, :image_path, :contactno, :address)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':contactno', $contactno);
        $stmt->bindParam(':address', $address);
        return $stmt->execute();
    }

    public function update($id, $firstname, $lastname, $email, $contactno, $address) {
        $sql = "UPDATE User SET firstname = :firstname, lastname = :lastname, email = :email, contactno = :contactno, address = :address WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contactno', $contactno);
        $stmt->bindParam(':address', $address);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM User WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function read() {
        $sql = "SELECT * FROM User";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function readById($id) {
        $sql = "SELECT * FROM User WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // public function markAttendance($student_id, $attendance_date, $status) {
    //     $sql = "INSERT INTO attendance (student_id, attendance_date, status)
    //             VALUES (:student_id, :attendance_date, :status)";
    //     $stmt = $this->connection->prepare($sql);
    //     $stmt->bindParam(':student_id', $student_id, \PDO::PARAM_INT);
    //     $stmt->bindParam(':attendance_date', $attendance_date);
    //     $stmt->bindParam(':status', $status);
    //     return $stmt->execute();
    // }
}