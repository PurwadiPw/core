<?php

namespace Pw\Core\Controllers;

use App\Http\Controllers\Controller;
use Pw\Core\Jobs\ChangeLocale;

class LangController extends Controller
{
	/**
	 * Change language.
	 *
	 * @param  App\Jobs\ChangeLocaleCommand $changeLocale
	 * @param  String $lang
	 * @return Response
	 */
	public function language($lang, ChangeLocale $changeLocale)
	{		
		$lang = in_array($lang, array_keys(config('core.locales'))) ? $lang : config('app.fallback_locale');
		$changeLocale->lang = $lang;
		$this->dispatch($changeLocale);

		return redirect()->back();
	}
}