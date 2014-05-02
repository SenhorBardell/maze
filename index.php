<?php

// require_once 'maze.php';
// require_once 'solver.php';

$width = 50;
$height = 50;
$grid = array();
$unvisited = array();

$all = $width * $height;
$visited = 1;
for ($w = 0; $w < $width; $w++) {
 for ($h = 0; $h < $height; $h++) {
     $grid[$w][$h] = array('cell' => '#', false);
     $unvisited[$w][$h] = true; 
 }   
}

// Recursive backtracking

$current_width = 0;
$current_height = 0;

// Entrance
$grid[0][0] = array('cell' => '&nbsp;', true);

// Exit
$grid[$width][$height] = array('cell' => '&nbsp', true);

$neighbors_workable = array();
$path = array(array($current_width, $current_height));
$unvisited[$current_width][$current_height] = false;

function console_log($text) {
	trigger_error($text, E_USER_NOTICE);
}

function generate($width, $height, $grid) {
	$value = '';
	$value .= '<table>';
	for ($w = 0; $w < $width; $w++) {
		$value .= '<tr style="background-color: #ddd">';
		for ($h = 0; $h < $height; $h++) {
			$value .= "<td>";
				if ($grid[$w][$h][0]) {
					$value .= ' ';
				} else {
					$value .= "#";	
				}
			$value .= "</td>";
		}
		$value .= "</tr>";
	}
	$value .= "</table>";
	return $value;
}

while (count($path) != 0) {
	// Find all neighbors of $current_cell with all walls inact

	$neighbors = array(
			array($current_width-1, $current_height),
			array($current_width, $current_height-1),
			array($current_width, $current_height+1),
			array($current_width+1, $current_height)
		);

	$neighbors_workable = array();

	foreach($neighbors as $neighbor) {

		if($neighbor[0] > -1 && 
			$neighbor[0] < $width &&
			$neighbor[1] > -1 && 
			$neighbor[1] < $height && 
			$unvisited[$neighbor[0]][$neighbor[1]] == true &&
			$grid[$neighbor[0]][$neighbor[1]][0] == false) {

				$adj = 0;

				if ($grid[$neighbor[0]+1][$neighbor[1]][0] == true) $adj = $adj + 1;
				if ($grid[$neighbor[0]-1][$neighbor[1]][0] == true) $adj = $adj + 1;
				if ($grid[$neighbor[0]][$neighbor[1]+1][0] == true) $adj = $adj + 1;
				if ($grid[$neighbor[0]][$neighbor[1]-1][0] == true) $adj = $adj + 1;

				if ($adj == 1) {
					array_push($neighbors_workable, $neighbor);
				}		
		}
	}

	if (count($neighbors_workable)) {
		// choose one at random
		$next = $neighbors_workable[array_rand($neighbors_workable, 1)];

		// make it walkable
		$grid[$next[0]][$next[1]] = array('cell' => '&nbsp', true);
		$unvisited[$next[0]][$next[1]] = false;
        
		$current_width = $next[0];
		$current_height = $next[1];

		array_push($path, array($next[0], $next[1]));
		
	} else {
		$current_cell = array_pop($path);
		$current_width = $current_cell[0];
		$current_height = $current_cell[1];
	}

}

echo generate($width, $height, $grid);