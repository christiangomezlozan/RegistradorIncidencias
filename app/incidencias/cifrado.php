<?php

/**
 * Proporciona las funciones para el cifrado y descifrado de las contraseñas de los empleados
 * 
 * @package incidencias
 * @author Christian Gómez Lozano 
 */

/**
 * Cifra una cadena utilizando el algoritmo AES-256-CBC
 * 
 * @param $claveUsuario Clave que se desea cifrar
 * @return string la cadena que se ha introducido como parametro cifrada en formato Base64
 */
function cifrar($claveUsuario){

    $claveCifrado = 'ABCD-1234.aer';
    $cifrado = 'AES-256-CBC'; // Cifrado obtenido de https://www.php.net/manual/es/function.openssl-get-cipher-methods.php

    $ivSize = openssl_cipher_iv_length($cifrado); // Tamaño del vector de inicialización del cifrado
    
    $iv = openssl_random_pseudo_bytes($ivSize);
    $datosCifrados = openssl_encrypt($claveUsuario, $cifrado, $claveCifrado, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $datosCifrados);
    
}

/**
 * Descifra una cadena cifrada previamente con la funcion `cifrar`
 * 
 * @param $claveCifrada Clave que se desea descifrar
 * @return string la cadena descifrada
 */
function descifrar($claveCifrada){

    $claveCifrado = 'ABCD-1234.aer';
    $cifrado = 'AES-256-CBC'; 

    $claveCifrada = base64_decode($claveCifrada);

    $ivSize = openssl_cipher_iv_length($cifrado);

    $iv = substr($claveCifrada, 0, $ivSize);
    $datosCifrados = substr($claveCifrada, $ivSize);

    return openssl_decrypt($datosCifrados, $cifrado, $claveCifrado, OPENSSL_RAW_DATA, $iv);

}



?>