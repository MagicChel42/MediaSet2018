<?php
// простейшая функция для работы с VK API
function VkApi($access_token, $method, $params = [])
{
    // обязательные параметры запроса
    $required_params = [
        'access_token' => $access_token,
        'v' => '5.80'
    ];
    // дополняем переданные параметры обязательными
    $params = array_merge($required_params, $params);
    // генерим адрес запроса
    $url = sprintf("https://api.vk.com/method/%s?%s", $method, http_build_query($params));
    // делаем GET-запрос и декодируем JSON в массив
    $result = json_decode(file_get_contents($url));
    // возвращаем ответ
    return (isset($result->response)) ? $result->response : $result;
}
