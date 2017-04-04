<?php
namespace Pw\Core\Jobs;
use Pw\Core\Jobs\Job;
use Request;
class SetLocale extends Job
{
    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        if(!session()->has('locale'))
        {
            session(['locale' => Request::getPreferredLanguage(array_keys(config('core.locales')))]);
        }
        app()->setLocale(session('locale'));
    }
}