<?php

namespace ApplyColors\Acrec;

class CustomDaysWeeklyTE extends TemporalExpression {

	const DAYNOFORMAT = "N";

	/**
	 * @var \DateTime
	 */
	protected $startDate;

	/**
	 * @var \DateTime
	 */
	protected $endDate;

	/**
	 * @var integer
	 */
	protected $occurences;

	/**
	 * @var array of days
	 */
	protected $days = array();

	/**
	 * Default constructor, private to force use of factory method
	 *
	 * @param \DateTime $date
	 * @param array of day indexes
	 */
	private function __construct($date, $days) {

		$day	= $date->format("w");
		$week	= $date->format("W");
		$year	= $date->format("Y");

		foreach ($this->days as $selected_day)
		{
			if($selected_day > $day) {
				$day = $selected_day;
				break;
			}
		}

		$this->startDate	= $date->setISODate($year, $week, $day);
		$this->days			= $days;
	}

	/**
	 * Custom days weekly repeat
	 *
	 * @param \DateTime $startdate
	 * @param \DateTime $endDate
	 * @param integer $occurences
	 *
	 * @TODO refactor move all factory methods to one parent class!!!
	 */
	public static function factory($startDate, $days, $endDate=null, $occurences=null)
	{
		$te = new CustomDaysWeeklyTE($startDate, $days);

		if(isset($endDate))
		{
			$te->endDate = $endDate;
		} elseif (isset($occurences))
		{
			$te->occurences = $occurences;
		}

		return $te;
	}

	/**
	 * Gets last day (largest index) of selected days
	 */
	private function getLastDay() {
		return max($this->days);
	}

	// refactor move interval calculation to method
	// and move this method to parent class
	private function isDateInRange($date) {
		if (isset($this->endDate))
		{
			// we have strart and end date
			if($date->format(TemporalExpression::FORMATISO) >= $this->startDate->format(TemporalExpression::FORMATISO) && $date->format(TemporalExpression::FORMATISO) <= $this->endDate->format(TemporalExpression::FORMATISO)) {
				return true;
			} else {
				return false;
			}
		} elseif (isset($this->occurences)) {
			// we have start date and number of occurences
			// Can make class to build complex interval string like P1Y2M15D from input

			$dateInterval = new \DateInterval("P".$this->occurences."W");

			$intervalEndDate = clone $this->startDate;
			$intervalEndDate->add($dateInterval);

			// gets last week of interval
			$intervalEndLastWeek	= $intervalEndDate->format('W');
			// gets Year of interval end
			$intervalEndYear		= $intervalEndDate->format("Y");
			// gets last day of interval as DateTime
			$intervalEndLastDay		= $date->setISODate($intevalEndYear, $intervalEndLastWeek, $this->getLastDay());
			// gets min of interval end and max day from last week
			$intervalLastDayOrRuleLastDay = ($intervalEndLastDay->format(TemporalExpression::FORMATISO) > $intervalEndDate->format(TemporalExpression::FORMATISO)) ? $intervalEndDate : $intervalEndLastDay;
			if ($date->format(TemporalExpression::FORMATISO) >= $this->startDate->format(TemporalExpression::FORMATISO) && $date->format(TemporalExpression::FORMATISO) <= $intervalLastDayOrRuleLastDay ) {
				return true;
			} else
			{
				return false;
			}
		} else {
			// we have start date
			if($date->format(TemporalExpression::FORMATISO) >= $this->startDate->format(TemporalExpression::FORMATISO))
			{
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * Checks if date is one of repeated days
	 *
	 * @param \DateTime $date
	 */
	private function checkDay($date)
	{
		$day = $date->format("w");
		return in_array($day, $this->days);
	}

	/**
	 * (non-PHPdoc)
	 * @see \ApplyColors\Namesp\TemporalExpression::includes()
	 */
	public function includes($date) {
		return ($this->isDateInRange($date) && $this->checkDay($date));
	}
}