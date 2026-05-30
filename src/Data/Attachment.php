<?php

declare(strict_types=1);

namespace ChrisJohnLeah\SageAccounting\Data;

use ChrisJohnLeah\SageAccounting\Data\Concerns\MapsAttributes;
use DateTimeImmutable;

final readonly class Attachment
{
    use MapsAttributes;

    public function __construct(
        public ?string $id = null,
        public ?string $displayedAs = null,
        public ?string $path = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?string $file = null,
        public ?string $mimeType = null,
        public ?string $description = null,
        public ?string $fileExtension = null,
        public ?Reference $transaction = null,
        public ?int $fileSize = null,
        public ?string $fileName = null,
        public ?string $filePath = null,
        public ?Reference $attachmentContextType = null,
        public ?Reference $attachmentContext = null,
        public ?bool $isPublic = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: self::string($data, 'id'),
            displayedAs: self::string($data, 'displayed_as'),
            path: self::string($data, '$path'),
            deletedAt: self::dateTime($data, 'deleted_at'),
            file: self::string($data, 'file'),
            mimeType: self::string($data, 'mime_type'),
            description: self::string($data, 'description'),
            fileExtension: self::string($data, 'file_extension'),
            transaction: Reference::fromNullable(self::nested($data, 'transaction')),
            fileSize: self::integer($data, 'file_size'),
            fileName: self::string($data, 'file_name'),
            filePath: self::string($data, '$file_path'),
            attachmentContextType: Reference::fromNullable(self::nested($data, 'attachment_context_type')),
            attachmentContext: Reference::fromNullable(self::nested($data, 'attachment_context')),
            isPublic: self::boolean($data, 'is_public'),
            createdAt: self::dateTime($data, 'created_at'),
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
