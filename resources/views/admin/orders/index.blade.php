@extends('layout.app')
@section('title')
    Заказы
@endsection
@section('main')
    <div class="container" id="orders">
        <div class="row mt-5 text-center">
            <h1>Заказы</h1>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Фамилия</th>
                        <th scope="col">Стоимость заказа</th>
                        <th scope="col"></th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in orders">
                        <th scope="row"></th>
                        <td>@{{ order.user.name }}</td>
                        <td>@{{ order.user.surname }}</td>
                        <td>@{{ order.summ }} р.</td>
                        <td>@{{ order.status }}</td>
                        <td>
                            <div class="row">
                                <div class="col-4">
                                    <button class="btn btn-success" >i</button>
                                </div>
                                <div class="col-4">
                                    <button v-if="order.status == 'в обработке'" type="submit" class="btn btn-warning" @click="confirmOrder(order.id)">Принять</button>
                                </div>
                                <div class="col-4">
                                    <button v-if="order.status == 'в обработке'" type="submit" class="btn btn-danger" data-bs-toggle="modal" :data-bs-target="`#rejectModal${order.id}`">Отклонить</button>
                                </div>
                                <div class="modal" :id="`rejectModal${order.id}`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fs-5" id="exampleModalLabel">Причина отказа</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" :id="`rejectForm${order.id}`">
                                                    <textarea name="comment" id="comment" class="form-control" required></textarea>
                                                    <div class="modal-bottom">
                                                        <button type="submit" class="btn btn-danger mt-3" @click="rejectOrder(order.id)">Ок</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
        const orders = {
            data() {
                return {
                    orders:{},
                    message:'',
                    errors:[],

                }
            },

            methods: {
                async getOrders(){
                    const response = await fetch('{{route('getOrders')}}');
                    const data = await response.json();
                    this.orders = data.orders_admin;
                },
                async confirmOrder(id){
                    const response = await fetch('{{route('confirmOrder')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Content-Type': 'application/json',
                        },
                        body:JSON.stringify({
                            order_id:id,
                        })
                    });
                },
                async rejectOrder(id){
                    const form = document.querySelector(`#rejectForm${id}`);
                    const form_data = new FormData(form);
                    form_data.append('id', id);
                    const response = await fetch('{{route('rejectOrder')}}',{
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
                }


            },

            mounted(){
                this.getOrders();
            }
        }

        Vue.createApp(orders).mount('#orders')
    </script>
@endsection
