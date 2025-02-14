<?php

return [
    'paths' => ['api/*'], // Spécifiez le chemin de vos routes API
    'allowed_methods' => ['*'], // Autorise toutes les méthodes (GET, POST, etc.)
    'allowed_origins' => ['*'], // Autorise toutes les origines
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Autorise tous les en-têtes
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
