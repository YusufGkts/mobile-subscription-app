<?php

namespace App\Services;

use App\Enums\PurchaseStatus;
use DateTime;
use DateTimeZone;
use function Symfony\Component\Translation\t;

class GoogleApiService
{
    public function checkReceipt(string $receipt): array
    {
        $status = false;
        $lastCharacter = substr($receipt, -1);
        $lastTwoCharacter = substr($receipt, -2);

        if (is_numeric($lastTwoCharacter) && $lastTwoCharacter % 6 == 0) {
            $message = 'Rate limit error';
            $statusCode = 422;
        } elseif (is_numeric($lastCharacter) && $lastCharacter % 2 == 1) {
            $status = true;
            $purchaseStatus = PurchaseStatus::PENDING;
            $expireDate = now()->addDay();
        } else {
            $message = 'Something went wrong';
            $statusCode = 404;
        }

        return [
            'status' => $status,
            'statusCode' => $statusCode ?? null,
            'purchaseStatus' => $purchaseStatus->value ?? null,
            'message' => $message ?? null,
            'expireDate' => $expireDate ?? null
        ];

    }
}
