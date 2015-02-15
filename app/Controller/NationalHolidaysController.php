<?php
class NationalHolidaysController extends AppController {
	public function view() {
		$this->viewClass = 'Json';

		$date = $this->params['date'] ? date('Y-m-d', strtotime($this->params['date'])) : date('Y-m-d');
		$national_holiday = $this->NationalHoliday->findByDate($date);

		$result = array();
		if ($national_holiday) {
			$result['is_national_holiday'] = true;
			$result['name'] = $national_holiday['NationalHoliday']['name'];
		}
		else {
			$result['is_national_holiday'] = false;
		}

		$this->set(compact('result'));
		$this->set('_serialize', 'result');
	}
}
?>
