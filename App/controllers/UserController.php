<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class UserController {
    protected $db;

    public function __construct() {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Login 
     *
     * @return void
     */
    public function login(): void {

        loadView('users/login');
    }

    /**
     * Login 
     *
     * @return void
     */
    public function create(): void {

        loadView('users/register');
    }

    public function store(): void {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $passwordConfimation = $_POST['password_confirmation'];

        $errors = [];

        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email';
        }

        if (!Validation::string($name, 2, 50)) {
            $errors['name'] = 'Name must be between 2 and 50 characters';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be at least characters';
        }

        if (!Validation::match($password, $passwordConfimation)) {
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            loadView('users/register', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'city' => $city,
                    'email' => $email,
                    'state' => $state,
                ]
            ]);
            exit;
        } else {
            echo 'Success';
        }
    }
}
