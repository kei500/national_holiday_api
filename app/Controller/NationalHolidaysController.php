<?php
class NationalHolidaysController extends AppController {
	public function view() {
		$this->viewClass = 'Json';
		$date = $this->params['date'];

		if (!$date) {
			return $this->__view(date('Y-m-d'));
		}

		if (preg_match("/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/", $date)) {
			return $this->__view(date('Y-m-d', strtotime($date)));
		}

		$conditions;
		if (preg_match("/^(\d{4})-(0[1-9]|1[0-2])$/", $date)) {
			$date .= '-01';
			$conditions = array(
				'NationalHoliday.date >=' => date('Y-m-d', strtotime($date)),
				'NationalHoliday.date <'  => date('Y-m-d', strtotime('+1 month', strtotime($date))),
			);
		}
		else if (preg_match("/^(\d{4})$/", $date)){
			$date .= '-01-01';
			$conditions = array(
				'NationalHoliday.date >=' => date('Y-m-d', strtotime($date)),
				'NationalHoliday.date <'  => date('Y-m-d', strtotime('+1 year', strtotime($date))),
			);
		}
		else {
			throw new NotFoundException;
		}
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

	private function __view($date) {
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
