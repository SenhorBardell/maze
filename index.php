<?php

require_once 'maze.php';
require_once 'solver.php';

$maze = new Maze(5, 5);

$maze->generate();

Solver::solve($maze->grid);

$maze->render();