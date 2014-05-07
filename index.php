<?php

require_once 'maze.php';
require_once 'solver.php';

$width = 25;
$height = 79;

$maze = new Maze($width, $height);

$maze->generate();

$grid = $maze->grid;

$path = Solver::a_star(array(0, 0), array($width, $height), $grid);

foreach ($path as $node) {
	$grid[$node[0]][$node[1]] = array('cell' => '+', true);
}

echo "<html><body><pre>\n";
Maze::render($grid, $width, $height);
echo "</pre></body></html>";