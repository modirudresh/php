<?php
namespace Controllers;

include_once __DIR__ . '/../Models/User.php';
use Models\User;

class UserController {

    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function index() {
        return $this->user->read();
    }

    public function adduser($first_name, $last_name, $email, $phone_no, $address, $password, $gender, $DOB, $hobby, $country, $image_path) {
        return $this->user->create($first_name, $last_name, $email, $image_path, $phone_no, $address, $password, $DOB, $gender, $hobby, $country);
    }


    public function edituser( $id, $first_name, $last_name, $email, $phone_no, $address, $DOB, $gender, $hobby, $country, $image_path = null ) {
        return $this->user->update( $id, $first_name, $last_name, $email, $phone_no, $address, $DOB, $gender, $hobby, $country, $image_path );
    }

    public function deleteuser( $id ) {
        return $this->user->delete( $id );
    }

    public function getuser( $id ) {
        return $this->user->readById( $id );
    }
}
