<?php

namespace App\Helpers;

class ColorGenerator {

	/**
	 * Generate n distinct color
	 *
	 * @param n (number of required color)
	 * @return array of color in hex code
	 */
	public static function generateContrastColor($n) {

		if ($n == 0) {
			return [];
		}
		
		$offset = 50;
		$lim = 256 - $offset;
		$r = $g = $b = [];
		$offset_r = rand(0, $lim % $n);
		$offset_g = rand(0, $lim % $n);
		$offset_b = rand(0, $lim % $n);
		for ($i = 0 ; $i < $n ; ++$i) {
			array_push($r, $offset + $i * ($lim / $n) + $offset_r);
			array_push($g, $offset + $i * ($lim / $n) + $offset_g);
			array_push($b, $offset + $i * ($lim / $n) + $offset_b);
		}

		shuffle($r);
		shuffle($g);
		shuffle($b);

		return array_map(function($r, $g, $b) {
			return '#'. dechex($r) . dechex($g) . dechex($b);
		}, $r, $g, $b);
	}

};
