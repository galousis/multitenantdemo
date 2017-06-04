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
		/** @var LengthAwarePaginator $allTours */
		$allTours = $this->getToursService->execute($request);


		$allTours = $allTours->toArray();

		$data = $allTours['data'];

		foreach ($allTours['data'] as $key => $value)
		{
			/** @var Tour $tour */
			$tour = $value;
			$allTours['data'][$key] = array('id'=>$tour->getId(), 'name'=>$tour->getTourCode());
		}

		return $allTours;
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