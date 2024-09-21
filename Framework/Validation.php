<?php

namespace Framework;

class Validation {

    /**
     * Validate string
     *
     * @param string $value
     * @param integer $min
     * @param float | int $max
     * @return bool
     */
    public static function string(string $value, int $min = 1, mixed $max = INF) {
        if (is_string($value)) {
            $value = trim($value);
            $length = strlen($value);

            return $length >= $min && $length <= $max;
        }

        return false;
    }

    /**
     * Validate email
     *
     * @param string $value
     * @return mixed
     */
    public static function email(string $value): mixed {
        return filter_var(trim($value), FILTER_VALIDATE_EMAIL);
    }

    /**
     * Compare 2 values to equality
     *
     * @param string $value1
     * @param string $value2
     * @return boolean
     */
    public static function match(string $value1, string $value2): bool {
        return trim($value1) === trim($value2);
    }
}
