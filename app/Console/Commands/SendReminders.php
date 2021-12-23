<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Facades\DB;


class SendReminders extends Command
{
    protected $signature = 'email:reminder';

    /**
     * @return void
     */
    public function handle()
    {
        $items = DB::table('items')
            ->join('reminders', 'reminders.id', '=', 'items.reminder')
            ->where(DB::raw('DATE_ADD(date(items.created_at), INTERVAL reminders.duration DAY)'), '=', DB::raw('date(now())'))
            ->whereNull('items.reminder_status')
            ->get()->toArray();

        foreach($items as $item)
        {
            //todo: implement send mail
            Item::where("id", $item->id)->update(['reminder_status' => 'sent']);
        }

    }
}
