<?php

require_once 'util.php';


/**
 * Solver for mazes
 */
class Solver {

	public static $width;
	public static $height;
	public static $grid;
	public static $start;
	public static $end;

	private static $node;
	private static $list;
	private static $path;


	/**
	 * A* algorithm
	 * @param  array(x, y) $start
	 * @param  array(x, y) $end
	 * @param  array(array(x, y), array(x, y)) $grid
	 * @return array $path
	 */
	public static function a_star($start, $end, $grid) {
		static::$start = $start;
		static::$end = $end;
		static::$grid = $grid;

		$list = array();
		$path = array();

		$start['f'] = static::cost($start);

		array_push($list, $start);
		$grid[$start[0]][$start[1]] = array('cell' => '+', false);
		$grid[static::$width-1][static::$height-1] = array('cell' => '+', false);


		while(count($list)) {
			$current = static::lowest_f($list);

			if (!Utils::node_in_array($current, $path)) {
				array_push($path, $current);
			}


			// If end point is current we no need to do the rest
			if ($current[0] == $end[0]-1 && $current[1] == $end[1]-1) 
				break;

			foreach ($path as $node) {
				$grid[$node[0]][$node[1]] = array('cell' => '+', true);
			}

			$list = Utils::remove_from_array($current, $list);

			$neighbours = static::neighbours($current);

			foreach ($neighbours as $neighbour) {

				if (!Utils::node_in_array($neighbour, $path)) {
					if (!Utils::node_in_array($neighbour, $list)) {

						$neighbour['f'] = static::cost($neighbour);
						array_push($list, $neighbour);

						$current['f'] = static::cost($current);
						$current = $neighbour;

					}
				} elseif ($neighbour != Utils::array_last($path)) {
					$list = Utils::remove_from_array($neighbour, $list);
				}

			}

			array_reverse($path);

		}

		return $path;
	}


	/**
	 * Calculate F, G and H cost to move to end point
	 * @param  array(x, y) $node
	 * @return integer $f cost
	 */
	private static function cost($node) {

		$target_x = static::$end[0];
		$target_y = static::$end[1];

		$current_x = $node[0];
		$current_y = $node[1];

		$g = 1;
		
		// Manhattan
		$h = $g * abs($current_x - $target_x) + abs($current_y - $current_x);
		
		$f = $g + $h;
		return $f;
	}

	/**
	 * Look for lowest F value in list
	 * @param  array(array(x, y), array(x, y)) $list
	 * @return array $node with lowest $f
	 */
	private static function lowest_f($list) {
		$min = 1000000000;
		foreach ($list as $key => $node) {
			if ($node['f' < $min]) {
				$min = $node['f'];
				$min_key = $key;
			}
		}
		return $list[$key];
	}


	/**
	 * Get the neighbours of a certan point
	 * @param  array(x, y) $node
	 * @return array(array(x, y)) $neughbours
	 */
	private static function neighbours($node) {
		$grid = static::$grid;
		$width = static::$width;
		$height = static::$height;

		$x = $node[0];
		$y = $node[1];

		$neighbours = array();

		$x - 1 >= 0 && $grid[$x-1][$y][0] == true ? array_push($neighbours, array($x-1, $y)) : false;
		$x + 1 >= 0 && $grid[$x+1][$y][0] == true ? array_push($neighbours, array($x+1, $y)) : false;
		$y - 1 >= 0 && $grid[$x][$y-1][0] == true ? array_push($neighbours, array($x, $y-1)) : false;
		$y + 1 >= 0 && $grid[$x][$y+1][0] == true ? array_push($neighbours, array($x, $y+1)) : false;

		return $neighbours;
	}

}