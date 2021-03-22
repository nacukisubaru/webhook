<?php

namespace Webhook\QueryRest;
/**
 * Class QueryRest
 * Класс для создания выполнения запросов к rest api по заданному методу
 * @package Webhook\QueryRest
 */
class QueryRest
{
    /**
     * урл
     * @var string
     */
    protected $url = 'https://uttest.bitrix24.com/rest/1/mxd5fcd4x0ijzegt/';
    /**
     * метод который хотим в выполнить
     * @var string
     */
    protected $method = "";

    /**
     * QueryRest constructor.
     * @param string $method метод для выполнения запроса
     */
    public function __construct(string $method = "")
    {
        $this->method = $method;
    }

    /**
     * Выполняет запрос к rest api bitrix24
     * @param array $array_param массив с полями для запроса
     * @return mixed|string
     */
    public function executeQuery(array $array_param)
    {
        $ch = curl_init($this->url . $this->method);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array_param));
        $result = curl_exec($ch);
        if ($result == false) {
            return curl_error($ch);
        } else {
            return json_decode($result, true)['result'];
        }
    }
}