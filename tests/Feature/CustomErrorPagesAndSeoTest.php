<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Webinar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomErrorPagesAndSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_404_error_page_renders_with_custom_branding_and_search(): void
    {
        $response = $this->get('/non-existent-institutional-path-'.uniqid());

        $response->assertStatus(404);
        $response->assertSee('Academic Record or Page Not Found');
        $response->assertSee('Search short courses, webinars, or research...');
        $response->assertSee('Return Home');
    }

    public function test_403_error_view_renders_institutional_clearance_message(): void
    {
        $view = $this->view('errors.403');

        $view->assertSee('Institutional Clearance Required');
        $view->assertSee('Access Restricted');
        $view->assertSee('Sign In to Account');
    }

    public function test_419_error_view_renders_security_token_expired(): void
    {
        $view = $this->view('errors.419');

        $view->assertSee('Your Portal Session Has Expired');
        $view->assertSee('Security Token Expired');
        $view->assertSee('Refresh and Reload');
    }

    public function test_500_error_view_renders_system_interruption_and_support_contact(): void
    {
        $view = $this->view('errors.500');

        $view->assertSee('Temporary System Interruption');
        $view->assertSee('thebrandsacademy@gmail.com');
        $view->assertSee('Retry Request');
    }

    public function test_public_pages_include_canonical_and_json_ld_schema(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('<link rel="canonical"', false);
        $response->assertSee('"@type": "EducationalOrganization"', false);
        $response->assertSee('Brands Academy Nigeria Foundation');
    }

    public function test_course_show_page_includes_dynamic_meta_and_article_og_type(): void
    {
        $course = Course::create([
            'title' => 'Advanced Strategic Brand Valuation',
            'slug' => 'advanced-strategic-brand-valuation',
            'track' => 'Strategy',
            'code' => 'SBV-901',
            'level' => 'executive',
            'delivery_mode' => 'self_paced',
            'duration_weeks' => 4,
            'estimated_hours' => 20,
            'regular_price' => 75000,
            'member_price' => 56250,
            'short_description' => 'Comprehensive financial and perceptual brand valuation models for executive practitioners.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('courses.show', $course->slug));

        $response->assertOk();
        $response->assertSee('<meta property="og:type" content="article">', false);
        $response->assertSee('Comprehensive financial and perceptual brand valuation models', false);
    }

    public function test_webinar_show_page_includes_dynamic_meta(): void
    {
        $webinar = Webinar::create([
            'title' => 'Pan-African Brand Governance Masterclass',
            'slug' => 'pan-african-brand-governance',
            'speaker_name' => 'Prof. O. Adebayo',
            'speaker_title' => 'Fellow of Brands Academy',
            'starts_at' => now()->addDays(7),
            'duration_minutes' => 90,
            'summary' => 'Exploring cross-border trademark protection and brand licensing in emerging markets.',
            'fee_type' => 'free',
            'regular_price' => 0,
            'status' => 'published',
        ]);

        $response = $this->get(route('webinars.show', $webinar->slug));

        $response->assertOk();
        $response->assertSee('<meta property="og:type" content="article">', false);
        $response->assertSee('Exploring cross-border trademark protection', false);
    }
}
