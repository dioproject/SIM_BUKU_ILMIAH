<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Status;
use App\Helpers\StatusHelper;

class StatusTransitionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_draft_can_transition_to_tersedia()
    {
        Status::factory()->create(['id' => Status::DRAFT]);
        Status::factory()->create(['id' => Status::TERSEDIA]);

        $this->assertTrue(StatusHelper::isValidTransition(Status::DRAFT, Status::TERSEDIA));
    }

    public function test_draft_cannot_transition_directly_to_disetujui()
    {
        Status::factory()->create(['id' => Status::DRAFT]);
        Status::factory()->create(['id' => Status::DISETUJUI]);

        $this->assertFalse(StatusHelper::isValidTransition(Status::DRAFT, Status::DISETUJUI));
    }

    public function test_ditugaskan_can_transition_to_dikirim_author()
    {
        Status::factory()->create(['id' => Status::DITUGASKAN]);
        Status::factory()->create(['id' => Status::DIKIRIM_AUTHOR]);

        $this->assertTrue(StatusHelper::isValidTransition(Status::DITUGASKAN, Status::DIKIRIM_AUTHOR));
    }

    public function test_dikirim_author_can_transition_to_dalam_review()
    {
        Status::factory()->create(['id' => Status::DIKIRIM_AUTHOR]);
        Status::factory()->create(['id' => Status::DALAM_REVIEW]);

        $this->assertTrue(StatusHelper::isValidTransition(Status::DIKIRIM_AUTHOR, Status::DALAM_REVIEW));
    }

    public function test_dalam_review_can_approve_or_revisi()
    {
        Status::factory()->create(['id' => Status::DALAM_REVIEW]);
        Status::factory()->create(['id' => Status::DISETUJUI]);
        Status::factory()->create(['id' => Status::REVISI]);

        $this->assertTrue(StatusHelper::isValidTransition(Status::DALAM_REVIEW, Status::DISETUJUI));
        $this->assertTrue(StatusHelper::isValidTransition(Status::DALAM_REVIEW, Status::REVISI));
    }

    public function test_revisi_can_transition_to_direvisi()
    {
        Status::factory()->create(['id' => Status::REVISI]);
        Status::factory()->create(['id' => Status::DIREVISI]);

        $this->assertTrue(StatusHelper::isValidTransition(Status::REVISI, Status::DIREVISI));
    }

    public function test_direvisi_can_transition_back_to_dalam_review()
    {
        Status::factory()->create(['id' => Status::DIREVISI]);
        Status::factory()->create(['id' => Status::DALAM_REVIEW]);

        $this->assertTrue(StatusHelper::isValidTransition(Status::DIREVISI, Status::DALAM_REVIEW));
    }

    public function test_disetujui_can_transition_to_finalisasi()
    {
        Status::factory()->create(['id' => Status::DISETUJUI]);
        Status::factory()->create(['id' => Status::FINALISASI]);

        $this->assertTrue(StatusHelper::isValidTransition(Status::DISETUJUI, Status::FINALISASI));
    }

    public function test_disetujui_cannot_go_back_to_revisi()
    {
        Status::factory()->create(['id' => Status::DISETUJUI]);
        Status::factory()->create(['id' => Status::REVISI]);

        $this->assertFalse(StatusHelper::isValidTransition(Status::DISETUJUI, Status::REVISI));
    }

    public function test_terbit_is_final_no_transitions()
    {
        Status::factory()->create(['id' => Status::TERBIT]);

        $this->assertEmpty(StatusHelper::getValidTransitions(Status::TERBIT));
    }

    public function test_can_be_uploaded_by_author_allows_ditugaskan_and_revisi()
    {
        $this->assertTrue(StatusHelper::canBeUploadedByAuthor(Status::DITUGASKAN));
        $this->assertTrue(StatusHelper::canBeUploadedByAuthor(Status::REVISI));
        $this->assertFalse(StatusHelper::canBeUploadedByAuthor(Status::DRAFT));
        $this->assertFalse(StatusHelper::canBeUploadedByAuthor(Status::DISETUJUI));
    }

    public function test_can_be_approved_allows_dalam_review_and_direvisi()
    {
        $this->assertTrue(StatusHelper::canBeApproved(Status::DALAM_REVIEW));
        $this->assertTrue(StatusHelper::canBeApproved(Status::DIREVISI));
        $this->assertFalse(StatusHelper::canBeApproved(Status::DITUGASKAN));
        $this->assertFalse(StatusHelper::canBeApproved(Status::DISETUJUI));
    }

    public function test_can_be_assigned_allows_draft_and_tersedia()
    {
        $this->assertTrue(StatusHelper::canBeAssigned(Status::DRAFT));
        $this->assertTrue(StatusHelper::canBeAssigned(Status::TERSEDIA));
        $this->assertFalse(StatusHelper::canBeAssigned(Status::DITUGASKAN));
    }

    public function test_can_be_merged_returns_true_only_when_all_disetujui()
    {
        $this->assertTrue(StatusHelper::canBeMerged([Status::DISETUJUI, Status::DISETUJUI]));
        $this->assertFalse(StatusHelper::canBeMerged([Status::DISETUJUI, Status::DITUGASKAN]));
        $this->assertFalse(StatusHelper::canBeMerged([Status::DITUGASKAN, Status::DALAM_REVIEW]));
    }
}
