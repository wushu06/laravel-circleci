<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Nour\Filter\FilterScope;

class TicketService implements TicketInterface
{

    /**
     * @return LengthAwarePaginator
     */
    public function getData($withoutGlobal = false): LengthAwarePaginator
    {
        $ticket = Ticket::latest();
        return $withoutGlobal ?
            $ticket->orderBy('status', $request->dir ?? 'ASC')->paginate(self::page) :
            $ticket->withoutGlobalScope(FilterScope::class)->orderBy('status', $request->dir ?? 'ASC')->paginate(self::page);
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function sort($request)
    {
        if ($request->sort && Schema::hasColumn('tickets', $request->sort)) {
            return DB::table('tickets')->orderBy($request->sort, $request->dir ?? 'ASC')->paginate(self::page);
        }
        return DB::table('tickets')->orderBy('id', $request->dir ?? 'ASC')->paginate(self::page);
    }
}
