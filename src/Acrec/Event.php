<?php
namespace ApplyColors\Acrec;
/**
 * Event logic
 *
 * @author nikola
 *
 */
class Event {
	/**
	 * Event name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Schedule property
	 *
	 * @var Schedule
	 */
	protected $schedule;

	/**
	 * Default constructor
	 *
	 * @param string $name
	 */
	public function __construct($name) {
		$this->name = $name;
	}

	/**
	 * Event name getter
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Schedule setter
	 *
	 * @param Schedule
	 *
	 * @return Event
	 */
	public function setSchedule($schedule) {
		$this->schedule = $schedule;

		return $this;
	}
}