<?php

namespace FoxLaby\SMSLaby;

use FoxLaby\SMSLaby\Config;

use Exception;

class Send
{
    private static $instance = null;

    public static function init($hash_key = '')
    {
        if (self::$instance !== null) {
            return self::$instance;
        }
        return self::$instance = new self($hash_key);
    }
    
    public function __construct($hash_key = '') {
        $this->config = new Config($hash_key);
        $this->call = new CallServer($this->config);
    }

    public function lang($lang)
    {
        if (!in_array($lang, ['ar', 'en'])) {
            throw new Exception('The selected language is not accepted.');
        }

        $this->config['lang'] = $lang;
        return $this;
    }

    public function to($number)
    {
        $this->config['to'] = $number;
        return $this;
    }

    public function sandbox($mode)
    {
        if ($mode) {
            $mode = 'sandbox';
        }

        $this->config['mode'] = $mode;
        return $this;
    }

    public function message($body)
    {
        $this->config['message'] = $body;
        return $this->call->run();
    }
}