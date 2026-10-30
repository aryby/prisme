<?php

namespace Database\Seeders;

use App\Models\Paper;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Symposium Admin',
            'email' => 'admin@siprisme.test',
            'role' => 'admin',
            'status' => 'active',
            'is_active' => true,
        ]);

        $authors = User::factory()->count(5)->create([
            'role' => 'author',
            'status' => 'active',
            'is_active' => true,
        ]);

        $papers = [
            ['title' => 'AI Governance for Smart Cities', 'status' => 'accepted', 'track' => 'AI & Data Science'],
            ['title' => 'Blockchain in Digital Supply Chains', 'status' => 'under_review', 'track' => 'Digital Innovation'],
            ['title' => 'Predictive Analytics for Smart Business', 'status' => 'accepted', 'track' => 'Smart Business'],
            ['title' => 'Secure Digital Economy Platforms', 'status' => 'rejected', 'track' => 'Cybersecurity'],
            ['title' => 'Data-Driven Decision Models', 'status' => 'under_review', 'track' => 'Decision Systems'],
        ];

        foreach ($papers as $index => $paperData) {
            $paper = Paper::create([
                'author_id' => $authors[$index % count($authors)]->id,
                'title' => $paperData['title'],
                'abstract' => 'This paper explores the role of modern digital systems in improving strategic decision-making and operational efficiency.',
                'keywords' => 'digital economy, analytics, innovation',
                'track' => $paperData['track'],
                'submission_option' => 'full_submission',
                'affiliation' => 'Research Center',
                'country' => 'Morocco',
                'phone' => '+212600000000',
                'file_path' => 'papers/sample.pdf',
                'status' => $paperData['status'],
                'submitted_at' => now()->subDays(rand(1, 30)),
            ]);

            Review::create([
                'paper_id' => $paper->id,
                'reviewer_id' => $admin->id,
                'status' => $paperData['status'] === 'rejected' ? 'completed' : 'pending',
                'score' => $paperData['status'] === 'accepted' ? 88 : 75,
                'comments' => 'Strong contribution and promising outcomes.',
            ]);
        }
    }
}
