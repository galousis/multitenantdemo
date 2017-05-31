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
		$data = array(
			array('id'=>1, 'name'=>'Tour1'),
			array('id'=>2, 'name'=>'Tour2'),
			array('id'=>3, 'name'=>'Tour3'),
			array('id'=>4, 'name'=>'Tour4'),
			array('id'=>5, 'name'=>'Tour5'),
			array('id'=>6, 'name'=>'Tour6'),
			array('id'=>7, 'name'=>'Tour7'),
			array('id'=>8, 'name'=>'Tour8'),
			array('id'=>9, 'name'=>'Tour9'),
			array('id'=>10, 'name'=>'Tour10'),
			array('id'=>11, 'name'=>'Tour11'),
			array('id'=>12, 'name'=>'Tour12')
		);

//		return JsonResponseDefault::create(true, $data, 'tours retrieved successfully', 200);

		return $data;

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