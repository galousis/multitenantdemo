<?php
namespace App\Application\Services;

/**
 * Class TransactionalApplicationService
 *
 * @package App\Application\Services
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TransactionalApplicationService implements ApplicationService
{

	#region properties
	/**
	 * @var TransactionalSession
	 */
	private $session;

	/**
	 * @var ApplicationService
	 */
	private $service;
	#endregion

	#region Constructor
	/**
	 * @param ApplicationService $service
	 * @param TransactionalSession $session
	 */
	public function __construct(ApplicationService $service, TransactionalSession $session)
	{
		$this->session = $session;
		$this->service = $service;
	}
	#endregion

	#region Methods
	/**
	 * @param $request
	 * @return mixed
	 */
	public function execute($request = null)
	{
		if (empty($this->service)) {
			throw new \LogicException('A use case must be specified');
		}
		$operation = function () use ($request) {
			return $this->service->execute($request);
		};
		return $this->session->executeAtomically($operation);
	}
	#endregion
}