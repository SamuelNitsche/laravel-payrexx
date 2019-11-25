<?php

namespace SamuelNitsche\LaravelPayrexx;

use Illuminate\Database\Eloquent\Model;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class Payment extends Model
{
    public function rawAmount()
    {
        return $this->amount;
    }

    public function amount()
    {
        $money = new Money($this->rawAmount(), new Currency('CHF'));
        $numberFormatter = new NumberFormatter('de_CH', NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies);

        return $moneyFormatter->format($money);
    }
}
