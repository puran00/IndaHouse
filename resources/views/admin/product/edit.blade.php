@extends('layout.app')
@section('title')
    Редактирование продуктов
@endsection
@section('main')
    <div class="container" id="AddPage">
        <div class="row mt-5 text-center">
            <h1>Редактирование продуктов</h1>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-6">
                <div :class="message ? 'alert alert-success' : '' ">
                    @{{ message }}
                </div>
                <form id="form" @submit.prevent="EditProduct({{$product->id}})" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text"class="visually-hidden" name="id" value="{{$product->id}}">
                        <label for="title" class="form-label">Продукт</label>
                        <input type="text" name="title" class="form-control" id="title" :class="errors.title ? 'is-invalid' : ''" value="{{$product->title}}">
                        <div :class="invalid-feedback" v-for="error in errors.title">
                            @{{ errors }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Категория</label>
                        <select class="form-select" name="category_id" id="category_id" :class="errors.category_id ? 'is-invalid' : ''">
                            <option v-for="category in categories" :value="category.id" @if($product->category_id==`{{category.id}}` ) selected @endif>@{{ category.title }}</option>
                        </select>
                        <div :class="invalid-feedback" v-for="error in errors.category_id">
                            @{{ errors }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Изображение</label>
                        @if($product->img)
                            <img  src="{{$product->img}}" alt="" class="w-25">
                        @endif
                        <input type="file" name="img" class="form-control" id="img" :class="errors.img ? 'is-invalid' : ''">
                        <div :class="invalid-feedback" v-for="error in errors.img">
                            @{{ errors }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Дата</label>
                        <input type="date" name="age" class="form-control" id="age" :class="errors.age ? 'is-invalid' : ''" value="{{$product->age}}">
                        <div :class="invalid-feedback" v-for="error in errors.age">
                            @{{ errors }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="antagonist" class="form-label">Антагонист</label>
                        <input type="text" name="antagonist" class="form-control" id="antagonist" :class="errors.antagonist ? 'is-invalid' : ''" value="{{$product->antagonist}}">
                        <div :class="invalid-feedback" v-for="error in errors.antagonist">
                            @{{ errors }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Цена</label>
                        <input type="text" name="price" class="form-control" id="price" :class="errors.price ? 'is-invalid' : ''" value="{{$product->price}}">
                        <div :class="invalid-feedback" v-for="error in errors.price">
                            @{{ errors }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="count" class="form-label">Количество</label>
                        <input type="number" name="count" class="form-control" id="count" :class="errors.count ? 'is-invalid' : ''" value="{{$product->count}}">
                        <div :class="invalid-feedback" v-for="error in errors.count">
                            @{{ errors }}
                        </div>
                    </div>
                    <button type="submit" class="btn col-12" style="background-color:#396f94; color: white">Изменить</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const Add = {
            data() {
                return {
                    errors: [],
                    message: '',

                    categories:[],
                }
            },

            methods: {
                async getCategories() {
                    const response = await fetch('{{route('getCategories')}}');
                    const data = await response.json();
                    this.categories = data.categories;
                },

                async EditProduct(id) {
                    const form = document.querySelector('#form');
                    const form_data = new FormData(form);
                    form_data.append('product_id', id);
                    const response = await fetch('{{route('EditProductSave')}}', {
                        method:'post',
                        headers: {
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                        },
                        body:form_data,

                    });
                    if (response.status===400) {
                        this.errors = await response.json();
                        setTimeout(() => {
                            this.errors = [];
                        }, 3000);
                    }
                    if (response.status===200) {
                        this.message = await response.json();
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    }
                }
            },

            mounted() {
                this.getCategories();
            }
        }

        Vue.createApp(Add).mount('#AddPage')
    </script>
@endsection
