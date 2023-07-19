<?php
function jsonResponse($code, $message, $others = array()) {
    return json_encode([
        'status' => $code,
        'message' => $message,
        'data' => $others
    ]);
}