<?php
namespace App\Application\Services;

use Illuminate\Http\Request;

/**
 * Interface ApplicationService
 *
 * @package App\Application\Services
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface ApplicationService
{
	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function execute(Request $request);
}