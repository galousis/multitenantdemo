<?php
namespace App\Domain\User\Contracts;

use Illuminate\Http\Request;

/**
 * interface AuthentifierContract
 *
 * @package App\Domain\User\Contracts
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface AuthentifierContract
{
	public function authenticate(Request $request);
}