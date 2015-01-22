<?php

require_once __DIR__.'/../vendor/autoload.php';

use ApplyColors\Acrec\Event;
use ApplyColors\Acrec\Schedule;
use ApplyColors\Acrec\ScheduleElement;
use ApplyColors\Acrec\OneDayWeeklyTE;
use ApplyColors\Acrec\DailyTE;
use ApplyColors\Acrec\CustomDaysWeeklyTE;
use ApplyColors\Acrec\TemporalExpression;

echo "Showcase for Humanity task:";

echo "\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n";

/**
 * Loops trough filter resultset of days, only for demo
 *
 * @param array of DateTime $filter
 */
function loopFilter($filter) {
	$filter_date = new DateTime('now');

	foreach ($filter['dates'] as $filter_date) {
		echo "Event: ".$filter['event']->getName()." date: ".$filter_date->format(TemporalExpression::FORMATISO)."\n";
	}
}

$event = new Event("Event Once Weeky: Start 6-jan-2014, 11 repeats: ");

$oneDayWeekly = OneDayWeeklyTE::factory(new DateTime("2014-1-6 13:00:00"), null, 11);

$se = new ScheduleElement($event, $oneDayWeekly);

$schedule = new Schedule;
$schedule->addElements($se);

$filter = $schedule->filter($event, new DateTime('2014-3-1'), new DateTime('2014-3-31'));

loopFilter($filter);

echo "\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
echo "\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n";

$event2= new Event("Event every day, with end date: ");

$daily = DailyTE::factory(new DateTime("2014-1-6 13:00:00"), new DateTime("2014-3-15"), null);

$se2 = new ScheduleElement($event2, $daily);

$schedule2 = new Schedule;
$schedule2->addElements($se2);

$filter2 = $schedule2->filter($event2, new DateTime('2014-3-1'), new DateTime('2014-3-31'));

loopFilter($filter2);

echo "\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
echo "\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n";

$event3 = new Event("Custom selected days, weekly: ");

$daysWeekly = CustomDaysWeeklyTE::factory(new DateTime("2014-1-6 13:00:00"), array(1,3,5));

$se3 = new ScheduleElement($event3, $daysWeekly);

$schedule3 = new Schedule;
$schedule3->addElements($se3);

$filter3 = $schedule3->filter($event3, new DateTime('2014-3-1'), new DateTime('2014-3-15'));

loopFilter($filter3);

echo "\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
echo "\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n";