<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LiteracyContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

//        $contents = [
//            // ==========================================
//            // CATEGORY: ANTI-BULLYING
//            // ==========================================
//            [
//                'type' => 'video',
//                'category' => 'anti-bullying',
//                'title' => 'How to Stop A Bully',
//                'content' => 'Educator Brooks Gibbs explains a simple psychological approach to conflict resolution and stopping bullying behavior.',
//                'url' => 'https://www.youtube.com/watch?v=7oKjW1OIjuw',
//                'thumbnail' => 'https://i.ytimg.com/vi/7oKjW1OIjuw/hqdefault.jpg',
//                'platform' => 'youtube',
//                'platform_id' => '7oKjW1OIjuw',
//                'created_at' => $now,
//                'updated_at' => $now,
//            ],
//            [
//                'type' => 'video',
//                'category' => 'anti-bullying',
//                'title' => 'Stand Up Against Cyberbullying',
//                'content' => 'Short-form educational campaign on how to use reporting tools and block malicious users on social media.',
//                'url' => 'https://www.tiktok.com/@tiktokcreators/video/7010487082989931782',
//                'thumbnail' => 'https://placehold.co/600x800/black/white?text=TikTok+AntiBullying',
//                'platform' => 'tiktok',
//                'platform_id' => '7010487082989931782',
//                'created_at' => $now->copy()->subDays(1),
//                'updated_at' => $now->copy()->subDays(1),
//            ],
//            [
//                'type' => 'article', // Changed from 'image' to 'article' to pass DB constraint
//                'category' => 'anti-bullying',
//                'title' => 'Words Matter: Preventing Bullying in Schools',
//                'content' => 'An infographic detailing how bystander intervention can reduce bullying incidents by up to 50%.',
//                'url' => 'https://www.instagram.com/p/C_1B9pXN_B2/',
//                'thumbnail' => 'https://placehold.co/800x800/c13584/white?text=IG+AntiBullying',
//                'platform' => 'instagram',
//                'platform_id' => 'C_1B9pXN_B2',
//                'created_at' => $now->copy()->subDays(2),
//                'updated_at' => $now->copy()->subDays(2),
//            ],
//
//            // ==========================================
//            // CATEGORY: DIGITAL LITERACY
//            // ==========================================
//            [
//                'type' => 'video',
//                'category' => 'digital-literacy',
//                'title' => 'Navigating Digital Information',
//                'content' => 'CrashCourse series teaching students how to fact-check, read laterally, and evaluate online sources.',
//                'url' => 'https://www.youtube.com/watch?v=pLlv282qKEE',
//                'thumbnail' => 'https://i.ytimg.com/vi/pLlv282qKEE/hqdefault.jpg',
//                'platform' => 'youtube',
//                'platform_id' => 'pLlv282qKEE',
//                'created_at' => $now->copy()->subDays(3),
//                'updated_at' => $now->copy()->subDays(3),
//            ],
//            [
//                'type' => 'video',
//                'category' => 'digital-literacy',
//                'title' => 'Spotting Fake News & Misinformation',
//                'content' => 'Quick tips from educators on how to spot AI-generated images and verify news headlines before sharing.',
//                'url' => 'https://www.tiktok.com/@tiktok/video/7093412534591458566',
//                'thumbnail' => 'https://placehold.co/600x800/black/white?text=TikTok+Digital+Literacy',
//                'platform' => 'tiktok',
//                'platform_id' => '7093412534591458566',
//                'created_at' => $now->copy()->subDays(4),
//                'updated_at' => $now->copy()->subDays(4),
//            ],
//            [
//                'type' => 'article',
//                'category' => 'digital-literacy',
//                'title' => 'Teaching Digital Citizenship in Modern Classrooms',
//                'content' => 'A comprehensive guide on why digital citizenship is a crucial 21st-century skill for students navigating the internet.',
//                'url' => 'https://medium.com/@education/the-importance-of-digital-citizenship-a39c812d8',
//                'thumbnail' => 'https://placehold.co/800x400/10b981/white?text=Medium+Digital+Citizenship',
//                'platform' => 'medium',
//                'platform_id' => 'a39c812d8',
//                'created_at' => $now->copy()->subDays(5),
//                'updated_at' => $now->copy()->subDays(5),
//            ],
//
//            // ==========================================
//            // CATEGORY: MENTAL HEALTH
//            // ==========================================
//            [
//                'type' => 'article',
//                'category' => 'mental-health',
//                'title' => 'How Social Media Impacts Mental Health: What You Need to Know',
//                'content' => 'A deep dive into social comparison, FOMO (Fear Of Missing Out), and strategies to manage social media anxiety.',
//                'url' => 'https://sampreetiatta.medium.com/how-social-media-impacts-mental-health-what-you-need-to-know-dcda34a6391b',
//                'thumbnail' => 'https://placehold.co/800x400/10b981/white?text=Medium+Mental+Health',
//                'platform' => 'medium',
//                'platform_id' => 'dcda34a6391b',
//                'created_at' => $now->copy()->subDays(6),
//                'updated_at' => $now->copy()->subDays(6),
//            ],
//            [
//                'type' => 'video',
//                'category' => 'mental-health',
//                'title' => 'The Impact of Social Media on Teen Mental Health',
//                'content' => 'A discussion on how algorithmic feeds affect adolescent brain development and well-being.',
//                'url' => 'https://www.youtube.com/watch?v=CZuQ_EHQHro',
//                'thumbnail' => 'https://i.ytimg.com/vi/CZuQ_EHQHro/hqdefault.jpg',
//                'platform' => 'youtube',
//                'platform_id' => 'CZuQ_EHQHro',
//                'created_at' => $now->copy()->subDays(7),
//                'updated_at' => $now->copy()->subDays(7),
//            ],
//            [
//                'type' => 'article', // Changed from 'image' to 'article' to pass DB constraint
//                'category' => 'mental-health',
//                'title' => '5 Ways to Protect Your Peace Online',
//                'content' => 'Actionable carousel post showing how to curate feeds, use screen-time limits, and mute triggering content.',
//                'url' => 'https://www.instagram.com/p/CyQK-k8R_0q/',
//                'thumbnail' => 'https://placehold.co/800x800/405de6/white?text=IG+Mental+Health',
//                'platform' => 'instagram',
//                'platform_id' => 'CyQK-k8R_0q',
//                'created_at' => $now->copy()->subDays(8),
//                'updated_at' => $now->copy()->subDays(8),
//            ],
//
//            // ==========================================
//            // CATEGORY: SCHOOL SAFETY
//            // ==========================================
//            [
//                'type' => 'video',
//                'category' => 'school-safety',
//                'title' => 'School Safety: Everyone Plays a Part!',
//                'content' => 'An awareness video from the Department of Public Safety highlighting how students and staff can collaborate to keep schools secure.',
//                'url' => 'https://www.youtube.com/watch?v=aLGIC0A-f0o',
//                'thumbnail' => 'https://i.ytimg.com/vi/aLGIC0A-f0o/hqdefault.jpg',
//                'platform' => 'youtube',
//                'platform_id' => 'aLGIC0A-f0o',
//                'created_at' => $now->copy()->subDays(9),
//                'updated_at' => $now->copy()->subDays(9),
//            ],
//            [
//                'type' => 'video',
//                'category' => 'school-safety',
//                'title' => 'Comprehensive School Safety Framework',
//                'content' => 'Overview of the global safety framework designed to protect students from physical hazards and promote safe learning environments.',
//                'url' => 'https://www.youtube.com/watch?v=pUQR_autlJ8',
//                'thumbnail' => 'https://i.ytimg.com/vi/pUQR_autlJ8/hqdefault.jpg',
//                'platform' => 'youtube',
//                'platform_id' => 'pUQR_autlJ8',
//                'created_at' => $now->copy()->subDays(10),
//                'updated_at' => $now->copy()->subDays(10),
//            ],
//            [
//                'type' => 'article',
//                'category' => 'school-safety',
//                'title' => 'Redesigning School Safety Strategies',
//                'content' => 'An article discussing modern approaches to school safety, emphasizing mental health support over purely punitive security measures.',
//                'url' => 'https://medium.com/education-now/redesigning-school-safety-strategies-b715a11c8',
//                'thumbnail' => 'https://placehold.co/800x400/10b981/white?text=Medium+School+Safety',
//                'platform' => 'medium',
//                'platform_id' => 'b715a11c8',
//                'created_at' => $now->copy()->subDays(11),
//                'updated_at' => $now->copy()->subDays(11),
//            ],
//        ];

        $contents = [
            // ==========================================
            // CATEGORY: ANTI-BULLYING
            // ==========================================
            [
                'type' => 'video',
                'category' => 'anti-bullying',
                'title' => 'Cyberbullying: What is it and How to Stop it',
                'content' => 'UNICEF explores the impact of digital harassment and provides a toolkit for students to stay safe online.',
                'url' => 'https://www.youtube.com/watch?v=vtfMzmkYp9E',
                'thumbnail' => 'https://i.ytimg.com/vi/vtfMzmkYp9E/hqdefault.jpg',
                'platform' => 'youtube',
                'platform_id' => 'vtfMzmkYp9E',
                'created_at' => $now->copy()->subHours(1),
                'updated_at' => $now->copy()->subHours(1),
            ],
            [
                'type' => 'article',
                'category' => 'anti-bullying',
                'title' => 'The Power of the Upstander',
                'content' => 'A guide for students on moving from being a silent bystander to an active upstander in bullying situations.',
                'url' => 'https://medium.com/@StopBullyingGov/the-power-of-the-upstander-7e12f45da',
                'thumbnail' => 'https://placehold.co/800x400/10b981/white?text=Medium+Upstander',
                'platform' => 'medium',
                'platform_id' => '7e12f45da',
                'created_at' => $now->copy()->subHours(5),
                'updated_at' => $now->copy()->subHours(5),
            ],
            [
                'type' => 'article',
                'category' => 'anti-bullying',
                'title' => 'Red Flags: Identifying Digital Harassment',
                'content' => 'Instagram educational carousel highlighting the subtle signs of cyberstalking and social exclusion.',
                'url' => 'https://www.instagram.com/p/C6Z7yK-L0x9/',
                'thumbnail' => 'https://placehold.co/800x800/5851db/white?text=IG+CyberSafety',
                'platform' => 'instagram',
                'platform_id' => 'C6Z7yK-L0x9',
                'created_at' => $now->copy()->subHours(12),
                'updated_at' => $now->copy()->subHours(12),
            ],

            // ==========================================
            // CATEGORY: DIGITAL LITERACY
            // ==========================================
            [
                'type' => 'video',
                'category' => 'digital-literacy',
                'title' => 'The Danger of Echo Chambers',
                'content' => 'How algorithms reinforce our biases and how to step outside your digital bubble to find objective truth.',
                'url' => 'https://www.youtube.com/watch?v=GuVfvM69830',
                'thumbnail' => 'https://i.ytimg.com/vi/GuVfvM69830/hqdefault.jpg',
                'platform' => 'youtube',
                'platform_id' => 'GuVfvM69830',
                'created_at' => $now->copy()->subDays(12),
                'updated_at' => $now->copy()->subDays(12),
            ],
            [
                'type' => 'video',
                'category' => 'digital-literacy',
                'title' => 'Phishing Scams: Don\'t Take the Bait',
                'content' => 'Learn to identify suspicious emails and links that target student accounts and personal data.',
                'url' => 'https://www.tiktok.com/@cybercare/video/7214596032145892140',
                'thumbnail' => 'https://placehold.co/600x800/black/white?text=TikTok+Phishing',
                'platform' => 'tiktok',
                'platform_id' => '7214596032145892140',
                'created_at' => $now->copy()->subDays(13),
                'updated_at' => $now->copy()->subDays(13),
            ],
            [
                'type' => 'article',
                'category' => 'digital-literacy',
                'title' => 'AI and the Future of Truth',
                'content' => 'Analyzing the rise of Deepfakes and how to use verification tools to check the authenticity of viral videos.',
                'url' => 'https://medium.com/digital-society/ai-deepfakes-and-digital-literacy-f82a12c4',
                'thumbnail' => 'https://placehold.co/800x400/10b981/white?text=Medium+AI+Truth',
                'platform' => 'medium',
                'platform_id' => 'f82a12c4',
                'created_at' => $now->copy()->subDays(14),
                'updated_at' => $now->copy()->subDays(14),
            ],
            [
                'type' => 'article',
                'category' => 'digital-literacy',
                'title' => 'Password Security 101',
                'content' => 'Why "123456" doesn\'t work anymore. A guide to passphrases and 2FA (Two-Factor Authentication).',
                'url' => 'https://www.instagram.com/p/C5n2Xy-v8P2/',
                'thumbnail' => 'https://placehold.co/800x800/405de6/white?text=IG+Security',
                'platform' => 'instagram',
                'platform_id' => 'C5n2Xy-v8P2',
                'created_at' => $now->copy()->subDays(15),
                'updated_at' => $now->copy()->subDays(15),
            ],

            // ==========================================
            // CATEGORY: MENTAL HEALTH
            // ==========================================
            [
                'type' => 'video',
                'category' => 'mental-health',
                'title' => 'Why We Feel Anxious on Social Media',
                'content' => 'Dr. Julie Smith explains the biological response to social comparison and "infinite scrolling."',
                'url' => 'https://www.tiktok.com/@drjuliesmith/video/7102345123456789012',
                'thumbnail' => 'https://placehold.co/600x800/black/white?text=TikTok+Anxiety',
                'platform' => 'tiktok',
                'platform_id' => '7102345123456789012',
                'created_at' => $now->copy()->subDays(16),
                'updated_at' => $now->copy()->subDays(16),
            ],
            [
                'type' => 'video',
                'category' => 'mental-health',
                'title' => 'The Science of Sleep and Screens',
                'content' => 'How blue light affects your circadian rhythm and why a digital detox before bed improves student performance.',
                'url' => 'https://www.youtube.com/watch?v=G078R_5vDIs',
                'thumbnail' => 'https://i.ytimg.com/vi/G078R_5vDIs/hqdefault.jpg',
                'platform' => 'youtube',
                'platform_id' => 'G078R_5vDIs',
                'created_at' => $now->copy()->subDays(17),
                'updated_at' => $now->copy()->subDays(17),
            ],
            [
                'type' => 'article',
                'category' => 'mental-health',
                'title' => 'Journaling for Digital Well-being',
                'content' => 'Step-by-step methods to use journaling as a tool to process online stress and academic pressure.',
                'url' => 'https://medium.com/mindful-musings/journaling-for-mental-clarity-d9e21c33',
                'thumbnail' => 'https://placehold.co/800x400/10b981/white?text=Medium+Journaling',
                'platform' => 'medium',
                'platform_id' => 'd9e21c33',
                'created_at' => $now->copy()->subDays(18),
                'updated_at' => $now->copy()->subDays(18),
            ],
            [
                'type' => 'article',
                'category' => 'mental-health',
                'title' => 'Self-Care vs. Self-Soothing',
                'content' => 'Understanding the difference between escaping through social media and actually recharging your mental battery.',
                'url' => 'https://www.instagram.com/p/C4m9Z1Xv7R9/',
                'thumbnail' => 'https://placehold.co/800x800/c13584/white?text=IG+SelfCare',
                'platform' => 'instagram',
                'platform_id' => 'C4m9Z1Xv7R9',
                'created_at' => $now->copy()->subDays(19),
                'updated_at' => $now->copy()->subDays(19),
            ],

            // ==========================================
            // CATEGORY: SCHOOL SAFETY
            // ==========================================
            [
                'type' => 'video',
                'category' => 'school-safety',
                'title' => 'See Something, Say Something',
                'content' => 'A guide for students on how to use anonymous reporting apps to flag potential safety threats in school.',
                'url' => 'https://www.youtube.com/watch?v=DWv8q2m_k4o',
                'thumbnail' => 'https://i.ytimg.com/vi/DWv8q2m_k4o/hqdefault.jpg',
                'platform' => 'youtube',
                'platform_id' => 'DWv8q2m_k4o',
                'created_at' => $now->copy()->subDays(20),
                'updated_at' => $now->copy()->subDays(20),
            ],
            [
                'type' => 'article',
                'category' => 'school-safety',
                'title' => 'The Importance of Fire & Disaster Drills',
                'content' => 'Why regular drills are not just a break from class, but a vital part of building community resilience.',
                'url' => 'https://medium.com/safety-first/school-disaster-preparedness-f38c91a2',
                'thumbnail' => 'https://placehold.co/800x400/10b981/white?text=Medium+School+Safety',
                'platform' => 'medium',
                'platform_id' => 'f38c91a2',
                'created_at' => $now->copy()->subDays(21),
                'updated_at' => $now->copy()->subDays(21),
            ],
            [
                'type' => 'video',
                'category' => 'school-safety',
                'title' => 'Emergency Contacts: Your Digital Safety Net',
                'content' => 'Quick tutorial on setting up Medical ID and Emergency SOS on your smartphone for school emergencies.',
                'url' => 'https://www.tiktok.com/@techsafety/video/7192345098765432109',
                'thumbnail' => 'https://placehold.co/600x800/black/white?text=TikTok+TechSafety',
                'platform' => 'tiktok',
                'platform_id' => '7192345098765432109',
                'created_at' => $now->copy()->subDays(22),
                'updated_at' => $now->copy()->subDays(22),
            ],
        ];

        \App\Models\LiteracyContent::insert($contents);
    }
}
