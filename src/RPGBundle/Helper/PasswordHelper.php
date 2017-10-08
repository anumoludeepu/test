<?php
namespace RPGBundle\Helper;


class PasswordHelper
{
    public static final function encode($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 20]);
    }
}