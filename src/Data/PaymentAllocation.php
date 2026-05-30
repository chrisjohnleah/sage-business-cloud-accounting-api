<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class PaymentAllocation
{
    use MapsAttributes;

    /**
     * @param  list<Link>  $links
     */
    public function __construct(
        public array $links = [],
        public ?DateTimeImmutable $date = null,
        public ?string $type = null,
        public ?string $reference = null,
        public ?float $amount = null,
        public ?float $discount = null,
        public ?string $stripeTransactionId = null,
        public ?ContactAllocation $contactAllocation = null,
        public ?Generic $artefact = null,
        public ?ContactPayment $contactPayment = null,
        public ?string $displayedAs = null,
        public ?bool $negativePayment = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            links: array_map(static fn (array $item): Link => Link::fromArray($item), self::nestedList($data, 'links')),
            date: self::dateTime($data, 'date'),
            type: self::string($data, 'type'),
            reference: self::string($data, 'reference'),
            amount: self::float($data, 'amount'),
            discount: self::float($data, 'discount'),
            stripeTransactionId: self::string($data, 'stripe_transaction_id'),
            contactAllocation: ContactAllocation::fromNullable(self::nested($data, 'contact_allocation')),
            artefact: Generic::fromNullable(self::nested($data, 'artefact')),
            contactPayment: ContactPayment::fromNullable(self::nested($data, 'contact_payment')),
            displayedAs: self::string($data, 'displayed_as'),
            negativePayment: self::boolean($data, 'negative_payment'),
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
