<?php
namespace meSmart\Views;

interface View {

	public function fetch($name, $array, $display);
}