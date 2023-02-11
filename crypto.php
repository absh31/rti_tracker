<?php
$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$encryption_iv = '1208200031072002';
$encryption_key = "hackathon";
function encryptAadhar($aadhar, $ciphering, $encryption_key, $options, $encryption_iv)
{
    $encryption = openssl_encrypt(
        $aadhar,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );
    return $encryption;
}
function decryptAadhar($aadhar, $ciphering, $encryption_key, $options, $encryption_iv)
{
    $decryption = openssl_decrypt(
        $aadhar,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );
    return $decryption;
}
// $aadhar = 123456789012;
// $enc = encryptAadhar($aadhar, $ciphering, $encryption_key, $options, $encryption_iv);
// echo $enc;
// $dec = decryptAadhar($enc, $ciphering, $encryption_key, $options, $encryption_iv);
// echo "<br>";
// echo $dec;