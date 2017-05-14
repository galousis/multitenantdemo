<?php
namespace App\Interfaces\Api\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Response;
use Illuminate\Http\Request;


/**
 * Class ApiController
 *
 * @package App\Interfaces\Api\Http\Controllers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class ApiController extends Controller
{

	/**
	 * @var int
	 */
	protected $statusCode = 200;

	/**
	 *
	 */
	const CODE_BAD_REQUEST = 'ERR-BADREQUEST';
	/**
	 *
	 */
	const CODE_WRONG_ARGS = 'ERR-WRONGARGS';
	/**
	 *
	 */
	const CODE_NOT_FOUND = 'ERR-NOTFOUND';
	/**
	 *
	 */
	const CODE_INTERNAL_ERROR = 'ERR-WHOOPS';
	/**
	 *
	 */
	const CODE_UNAUTHORIZED = 'ERR-UNAUTHORIZED';
	/**
	 *
	 */
	const CODE_FORBIDDEN = 'ERR-FORBIDDEN';


	/**
	 * Getter for statusCode
	 *
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * Setter for statusCode
	 *
	 * @param int $statusCode Value to set
	 *
	 * @return self
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

	/**
	 * Respond with the given data after checking
	 * that everything exists and is valid
	 *
	 * @param $data
	 * @param $callback
	 * @param array $includes
	 *
	 * @return \Response
	 */
	public function respondWith($data, $callback, $includes=[]){

		#if $data is null throw error
		if(!$data){
			return $this->errorNotFound('Requested response not found.');
		}
		#if $data is a Collection or a Paginated Collection
		else if($data instanceof Collection || $data instanceof LengthAwarePaginator){
			return $this->respondWithCollection($data, $callback, $includes);
		}
		else {
			return $this->errorInternalError();
		}
	}

	/**
	 * @param $collection
	 * @param $callback
	 * @param array $includes
	 * @return mixed
	 */
	protected function respondWithCollection($collection, $callback, $includes=[])
	{
		//TODO
	}

	/**
	 * @param array $array
	 * @param array $headers
	 * @return mixed
	 */
	protected function respondWithArray(array $array, array $headers = [])
	{
		$response = Response::json($array, $this->statusCode, $headers);

		return $response;
	}

	/**
	 * @param $message
	 * @param $errorCode
	 * @return mixed
	 */
	public function respondWithError($message, $errorCode)
	{
		return $this->respondWithArray([
			'error' => [
				'code' => $errorCode,
				'http_code' => $this->statusCode,
				'message' => $message,
			]
		]);
	}

	/**
	 * Generates a Response with a 403 HTTP header and a given message.
	 *
	 * @param string $message
	 * @return Response
	 */
	public function errorForbidden($message = 'Forbidden')
	{
		return $this->setStatusCode(401)
			->respondWithError($message, self::CODE_FORBIDDEN);
	}

	/**
	 * Generates a Response with a 500 HTTP header and a given message.
	 *
	 * @param string $message
	 * @return Response
	 */
	public function errorInternalError($message = 'Internal Error')
	{
		return $this->setStatusCode(500)
			->respondWithError($message, self::CODE_INTERNAL_ERROR);
	}

	/**
	 * Generates a Response with a 404 HTTP header and a given message.
	 *
	 * @param string $message
	 * @return Response
	 */
	public function errorNotFound($message = 'Resource Not Found')
	{
		return $this->setStatusCode(404)
			->respondWithError($message, self::CODE_NOT_FOUND);
	}

	/**
	 * Generates a Response with a 401 HTTP header and a given message.
	 *
	 * @param string $message
	 * @return Response
	 */
	public function errorUnauthorized($message = 'Unauthorized')
	{
		return $this->setStatusCode(403)
			->respondWithError($message, self::CODE_UNAUTHORIZED);
	}

	/**
	 * Generates a Response with a 400 HTTP header and a given message.
	 *
	 * @param string $message
	 * @return Response
	 */
	public function errorWrongArgs($message = 'Wrong Arguments')
	{
		return $this->setStatusCode(400)
			->respondWithError($message, self::CODE_WRONG_ARGS);
	}
}