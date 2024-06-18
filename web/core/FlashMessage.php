<?php

class FlashMessage
{
    const FLASH_ERROR = 'danger';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

    public static function addMessage($message, $type = "success")
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public static function getMessage()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['flash_message'])) {
            $type = $_SESSION['flash_message']['type'];
            $message = $_SESSION['flash_message']['message'];

            echo "<div class='alert alert-$type'>$message</div>";

            unset($_SESSION['flash_message']);
        }
    }


}