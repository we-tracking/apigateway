<?php

namespace Source\Api\Telegram;

class Messanger extends \Source\Curl\Curl {

    public function send ( string|array $message ) : void
    {
        $post = [
            "parse_mode" => "markdown",
            'chat_id' => getenv("TELEGRAM_CHAT_ID"),
            'text' =>  $message
        ];
        
        $this->post(getenv("6d890a15c2f53ff52c437e2e241e1513") . "/sendMessage", post: http_build_query($post));

    }

}