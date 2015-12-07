<?php

/**
 * Main maze class for generation
 */
class Maze {

	public $width;
	public $height;
	public $grid;
	private $path;
	private $unvisited;
	private $cells;
	public $total_cells;
	private $unchecked;
	private $current_width;
	private $current_height;
	private $neighbors_workable;
	private $neighbors;


	/**
	 * Initial function, preparing maze, setting values
	 * @param integer $width
	 * @param integer $height
	 */
	public function __construct($width, $height) {
		$this->width = $width;
		$this->height = $height;
		$this->grid = array();
		$this->unvisited = array();

		// Fill maze
		for ($w = 0; $w < $this->width; $w++) {
			for ($h = 0; $h < $this->height; $h++) {
				$this->grid[$w][$h] = array('cell' => '#', false);
				$this->unvisited[$w][$h] = true;
			}
		}

		$this->current_width = 0;
		$this->current_height = 0;

		// Entrance
		$this->grid[0][0] = array('cell' => '&nbsp;', true);

		// Exit
		$this->grid[$width][$height] = array('cell' => '&nbsp', true);

		$this->neighbors_workable = array();
		$this->path = array(array($this->current_width, $this->current_height));
		$this->unvisited[$this->current_width][$this->current_height] = false;

		return $this;

	}

	/**
	 * Main function generate maze by using recursive backtracking algorithm
	 * @return array $maze
	 */
	public function generate() {

		// Recursive backtracking

		while (count($this->path) != 0) {

			// Find all neighbors of $current_cell with all walls intact

			$this->neighbors = array(
					array($this->current_width-1, $this->current_height),
					array($this->current_width, $this->current_height-1),
					array($this->current_width, $this->current_height+1),
					array($this->current_width+1, $this->current_height)
				);

			$this->neighbors_workable = array();

			foreach($this->neighbors as $neighbor) {

				// check neighbours

				if($neighbor[0] > -1 &&
					$neighbor[0] < $this->width &&
					$neighbor[1] > -1 &&
					$neighbor[1] < $this->height &&
					$this->unvisited[$neighbor[0]][$neighbor[1]] == true &&
					$this->grid[$neighbor[0]][$neighbor[1]][0] == false) {

						// Every cell must have one empty adjacent cell

						$adj = 0;

						if (@$this->grid[$neighbor[0]+1][$neighbor[1]][0] == true) $adj = $adj + 1;
						if (@$this->grid[$neighbor[0]-1][$neighbor[1]][0] == true) $adj = $adj + 1;
						if (@$this->grid[$neighbor[0]][$neighbor[1]+1][0] == true) $adj = $adj + 1;
						if (@$this->grid[$neighbor[0]][$neighbor[1]-1][0] == true) $adj = $adj + 1;

						if ($adj == 1) {
							array_push($this->neighbors_workable, $neighbor);
						}
				}
			}

			if (count($this->neighbors_workable)) {

				// choose one at random
				$next = $this->neighbors_workable[array_rand($this->neighbors_workable, 1)];

				// make it walkable
				$this->grid[$next[0]][$next[1]] = array('cell' => '&nbsp', true);
				$unvisited[$next[0]][$next[1]] = false;

				$this->current_width = $next[0];
				$this->current_height = $next[1];

				array_push($this->path, array($next[0], $next[1]));

			} else {

				// Otherwise pop it out

				$current_cell = array_pop($this->path);
				$this->current_width = $current_cell[0];
				$this->current_height = $current_cell[1];
			}
		}

	return $this;

	}

	/**
	 * Render maze with html tags, can use as static method without initializing
	 * @param  array $grid
	 * @param  array(x, y) $width
	 * @param  array(x, y) $height
	 * @return string
	 */
	public static function render($grid, $width, $height) {
		$value = '';
		$value .= '<table>';
		for ($w = 0; $w < $width; $w++) {
			$value .= '<tr style="background-color: #ddd">';
			for ($h = 0; $h < $height; $h++) {
				$value .= "<td>";
				$value .= $grid[$w][$h]['cell'];
				$value .= "</td>";
			}
			$value .= "</tr>";
		}
		$value .= "</table>";
        return $value;
	}

}