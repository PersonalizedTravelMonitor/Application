<?php

namespace App\ExternalAPIs;

use GuzzleHttp\Client;
use Carbon\Carbon;

class TrenordAPI
{
	const BASE_URL='https://baas.trenord.it';

	public static function search($from, $to,Carbon $date)
	{
		$url = self::BASE_URL . '/hafas';
		$client = new Client;
		$response = $client->get($url,[
			'query' => [
				'orig' => self::cleanStationName($from),
				'dest' => self::cleanStationName($to),
				'departure_date' => $date->format('Ymd'),
				'departure_hour' => $date->format('H:i'),
				'type' => '0',
				'live_data' => true,
				'plus' => true,
				'no_changes' => 0,
				'transfers' => 1
			],
			'headers' => [
				'Secret' => env('TRENORD_SECRET')
			]
		]);

		if($response->getStatusCode() != 200)
		{
			throw new Exception("Error Processing Request: " . $response->getStatusCode(), 1);
			
		}
		
		$body = $response->getBody();
		return json_decode($body, true);

	} 

	static function cleanStationName($stationName)
	{
		return str_replace(' ','+',$stationName);
	}

}