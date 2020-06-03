<?php

namespace PtzCamera;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Camera
 *
 * @package PtzCamera
 */
class Camera
{

	public string $base_url;
	public int $channel = 1;

	/**
	 * Camera constructor.
	 *
	 * @param string $login
	 * @param string $password
	 * @param string $ip
	 * @param int $port
	 * @param bool $is_https
	 * @param string $provider
	 */
	public function __construct(string $login, string $password, string $ip, int $port, bool $is_https = false, string $provider = 'hikvision')
	{
		$base_url = $is_https ? 'https://' : 'http://';
		$base_url .= "{$login}:{$password}@{$ip}:{$port}";
		$base_url .= $this->getProviderPath($provider);

		$this->base_url = $base_url;
	}

	/**
	 * Get Provider Camera Path
	 *
	 * @param string $provider
	 * @return string
	 */
	private function getProviderPath(string $provider)
	{
		switch ($provider) {
			case 'hikvision':
				return '/PTZCtrl';
				break;
			case 'isapi':
				return '/ISAPI/PTZCtrl';
				break;
			default:
				return $provider;
		}
	}

	/**
	 * Send Request to Camera
	 *
	 * @param string $url
	 * @param string $data
	 * @param string $method
	 * @param bool $return_response
	 * @return string
	 */
	private function makeRequest(string $url, string $data = null, string $method = 'PUT', $return_response = false)
	{
		$client = new Client();
		$args = ['http_errors' => false];

		if ($data) {
			$args[ 'headers' ] = ['Content-Type' => 'text/xml; charset=utf-8'];
			$args[ 'body' ] = $data;
		}

		try {
			$response = $client->request($method, $url, $args);
		} catch (GuzzleException $e) {
			return $e->getCode();
		}

		if ($return_response) {
			return $response;
		}

		return $response->getStatusCode();

	}

	/**
	 * Set Working Channel
	 *
	 * @param int $channel
	 */
	public function setChannel(int $channel)
	{
		$this->channel = $channel;
	}

	/**
	 * It is used to control PTZ move around and zoom in a period of time for the device
	 *
	 * @param int $pan
	 * @param int $tilt
	 * @param int $zoom
	 * @param int $duration
	 * @return string
	 */
	public function momentary(int $pan = 0, int $tilt = 0, int $zoom = 0, int $duration = 1000)
	{
		$url = $this->base_url . "/channels/{$this->channel}/momentary";
		$data = RequestDataBuilder::ptzDataMomentary($pan, $tilt, $zoom, $duration);

		return $this->makeRequest($url, $data);
	}

	/**
	 * It is used to move the position which is defined by positionX, positionY
	 * to the screen center and relative zoom for the device
	 *
	 * @param int $posX
	 * @param int $posY
	 * @param int $zoom
	 * @return string
	 */
	public function relative(int $posX = 0, int $posY = 0, int $zoom = 0)
	{
		$url = $this->base_url . "/channels/{$this->channel}/relative";
		$data = RequestDataBuilder::ptzDataRelative($posX, $posY, $zoom);

		return $this->makeRequest($url, $data);
	}

	/**
	 * Camera PTZ move to Home
	 *
	 * @return string
	 */
	public function home()
	{
		$url = $this->base_url . "/channels/{$this->channel}/homeposition/goto";

		return $this->makeRequest($url);
	}

	/**
	 * Camera PTZ Move to Preset Number
	 *
	 * @param int $preset
	 * @return string
	 */
	public function preset(int $preset = 1)
	{
		$url = $this->base_url . "/channels/{$this->channel}/presets/{$preset}/goto";

		return $this->makeRequest($url);
	}

}