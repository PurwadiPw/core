<?php

namespace Pw\Core\Jobs;

use Pw\Core\Jobs\Job;

class ChangeLocale extends Job
{
	public $lang;
	
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        session(['locale' => $this->lang]);
    }
}
