<?php


namespace PtzCamera;


class RequestDataBuilder
{

	/**
	 * @param int $pan
	 * @param int $tilt
	 * @param int $zoom
	 * @param int $duration
	 * @return false|string
	 */
	public static function ptzDataMomentary(int $pan, int $tilt, int $zoom, int $duration)
	{
		ob_start(); ?>
        <PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
            <pan><?= $pan ?></pan>
            <tilt><?= $tilt ?></tilt>
            <zoom><?= $zoom ?></zoom>
            <Momentary>
                <duration><?= $duration ?></duration>
            </Momentary>
        </PTZData>
		<?php return ob_get_clean();
	}

	public static function ptzDataRelative(int $posX, int $posY, int $zoom)
	{
		ob_start(); ?>
        <PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
            <Relative>
                <positionX><?= $posX ?></positionX>
                <positionY><?= $posY ?></positionY>
                <relativeZoom><?= $zoom ?></relativeZoom>
            </Relative>
        </PTZData>
		<?php return ob_get_clean();
	}

}