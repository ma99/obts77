<?php

if(!function_exists('sendSms'))
{
    function sendSms(array $data)
    {
        return app('App\Repositories\Sms\SmsInterface')->send($data);
    }
}


/*** Get previous route name ***/

if (! function_exists('previousRoute')) {
    /**
     * Generate a route name for the previous request.
     *
     * @return string|null
     */
    function previousRoute()
    {
        $previousRequest = app('request')->create(app('url')->previous());

        try {
            $routeName = app('router')->getRoutes()->match($previousRequest)->getName();
        } catch (NotFoundHttpException $exception) {
            return null;
        }

        return $routeName;
    }
}