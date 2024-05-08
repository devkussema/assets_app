<?php

require "src/core/run.php";

// Função para criptografar um texto
function encrypt($text, $key) {
    // Use AES-256-CBC para criptografia
    $cipher = "aes-256-cbc";

    // Gere um vetor de inicialização aleatório
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);

    // Criptografe o texto
    $ciphertext = openssl_encrypt($text, $cipher, $key, $options=0, $iv);

    // Combine o IV com o texto cifrado para que possam ser decifrados mais tarde
    $encrypted_text = base64_encode($iv . $ciphertext);

    return $encrypted_text;
}

// Função para descriptografar um texto
function decrypt($encrypted_text, $key) {
    // Use AES-256-CBC para criptografia
    $cipher = "aes-256-cbc";

    // Decodifique o texto cifrado
    $ciphertext_dec = base64_decode($encrypted_text);

    // Obtenha o IV do texto cifrado
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = substr($ciphertext_dec, 0, $ivlen);

    // Obtenha o texto cifrado (excluindo o IV)
    $ciphertext = substr($ciphertext_dec, $ivlen);

    // Descriptografe o texto
    $plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv);

    return $plaintext;
}

// Defina o cabeçalho HTTP 404
#header("HTTP/1.0 404 Not Found");

// Exiba uma mensagem de erro personalizada
#echo "<h1>Erro 404 - Página não encontrada</h1>";

// Texto a ser criptografado
$texto_original = "Hello, world!";
// Chave de criptografia (deve ser mantida em segredo)
$chave = "minhachavedecriptografia";

// Criptografar o texto
$texto_cifrado = encrypt($texto_original, $chave);
echo "Texto criptografado: $texto_cifrado <br>";

// Descriptografar o texto
$texto_descriptografado = decrypt($texto_cifrado, $chave);
echo "Texto descriptografado: $texto_descriptografado <br>";
echo "<hr>".env('APP_NAME');
?>
