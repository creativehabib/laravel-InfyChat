<?php

namespace App\Utils;

class ResponseUtil
{
    /**
     * Prepare a success response structure.
     */
    public static function makeResponse(string $message, $data): array
    {
        return ['success' => true, 'message' => $message, 'data' => $data];
    }

    /**
     * Prepare an error response structure.
     */
    public static function makeError(string $message, array $errors = []): array
    {
        $response = ['success' => false, 'message' => $message];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return $response;
    }
}
