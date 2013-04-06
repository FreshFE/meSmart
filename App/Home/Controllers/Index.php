<?php
namespace App\Home\Controllers;

use meSmart\Controllers\Base as Controller;

class Index extends Controller {

	public function index() {
		dump('welcome to index');

		$this->assign('nihao', 'nihao!');
		$this->display();
	}
}