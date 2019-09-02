<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 9/2/19
 * Time: 3:43 p. m.
 */

namespace Mappweb\Mappweb\Presenters;



class CurrencyPresenter
{
    /**
     * Convert number to money format
     *
     * @param double $number
     * @param string $format
     * @return string
     */
    public function moneyFormat($number, $format = '% ')
    {
        return money_format($number, $format);
    }

    /**
     * Convert number to number format
     *
     * @param double $number
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousansSeparator
     * @return string
     */
    public function numberFormat($number, $decimals = 0, $decimalPoint = '.', $thousansSeparator = ',')
    {
        return number_format($number, $decimals, $decimalPoint, $thousansSeparator);
    }
}