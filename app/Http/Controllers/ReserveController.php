<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Auth;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Schedule $schedule)
    {
        $schedule->users()->attach(Auth::id());

        $client = new \GuzzleHttp\Client();
        $config = new \LINE\Clients\MessagingApi\Configuration();
        $config->setAccessToken(config('services.line.message.channel_token'));
        $messagingApi = new \LINE\Clients\MessagingApi\Api\MessagingApiApi(
            client: $client,
            config: $config,
        );
        $message = new \LINE\Clients\MessagingApi\Model\TextMessage(['type' => 'text','text' => 'あなたにライドシェアが申し込まれました！']);
        $request = new \LINE\Clients\MessagingApi\Model\PushMessageRequest([
            'to' => $schedule->user->lineid,
            'messages' => [$message],
        ]);
        $response = $messagingApi->pushMessage($request);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->users()->detach(Auth::id());

        $client = new \GuzzleHttp\Client();
        $config = new \LINE\Clients\MessagingApi\Configuration();
        $config->setAccessToken(config('services.line.message.channel_token'));
        $messagingApi = new \LINE\Clients\MessagingApi\Api\MessagingApiApi(
            client: $client,
            config: $config,
        );
        $message = new \LINE\Clients\MessagingApi\Model\TextMessage(['type' => 'text','text' => 'ライドシェアがキャンセルされました']);
        $request = new \LINE\Clients\MessagingApi\Model\PushMessageRequest([
            'to' => $schedule->user->lineid,
            'messages' => [$message],
        ]);
        $response = $messagingApi->pushMessage($request);

        return redirect()->back();
    }
}
