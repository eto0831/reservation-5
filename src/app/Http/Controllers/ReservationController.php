<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\Genre;
use App\Models\Area;
use App\Models\User;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $reservation = [
            'user_id' => auth()->user()->id, // ログイン中のユーザーID
            'shop_id' => $request->shop_id, // リクエストから取得した店舗ID
            'reserve_date' => $request->reserve_date, // リクエストから取得した予約日
            'reserve_time' => $request->reserve_time, // リクエストから取得した予約時間
            'guest_count' => $request->guest_count, // リクエストから取得した来店人数
        ];
        Reservation::create($reservation);

        return redirect('/');
    }

    public function destroy(Request $request)
    {
        auth()->user()->reservations()->where('id', $request->reservation_id)->delete();

        return back()->with('error', '予約の削除に失敗しました');
    }

    public function edit($id)
{
    $reservation = Reservation::find($id);
    $shop = $reservation->shop;

    return view('mypage.edit', compact('reservation', 'shop'));
}


    public function update(Request $request)
    {
        $reservation =  $request->all();
        unset($reservation['_token']);
        Reservation::find($request->input('reservation_id'))->update($reservation);

        return redirect('/mypage');
    }
}
