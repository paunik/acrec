<?php

namespace ApplyColors\Acrec;

class ScheduleElement {

	/**
	 * @var Event $event;
	 */
	protected $event;

	/**
	 * @var TemporalExpression
	 */
	protected $temporalExpression;

	/**
	 *
	 * Default constructor
	 *
	 * @param Event $event
	 * @param TemporalExpression $temporalExpression
	 */
	public function __construct($event, $temporalExpression) {
		$this->event = $event;
		$this->temporalExpression = $temporalExpression;
	}

	/**
	 * Determine whether an event would occur on a given date
	 *
	 * @param Event $event
	 * @param \DateTime $date
	 *
	 * @return boolean
	 */
	public function isOccuring($event, $date) {
		if($event == $this->event) {
			return $this->temporalExpression->includes($date);
		} else {
			return false;
		}
	}
}