<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicInfoPagesTest extends TestCase
{
    public function test_venue_page_is_public_and_linked_in_navigation(): void
    {
        $this->get(route('venue'))
            ->assertOk()
            ->assertSee('Higher School of Technology of Casablanca (ESTC)')
            ->assertSee('17–18 December 2026')
            ->assertSee('VENUE');
    }

    public function test_contact_page_is_public_and_has_a_working_email_link(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('mailto:prisme26@prisme.org')
            ->assertSee(route('venue'))
            ->assertSee('CONTACT');
    }

    public function test_call_for_papers_uses_the_same_thematic_areas_as_the_home_page(): void
    {
        $themes = [
            'Thematic Areas',
            'Transitions and Organizational Resilience',
            'Managing Transitions: Performance and Management Control',
            'Digital Transformation and Artificial Intelligence',
            'Human Capital and Social Change',
            'Territorial Resilience and Local Development',
            'New Value and Business Models',
            'Governance, CSR, and Ethics',
            'Morocco and Africa Facing Transitions',
        ];

        $homeResponse = $this->get(route('home'))->assertOk();
        $callForPapersResponse = $this->get(route('call-for-papers'))
            ->assertOk()
            ->assertDontSee('Symposium Tracks')
            ->assertDontSee('Track 1:');

        foreach ($themes as $theme) {
            $homeResponse->assertSee($theme);
            $callForPapersResponse->assertSee($theme);
        }
    }
}
