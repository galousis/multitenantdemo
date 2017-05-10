<?php
namespace App\Application\Services;

/**
 * Interface TransactionalSession
 *
 * @package App\Application\Services
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface TransactionalSession
{
	/**
	 * @param  callable $operation
	 * @return mixed
	 */
	public function executeAtomically(callable $operation);
}