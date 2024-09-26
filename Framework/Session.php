<?php

namespace Framework;

class Session {
    /**
     * Start session
     *
     * @return void
     */
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set Session key/pair value;
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    /**
     * Get Session value by the key;
     *
     * @param string $key
     * @param [type] $default
     * @return mixed
     */
    public static function get(string $key, $default = null): mixed {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Check if session key exists
     *
     * @param string $key
     * @return boolean
     */
    public static function has(string $key) {
        return isset($_SESSION[$key]);
    }

    /**
     * Clear session by a key
     *
     * @param string $key
     * @return void
     */
    public static function clear(string $key): void {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Clear all session data
     *
     * @return void
     */
    public static function clearAll(): void {
        session_unset();
        session_destroy();
    }

    /**
     * Set Flash message
     *
     * @param string $key
     * @param string $message
     * @return void
     */
    public static function setFlashMessage(string $key, string $message): void {

        self::set('flash_' . $key, $message);
        // inspectAndDie(['key' => $key, 'message' => $message, 'Session' => $_SESSION]);
    }

    /**
     * Get Flash message
     *
     * @param string $key
     * @param mixed $default
     * @return string
     */
    public static function getFlashMessage(string $key, mixed $default = null): mixed {
        $messageKey = 'flash_' . $key;
        $message = self::get($messageKey, $default);
        // $message = isset($_SESSION[$messageKey]) ? $_SESSION[$messageKey] : null;
        // inspect($key);
        // inspect($message);
        self::clear($messageKey);
        return $message;
    }
}
