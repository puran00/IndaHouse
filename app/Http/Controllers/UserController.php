<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function NewUserSave(Request $request){
        $validation = Validator::make($request->all(), [
            'firstname'=>['required', 'regex:/[А-Яа-яЁё]/u'],
            'lastname'=>['required', 'regex:/[А-Яа-яЁё]/u'],
            'patronymic'=>['regex:/[А-Яа-яЁё]/u', 'nullable'],
            'email'=>['required', 'email:frc', 'unique:users'],
            'login'=>['required', 'regex:/[А-Яа-яЁёA-Za-z0-9-]/u'],
            'password'=>['required', 'min:6', 'max:12', 'confirmed'],
            'rules'=>['required'],
        ],[
            'firstname.required'=>'Обязательное поле',
            'firstname.regex'=>'Поле может содержать только кириллицу',
            'lastname.required'=>'Обязательное поле',
            'lastname.regex'=>'Поле может содержать только кириллицу',
            'patronymic.regex'=>'Поле может содержать только кириллицу',
            'email.required'=>'Обязательное поле',
            'email.email'=>'Пример: oleg@amil.ru',
            'email.unique'=>'Пользователь с такой почтой уже зарегистрирован',
            'login.required'=>'Обязательное поле',
            'login.regex'=>'Поле может содержать только кириллицу/латиницу',
            'password.required'=>'Обязательное поле',
            'password.confirmed'=>'Пароли не совпадают',
            'rules.required'=>'Обязательное поле',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }
        $user = new User();
        $user->name=$request->firstname;
        $user->surname=$request->lastname;
        $user->patronymic=$request->patronymic;
        $user->email=$request->email;
        $user->login=$request->login;
        $user->password=md5($request->password);

        $user->save();

        return redirect()->route('login');
    }

    public function AuthSave(Request $request) {
        $validation = Validator::make($request->all(), [
            'login'=>['required', 'regex:/[А-Яа-яA-Za-z0-9-]/u'],
            'password'=>['required'],
        ],[
            'login.required'=>'Обязательное поле',
            'login.regex'=>'Поле может содержать только кириллицу/латиницу',
            'password.required'=>'Обязательное поле',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $user = User::query()->where('login', $request->login)->where('password', md5($request->password))->first();

        if ($user) {
            Auth::login($user);
            if ($user->role=='user') {
                return redirect()->route('UserPage');
            }
            if ($user->role=='admin') {
                return redirect()->route('AdminPage');
            }
        }
        else {
            return response()->json('неверный логин или пароль', 403);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('AboutUs');
    }
}
