<?php

function uuidv4()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function better_crypt($input, $rounds = 7)
{
    $salt = "";
    $salt_chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    for ($i = 0; $i < 22; $i++) {
        $salt .= $salt_chars[array_rand($salt_chars)];
    }
    return crypt($input, sprintf('$2y$%02d$', $rounds) . $salt);
}

function safeInput($input)
{
    $input = htmlentities($input);
    $input = htmlspecialchars($input);
    $input = trim($input);
    return $input;
}

function readJsonConfig()
{
    $config = file_get_contents(__DIR__ . "/../config/config.json");
    $config = json_decode($config, true);
    return $config;
}

function saveConfig($config)
{
    $config = json_encode($config, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__ . "/../config/config.json", $config);
}

function isAppConfigured()
{
    $config = readJsonConfig();
    return $config["isConfigured"];
}

class CResponse
{
    public $status;
    public $message;
    public $data;

    public function __construct($status, $message, $data)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    public function getResponse(){
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}

?>