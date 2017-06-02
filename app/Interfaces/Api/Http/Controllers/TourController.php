<?php
namespace App\Interfaces\Api\Http\Controllers;

use App\Application\Services\Tour\Access\GetToursService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Domain\Tour\Entities\Tour;
use Illuminate\Support\Collection;


/**
 * Class TourController
 *
 * @package App\Interfaces\Api\Http\Controllers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TourController extends ApiController
{

	#region Properties
	/** @var GetToursService  */
	public $getToursService;
	#endregion

	#region Constructor
	/**
	 * TourController constructor.
	 * @param GetToursService $getToursService
	 */
	public function __construct(GetToursService $getToursService)
	{
		$this->getToursService = $getToursService;
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
		#Eager load all tours with their destinations
		/** @var LengthAwarePaginator $allTours */
		$allTours = $this->getToursService->execute($request);


		$allTours = $allTours->toArray();

		$data = $allTours['data'];


		$result = new Collection();

		foreach ($data as $value)
		{
			/** @var Tour $tour */
			$tour = $value;

			$result->push(array('id'=>$tour->getId(), 'name'=>$tour->getTourCode()));


		}
		$result = $result->all();

//		$result = array(
//			array('id'=>1, 'name'=>'Tour1'),
//			array('id'=>2, 'name'=>'Tour2'),
//			array('id'=>3, 'name'=>'Tour3'),
//			array('id'=>4, 'name'=>'Tour4'),
//			array('id'=>5, 'name'=>'Tour5'),
//			array('id'=>6, 'name'=>'Tour6'),
//			array('id'=>7, 'name'=>'Tour7'),
//			array('id'=>8, 'name'=>'Tour8'),
//			array('id'=>9, 'name'=>'Tour9'),
//			array('id'=>10, 'name'=>'Tour10'),
//			array('id'=>11, 'name'=>'Tour11'),
//			array('id'=>12, 'name'=>'Tour12')
//		);

//		return JsonResponseDefault::create(true, $data, 'tours retrieved successfully', 200);

		return $result;

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