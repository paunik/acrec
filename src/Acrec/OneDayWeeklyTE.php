<?php

namespace ApplyColors\Acrec;

class OneDayWeeklyTE extends TemporalExpression {

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
	 * Private to force use of factory
	 *
	 * @param \DateTime $date
	 */
	private function __construct($date) {
		$this->startDate = $date;
	}

	/**
	 *
	 * @param \DateTime $startdate
	 * @param \DateTime $endDate
	 * @param integer $occurences
	 */
	public static function factory($startDate, $endDate=null, $occurences=null)
	{
		$te = new OneDayWeeklyTE($startDate);

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
	 * Checks if date is in range for various conditions
	 *
	 * If endDate set then checks if date is in range and checks day of week
	 * If occurences set then uses DateInterval to create endDate for checking is date i valid range
	 * If occurences and endDate null then just checks that date is not passed startDate
	 *
	 * @param \DateTime $date
	 */
	private function isDateInRange($date) {
		if (isset($this->endDate))
		{
			// we have start and end date
			if($date->format(TemporalExpression::FORMATISO) >= $this->startDate->format(TemporalExpression::FORMATISO) && $date->format(TemporalExpression::FORMATISO) <= $this->endDate->format(TemporalExpression::FORMATISO)) {
				return true;
			} else {
				return false;
			}
		} elseif (isset($this->occurences)) {
			// we have start date and number of occurences
			$dateInterval = new \DateInterval("P".$this->occurences."W");

			$intervalEndDate = clone $this->startDate;
			$intervalEndDate->add($dateInterval);
			//@TODO refactor move to separate method
			if ($date->format(TemporalExpression::FORMATISO) >= $this->startDate->format(TemporalExpression::FORMATISO) && $date->format(TemporalExpression::FORMATISO) <= $intervalEndDate->format(TemporalExpression::FORMATISO)) {
				return true;
			} else
			{
				return false;
			}
		} else {
			// we have start
			if($date->format(TemporalExpression::FORMATISO) >= $this->startDate->format(TemporalExpression::FORMATISO))
			{
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * Checks if day matches for weekly rule
	 *
	 * @param \DateTime $date
	 * @return boolean
	 */
	private function dayMatches($date) {
		return ($this->startDate->format(OneDayWeeklyTE::DAYNOFORMAT)==$date->format(OneDayWeeklyTE::DAYNOFORMAT)) ? true : false;
	}

	/**
	 * (non-PHPdoc)
	 * @see \ApplyColors\Namesp\TemporalExpression::includes()
	 */
	public function includes($date) {
		if ($this->isDateInRange($date) && $this->dayMatches($date))
			return true;
		else
			return false;
	}
}