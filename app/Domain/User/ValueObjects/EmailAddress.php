<?php
namespace App\Domain\User\ValueObjects;

/**
 * Class EmailAddress
 *
 * @package App\Domain\User\ValueObjects
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class EmailAddress
{
	#region properties
	/**
	 * @var strings
	 */
	private $email;
	#endregion

	/**
	 * @param string $email
	 */
	public function __construct($email)
	{
		$this->email = $email;
	}
	public function __toString()
	{
		return $this->email;
	}
}
