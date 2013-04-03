<?php
namespace meSmart;

use App;

class Application {

	public static function build() {
		
		App\Route::parse();

		echo App\Route::name('group');

	}
}