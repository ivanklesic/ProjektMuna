<?php declare(strict_types = 1);

namespace App\Core\Request;

class Request implements RequestInterface
{
    public function __construct()
    {
        $this->bootstrap();
    }

    private function bootstrap()
    {
        foreach($_SERVER as $key => $value)
        {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach($matches[0] as $match)
        {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    public function getBody(): ?array
    {
        if($this->requestMethod === "GET")
        {
            return null;
        }

        if ($this->requestMethod === "POST")
        {
            return $_POST;
        }
        return null;
    }

}