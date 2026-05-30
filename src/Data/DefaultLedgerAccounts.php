<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;

final readonly class DefaultLedgerAccounts
{
    use MapsAttributes;

    public function __construct(
        public ?Reference $bankChargesLedgerAccount = null,
        public ?Reference $bankInterestReceivedLedgerAccount = null,
        public ?Reference $bankInterestChargesPaidLedgerAccount = null,
        public ?Reference $exchangeRateGainsLedgerAccount = null,
        public ?Reference $exchangeRateLossesLedgerAccount = null,
        public ?Reference $salesLedgerAccount = null,
        public ?Reference $salesDiscountLedgerAccount = null,
        public ?Reference $purchaseLedgerAccount = null,
        public ?Reference $purchaseDiscountLedgerAccount = null,
        public ?Reference $productSalesLedgerAccount = null,
        public ?Reference $productPurchaseLedgerAccount = null,
        public ?Reference $serviceSalesLedgerAccount = null,
        public ?Reference $servicePurchaseLedgerAccount = null,
        public ?Reference $stockPurchaseLedgerAccount = null,
        public ?Reference $otherReceiptLedgerAccount = null,
        public ?Reference $otherPaymentLedgerAccount = null,
        public ?Reference $customerReceiptDiscountLedgerAccount = null,
        public ?Reference $vendorPaymentDiscountLedgerAccount = null,
        public ?Reference $carriageLedgerAccount = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            bankChargesLedgerAccount: Reference::fromNullable(self::nested($data, 'bank_charges_ledger_account')),
            bankInterestReceivedLedgerAccount: Reference::fromNullable(self::nested($data, 'bank_interest_received_ledger_account')),
            bankInterestChargesPaidLedgerAccount: Reference::fromNullable(self::nested($data, 'bank_interest_charges_paid_ledger_account')),
            exchangeRateGainsLedgerAccount: Reference::fromNullable(self::nested($data, 'exchange_rate_gains_ledger_account')),
            exchangeRateLossesLedgerAccount: Reference::fromNullable(self::nested($data, 'exchange_rate_losses_ledger_account')),
            salesLedgerAccount: Reference::fromNullable(self::nested($data, 'sales_ledger_account')),
            salesDiscountLedgerAccount: Reference::fromNullable(self::nested($data, 'sales_discount_ledger_account')),
            purchaseLedgerAccount: Reference::fromNullable(self::nested($data, 'purchase_ledger_account')),
            purchaseDiscountLedgerAccount: Reference::fromNullable(self::nested($data, 'purchase_discount_ledger_account')),
            productSalesLedgerAccount: Reference::fromNullable(self::nested($data, 'product_sales_ledger_account')),
            productPurchaseLedgerAccount: Reference::fromNullable(self::nested($data, 'product_purchase_ledger_account')),
            serviceSalesLedgerAccount: Reference::fromNullable(self::nested($data, 'service_sales_ledger_account')),
            servicePurchaseLedgerAccount: Reference::fromNullable(self::nested($data, 'service_purchase_ledger_account')),
            stockPurchaseLedgerAccount: Reference::fromNullable(self::nested($data, 'stock_purchase_ledger_account')),
            otherReceiptLedgerAccount: Reference::fromNullable(self::nested($data, 'other_receipt_ledger_account')),
            otherPaymentLedgerAccount: Reference::fromNullable(self::nested($data, 'other_payment_ledger_account')),
            customerReceiptDiscountLedgerAccount: Reference::fromNullable(self::nested($data, 'customer_receipt_discount_ledger_account')),
            vendorPaymentDiscountLedgerAccount: Reference::fromNullable(self::nested($data, 'vendor_payment_discount_ledger_account')),
            carriageLedgerAccount: Reference::fromNullable(self::nested($data, 'carriage_ledger_account')),
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
