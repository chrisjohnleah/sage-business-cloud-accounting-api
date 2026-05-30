<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class postHostedArtefactPaymentSettings
{
    use MapsAttributes;

    /**
     * @param  array<string, mixed>|null  $hostedArtefactPaymentSetting
     */
    public function __construct(
        public ?array $hostedArtefactPaymentSetting = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            hostedArtefactPaymentSetting: self::nested($data, 'hosted_artefact_payment_setting'),
        );
    }

    /**
     * @param  array<string, mixed>|null  $data
     */
    public static function fromNullable(?array $data): ?self
    {
        return $data === null ? null : self::fromArray($data);
    }
}
