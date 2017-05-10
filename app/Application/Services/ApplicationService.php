<?php
namespace App\Application\Services;

/**
 * Interface ApplicationService
 *
 * @package App\Application\Services
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface ApplicationService
{
	/**
	 * @param $request
	 * @return mixed
	 */
	public function execute($request = null);
}