@extends('layout.app')
@section('title')
    Каталог
@endsection
@section('main')
    <div class="container" id="ShowCatalog">
        <div class="row mt-5">
            <div class="col-3">
                <div class="row">
                    <h4>Фильтрация</h4>
                </div>
                <div class="row mt-2">
                    <select name="" id="" class="form-select" v-model="filter_atr">
                        <option value="created_at">по новизне</option>
                        <option value="title">по названию</option>
                        <option value="price">по цене</option>
                        <option value="age">по дате издания</option>
                    </select>
                </div>
                <div class="row mt-2">
                    <select name="" id="" class="form-select" v-model="category_id">
                        <option value="0">Все категории</option>
                        <option v-for="category in categories" :value="category.id">@{{ category.title }}</option>
                    </select>
                </div>
                <div class="row mt-5">
                    <label class="form-label p-0">Цена</label>
                    <input type="text" value="100" class="form-control" v-model="price_min">
                    <input type="text" value="1000000" class="form-control mt-2" v-model="price_max">
                </div>
            </div>
            <div class="col-9">
                <div :class="message ? 'alert alert-success' : ''">
                    @{{ message }}
                </div>
                <div :class="message_danger ? 'alert alert-danger' : ''">
                    @{{ message_danger }}
                </div>
                <div class="row mt-5">
                    <div class="col-3" v-for="product in filterProducts">
                        <div class="card border-0" style="width: 14rem;">
                            <img :src="product.img" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">@{{ product.title }}</h5>
                                <p class="card-text">@{{ product.price }} р.</p>
                                @auth
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-success" @click="addInCart(product.id)">+</button>
                                    </div>
                                    <div class="col-6">
                                        <a :href="`{{route('InfoPage')}}/${product.id}`" class="btn btn-dark">подробне</a>
                                    </div>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const Show = {
            data() {
                return {
                    products: [],
                    message:'',
                    message_danger:'',
                    categories:'',
                    category_id:0,
                    filter_atr:'created_at',
                    price_min:100,
                    price_max:1000000,
                }
            },

            methods: {
                async getProducts() {
                    const response = await fetch('{{route('getProducts')}}');
                    const data = await response.json();
                    this.products = data.products_catalog;
                },
                async getCategories() {
                    const response = await fetch('{{route('getCategories')}}');
                    const data = await response.json();
                    this.categories = data.categories;
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
                }
            },
            computed: {
              filterProducts() {
                   let products = this.products;

                   if (this.category_id != 0) {
                       products = this.products.filter(product => product.category_id == this.category_id);
                   }
                   if (this.price_min != 1 || this.price_max != 1000000) {
                       products = this.products.filter(product => product.price >= this.price_min && product.price <= this.price_max);
                   }
                   products.sort((a, b) => {
                       if (a[this.filter_atr] > b[this.filter_atr]) return -1
                       if (a[this.filter_atr] < b[this.filter_atr]) return 1
                       if (a[this.filter_atr] === b[this.filter_atr]) return 0
                   })
                   return products;
                }
            },
            mounted() {
                this.getProducts();
                this.getCategories();
            },
        }

        Vue.createApp(Show).mount('#ShowCatalog');
    </script>
@endsection
