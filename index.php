<?php

require_once 'maze.php';
require_once 'solver.php';

$width = 5;
$height = 5;

$all = $width * $height;
$visited = 1;

// Depth-First Search

while ($visited < $all) {
	// Find all neighbors of $current_cell with all walls inact
	$current_cell = array(1, 1, false);
	$neighbors = array(
			array($current_cell[0]-1, $current_cell[1], true), // top
			array($current_cell[0], $current_cell[1]-1, true), // left
			array($current_cell[0], $current_cell[1]+1, true), // right 
			array($current_cell[0]+1, $current_cell[1], true) // bottom
		);
	if (count($neighbors)) {
		// choose one at random
		$next = rand(1, $neighbors);

		// knock down the wall
		// push to $current_cell
		// make the new cell $current_cell
		// add 1 to $visited
		$visited++;
	} else {
		// $current_cell = array_pop();
	}
}

// $maze = new Maze(2, 2);

// $maze->generate();

// $maze_solver = new Solver();

// print $maze_solver->solve($maze->to_array());