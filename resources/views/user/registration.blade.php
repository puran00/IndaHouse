@extends('layout.app')
@section('title')
    Регистрация
@endsection

@section('main')
    <div class="container" id="RegistrationPage">
        <div class="row text-center">
            <h1>Регистрация</h1>
        </div>
        <div class="row  justify-content-center">
            <div class="col-6">
                <form id="form" @submit.prevent="Registration">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Имя</label>
                        <input type="text" name="firstname" class="form-control" id="firstname" :class="errors.firstname ? 'is-invalid': '' ">
                        <div :class="errors.firstname ? 'invalid-feedback' : '' " v-for="error in errors.firstname">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Фамилия</label>
                        <input type="text" name="lastname" class="form-control" id="lastname" :class="errors.lastname ? 'is-invalid': '' ">
                        <div :class="errors.lastname ? 'invalid-feedback' : '' " v-for="error in errors.lastname">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="patronymic" class="form-label">Отчество</label>
                        <input type="text" name="patronymic" class="form-control" id="patronymic" :class="errors.patronymic ? 'is-invalid': '' ">
                        <div :class="errors.patronymic ? 'invalid-feedback' : '' " v-for="error in errors.patronymic">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" name="login" class="form-control" id="login" :class="errors.login ? 'is-invalid': '' ">
                        <div :class="errors.login ? 'invalid-feedback' : '' " v-for="error in errors.login">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" :class="errors.email ? 'is-invalid': '' ">
                        <div :class="errors.email ? 'invalid-feedback' : '' " v-for="error in errors.email">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" id="password" :class="errors.password ? 'is-invalid': '' ">
                        <div :class="errors.password ? 'invalid-feedback' : '' " v-for="error in errors.password">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="rules" class="form-check-input" id="agree" :class="errors.rules ? 'is-invalid': '' ">
                        <label class="form-check-label">Согласие на обработку ПД</label>
                        <div :class="errors.rules ? 'invalid-feedback' : '' " v-for="error in errors.rules">
                            @{{ error }}
                        </div>
                    </div>
                    <button type="submit" class="btn col-12" style="background-color:#93A0FF; color: white">Регистрация</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const Registration={
            data() {
                return {
                    errors:[],
                }
            },

            methods:{
                async Registration() {
                    const form = document.querySelector('#form');
                    const form_data = new FormData(form);
                    const response = await fetch('{{route('NewUserSave')}}', {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                        },
                        body:form_data
                        });
                    if (response.status===400){
                        this.errors = await response.json();
                    }
                    if (response.status===200) {
                        window.location = response.url;
                    }
                }
            },

        }
        Vue.createApp(Registration).mount('#RegistrationPage');
    </script>
@endsection
