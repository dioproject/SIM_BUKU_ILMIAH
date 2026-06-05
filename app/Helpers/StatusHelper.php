<?php

namespace App\Helpers;

use App\Models\Status;

class StatusHelper
{
    /**
     * Get all status options with their labels
     */
    public static function getAllStatuses(): array
    {
        return [
            Status::DRAFT => 'Draft',
            Status::TERSEDIA => 'Tersedia',
            Status::DITUGASKAN => 'Ditugaskan',
            Status::DIKIRIM_AUTHOR => 'Dikirim Author',
            Status::DALAM_REVIEW => 'Dalam Review',
            Status::REVISI => 'Revisi',
            Status::DIREVISI => 'Direvisi',
            Status::DISETUJUI => 'Disetujui',
            Status::FINALISASI => 'Finalisasi',
            Status::TERBIT => 'Terbit',
        ];
    }

    /**
     * Get status label by ID
     */
    public static function getStatusLabel(int $statusId): string
    {
        $statuses = self::getAllStatuses();
        return $statuses[$statusId] ?? 'Unknown';
    }

    /**
     * Get valid transitions for a given status
     */
    public static function getValidTransitions(int $statusId): array
    {
        $transitions = [
            Status::DRAFT => [Status::TERSEDIA],
            Status::TERSEDIA => [Status::DITUGASKAN],
            Status::DITUGASKAN => [Status::DIKIRIM_AUTHOR],
            Status::DIKIRIM_AUTHOR => [Status::DALAM_REVIEW],
            Status::DALAM_REVIEW => [Status::REVISI, Status::DISETUJUI],
            Status::REVISI => [Status::DIREVISI],
            Status::DIREVISI => [Status::DALAM_REVIEW],
            Status::DISETUJUI => [Status::FINALISASI],
            Status::FINALISASI => [Status::TERBIT],
            Status::TERBIT => [],
        ];

        return $transitions[$statusId] ?? [];
    }

    /**
     * Check if a status transition is valid
     */
    public static function isValidTransition(int $fromStatus, int $toStatus): bool
    {
        $validTransitions = self::getValidTransitions($fromStatus);
        return in_array($toStatus, $validTransitions);
    }

    /**
     * Get badge class for status
     */
    public static function getStatusBadgeClass(int $statusId): string
    {
        $badgeClasses = [
            Status::DRAFT => 'badge-secondary',
            Status::TERSEDIA => 'badge-primary',
            Status::DITUGASKAN => 'badge-info',
            Status::DIKIRIM_AUTHOR => 'badge-info',
            Status::DALAM_REVIEW => 'badge-warning',
            Status::REVISI => 'badge-danger',
            Status::DIREVISI => 'badge-warning',
            Status::DISETUJUI => 'badge-success',
            Status::FINALISASI => 'badge-primary',
            Status::TERBIT => 'badge-success',
        ];

        return $badgeClasses[$statusId] ?? 'badge-secondary';
    }

    /**
     * Get editorial statuses (for chapter workflow)
     */
    public static function getEditorialStatuses(): array
    {
        return [
            Status::DRAFT,
            Status::TERSEDIA,
            Status::DITUGASKAN,
            Status::DIKIRIM_AUTHOR,
            Status::DALAM_REVIEW,
            Status::REVISI,
            Status::DIREVISI,
            Status::DISETUJUI,
        ];
    }

    /**
     * Check if chapter can be assigned
     */
    public static function canBeAssigned(int $statusId): bool
    {
        return in_array($statusId, [Status::DRAFT, Status::TERSEDIA]);
    }

    /**
     * Check if chapter can be uploaded by author
     */
    public static function canBeUploadedByAuthor(int $statusId): bool
    {
        return in_array($statusId, [Status::DITUGASKAN, Status::REVISI]);
    }

    /**
     * Check if chapter can be reviewed
     */
    public static function canBeReviewed(int $statusId): bool
    {
        return in_array($statusId, [Status::DIKIRIM_AUTHOR, Status::DALAM_REVIEW, Status::DIREVISI]);
    }

    /**
     * Check if chapter can be approved
     */
    public static function canBeApproved(int $statusId): bool
    {
        return in_array($statusId, [Status::DALAM_REVIEW, Status::DIREVISI]);
    }

    /**
     * Check if chapter can be marked for revision
     */
    public static function canBeMarkedForRevision(int $statusId): bool
    {
        return in_array($statusId, [Status::DALAM_REVIEW, Status::DIREVISI]);
    }

    /**
     * Check if book can be merged/finalized
     */
    public static function canBeMerged(array $chapterStatuses): bool
    {
        $requiredStatuses = self::getEditorialStatuses();
        foreach ($chapterStatuses as $statusId) {
            if (!in_array($statusId, [Status::DISETUJUI])) {
                return false;
            }
        }
        return true;
    }
}