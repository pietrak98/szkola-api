<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        if (Auth::user()->type == User::TYPE_PARENT) {
            return Message::with('author')->whereHas('user', function ($query) {
                return $query->where('user_id', '=', Auth::user()->id);
            })->get();
        }
        return Message::with('author')->get();
    }

    public function show(Message $message)
    {
        return $message->with('author')->whereHas('user', function ($query) {
            return $query->where('user_id', '=', Auth::user()->id);
        })->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Message::create(['name' => $request->name]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Message $message
     * @return Message
     */
    public function setRead(Message $message)
    {
        $message->update(['status' => 1]);

        return $message;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return $message;
    }
}
