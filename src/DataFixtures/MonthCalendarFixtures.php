<?php

namespace App\DataFixtures;

use App\Entity\MonthCalendar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MonthCalendarFixtures extends Fixture
{
    const MONTHS = [
        'Janvier',
        'Février',
        'Mars',
        'Avril',
        'Mai',
        'Juin',
        'Juillet',
        'Aout',
        'Septembre',
        'Octobre',
        'Novembre',
        'Décembre'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::MONTHS as $key => $month) {
            $monthCalendar = new MonthCalendar();
            $monthCalendar->setMonth($month);
            $manager->persist($monthCalendar);
            $this->addReference('month_' . $key, $monthCalendar);
        }

        $manager->flush();
    }
}
