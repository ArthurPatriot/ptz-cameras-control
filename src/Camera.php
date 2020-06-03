<?php

namespace PtzCamera;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
	 * Set Working Channel
	 *
	 * @param int $channel
	 */
	public function setChannel(int $channel)
	{
		$this->channel = $channel;
	}

	/**
	 * Camera PTZ Left
	 *
	 * @param int $pan
	 * @param int $duration
	 * @return string
	 */
	public function left(int $pan = -20, int $duration = 1000)
	{
		return $this->momentary($pan, $duration);
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
	public function momentary($pan = 0, $tilt = 0, $zoom = 0, $duration = 1000)
	{
		$url = $this->base_url . "/channels/{$this->channel}/momentary";
		$data = RequestDataBuilder::ptzDataMomentary($pan, $tilt, $zoom, $duration);

		return $this->makeRequest($url, $data);
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
	 * Camera PTZ Right
	 *
	 * @param int $pan
	 * @param int $duration
	 * @return string
	 */
	public function right(int $pan = 20, int $duration = 1000)
	{
		return $this->momentary($pan, null, null, $duration);
	}

	/**
	 * Camera PTZ Up
	 *
	 * @param int $tilt
	 * @param int $duration
	 * @return string
	 */
	public function up(int $tilt = 20, int $duration = 1000)
	{
		return $this->momentary(null, $tilt, null, $duration);
	}

	/**
	 * Camera PTZ Down
	 *
	 * @param int $tilt
	 * @param int $duration
	 * @return string
	 */
	public function down(int $tilt = -20, int $duration = 1000)
	{
		return $this->momentary(null, $tilt, null, $duration);
	}

	/**
	 * Camera PTZ Zoom In
	 *
	 * @param int $zoom
	 * @param int $duration
	 * @return string
	 */
	public function zoomIn(int $zoom = 1, int $duration = 1000)
	{
		return $this->momentary(null, null, $zoom, $duration);
	}

	/**
	 * Camera PTZ Zoom Out
	 *
	 * @param int $zoom
	 * @param int $duration
	 * @return string
	 */
	public function zoomOut(int $zoom = -1, int $duration = 1000)
	{
		return $this->momentary(null, null, $zoom, $duration);
	}

	/**
	 * Camera PTZ Left / Right Moves
	 *
	 * @param int $pan
	 * @param int $duration
	 * @return string
	 */
	public function pan(int $pan, int $duration = 1000)
	{
		return $this->momentary($pan, null, null, $duration);
	}

	/**
	 * Camera PTZ Up / Down Moves
	 *
	 * @param int $tilt
	 * @param int $duration
	 * @return string
	 */
	public function tilt(int $tilt, int $duration = 1000)
	{
		return $this->momentary(null, $tilt, null, $duration);
	}

	/**
	 * Camera PTZ Zoom
	 *
	 * @param int $zoom
	 * @param int $duration
	 * @return string
	 */
	public function zoom(int $zoom, int $duration = 1000)
	{
		return $this->momentary(null, null, $zoom, $duration);
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