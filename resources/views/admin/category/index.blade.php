@extends('layout.app')
@section('title')
    Категории
@endsection
@section('main')
    <div class="container" id="ShowPage">
        <div class="row mt-5 text-center">
            <h1>Категории</h1>
        </div>
        <div class="row mt-5 justify-content-end">
            <div class="col-4">
                <a href="{{route('CategoryAddPage')}}" class="btn col-8" style="background-color:#93A0FF; color: white">Добавить категорию</a>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
                <div class="col-8">
                    <div :class="message ? 'alert alert-success' : ''">
                        @{{ message }}
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in categories">
                                <th scope="row">@{{ category.id }}</th>
                                <td>@{{ category.title }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-6">
                                            <a :href="`{{route('EditCategoryPage')}}/${category.id}`" class="btn btn-outline-warning col-12">Редактировать</a>
                                        </div>
                                        <div class="col-6">
                                            <form>
                                                <button type="submit" class="btn btn-outline-danger col-12" @click="deleteCategory(category.id)">Удалить</button>
                                            </form>
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
        const Shop = {
            data() {
                return {
                    categories: [],
                    message:'',
                }
            },

            methods: {
                async getCategories() {
                    const response = await fetch('{{route('getCategories')}}');
                    const data = await response.json();
                    this.categories = data.categories;
                },

                async deleteCategory(id) {
                    const response = await fetch('{{route('DeleteCategory')}}', {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                            'Content-Type':'application/json',
                        },
                        body:JSON.stringify({
                            id_category:id,
                        })
                    });

                    if (response.status===200){
                        this.message =  await response.json();
                        setTimeout(() => {
                            this.message = null;
                        }, 2000);
                    }
                    this.getCategories();
                 }
            },

            mounted() {
                this.getCategories();
            }
        }

        Vue.createApp(Shop).mount('#ShowPage');
    </script>
@endsection
