<?php

namespace PtzCamera;

/**
 * Class CameraMovement for easy camera control
 *
 * @package PtzCamera
 */
class CameraMovement extends Camera
{

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

}