@extends('layout.app')
@section('title')
    Авторизация
@endsection

@section('main')
    <div class="container" id="AuthPage">
        <div class="row mt-5 text-center">
            <h1>Авторизация</h1>
        </div>
        <div class="row mt-2 justify-content-center">
            <div :class="message ? 'alert alert-danger' : '' " class="col-6 text-center">
                @{{ message }}
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-6">
                <form id="form" @submit.prevent="Auth">
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" name="login" class="form-control" id="login" :class="errors.login ? 'is-invalid' : ''" >
                        <div :class="errors.login ? 'invalid-feedback' : ''" v-for="error in errors.login">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" id="password" :class="errors.password ? 'is-invalid' : ''">
                        <div :class="errors.password ? 'invalid-feedback' : ''" v-for="error in errors.password">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="btn col-12" style="background-color:#93A0FF; color: white">Авторизация</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const Auth={
            data() {
                return {
                    errors: [],
                    message: '',
                    }
            },

            methods:{
                async Auth(){
                    const form = document.querySelector('#form');
                    const form_data = new FormData(form);
                    const response =await fetch('{{route('AuthSave')}}',{
                        method:'post',
                        headers: {
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                        },
                        body: form_data
                    });
                    if (response.status===400) {
                        this.errors = await response.json();
                        setTimeout(()=>{
                            this.errors = [];
                        }, 5000);
                    }
                    if (response.status===200) {
                        window.location = response.url;
                    }
                    if (response.status===403) {
                        this.message = await response.json();
                        setTimeout(()=> {
                            this.messag = null;
                        }, 5000);
                    }
                }
            },
        }
        Vue.createApp(Auth).mount('#AuthPage')
    </script>
@endsection
