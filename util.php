<?php

/**
 * Utility function for arrays
 */
class Utils {


	/**
	 * Look for node in array
	 * @param  array(x, y) $node
	 * @param  array($node) $list of nodes
	 * @return bool
	 */
	public static function node_in_array($node, $list) {
		foreach ($list as $list_node) {
			if ($list_node[0] == $node[0] && $list_node[1] == $node[1]) return true;
		}
		return false;
	}

	/**
	 * Remove a node from given array
	 * @param  array(x, y) $node
	 * @param  array($nodes) $list
	 * @return array $list
	 */
	public static function remove_from_array($node, $list) {
		foreach ($list as $key => $list_node) {
			if ($node[0] == $list_node[0] && $node[1] == $list_node[1]) {
				unset($list[$key]);
			}
		}
		return $list;
	}

	/**
	 * Get the last node from list of nodes
	 * @param  array $array
	 * @return aray $node
	 */
	public static function array_last($array) {
		if (count($array) < 1)
			return null;

		$keys = array_keys($array);
		return $array[$keys[sizeof($keys) - 1]];
	}

}