<?php

namespace App\Jobs;

use App\Models\ConstructionImages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreConstructionImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $path,
        public $constructionId,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


        ConstructionImages::create([
            'construction_id' => $this->constructionId,
            'path' => $this->path,
        ]);
    }
}
