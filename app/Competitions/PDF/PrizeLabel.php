<?php

namespace App\Competitions\PDF;

use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\CompetitionPrize;
use Partymeister\Competitions\Models\Entry;
use Uskur\PdfLabel\PdfLabel;


class PrizeLabel extends PdfLabel
{
    public function __construct()
    {
        parent::__construct(config('partymeister-competitions-prizelabels.format', 'NewPrint4005'));
        $this->addPage();
    }

    public function addSingleLabel(Competition $competition, Entry $entry, CompetitionPrize $prize)
    {
        $this->addHtmlLabel(view('backend/competition_prizes/pdf/label', [
            'competition_name' => $competition->name,
            'rank' => $prize->rank,
            'entry_title' => $entry->title,
            'entry_author' => $entry->author,
            'prize_amount' => $prize->amount,
            'prize_currency' => config('partymeister-competitions-receipt.currency')
        ]));
    }
}