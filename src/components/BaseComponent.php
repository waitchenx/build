<?php

namespace app\components;


class BaseComponent
{
    private $message = '';

    private $code = 0;

    public function _err($message = '',$code = 0)
    {
        $this->message = $message;
        $this->code = $code;

        return false;
    }

    public function getLastMsg()
    {
        return $this->message;
    }
}