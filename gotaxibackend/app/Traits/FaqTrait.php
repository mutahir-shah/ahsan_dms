<?php

namespace App\Traits;

use App\CancellationReason;
use App\Faqs;
use App\Language;

trait FaqTrait
{

    public function storeFaqs()
    {
        $faqs = $this->getFaqs();
        $languages = Language::all();
        Faqs::truncate();

        foreach ($faqs as $faq) {
            $newfaq = Faqs::create($faq);
            foreach ($languages as $language) {
                if ($language->id == 1) {
                    continue;
                }
                $newfaq->translations()->create([
                    'question' => $newfaq->question,
                    'answer' => $newfaq->answer,
                    'type' => $newfaq->type,
                    'parent_id' => $newfaq->id,
                    'language_id' => $language->id,
                    'type' => $newfaq->type
                ]);
            }
        }
    }

    public function getFaqs()
    {
        return [
            [
                'question' => 'How do I request a ride?',
                'answer' => 'Enter destination, choose car type, and hit \'Request',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'What are the payment methods?',
                'answer' => 'We accept credit/debit cards, PayPal, and cash in some regions.',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'Can I pre-book a ride? ',
                'answer' => 'Yes, use \'Schedule for Later\' to book up to 30 days ahead.',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'What if I left an item in the car?',
                'answer' => 'Contact the driver via the app or reach out to our support team.',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'How do I rate my driver? ',
                'answer' => 'After the trip, the app prompts you to rate your driver.',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'How do I accept a ride? ',
                'answer' => 'Tap \'Accept\' when you receive a passenger\'s ride request.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'How do I accept a ride? ',
                'answer' => 'Tap \'Accept\' when you receive a passenger\'s ride request.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'What if a passenger leaves an item? ',
                'answer' => 'They may contact you via the app, or you can inform our support.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'How can I earn more? ',
                'answer' => 'Work during peak hours and provide excellent service for tips.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'How is my rating calculated?',
                'answer' => 'It\'s an average of the ratings passengers give you post-trip.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'When and how do I get paid?',
                'answer' => 'Earnings transfer weekly to your bank or use Instant Pay daily.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ],
            [
                'question' => 'After booking a ride, how long driver can wait?',
                'answer' => 'The driver\'s waiting time after booking a ride varies based on the company\'s policy, usually around 5-10 minutes.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1,
                'parent_id' => 0,
            ]
        ];
    }
}
