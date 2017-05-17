<?php
namespace App\Interfaces\Api\Http\Response;

use Illuminate\Http\JsonResponse;

/**
 * Class JsonResponseDefault
 * @package App\Interfaces\Api\Http\Response
 */
class JsonResponseDefault
{

	/**
	 * @param $success
	 * @param $data
	 * @param $meta
	 * @param $message
	 * @param $code
	 * @return static
	 */
	public static function create($success, $data, $message, $code)
	{
		$response = [
			'success' => $success,
			'data'  => $data,
			'message' => $message,
			'code'    => $code
		];

		$header = [$response['code'] => $response['message']];

		return JsonResponse::create($response,$response['code'],$header);
	}
}