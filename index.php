<?php

// require_once 'maze.php';
// require_once 'solver.php';

$width = 5;
$height = 5;

$all = $width * $height;
$visited = 1;
$grid[0][0][0] = "#";
for ($w = 0; $w < $width; $w++) {
 for ($h = 0; $h < $height; $h++) {
     $grid[$w][$h][0] = false;
 }   
}

// Depth-First Search

while ($visited < $all) {
	// Find all neighbors of $current_cell with all walls inact
	$current_cell = array(1, 1, array(0 => ' ', 1 => true));
	$neighbors = array(
			array($current_cell[0]-1, $current_cell[1], false), // top
			array($current_cell[0], $current_cell[1]-1, false), // left
			array($current_cell[0], $current_cell[1]+1, false), // right 
			array($current_cell[0]+1, $current_cell[1], false) // bottom
		);
	if (count($neighbors)) {
		// choose one at random
		$next = $neighbors[rand(1, count($neighbors))];

		// knock down the wall
		$next[2] = true;
		var_dump($next);
        
		// push to $current_cell
// 		$grid[]
// 		array_push($next, $grid);
		
		// make the new cell $current_cell
		
		// add 1 to $visited
		$visited++;
	} else {
	    array_pop($current_cell);
	    print "dont have any<br>";
	}
	$visited++;
}

$grid_width = 0;

print "<br>";

for ($w = 0; $w < $width; $w++) {
    for ($h = 0; $h < $height; $h++) {
        if ($grid_width == $width-1) {
            var_export($grid[$w][$h][0]);
            echo "<br>";
            $grid_width = 0;
        } else {
            var_export($grid[$w][$h][0]);
            echo " ";
            $grid_width++;
        }
    }
}


// $maze = new Maze(2, 2);

// $maze->generate();

// $maze_solver = new Solver();

// print $maze_solver->solve($maze->to_array());