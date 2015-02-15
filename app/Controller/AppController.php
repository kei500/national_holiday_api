<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {
	public function beforeFilter() {
		$this->__accessLog();
	}

	private function __accessLog() {
		$http_referer = env('HTTP_REFERER');
		if (!$http_referer) {
			$http_referer = '-';
		}

		$log_message = sprintf (
			"%s %s %s %s %s %s",
			date('Y-m-d H:i:s'),
			env('REQUEST_METHOD'),
			env('REQUEST_URI'),
			env('REMOTE_ADDR'),
			env('HTTP_USER_AGENT'),
			$http_referer
		);
		$this->log($log_message, 'access');
	}
}
