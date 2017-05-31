<?php
namespace App\Interfaces\Api\Http\Controllers;

use App\Interfaces\Api\Http\Response\JsonResponseDefault;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
//use App\Application\Services\Tour\Access\;
use Config;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class TourController
 *
 * @package App\Interfaces\Api\Http\Controllers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TourController extends ApiController
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
		//return $this->createTourService->execute($request);
	}

	/**
	 * @param Request $request
	 */
	public function getByPage(Request $request)
	{
		//return $this->getTourBy->execute($request);
	}

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function index(Request $request)
	{
		//return $this->getTourBy->execute($request);
	}

	/**
	 * @param Request $request
	 */
	public function getByFilter(Request $request)
	{
		$criteria = $request->only(['filter']);
		//return $this->getTourBy->execute($criteria['filter']);
	}
	#endregion

}