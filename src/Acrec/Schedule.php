<?php

namespace ApplyColors\Acrec;

class Schedule {

	/**
	 * @var Array of ScheduleElement
	 */
	protected $elements;

	/**
	 * @var \DatePeriod $dateRange
	 */
	protected $dateRange;

	public function addElements($se) {
		if($se instanceof ScheduleElement)
		{
			$this->elements[] = $se;
		}
	}


	public function getElements() {
		return $this->elements;
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
	 * @return Array of days
	 *
	 * @param Event $event
	 * @param \DatePeriod $datePeriod
	 *
	 */
	public function dates($event, $datePeriod) {

	}

	/**
	 * CHecks if Event occurs on a Date
	 *
	 * @param Event $event
	 * @param \DateTime $date
	 */
	public function isOccuring($event, $date) {
		foreach ($this->elements as $se) {
			return $se->isOccuring($event, $date);
		}
	}

		/**
	 * @param \DatePeriod $dateRange
	 */
	public function setDateRange($dateRange) {
		if($dateRange instanceof \DatePeriod)
		{
			$this->dateRange = $dateRange;
		} else {
			throw new \Exception("\$dateRange should be instance of DatePeriod");
		}

		return $this;
	}

	/**
	 * Checks rangne for occurance of certain event
	 *
	 * @param Event $event
	 * @param \DatePeriod
	 * @TODO Refactor
	 * @return Array of dates for event
	 */
	public function filter($event)
	{
		$resultSet = array();
		$resultSet['event'] = $event;
		$resultSet['dates'] = array();

		foreach ($this->dateRange as $dr) {
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