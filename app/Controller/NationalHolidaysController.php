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

	public function year() {
		$this->viewClass = 'Json';

		$year = $this->params['year'];
		if (!$year) {
			throw new NotFoundException;
		}

		if (!preg_match("/20[0-9]{2,2}/", $year)) {
			throw new NotFoundException;
		}

		$conditions = array(
			'NationalHoliday.date >=' => sprintf("%d-01-01", $year),
			'NationalHoliday.date <'  => sprintf("%d-01-01", $year + 1),
		);
		$national_holidays = $this->NationalHoliday->find('all', array('conditions' => $conditions));

		if (!$national_holidays) {
			throw new NotFoundException;
		}

		$result = array();
		foreach ($national_holidays as $national_holiday) {
			$result[$national_holiday['NationalHoliday']['date']] = $national_holiday['NationalHoliday']['name'];
		}

		$this->set(compact('result'));
		$this->set('_serialize', 'result');
	}
}
?>
