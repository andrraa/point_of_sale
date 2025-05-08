<?php

namespace App\Services;

use Proengsoft\JsValidation\Facades\JsValidatorFacade;

class ValidationService
{
    public function generateValidation(string $class, string $selector): array|string|null
    {
        return preg_replace("/<\/?script>/", "", JsValidatorFacade::formRequest($class, $selector));
    }
}
