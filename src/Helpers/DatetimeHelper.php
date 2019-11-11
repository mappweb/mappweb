<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 10/5/19
 * Time: 10:01 p. m.
 */

namespace Mappweb\Mappweb\Helpers;


use Carbon\Carbon;

class DatetimeHelper
{
    const dayNames = [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday'
    ];

    /**
     * @param string $timezone
     * @return Carbon
     */
    public static function getToday($timezone = 'default')
    {
        if ($timezone === 'default'){
            $timezone = geoip()->getLocation()->timezone;
        }

        return Carbon::today($timezone);
    }

    /**
     * @param string $timezone
     * @return Carbon
     */
    public static function now($timezone = 'default')
    {
        if ($timezone === 'default'){
            $timezone = geoip()->getLocation()->timezone;
        }

        return Carbon::now($timezone);
    }

    /**
     * @param $datetime
     * @param string $timezone
     * @param string $format
     * @return \DateTime|false
     */
    public static function parseFromFormatToUTC($datetime, $timezone = 'UTC', $format = 'Y-m-d H:i')
    {
        if ($timezone == 'UTC'){
            return Carbon::createFromFormat($format, $datetime, $timezone);
        }

        return Carbon::createFromFormat($format, $datetime, $timezone)->setTimezone('UTC');
    }

    /**
     * @param $datetime
     * @param string $timezone
     * @param string $format
     * @return \DateTime|false
     */
    public static function parseFromFormatToUserTimezone($datetime, $timezone = 'UTC', $format = 'Y-m-d H:i:s')
    {
        if ($timezone == 'UTC'){
            return Carbon::createFromFormat($format, $datetime, $timezone);
        }

        return Carbon::createFromFormat($format, $datetime)->setTimezone($timezone);
    }

    /**
     * parse datetime to format
     * @param $datetime
     * @param $format
     * @return string
     */
    public static function parseFormat($datetime, $format){
        return Carbon::parse($datetime)->format($format);
    }

    /**
     * Convert datetime to text
     *
     * @param $date
     * @param string $locale
     * @return string
     */
    public static function parseFromDatetimeToText($date, $locale = 'es_CO')
    {
        return Carbon::parse($date)->locale($locale)->isoFormat('LL');
    }

}
