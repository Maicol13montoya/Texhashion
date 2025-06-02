<?php

function generarContrasena($longitud = 10)
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($caracteres, $longitud)), 0, $longitud);
}
