@extends('layout.app')
@section('title')
    Товары
@endsection
@section('main')
    <div class="container" id="ShowProductPage">
        <div class="row mt-5 text-center">
            <h1>Товары</h1>
        </div>
        <div class="row mt-5 justify-content-end">
            <div class="col-4">
                <a href="{{route('ProductAddPage')}}" class="btn col-12 " style="background-color:#93A0FF; color: white">Добавить товар</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3 justify-content-center">
                <div :class="message ? 'alert alert-success' : ''">
                    @{{ message }}
                </div>
                <table class="table ">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Изображение</th>
                        <th scope="col">Название</th>
                        <th scope="col">Категория</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in products">
                        <th scope="row">@{{ product.id }}</th>
                        <td class="w-25"><img :src="product.img" class="w-25" alt=""></td>
                        <td>@{{ product.title }}</td>
                        <td>@{{ product.category_id }}</td>
                        <td>@{{ product.price }} р.</td>
                        <td>@{{ product.count }} шт.</td>
                        <td>
                            <div class="row">
                                <div class="col-6">
                                    <a :href="`{{route('EditPageProduct')}}/${product.id}`" class="btn btn-outline-warning col-12">Редактировать</a>
                                </div>
                                <div class="col-6">
                                    <button  class="btn btn-outline-danger col-12" @click="deleteProduct(product.id)">Удалить</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const Show = {
            data() {
                return {
                    products: [],
                    message:'',
                }
            },

            methods: {
                async getProducts() {
                    const response = await fetch('{{route('getProducts')}}');
                    const data = await response.json();
                    this.products = data.products_admin;
                },

                async deleteProduct(id) {
                    const response = await fetch('{{route('DeleteProduct')}}', {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                            'Content-Type':'application/json',
                        },
                        body:JSON.stringify({
                           id:id,
                        }),
                    });
                    if (response.status===200){
                        this.message =  await response.json();
                        setTimeout(() => {
                            this.message = null;
                        }, 2000);
                    }
                    this.getProducts();
                },
            },

            mounted() {
                this.getProducts();
            }
        }

        Vue.createApp(Show).mount('#ShowProductPage');
    </script>
@endsection
