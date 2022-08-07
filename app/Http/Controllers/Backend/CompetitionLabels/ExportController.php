<?php

namespace App\Http\Controllers\Backend\CompetitionLabels;

use App\Competitions\PDF\PrizeLabel;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Services\VoteService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * @return StreamedResponse
     */
    public function prizeMoney()
    {
        $pdf = new PrizeLabel();
        $pdf->SetCompression(true);
        $pdf->SetDisplayMode('fullpage');

        $competitions = Competition::where('has_prizegiving', true)
            ->orderBy('prizegiving_sort_position', 'DESC')
            ->get();

        if ($competitions->count() == 0) {
            die("no competitions");
        }

        $results = VoteService::getAllVotesByRank('DESC');
        foreach ($results as $competition) {
            $c = Competition::find($competition['id']);

            $num = 1;
            //foreach ($competition->entries()->get() as $entry) {
            foreach ($competition['entries'] as $entry) {
                $e = Entry::find($entry['id']);
                if ($num >= 4) {
                    continue;
                }

                $prize = $c->prizes()
                    ->where('rank', $num)
                    ->first();
                if ((int)$prize->amount > 0) {
                    $pdf->addPrizeMoneyLabel($c, $e, $prize);
                }
                $num++;
            }
        }

        // Send the file content as the response
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->Output('prize-money.pdf', 'S');
            $pdf->Close();
        }, 'prize-money.pdf');
    }

    /**
     * @return StreamedResponse
     */
    public function competitionRanks()
    {
        $pdf = new PrizeLabel();
        $pdf->SetCompression(true);
        $pdf->SetDisplayMode('fullpage');

        $competitions = Competition::where('has_prizegiving', true)
            ->orderBy('prizegiving_sort_position', 'DESC')
            ->get();

        if ($competitions->count() == 0) {
            die("no competitions");
        }

        foreach ($competitions as $competition) {
            for ($i=1; $i<=3; $i++) {
                $pdf->addCompetitionRankLabel($competition, $i);
#                $pdf->addSingleLabel($c, $e, $prize);
            }
        }

        // Send the file content as the response
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->Output('competition-ranks.pdf', 'S');
            $pdf->Close();
        }, 'competition-ranks.pdf');
    }
}