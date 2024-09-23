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
}
