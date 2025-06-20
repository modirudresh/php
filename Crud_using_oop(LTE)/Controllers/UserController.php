<?php
namespace Controllers;

include_once __DIR__ . '/../Models/user.php'; 
use Models\User;

class UserController {

    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function index() {
        return $this->user->read();
    }

    public function adduser($firstname, $lastname, $email, $contactNo, $address) {
        return $this->user->create($firstname, $lastname, $email, '', $contactNo, $address); // Pass empty image_path
    }

    public function edituser($id, $firstname, $lastname, $email, $contactNo, $address) {
        return $this->user->update($id, $firstname, $lastname, $email, $contactNo, $address);
    }

    public function deleteuser($id) {
        return $this->user->delete($id);
    }

    public function getuser($id) {
        return $this->user->readById($id);
    }
}
//     public function markAttendance($user_id, $attendance_date, $status) {
//         return $this->user->markAttendance($user_id, $attendance_date, $status);
//     }
// }