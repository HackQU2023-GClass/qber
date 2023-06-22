<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Schedule;
use Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::getAllOrderByDepartureTime();
        return view('schedule.index',compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'description' => 'required | max:191',
            'departure_time' => 'required',
            'arrival_time'=>'required | after:start'
        ]);
        // バリデーション:エラー
        if ($validator->fails()) {
            return redirect()
            ->route('schedule.create')
            ->withInput()
            ->withErrors($validator);
        }
        // create()は最初からmodelに用意されている関数
        // 戻り値は挿入されたレコードの情報
        $data = $request->merge(['user_id' => Auth::user()->id])->all();
        $result = Schedule::create($data);
        // ルーティング「schedule.index」にリクエスト送信（一覧ページに移動）
        return redirect()->route('schedule.index');
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
    public function destroy(string $id)
    {
        //
    }
}
