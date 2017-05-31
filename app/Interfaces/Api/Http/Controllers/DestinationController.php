<?php
namespace App\Interfaces\Api\Http\Controllers;

use App\Interfaces\Api\Http\Response\JsonResponseDefault;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
//use App\Application\Services\Destination\Access\;
use Config;
use Tymon\JWTAuth\Facades\JWTAuth;


/**
 * Class DestinationController
 *
 * @package App\Interfaces\Api\Http\Controllers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class DestinationController extends ApiController
{

	#region Properties
	//TODO
	#endregion

	#region Constructor
	/**
	 * DestinationController constructor.
	 *
	 */
	public function __construct()
	{
		//TODO
	}
	#endregion

	#region Methods
	/**
	 * @param Request $request
	 */
	public function recovery(Request $request)
	{
		//TODO
	}

	/**
	 * @param Request $request
	 */
	public function reset(Request $request)
	{
		//TODO
	}

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function create(Request $request)
	{
		//return $this->createDestinationService->execute($request);
	}

	/**
	 * @param Request $request
	 */
	public function getByPage(Request $request)
	{
		//return $this->getDestinationBy->execute($request);
	}

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function index(Request $request)
	{

		$data = array(
			array('id'=>1, 'name'=>'Thessaloniki'),
			array('id'=>2, 'name'=>'Chania'),
			array('id'=>3, 'name'=>'Giannena'),
			array('id'=>4, 'name'=>'Patra'),
			array('id'=>5, 'name'=>'Santorini'),
			array('id'=>6, 'name'=>'Rodos')
		);

		return JsonResponseDefault::create(true, $data, 'destinations retrieved successfully', 200);

		//return $this->getDestinationBy->execute($request);
	}

	/**
	 * @param Request $request
	 */
	public function getByFilter(Request $request)
	{
		$criteria = $request->only(['filter']);
		//return $this->getDestinationBy->execute($criteria['filter']);
	}
	#endregion

}