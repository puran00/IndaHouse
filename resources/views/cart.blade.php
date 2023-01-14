@extends('layout.app')
@section('title')
    Корзина
@endsection
@section('main')
    <div class="container" id="Cart">
        <div class="row mt-5 text-center">
            <h1>Корзина</h1>
        </div>
        <div class="row mt-4 justify-content-center">
            <div :class = "message? 'alert alert-success':''">
                @{{ message }}
            </div>

            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Изображение</th>
                        <th scope="col">Товар</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Стоимость</th>
                        <th scope="col">Действия</th>
                        <th scope="col"></th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="cart in carts">
                        <th scope="row"></th>
                        <td class="w-25"><img :src="cart.product.img" class="w-25" alt=""></td>
                        <td>@{{ cart.product.title }}</td>
                        <td>@{{ cart.count }}</td>
                        <td>@{{ cart.summ }}</td>
                        <td>
                            <div class="row">
                                <div class="col-4">
                                    <button class="btn btn-success" @click="addInCart(cart.product.id)">+</button>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <button class="btn btn-danger" @click="decrementInCart(cart.product.id)">-</button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-dark" @click = 'deleteFromCart(cart.product.id)' >Удалить</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-4"><h4>Всего: </h4></div>
            <div class="col-2">@{{ order.summ }} р.</div>
            <div class="justify-content-end">
                <button class="btn btn-dark col-2 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Оформить заказ</button>


                <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fs-5" id="exampleModalLabel">Оформить заказ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div :class="message_order?'alert alert-secondary':''">
                                    @{{ message_order }}
                                </div>
                                <form id="form" @submit.prevent="completedOrder">
                                    <input type="password" class="form-control" placeholder="Введите пароль" name="password" :class="errors.password?'is-invalid':''">
                                    <div class="invalid-feedback" v-for="error in errors.password">
                                        @{{ error }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Оформить</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
    <script>
        const Cart = {
            data() {
                return {
                    carts: [],
                    order:{},
                    message: '',
                    message_order:'',
                    errors:[],

                }
            },

            methods: {
                async getCarts() {
                  const response = await fetch('{{route('GetCart')}}');
                  const data = await response.json();
                  this.carts = data.carts;
                  this.order = data.order;
                },

                async addInCart(id) {
                    const response = await fetch('{{route('AddInCart')}}', {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                            'Content-Type':'application/json',
                        },
                        body:JSON.stringify({
                            id:id,
                        })
                    });

                    if (response.status===200) {
                        this.message = await response.json();
                        setTimeout(() => {
                            this.message = null;
                        }, 2000);
                    }
                    if (response.status===400) {
                        this.message_danger = await response.json();
                        setTimeout(() => {
                            this.message_danger = null;
                        }, 2000);
                    }
                    this.getCarts();
                },

                async deleteCartProduct(id){
                    const response = await fetch('{{route('deleteCartProduct')}}', {
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
                        }, 2500);
                    }
                    this.getCarts();
                },
                async completedOrder(){
                    const form = document.querySelector('#form');
                    const form_data = new FormData(form);
                    const response = await fetch('{{route('completedOrder')}}',{
                        method: 'post',
                        headers:{
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body:form_data,
                    });
                    if(response.status===200){
                        this.message_order = await response.json();
                    }
                    if(response.status===400){
                        this.errors = await response.json();
                    }
                    if(response.status===403){
                        this.message_order = await response.json();
                    }
                }

            },
            mounted(){
                this.getCarts();
            }
        }

        Vue.createApp(Cart).mount('#Cart')
    </script>
@endsection
