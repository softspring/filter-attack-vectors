<?php

function softspring_filter_attack_vectors_do_exit(): void
{
    http_response_code(404);
    echo 'Not Found';
    exit;
}

function softspring_filter_attack_vectors_should_block(?string $requestUri): bool
{
    if (null === $requestUri) {
        return false;
    }

    // Filter WordPress probing requests.
    if (str_starts_with($requestUri, '/wp-')) {
        return true;
    }

    // Filter direct PHP file requests.
    if (str_contains($requestUri, '.php')) {
        return true;
    }

    // Filter Symfony env injection attempts.
    return str_contains($requestUri, '+--env=');
}

if (softspring_filter_attack_vectors_should_block($_SERVER['REQUEST_URI'] ?? null)) {
    softspring_filter_attack_vectors_do_exit();
}
