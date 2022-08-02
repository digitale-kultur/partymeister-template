<?php

namespace App\Competitions\PDF;

use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\CompetitionPrize;
use Partymeister\Competitions\Models\Entry;


class PrizeLabel extends \Uskur\PdfLabel\PdfLabel
{
    public function __construct()
    {
        parent::__construct('NewPrint4005');
        $this->addPage();
        $this->drawCutLines();
    }

    public function addSingleLabel(Competition $competition, Entry $entry, CompetitionPrize $prize) {
        $text  = '<h4>'. $competition->name . ' #'.$prize->rank . "</h4>";
        $text .= '<p>"'.$entry->title.'" by '.$entry->author . "</p>";
        $text .= '<h2>' . $prize->amount . ' EURO</h2>';

        $this->addHtmlLabel($text);
    }
}