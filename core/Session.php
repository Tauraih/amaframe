<?php


namespace app\core;


class Session
{
    protected const FLASH_KEY = 'flash_messages';

    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage){
//            Mark to be removed
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
//        print_r($_SESSION[self::FLASH_KEY]);
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct()
    {
//        iterate over marked to be removed
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage){
            if ($flashMessage['remove']){
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}