<?php
namespace RPGBundle\Helper;


class PasswordHelper
{
    public static final function encode($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static final function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}