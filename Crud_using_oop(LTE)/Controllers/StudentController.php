<?php
namespace Controllers;

require_once __DIR__ . '/../Models/Student.php'; // Required if not using autoloader

use Models\Student;

class StudentController {

    private $student;

    public function __construct() {
        $this->student = new Student();
    }

    public function index() {
        return $this->student->read();
    }

    public function addStudent($firstname, $lastname, $email, $contactNo, $address) {
        return $this->student->create($firstname, $lastname, $email, $contactNo, $address);
    }

    public function editStudent($id, $firstname, $lastname, $email, $contactNo, $address) {
        return $this->student->update($id, $firstname, $lastname, $email, $contactNo, $address);
    }

    public function deleteStudent($id) {
        return $this->student->delete($id);
    }

    public function getStudent($id) {
        return $this->student->readById($id);
    }

}
?>
