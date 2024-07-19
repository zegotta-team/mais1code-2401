<?php

class FlashMessage
{
    const FLASH_ERROR = 'danger';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

    const FLASH_FRONT_BOOSTRAP = 'bootstrap';
    const FLASH_FRONT_TAILWIND = 'tailwind';

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

    public static function getMessage($front = FlashMessage::FLASH_FRONT_BOOSTRAP)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['flash_message'])) {
            $type = $_SESSION['flash_message']['type'];
            $message = $_SESSION['flash_message']['message'];

            if ($front == self::FLASH_FRONT_BOOSTRAP) {
                echo "<div class='alert alert-$type'>$message</div>";
            } else {

                $svg = match($type) {
                    self::FLASH_SUCCESS => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg>',
                    self::FLASH_WARNING => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /> </svg>',
                    self::FLASH_ERROR => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /> </svg>',
                    default => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path> </svg>',
                };

                echo <<<HTML
                <div role="alert" class="alert alert-$type max-w-7xl mt-4 mx-auto px-4 text-white">$svg<span>$message</span></div>
                HTML;
            }

            unset($_SESSION['flash_message']);
        }
    }


}