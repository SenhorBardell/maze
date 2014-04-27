<?php

class Maze {

	public $width;
	public $height;
	public $grid;
	public $cells;
	public $total_cells;
	public $unchecked;

	public function __construct($width, $height) {
		$this->width = $width;
		$this->height = $height;

		return true;
	}

	public function generate() {

		$this->total_cells = $this->width * $this->height;

		$this->grid = array();
		$this->unchecked = array();
		for ($w = 0; $w < $this->width; $w++) {
			for ($h = 0; $h < $this->height; $h++) {
				$this->grid[$w][$h] = [0, 0, 0, 0];
				$this->unchecked[$w][$h] = true;
			}
		}

		$rand01 = rand(1, $w);
		$rand02 = rand(1, $h);

		var_dump($rand01);
		var_dump($rand02);

		// $current_cell = array();

		$current_cell = [$rand01, $rand02];

		$path = [$current_cell];
		$this->unchecked[$current_cell[0]][$current_cell[1]] = false;
		$visited = 1;

		while ($visited < $this->total_cells) {
			$potential = [
				[$current_cell[0]-1, $current_cell[1], 0, 2], 
				[$current_cell[0], $current_cell[1]+1, 1, 3], 
				[$current_cell[0]+1, $current_cell[1], 2, 0], 
				[$current_cell[0], $current_cell[1]-1, 3, 1]
			];

			$neighbors = array();
			$cells = array();

			for ($l = 0; $l < 4; $l++) {

				if ($potential[$l][0] > -1 && // $h inside?
					$potential[$l][0] < $h && // $h inside?
					$potential[$l][1] > -1 && // $w inside?
					$potential[$l][1] < $w && // $w inside?
					$this->unchecked[$l][0][$potential[$l][1]]) { // Has the neibhor already visited? 
						array_push($neighbors, $potential[$l]);
				}

				if (count($neighbors)) {
					$next = $neighbors[rand(count($neighbors))];

					$cells[$current_cell[0]][$current_cell[1]][$next[2]] = true;

					$cells[$next[0]][$next[1]][$next[3]] = true;

					$this->unchecked[$next[0][$next[1]]] = false;
					$visited++;

					$this->current_cell = [$next[0], $next[1]];
					array_push($this->current_cell);
				} else {
					$current_cell = array_pop($path);
				}

				$this->cells = $cells;
			}
		}
	}

	public function to_array() {
		// var_dump($this->cells);
	}
}