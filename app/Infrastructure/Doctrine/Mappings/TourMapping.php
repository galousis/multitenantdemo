<?php
namespace App\Infrastructure\Doctrine\Mappings;

use App\Domain\Tour\Entities\Tour;
use App\Domain\Destination\Entities\Destination;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

/**
 * Class Tour
 *
 * @package App\Infrastructure\Doctrine\Mappings
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TourMapping extends EntityMapping
{
	/**
	 * Returns the fully qualified name of the class that this mapper maps.
	 *
	 * @return string
	 */
	public function mapFor()
	{
		return Tour::class;
	}

	/**
	 * Load the object's metadata through the Metadata Builder object.
	 *
	 * @param Fluent $builder
	 */
	public function map(Fluent $builder)
	{

		/*
		* Here we'll map each field in the object.
		* Right now we'll just add the single "id" field as an "increments" type: that's our shortcut to
		* tell Doctrine to do an auto-incrementing, unsigned, primary integer field.
		* We could also do `bigIncrements('id')` or the whole `integer('id')->primary()->unsigned()->autoIncrement()`
		*/

		// This will result in an autoincremented integer
		$builder->increments('id');
		$builder->hasMany(Destination::class, 'destinations')->ownedBy('tour');
		// Both strings will be varchars
		$builder->string('tourcode');
		$builder->string('title');
		$builder->string('description');
		$builder->string('duration');
		$builder->string('createdAt')->nullable();
		$builder->string('updatedAt')->nullable();

	}
}