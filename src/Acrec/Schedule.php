<?php

namespace ApplyColors\Acrec;

class Schedule {

	/**
	 * @var Array of ScheduleElement
	 */
	protected $elements;

	public function addElements($se) {
		if($se instanceof ScheduleElement)
		{
			$this->elements[] = $se;
		}
	}

	/**
	 * Gets next occurence from date provided
	 *
	 * @param Event $event
	 * @param \DateTime $date
	 */
	public function nextOccurence($event, $date) {

	}

	/**
	 * Checks if Event occurs on a Date
	 *
	 * @param Event $event
	 * @param \DateTime $date
	 */
	public function isOccuring($event, $date) {
		foreach ($this->elements as $se) {
			$se->isOccuring($event, $date);
		}
	}

	/**
	 * Checks rangne for occurance of certain event
	 *
	 * @param Event $event
	 * @param \DateTime $dateStart
	 * @param \DateTime $dateEnd
	 * @param \DateInterval string $frequency
	 * @return Array of dates for event
	 */
	public function filter($event, $dateStart, $dateEnd, $frequency = "P1D")
	{
		$resultSet = array();
		$resultSet['event'] = $event;
		$resultSet['dates'] = array();
		// dateEnd modify +1 day to include end date
		$daterange = new \DatePeriod($dateStart, new \DateInterval($frequency), $dateEnd->modify('+1 day'));
		foreach ($daterange as $dr) {

			var_dump($dr);

			foreach ($this->elements as $se) {
				if($se->isOccuring($event, $dr))
				{
					$resultSet['dates'][] = $dr;
				}
			}
		}

		return $resultSet;
	}

	// GET ALL EVENTS WITH ALL DATES ???
	public function getAll()
	{

	}
}