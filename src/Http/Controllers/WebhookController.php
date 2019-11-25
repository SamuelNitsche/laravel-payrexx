<?php

namespace SamuelNitsche\LaravelPayrexx\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use SamuelNitsche\LaravelPayrexx\Events\PaymentReceived;
use SamuelNitsche\LaravelPayrexx\Events\WebhookHandled;
use SamuelNitsche\LaravelPayrexx\Events\WebhookReceived;
use SamuelNitsche\LaravelPayrexx\Payment;

class WebhookController
{
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $eventType = array_key_first($payload);
        $eventStatus = Arr::get($payload, 'transaction.status');
        $method = 'handle'.Str::studly("{$eventType}_{$eventStatus}");

        WebhookReceived::dispatch([]);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            WebhookHandled::dispatch($payload);

            return $response;
        }

        return $this->missingMethod();
    }

    protected function handleTransactionConfirmed($payload)
    {
        $payment = Payment::wherePayrexxId($payload['transaction']['id'])->firstOrFail();

        PaymentReceived::dispatch($payment, $payload);

        return $this->successMethod();
    }

    protected function successMethod()
    {
        return new Response('Webhook handled', 200);
    }

    protected function missingMethod()
    {
        return new Response('Missing method', 200);
    }
}
