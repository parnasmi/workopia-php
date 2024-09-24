<?php

namespace Framework;

use Framework\Session;

class Guard {

    public static function isOwner(int $resourceId): bool {
        $sessionUser = Session::get('user');

        if ($sessionUser !== null && isset($sessionUser['id'])) {
            $sessionUserId = (int) $sessionUser['id'];

            return $sessionUserId === $resourceId;
        }

        return false;
    }
}
