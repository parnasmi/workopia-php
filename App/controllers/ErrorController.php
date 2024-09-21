<?php

namespace App\Controllers;

use Framework\Database;

class ErrorController {
    /**
     * 404 not found page
     *
     * @return void
     */
    static function notFound(string $message = 'The page is not found') {

        http_response_code(404);
        loadView('error', [
            'message' => $message,
            'status' => '404'
        ]);
    }

    /**
     * 404 not found page
     *
     * @return void
     */
    static function unauthorized(string $message = 'You are not authorized to view this resource') {

        http_response_code(401);
        loadView('error', [
            'message' => $message,
            'status' => '401'
        ]);
    }
}
