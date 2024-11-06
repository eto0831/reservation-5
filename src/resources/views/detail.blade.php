@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="attendance__alert">
    // メッセージ機能
</div>

<div class="detail__content">
    <div class="detail__wrap">
        <h1>店舗詳細</h1>
        <ul>
            <li>
                <h2>{{ $shop->shop_name }}</h2>
                <p>ジャンル: {{ $shop->genre->genre_name }}</p>
                <p>エリア: {{ $shop->area->area_name }}</p>
                <p>説明: {{ $shop->description }}</p>
                <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->shop_name }}" class="shop__img">
                @if ($shop->isFavorited)
                <form action="/not-favorite" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <button type="submit">お気に入りから外す</button>
                </form>
                @else
                <form action="/favorite" method="POST">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <button type="submit">お気に入り</button>
                </form>
                @endif
            </li>
        </ul>
    </div>
    <div class="reservation__form">
        <h1>予約</h1>
        <form action="/reserve" method="post">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <input type="date" name="reserve_date" id="reserve_date">
            <select name="reserve_time" id="reserve_time" required>
                <option value="" disabled selected>時間を選択してください</option>
                    @for ($hour = 9; $hour<= 22; $hour++)
                        @foreach (['00', '15', '30', '45'] as $minute)
                            <option value="{{ sprintf('%02d:%02d', $hour, $minute) }}">
                                {{ sprintf('%02d:%02d', $hour, $minute) }}
                            </option>
                        @endforeach
                    @endfor
            </select>
            <select name="guest_count" id="guest_count">
                <option value="" disabled selected>人数を選択してください</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value= "{{ $i }}">{{ $i }} 人</option>
                    @endfor
            </select>
            <div class="confirmation__table">
                <table>
                    <tr>
                        <th>Shop</th>
                        <td>{{ $shop->shop_name }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td id="display_date"></td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td id="display_time"></td>
                    </tr>
                    <tr>
                        <th>人数</th>
                        <td id="display_guests"></td>
                    </tr>
                </table>
            </div>
            <button type="submit">予約する</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('reserve_date').addEventListener('input', function() {
    document.getElementById('display_date').innerText = this.value;
});

document.getElementById('reserve_time').addEventListener('input', function() {
    document.getElementById('display_time').innerText = this.value;
});

document.getElementById('guest_count').addEventListener('input', function() {
    document.getElementById('display_guests').innerText = this.value;
});
</script>
@endsection