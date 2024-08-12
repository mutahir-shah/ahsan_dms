<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Imports\LanguageImport;
use Illuminate\Support\Facades\Storage;

class ImportLanguageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Get the full storage path of the file
            $storagePath = Storage::path($this->filePath);
            // Delete the file after import to free up space
            Storage::delete($this->filePath);
        } catch (\Exception $e) {
            // Handle exceptions or errors during import
            // Optionally, log the error or notify the user
        }
    }
}
