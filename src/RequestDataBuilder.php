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

}