<?php
namespace App\Application\Services\User\AggregateVersion;

use App\Application\Services\Tour\AggregateVersion\TourService;
use App\Domain\Tour\Entities\Tour;
use Illuminate\Http\Request;
use App\Domain\User\ValueObjects\UserId;

/**
 * Class ViewToursService
 *
 * @package App\Application\Services\User\AggregateVersion
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class ViewToursService extends TourService
{

	/**
	 * @param Request $request
	 * @return Tour[]
	 */
	public function execute(Request $request)
	{
		return $this
			->findUserOrFail($request->get('user_id'))
			->getTours();
	}

}