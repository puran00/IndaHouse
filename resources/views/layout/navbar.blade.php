
<nav class="navbar navbar-expand-lg" style="background-color:#93A0FF;">
    <div class="container-fluid container">
        <a class="navbar-brand text-white" href="{{route('AboutUs')}}">Funny Comics Land</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{route('CatalogPage')}}">Каталог</a>
                </li>
                @guest()
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page"
                           href="{{route('login')}}">Авторизация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('RegistrationPage')}}">Регистрация</a>
                    </li>
                @endguest
                @auth()
                    @if(\Illuminate\Support\Facades\Auth::user()->role=='user')
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('UserOrderPage')}}">Мои заказы</a>
                        </li>
                    @endif
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('CartPage')}}">Корзина</a>
                        </li>

                    @if(\Illuminate\Support\Facades\Auth::user()->role=='admin')
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('AdminPage')}}">Админ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('AdminOrdersPage')}}">Заказы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('ProductPage')}}">Товары</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('CategoryPage')}}">Категории</a>
                        </li>
                    @endif
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('ContactsPage')}}">Где нас найти</a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('logout')}}">Выход</a>
                    </li>


                @endauth

            </ul>
        </div>
    </div>
</nav>
