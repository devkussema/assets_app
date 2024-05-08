<?php

// Função para carregar as variáveis de ambiente de um arquivo .env
function loadEnv($filePath)
{
    // Verifica se o arquivo existe
    if (!file_exists($filePath)) {
        throw new Exception('.env file not found');
    }

    // Lê o conteúdo do arquivo .env
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Percorre as linhas e define as variáveis de ambiente
    foreach ($lines as $line) {
        // Ignora linhas que começam com '#' (comentários)
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Separa a linha pelo sinal de igual
        list($name, $value) = explode('=', $line, 2);

        // Define a variável de ambiente
        $name = trim($name);
        $value = trim($value);
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Função env para obter variáveis de ambiente
function env($key, $default = null)
{
    $value = getenv($key);

    // Se a variável de ambiente não estiver definida, retorna o valor padrão (se fornecido)
    return $value !== false ? $value : $default;
}

// Carrega as variáveis de ambiente do arquivo .env na raiz do projeto
$envFilePath = __DIR__ . '../../.env';
if (file_exists($envFilePath)) {
    $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Define a variável de ambiente apenas se ainda não estiver definida
        if (!getenv($name)) {
            putenv("$name=$value");
        }
    }
}

// Carrega as variáveis de ambiente do arquivo .env na raiz do projeto
loadEnv(__DIR__ . '../../.env');
