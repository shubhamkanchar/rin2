<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ValidPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');

        $url = "https://lookups.twilio.com/v1/PhoneNumbers/{$value}?Type=carrier";

        $response = Http::withBasicAuth($sid, $token)->get($url);

        if (!$response->successful()) {
            $fail('The :attribute must be a valid and reachable phone number.');
        }
    }
}
