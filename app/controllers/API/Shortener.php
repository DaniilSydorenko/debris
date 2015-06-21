<?php
/*******************************************************************************
 * Name: App -> API -> Shortener
 * Version: 1.0
 * Author: Daniil Sydorenko (daniildeveloper@gmail.com)
 ******************************************************************************/


// Namespace
namespace App\API;


/**
 * Shortener class
 * @TODO Не важно, как выполнится запрос — Facebook всегда вернет нам код 200 OK.
 * @TODO откинуть все методы кроме GET, получить все прараметры, разбить на элементы массива
 * @TODO перевести в lowercase, допускать сразу до пяти урлов, ошибки возварашать в ответе
 * @TODO
 * @TODO
 */
class Shortener extends API
{
    public function short($url) {
        // lOGIC
    }

    public function checkRequest()
    {

    }

}
