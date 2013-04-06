<?php
namespace App\Home\Controllers;

use meSmart\Controllers\Base as Controller;
use meSmart\Models\Base as Model;

class Index extends Controller {

	public function index() {
		dump('welcome to index');

		$model = new Model('Category');
		dump($model->select());

		$this->assign('nihao', 'nihao!');
		$this->display();
	}
}