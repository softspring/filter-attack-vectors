<?php

function softspring_filter_attack_vectors_do_exit(): void
{
    http_response_code(404);
    echo 'Not Found';
    exit;
}

// Filter WordPress probing requests.
if (isset($_SERVER['REQUEST_URI']) && str_starts_with($_SERVER['REQUEST_URI'], '/wp-')) {
    softspring_filter_attack_vectors_do_exit();
}

// Filter direct PHP file requests.
if (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '.php')) {
    softspring_filter_attack_vectors_do_exit();
}

// Filter Symfony env injection attempts.
if (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], '+--env=')) {
    softspring_filter_attack_vectors_do_exit();
}
