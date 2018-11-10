<?php
/*
 Сам код не был протестен, поскольку при настройке сообщества, в разделе (настройка сервера -> CallBack), сервер
возвращал неправильный ответ. Тип ошибки "HTTP response code said error". Я не смог решить данную проблему. Надеюсь в
обратной связи, при разборе ДЗ мне объяснят, в чём была ошибка
 */
require 'vk_wrapper.php'; // подгружаем файл с функцией VkApi()
require 'config.php'; // подгружаем токены

// принимаем запрос от вк
$get = file_get_content('php://input');
$data = json_decode($get);

switch ($data->type) {
    case 'confirmation': // подтверждение колбек сервера
        echo $confirmation_code;
        break;
    case 'message_new': // новое сообщение
        echo 'ok';
        $user_id = $data->object->from_id;
        $text = $data->object->text;


        $words = explode(" ", $text);

        $message = "Приветствую друг !";
        $message .= "Я бот, который поможет тебе с приобретением аксессуаров для  ленивцев\r\n";
        $message .= "Отправьте '1', чтобы оформить заказ\r\n";
        $message .= "Отправьте '2', чтобы оствать заявку для связи с нашим специалистом\r\n";
        $message .= "Отправьте 3, чтобы узнать больше об ленивцах и как их содержать";

        switch ($words[0]) {
            case '1';
                $message = "Пожалуйста, отправьте:\r\n";
                $message .= "Ссылку на интересующий товар\r\n";
                $message .= "Город, в который потребуется доставка\r\n";
                $message .= "Предпочтительный вариант оплаты: Сбербанк/наличными/Терминалы Qiwi";
                break;
            case '2';
                $message = "Пожалуйста, укажите:\r\n";
                $message .= "Имя\r\n";
                $message .= "Номер телефона/r/n";
                $message .= "Удобную дату и время для звонка";
                break;
            case '3';
                $message = "Здесь вы сможете найти всю необходимую вам информацию:\r\n";
                $message .= "https://tutknow.ru/animals/1405-lenivec-medlitelnoe-zhivotnoe.html";
                break;
            default:
                $message = "Я не понял команды\nДоступные команды:\n- 1\n- 2\n- 3";
                break;
        }


        // отправка сообщения пользователю
        $response = VkApi($community_token, 'messages.send', [
            'user_id' => $user_id,
            'message' => $message
        ]);
        break;

}
