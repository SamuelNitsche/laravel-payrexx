<?php

namespace SamuelNitsche\LaravelPayrexx;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class Payment extends Model
{
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_WAITING = 'waiting';
    const STATUS_DECLINED = 'declined';
    const STATUS_REFUNDED = 'refunded';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function isConfirmed()
    {
        return $this->status === Payment::STATUS_CONFIRMED;
    }

    public function isCancelled()
    {
        return $this->status === Payment::STATUS_CANCELLED;
    }

    public function isWaiting()
    {
        return $this->status === Payment::STATUS_WAITING;
    }

    public function isDeclined()
    {
        return $this->status === Payment::STATUS_DECLINED;
    }

    public function isRefunded()
    {
        return $this->status === Payment::STATUS_REFUNDED;
    }
}
