<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class PaymentComponent extends Component
{

    public $campaign, $activeStep;
    public $clientId;
    public $secret;
    public $currency;
    public $amount;
    public $paypal_keys;
    // AWNBOqMVVafw3FTRvGxhQ2x3OQqpxJ5y8ht1JS5mNdbuqVqDS_ESpQeESXjw-ODpK0etWkLVUAmW-ZGH

    public function mount($activeStep, $campaign)
    {
        $this->activeStep = $activeStep;
        $this->campaign = $campaign;
        $this->paypal_keys = json_decode($this->campaign->paypal_keys, true) ?? [];
        $this->clientId = $this->paypal_keys['client_id'] ?? '';
        $this->secret = $this->paypal_keys['secret'] ?? '';
        $this->currency = $this->paypal_keys['currency'] ?? 'USD';
        $this->amount = $this->activeStep->amount ?? '';
    }



    public function saveCredentials()
    {
        $this->validate([
            'clientId' => 'required|string',
            'secret' => 'required|string',
        ]);

        $encryptedClientId = Crypt::encryptString(trim($this->clientId));
        $encryptedSecret = Crypt::encryptString(trim($this->secret));

        $paypal_keys = json_encode([
            'client_id' => $encryptedClientId,
            'secret' => $encryptedSecret,
            'currency' => 'USD',
        ]);
        $this->campaign->update([
            'paypal_keys' =>  $paypal_keys,
        ]);

        $this->paypal_keys['client_id'] = $encryptedClientId;
        $this->paypal_keys['secret'] = $encryptedSecret;
        $this->clientId = $encryptedClientId;
        $this->secret = $encryptedSecret;

        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }


    public function update_currency($key)
    {
        $this->paypal_keys[$key] =  $this->currency;

        $this->campaign->update([
            'paypal_keys' => json_encode($this->paypal_keys),
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    public function update_amount()
    {
        $this->activeStep->update([
            'amount' => $this->amount,
        ]);

        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    public function clearKeys()
    {
        $this->campaign->update([
            'paypal_keys' => null,
        ]);

        $this->paypal_keys['client_id'] = null;
        $this->paypal_keys['secret'] = null;
        $this->clientId = '';
        $this->secret = '';


        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    public function render()
    {
        return view('livewire.payment-component');
    }
}
