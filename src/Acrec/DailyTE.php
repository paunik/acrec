<?php

namespace ApplyColors\Acrec;

class DailyTE extends TemporalExpression {

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
	 * Private constructor to force use of factory method
	 *
	 * @param DateTime $date
	 */
	private function __construct($date) {
		$this->startDate = $date;
	}

	/**
	 * Create DailyTE TemporalExpression
	 *
	 * @param \DateTime $startdate
	 * @param \DateTime $endDate
	 * @param integer $occurences
	 *
	 * @return DailyTE;
	 * @TODO refactor move all factory methods to one parent class!!!
	 */
	public static function factory($startDate, $endDate=null, $occurences=null)
	{
		$te = new DailyTE($startDate);

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
	 * Checks if date is in valid range
	 *
	 * @param unknown $date
	 * @return boolean
	 */
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
			$dateInterval = new \DateInterval("P".$this->occurences."D");

			$intervalEndDate = clone $this->startDate;
			$intervalEndDate->add($dateInterval);
			//@TODO refactor move to method
			if ($date->format(TemporalExpression::FORMATISO) >= $this->startDate->format(TemporalExpression::FORMATISO) && $date->format(TemporalExpression::FORMATISO) <= $intervalEndDate->format(TemporalExpression::FORMATISO)) {
				return true;
			} else
			{
				return false;
			}
		} else {
			// we have start date
			//@TODO refactor move to method
			if($date->format(TemporalExpression::FORMATISO) >= $this->startDate->format(TemporalExpression::FORMATISO))
			{
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see \ApplyColors\Namesp\TemporalExpression::includes()
	 */
	public function includes($date) {
		return $this->isDateInRange($date);
	}
}