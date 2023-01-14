@extends('layout.app')
@section('title')
    {{$product->title}}
@endsection
@section('main')
    <div class="container" id="infoPage">
        <h1 class="text-center mt-5">{{$product->title}}</h1>

        <div v-if="message" class="row d-flex justify-content-center mt-5">
            <div class="col-4 text-center" :class="message ? 'alert alert-success': ''">
                @{{message}}
            </div>
        </div>

        <div v-if="message_danger" class="row d-flex justify-content-center mt-5">
            <div class="col-4 text-center" :class="message_danger ? 'alert alert-danger': ''">
                @{{message_danger}}
            </div>
        </div>

        <div class="content d-flex justify-content-between mt-5" >
            <div class="col-4 p-1" style="transform: translate(150px, -11px)">
                <img class="col-12" src="{{$product->img}}" alt="" style="width: 20rem;">
            </div>
            <div class=" col-6" style="font-size: 20px; transform: translate(-10px, 30px)">
                <p>Цена: {{$product->price}} руб.</p>
                <p>Дата публикции: {{$product->age}}</p>
                @if ($product->antagonist)
                    <p>Антагонист: {{$product->antagonist}}</p>
                @endif
                <p>Осталось в наличии: {{$product->count}} шт.</p>

                @auth()
                    <button type="submit" @click = "AddInCart({{$product->id}})" class="btn btn-warning mt-3 col-4">Купить</button>
                @endauth

                @guest()
                    <a href="{{route('login')}}"><button type="submit" class="btn btn-warning mt-3 col-4">Купить</button></a>
                @endguest

            </div>
        </div>
    </div>

    <script>
        const Product = {
            data(){
                return {
                    message:'',
                    message_danger: '',
                }
            },
            methods:{

                async AddInCart(id){
                    const response = await fetch('{{route('AddInCart')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type': 'application/json',
                        },
                        body:JSON.stringify({
                            product_id:id,
                        })
                    });
                    if (response.status === 200){
                        this.message = await response.json();
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    }
                    if (response.status === 400){
                        this.message_danger = await response.json();
                        setTimeout(() => {
                            this.message_danger = null;
                        }, 3000);
                    }
                }
            }
        }
        Vue.createApp(Product).mount('#infoPage');
    </script>
@endsection
