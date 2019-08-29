<?php
/**
 * Created by PhpStorm.
 * User: Diego
 * Date: 4/04/2019
 * Time: 11:25 AM
 */

namespace Mappweb\Mappweb\Helpers;


use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class Notification
{
    /**
     * @param $message
     * @param null $title
     * @param null $url
     * @param null $icon
     */
    public static function web($message, $title = null, $url = null, $icon = null){
        $contents = array(
            "en" => $message
        );

        $params = array(
            'contents' => $contents,
            'included_segments' => array('All'),
            'chrome_web_icon' => $icon
        );

        if (isset($title)) {

            $headings = array(
                "en" => $title
            );

            $params['headings'] = $headings;
        }

        if (isset($url)) {
            $params['url'] = $url;
        }

        \OneSignal::sendNotificationCustom($params);
    }

    /**
     * @param $tokens
     * @param string $title
     * @param string $body
     * @return mixed
     */
    public static function smartPhone($tokens, $title = 'my title', $body = 'Hello world'){

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setTitle($title)->setBody($body);

        $dataBuilder = new PayloadDataBuilder();
       // $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        return $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
    }
}