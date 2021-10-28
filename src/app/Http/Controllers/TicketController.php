<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Services\TicketInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(TicketInterface $service)
    {
        return $service->getData();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketRequest $request
     * @param TicketInterface $service
     */
    public function store(TicketRequest $request, TicketInterface $service)
    {
        $request->validated();
        Ticket::create($request->all());
        return $service->getData();
    }

    /**
     * Search for a name
     *
     * @param string $name
     * @return LengthAwarePaginator
     */
    public function search(string $name): LengthAwarePaginator
    {
        return DB::table('tickets')
            ->where('first_name', 'like', '%' . $name . '%')
            ->orWhere('last_name', 'like', '%' . $name . '%')
            ->orderBy('first_name', $request->dir ?? 'ASC')
            ->paginate(TicketInterface::page);
    }

    /**
     * @param Request $request
     * @param TicketInterface $service
     * @return mixed
     */
    public function filterBy(Request $request, TicketInterface $service)
    {
        return $service->getData(true);
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function sort(Request $request, TicketInterface $service)
    {
        return $service->sort($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param TicketInterface $service
     * @return LengthAwarePaginator|null
     */
    public function destroy($id, TicketInterface $service)
    {
        return Ticket::destroy($id) ? $service->getData() : null;
    }
}
