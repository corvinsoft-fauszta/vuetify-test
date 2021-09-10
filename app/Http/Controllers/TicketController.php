<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view("tickets.index");
    }

    public function list()
    {
        return Ticket::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(TicketRequest $request)
    {
        $ticket = Ticket::create($request->validated());
        return response($ticket->id, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TicketRequest $request
     * @param Ticket $ticket
     * @return Response
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        return response('Ok', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ticket $ticket
     * @return Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response('Ok',200);
    }
}
