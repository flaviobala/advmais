<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration - SANCTUM SPA MODE
    |--------------------------------------------------------------------------
    */

    // 1. Incluímos 'sanctum/csrf-cookie' para o frontend solicitar o cookie inicial.
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // 2. Métodos permitidos.
    'allowed_methods' => ['*'],

    // 3. Origens Permitidas.
    // ATENÇÃO: Com 'supports_credentials' = true, NÃO podemos usar '*'.
    // Coloquei 'http://localhost:3000' como padrão do Next/React.
    // Se seu front rodar em outra porta, altere aqui.
    'allowed_origins' => [
      'http://localhost:3000',      // Next.js Padrão
        'http://127.0.0.1:3000',
        
        'http://localhost:3001',      // Fallback 1 (se a 3000 estiver em uso)
        'http://127.0.0.1:3001',
        
        'http://localhost:3002',      // Fallback 2
        'http://127.0.0.1:3002',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // 4. CRUCIAL PARA SPA: Permite o envio de Cookies de sessão/autenticação.
    'supports_credentials' => true,

];