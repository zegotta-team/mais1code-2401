<?php

class FlashMessage
{
    const SESSION_KEY = 'flash_message';

    public static function addMessage(string $message, FlashMessageType $type = FlashMessageType::SUCCESS)
    {
        Session::iniciaSessao();

        Session::set(static::SESSION_KEY, [
            'type' => $type,
            'message' => $message
        ]);
    }

    public static function getMessage()
    {
        Session::iniciaSessao();

        if (!empty(Session::get(static::SESSION_KEY))) {
            $type = Session::get(static::SESSION_KEY)['type'];
            $message = Session::get(static::SESSION_KEY)['message'];

            $svg = $type->icon();

            echo <<<HTML
                <div role="alert" class="alert alert-{$type->value} max-w-7xl mt-4 mb-5 mx-auto px-4 text-white border">$svg<span>$message</span></div>
                HTML;


            Session::clear(static::SESSION_KEY);
        }
    }


}