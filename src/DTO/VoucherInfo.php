<?php

namespace Afea\UblTr\DTO;

class VoucherInfo
{
    public string $uuid;
    public string $id;
    public string $voucherSerieOrNumber;
    public string $issueDate;
    public ?string $issueTime = null;
    public string $documentCurrencyCode = 'TRY';
    public ?string $profileId = null;
    public ?string $customizationId = null;
    public ?string $ublVersionId = null;
    public ?bool $copyIndicator = null;
    public ?string $creditNoteTypeCode = null;
    public ?array $notes = null;
    public ?string $additionalDocumentReferenceId = null;
    public ?string $additionalDocumentReferenceIssueDate = null;
    public ?string $additionalDocumentReferenceDocumentTypeCode = null;
}
