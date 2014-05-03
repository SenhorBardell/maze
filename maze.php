<?php

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

	public function __construct($width, $height) {
		$this->width = $width;
		$this->height = $height;
		$this->grid = array();
		$this->unvisited = array();

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

	public function generate() {

		// Recursive backtracking

		while (count($this->path) != 0) {

			// Find all neighbors of $current_cell with all walls inact

			$this->neighbors = array(
					array($this->current_width-1, $this->current_height),
					array($this->current_width, $this->current_height-1),
					array($this->current_width, $this->current_height+1),
					array($this->current_width+1, $this->current_height)
				);

			$this->neighbors_workable = array();

			foreach($this->neighbors as $neighbor) {

				if($neighbor[0] > -1 && 
					$neighbor[0] < $this->width &&
					$neighbor[1] > -1 && 
					$neighbor[1] < $this->height && 
					$this->unvisited[$neighbor[0]][$neighbor[1]] == true &&
					$this->grid[$neighbor[0]][$neighbor[1]][0] == false) {

						$adj = 0;

						if ($this->grid[$neighbor[0]+1][$neighbor[1]][0] == true) $adj = $adj + 1;
						if ($this->grid[$neighbor[0]-1][$neighbor[1]][0] == true) $adj = $adj + 1;
						if ($this->grid[$neighbor[0]][$neighbor[1]+1][0] == true) $adj = $adj + 1;
						if ($this->grid[$neighbor[0]][$neighbor[1]-1][0] == true) $adj = $adj + 1;

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
				$current_cell = array_pop($this->path);
				$this->current_width = $current_cell[0];
				$this->current_height = $current_cell[1];
			}
		}
	
	return $this;

	}

	public function render() {
		$value = '';
		$value .= '<table>';
		for ($w = 0; $w < $this->width; $w++) {
			$value .= '<tr style="background-color: #ddd">';
			for ($h = 0; $h < $this->height; $h++) {
				$value .= "<td>";
					if ($this->grid[$w][$h][0]) {
						$value .= '&nbsp;';
					} else {
						$value .= "#";	
					}
				$value .= "</td>";
			}
			$value .= "</tr>";
		}
		$value .= "</table>";
		echo $value;
		return $this;
	}

}