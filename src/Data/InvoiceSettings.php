<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class InvoiceSettings
{
    use MapsAttributes;

    public function __construct(
        public ?string $path = null,
        public ?int $nextInvoiceNumber = null,
        public ?int $nextCreditNoteNumber = null,
        public ?bool $separateInvoiceCreditNoteNumbering = null,
        public ?string $salesInvoiceNumberPrefix = null,
        public ?string $salesCreditNoteNumberPrefix = null,
        public ?string $invoiceTermsAndConditions = null,
        public ?string $defaultNoteOnInvoice = null,
        public ?string $defaultNoteOnCreditNote = null,
        public ?string $defaultNoteOnEstimate = null,
        public ?string $defaultNoteOnQuote = null,
        public ?int $nextQuoteNumber = null,
        public ?string $quoteNumberPrefix = null,
        public ?string $estimateNumberPrefix = null,
        public ?int $quoteDefaultDaysToExpiry = null,
        public ?int $estimateDefaultDaysToExpiry = null,
        public ?string $quoteTermsAndConditions = null,
        public ?string $estimateTermsAndConditions = null,
        public ?string $deliveryNoteTermsAndConditions = null,
        public ?bool $deliveryNoteShowSignature = null,
        public ?bool $deliveryNoteShowPicked = null,
        public ?bool $deliveryNoteShowNotes = null,
        public ?bool $deliveryNoteShowContactDetails = null,
        public ?string $quickEntryPrefix = null,
        public ?float $latePaymentPercentage = null,
        public ?float $promptPaymentPercentage = null,
        public ?bool $showAutoEntrepreneur = null,
        public ?bool $showInsurance = null,
        public ?Contact $insurer = null,
        public ?string $insuranceArea = null,
        public ?string $insuranceType = null,
        public ?string $insuranceText = null,
        public ?Reference $paymentBankAccount = null,
        public ?string $salesCorrectiveInvoiceNumberPrefix = null,
        public ?int $nextSalesCorrectiveInvoiceNumber = null,
        public ?InvoiceSettingsDocumentHeadings $documentHeadings = null,
        public ?InvoiceSettingsLineItemTitles $lineItemTitles = null,
        public ?FooterDetails $footerDetails = null,
        public ?PrintContactDetails $printContactDetails = null,
        public ?PrintStatements $printStatements = null,
        public ?int $customerCreditDays = null,
        public ?int $vendorCreditDays = null,
        public ?string $customerCreditTerms = null,
        public ?string $vendorCreditTerms = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            path: self::string($data, '$path'),
            nextInvoiceNumber: self::integer($data, 'next_invoice_number'),
            nextCreditNoteNumber: self::integer($data, 'next_credit_note_number'),
            separateInvoiceCreditNoteNumbering: self::boolean($data, 'separate_invoice_credit_note_numbering'),
            salesInvoiceNumberPrefix: self::string($data, 'sales_invoice_number_prefix'),
            salesCreditNoteNumberPrefix: self::string($data, 'sales_credit_note_number_prefix'),
            invoiceTermsAndConditions: self::string($data, 'invoice_terms_and_conditions'),
            defaultNoteOnInvoice: self::string($data, 'default_note_on_invoice'),
            defaultNoteOnCreditNote: self::string($data, 'default_note_on_credit_note'),
            defaultNoteOnEstimate: self::string($data, 'default_note_on_estimate'),
            defaultNoteOnQuote: self::string($data, 'default_note_on_quote'),
            nextQuoteNumber: self::integer($data, 'next_quote_number'),
            quoteNumberPrefix: self::string($data, 'quote_number_prefix'),
            estimateNumberPrefix: self::string($data, 'estimate_number_prefix'),
            quoteDefaultDaysToExpiry: self::integer($data, 'quote_default_days_to_expiry'),
            estimateDefaultDaysToExpiry: self::integer($data, 'estimate_default_days_to_expiry'),
            quoteTermsAndConditions: self::string($data, 'quote_terms_and_conditions'),
            estimateTermsAndConditions: self::string($data, 'estimate_terms_and_conditions'),
            deliveryNoteTermsAndConditions: self::string($data, 'delivery_note_terms_and_conditions'),
            deliveryNoteShowSignature: self::boolean($data, 'delivery_note_show_signature'),
            deliveryNoteShowPicked: self::boolean($data, 'delivery_note_show_picked'),
            deliveryNoteShowNotes: self::boolean($data, 'delivery_note_show_notes'),
            deliveryNoteShowContactDetails: self::boolean($data, 'delivery_note_show_contact_details'),
            quickEntryPrefix: self::string($data, 'quick_entry_prefix'),
            latePaymentPercentage: self::float($data, 'late_payment_percentage'),
            promptPaymentPercentage: self::float($data, 'prompt_payment_percentage'),
            showAutoEntrepreneur: self::boolean($data, 'show_auto_entrepreneur'),
            showInsurance: self::boolean($data, 'show_insurance'),
            insurer: Contact::fromNullable(self::nested($data, 'insurer')),
            insuranceArea: self::string($data, 'insurance_area'),
            insuranceType: self::string($data, 'insurance_type'),
            insuranceText: self::string($data, 'insurance_text'),
            paymentBankAccount: Reference::fromNullable(self::nested($data, 'payment_bank_account')),
            salesCorrectiveInvoiceNumberPrefix: self::string($data, 'sales_corrective_invoice_number_prefix'),
            nextSalesCorrectiveInvoiceNumber: self::integer($data, 'next_sales_corrective_invoice_number'),
            documentHeadings: InvoiceSettingsDocumentHeadings::fromNullable(self::nested($data, 'document_headings')),
            lineItemTitles: InvoiceSettingsLineItemTitles::fromNullable(self::nested($data, 'line_item_titles')),
            footerDetails: FooterDetails::fromNullable(self::nested($data, 'footer_details')),
            printContactDetails: PrintContactDetails::fromNullable(self::nested($data, 'print_contact_details')),
            printStatements: PrintStatements::fromNullable(self::nested($data, 'print_statements')),
            customerCreditDays: self::integer($data, 'customer_credit_days'),
            vendorCreditDays: self::integer($data, 'vendor_credit_days'),
            customerCreditTerms: self::string($data, 'customer_credit_terms'),
            vendorCreditTerms: self::string($data, 'vendor_credit_terms'),
            updatedAt: self::dateTime($data, 'updated_at'),
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
