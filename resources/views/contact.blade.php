@extends('layout.app')

@section('title')
    Где нас найти?
@endsection

@section('main')
    <div class="container">
        <h1 class="m-5 text-center">Где нас найти?</h1>
        <div class="map col-12 d-flex justify-content-center">
            <img class="col-8" src="https://gamecop.ru/wp-content/uploads/2021/11/kak-otkryt-kartu-v-genshin-impakt.webp" alt="map">
        </div>
        <div class="col-12 mt-5 h4 d-flex flex-wrap align-items-center justify-content-center" >
            <div class="row col-8">
                <b class="w-auto p-1">Наш адрес:&nbsp;</b><p class="w-auto p-1">Москва, ул. Спартаковская, д. 23</p>
            </div>
            <div class="row col-8">
                <b class="w-auto p-1">Телефон:&nbsp;</b><p class="w-auto p-1">+7 (499) 400-41-03</p>
            </div>
            <div class="row col-8">
                <b class="w-auto p-1">Email:&nbsp;</b><p class="w-auto p-1">info@comicsland.ru</p>
            </div>
        </div>
    </div>
@endsection
