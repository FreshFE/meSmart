<?php
namespace meSmart;

use App;

class Application {

	public static function build() {
		
		new App\Routes();

	}
}