@extends('layout.app')
@section('title')
    Главная страница
@endsection
@section('main')
    <div class="container" id="welcomePage">
        <div class="row mt-5 text-center">
            <p class="text-center h4 mb-4">Новые товары уже доступны!</p>
        </div>
        <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="true">
            <div class="carousel-indicators">
                @foreach($products as $key=>$product)""
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$key}}" class="{{$key==0?'active':''}}" aria-current="true" aria-label="Slide 1"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($products as $key=>$product)
                <div class="carousel-item {{$key==0?'active':''}}" style="background-size: cover; height: 60vh">
                    <img src="{{asset($product->img)}}" class="d-block h-100 img-fluid" style="object-fit: cover; margin: 0 auto;" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 style="text-shadow: 0.1em 0.1em 0.1em black; color: white">{{$product->title}}</h5>
                    </div>
                </div>

                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class=" col-8" style="margin: 2rem auto 0 auto">
            <h2 class="text-center mb-3">О нас</h2>
            <p class="fs-4"><b>Funny Comics Land</b> - современная художественная литература, фэнтези и фантастика, культурология, искусство, книги для детей, комиксы и манга.</p>
            <p class="fs-4">Любители комиксов с нетерпением ждут эксклюзивных релизов графических романов от DC Comics и Vertigo и новых манга-сериалов, претендующих на популярность наряду с «Токийским гулем», Death Note, «Человеком-бензопилой» и Naruto.
                Издательство «Funny Comics Land» — впечатляющий спектр признанных бестселлеров от «Волкодава» и «Ходячего замка» до «Бэтмена» и «Шантарама»!</p>
        </div>


    </div>


@endsection
