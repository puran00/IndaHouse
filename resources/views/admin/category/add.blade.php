@extends('layout.app')
@section('title')
    Создание категории
@endsection
@section('main')
    <div class="container" id="AddPage">
        <div class="row mt-5 text-center">
            <h1>Создание категории</h1>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-6">
                <div :class="message ? 'alert alert-success' : '' ">
                    @{{ message }}
                </div>
                <form id="form" @submit.prevent="AddCategory">
                    <div class="mb-3">
                      <label for="title" class="form-label">Новая категория</label>
                      <input type="text" name="title" class="form-control" id="title" :class="errors.title ? 'is-invalid' : ''">
                      <div :class="invalid-feedback" v-for="error in errors.title">
                        @{{ errors }}
                      </div>
                    </div>
                    <button type="submit" class="btn col-12" style="background-color:#93A0FF; color: white">Создать</button>
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
                }
            },

            methods: {
                async AddCategory() {
                    const form = document.querySelector('#form');
                    const form_data = new FormData(form);
                    const response = await fetch('{{route('AddCategory')}}', {
                        method:'post',
                        headers: {
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                        },
                        body: form_data,

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
            }
        }

        Vue.createApp(Add).mount('#AddPage')
    </script>
@endsection

