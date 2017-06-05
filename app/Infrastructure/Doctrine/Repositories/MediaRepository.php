<?php
namespace App\Infrastructure\Doctrine\Repositories;

use App\Domain\Media\Entities\Media;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Media\Contracts\MediaRepositoryContract;

/**
 * Class MediaRepository
 *
 * @package App\Infrastructure\Doctrine\Repositories
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class MediaRepository implements MediaRepositoryContract
{

	/**
	 * @var string
	 */
	private $class = Media::class;

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * MediaRepository constructor.
	 * @param EntityManagerInterface $em
	 */
	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	/**
	 * @param Media $media
	 * @return void
	 */
	public function create(Media $media)
	{
		$this->em->persist($media);
		$this->em->flush();
	}


//	/**
//	 * Get all media in the collection.
//	 *
//	 * @param HasMedia $model
//	 * @param string $collectionName
//	 * @param array|callable $filter
//	 *
//	 * @return \Illuminate\Support\Collection
//	 */
//	public function getCollection(HasMedia $model, string $collectionName, $filter = []): Collection
//	{
//		return $this->applyFilterToMediaCollection($model->loadMedia($collectionName), $filter);
//	}
//
//	/**
//	 * Apply given filters on media.
//	 *
//	 * @param \Illuminate\Support\Collection $media
//	 * @param array|callable $filter
//	 *
//	 * @return \Illuminate\Support\Collection
//	 */
//	protected function applyFilterToMediaCollection(Collection $media, $filter): Collection
//	{
//		if (is_array($filter)) {
//			$filter = $this->getDefaultFilterFunction($filter);
//		}
//
//		return $media->filter($filter);
//	}
//
//	public function all(): DbCollection
//	{
//		return $this->model->all();
//	}
//
//	public function getByModelType(string $modelType): DbCollection
//	{
//		return $this->model->where('model_type', $modelType)->get();
//	}
//
//	public function getByIds(array $ids): DbCollection
//	{
//		return $this->model->whereIn('id', $ids)->get();
//	}
//
//	public function getByModelTypeAndCollectionName(string $modelType, string $collectionName): DbCollection
//	{
//		return $this->model
//			->where('model_type', $modelType)
//			->where('collection_name', $collectionName)
//			->get();
//	}
//
//	public function getByCollectionName(string $collectionName): DbCollection
//	{
//		return $this->model
//			->where('collection_name', $collectionName)
//			->get();
//	}
//
//	/**
//	 * Convert the given array to a filter function.
//	 *
//	 * @param $filters
//	 *
//	 * @return \Closure
//	 */
//	protected function getDefaultFilterFunction(array $filters): Closure
//	{
//		return function (Media $media) use ($filters) {
//			foreach ($filters as $property => $value) {
//				if (! Arr::has($media->getCustomProperty(), $property)) {
//					return false;
//				}
//
//				if (Arr::get($media->getCustomProperty(), $property) !== $value) {
//					return false;
//				}
//			}
//
//			return true;
//		};
//	}

}