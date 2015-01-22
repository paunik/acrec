<?php

namespace ApplyColors\Acrec;

/**
 * Main responsability to create event repeat patterns
 *
 * @author nikola
 * @TODO Use Interface instead!
 *
 */

abstract class TemporalExpression {

	const FORMATISO = "Y-m-d H:i:s" ;

	/**
	 * Checks if certan date occures in date repeat pattern
	 *
	 * @param \DateTime
	 */
	public abstract function includes($date);
}