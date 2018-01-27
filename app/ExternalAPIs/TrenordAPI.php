<?php

namespace App\ExternalAPIs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;

class TrenordAPI
{
	const BASE_URL='https://baas.trenord.it';

	public static function search($from, $to,Carbon $date)
	{
		$url = self::BASE_URL . '/hafas';
		$client = new Client;
		try
		{
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
		}
		catch(RequestException $e)
		{
			if($e->hasResponse()){
				switch($e->getResponse()->getStatusCode())
				{
					case 432:
						// No compatible solutions
						return [];
						break;
					default:
						throw $e;
				}
			}
		}

		$body = $response->getBody();
		return json_decode($body, true);
	}

    public static function getTrainInfo($trainId) {
        $url = self::BASE_URL . '/train/' . $trainId;
        $client = new Client;
        // TODO catch errors
        $response = $client->get($url, [
            'headers' => [
                'Secret' => env('TRENORD_SECRET')
            ]
        ]);
        $body = $response->getBody();
        return json_decode($body, true);
    }

	static function cleanStationName($stationName)
	{
		return str_replace(' ','+',$stationName);
	}

}
