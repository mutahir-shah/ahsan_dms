<?php

namespace App\Traits;

use App\CancellationReason;
use App\Language;

trait CancellationReasonTrait
{

    public function storeCancellationReasons()
    {
        $cancellationReasons = $this->getCancellationReasons();
        $languages = Language::all();
        CancellationReason::truncate();
        foreach ($cancellationReasons as $cancellationReason) {
            $newCancellationReason = CancellationReason::create($cancellationReason);
            foreach ($languages as $language) {
                if ($language->id == 1) {
                    continue;
                }
                $newCancellationReason->translations()->create([
                    'reason' => $newCancellationReason->reason,
                    'language_id' => $language->id,
                    'type' => $newCancellationReason->type
                ]);
            }
        }
    }

    public function getCancellationReasons()
    {
        return [
            [
                'reason' => 'Have an emergency',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1
            ],
            [
                'reason' => 'I’m not ready',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1
            ],
            [
                'reason' => 'Wife says “Are you sure you want to leave this early?”',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1
            ],
            [
                'reason' => 'Rider got another ride',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1
            ],
            [
                'reason' => 'Person sounded irritated on phone.',
                'type' => 'USER',
                'language_id' => 1,
                'created_by' => 1
            ],
            [
                'reason' => 'Pickup area is too dangerous to stop and wait in.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1
            ],
            [
                'reason' => 'Too much traffic would be late',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1
            ],
            [
                'reason' => 'Rarely, an emergency happened (vehicular or biological.)',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1
            ],
            [
                'reason' => 'Rarely, I don’t feel like driving a huge distance to get to a pickup.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1
            ],
            [
                'reason' => 'Person sounded irritated on phone.',
                'type' => 'DRIVER',
                'language_id' => 1,
                'created_by' => 1
            ]
        ];
    }
}
