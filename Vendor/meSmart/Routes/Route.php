<?php
namespace meSmart\Routes;

interface Route {

	public static function getPaths();

	public static function getController();
}