<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

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
        }

        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if ($user) {
            $errors['email'] = 'That email exists';
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
        }

        $payload = [
            'name' => $name,
            'city' => $city,
            'email' => $email,
            'state' => $state,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $this->db->query('INSERT INTO users (name, city, email, state, password) VALUES (:name, :city, :email, :state, :password)', $payload);

        $userId = $this->db->conn->lastInsertId();

        Session::set('user', [
            'id' => $userId,
            'name' => $name,
            'city' => $city,
            'email' => $email,
            'state' => $state,
        ]);

        inspectAndDie(Session::get('user'));

        redirect('/');
    }

    /**
     * Logout and kill session
     * @return void;
     */

    public function logout(): void {
        Session::clearAll();

        $params = session_get_cookie_params();
        inspect($params);
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);
        redirect('/');
    }
}
