<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorize {

    public static function isAuthenticated(): bool {
        return Session::has('user');
    }

    /**
     * Handle user's requests
     *
     * @param string $role
     * @return void;
     */
    public function handle(string $role): void {
        if ($role === 'guest' && $this->isAuthenticated()) {
            redirect('/');
            exit;
        } elseif ($role === 'auth' && !$this->isAuthenticated()) {
            redirect('/auth/login');
            exit;
        }
    }
}
