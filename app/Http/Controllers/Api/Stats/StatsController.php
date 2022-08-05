<?php

namespace App\Http\Controllers\Api\Stats;

use App\Competitions\PDF\PrizeLabel;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Accounting\Models\Item;
use Partymeister\Accounting\Models\ItemType;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Services\VoteService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StatsController extends Controller
{
    /**
     * @return StreamedResponse
     */
    public function visitors()
    {
        $total = 0;

        $itemType = ItemType::get()->where('name', '=', 'Entrance')->first();

        $items = Item::get()->where('item_type_id', '=', $itemType->id)->all();
        foreach ($items as $item) {
            $total += (int)$item->sales;
        }

        return response()->json(['total' => $total]);
    }
}