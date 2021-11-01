@extends('container.app')
@section('content')

<div class="flex gap-2 items-center text-gray-50 tracking-tighter py-4 mt-2 mb-6 border-b border-gray-600 text-gray-200">
    <a href="{{route('user.index')}}" class="py-2 w-16 text-center rounded-full bg-green-600 bg-opacity-30 hover:bg-opacity-40 cursor-pointer">
        <i class="fas fa-arrow-left"></i>
    </a>
    <i class="fas fa-tshirt"></i>
    <div class="text-lg">
        إضافة مستخدم جديد
    </div>
</div>

<div class="bg-white border-2 py-4 px-4 rounded mb-4 shadow">
    <div class="py-6 text-center font-bold text-2xl border-b bg-gray-50 -mx-4 -mt-4">
        إضافة مستخدم جديد
    </div>
    <div class="w-full xl:mx-auto 2xl:w-5/6 py-8">
        <form id="form" method="POST" action="" class="w-full flex gap-4">
            <div class="w-2/3 py-2 border-r pr-4">
                @csrf

                <div class="flex gap-4 my-4">
                    <div class="w-32 text-right text-xs text-gray-600 pt-2">
                        Nom / إسم المستخدم
                    </div>
                    <div class="flex-1">
                        <input value="@if( old('libelle') ) {{old('libelle')}} @endif" class="border-gray-400 border-2 rounded px-2 py-1 w-full" type="text" name="nom" id="" required>
                    </div>
                </div>

                <div class="flex gap-4 my-4">
                    <div class="w-32 text-right text-xs text-gray-600 pt-2">
                        Téléphone
                    </div>
                    <div class="flex-1">
                        <input value="@if( old('telephone') ) {{old('telephone')}} @endif" class="border-gray-400 border-2 rounded px-2 py-1 w-full" type="text" name="telephone">
                    </div>
                </div>

                <div class="flex gap-4 my-4">
                    <div class="w-32 text-right text-xs text-gray-600 pt-2">
                        Email
                    </div>
                    <div class="flex-1">
                        <input value="@if( old('email') ) {{old('email')}} @endif" class="border-gray-400 border-2 rounded px-2 py-1 w-full" type="email" name="email">
                    </div>
                </div>

                <div class="flex gap-4 my-4">
                    <div class="w-32 text-right text-xs text-gray-600 pt-2">
                        Password
                    </div>
                    <div class="flex-1">
                        <div class="w-full flex justify-between items-center">
                            <input placeholder="******" value="@if( old('password') ) {{old('password')}} @endif" class="border-gray-400 border-2 rounded px-2 py-1 w-full" type="password" name="password">
                            <button class="text-red-500 text-xs px-2 hover:text-gray-500 "><i class="fas fa-sync"></i></button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 my-4">
                    <div class="w-32 text-right text-xs text-gray-600 pt-2"></div>
                    <div class="xl:flex gap-2">
                        <div class="flex items-center gap-4 my-4">
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="is_active" class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                                <span class="text-gray-900 font-medium text-xs">Activé</span>
                            </label>
                        </div>
                    </div>
                </div>



                @include('tools.upload', ['folder'=>'users/' . "123456"])


                <div class="flex items-center gap-4 my-4 mt-8">
                    <div class="w-32 text-right text-xs text-gray-600"></div>
                    <div class="flex flex-1 gap-4">
                        <button type="submit" class="bg-green-400 text-white py-2 px-6 border border-green-500 rounded hover:bg-green-500">Enregistrer</button>
                    </div>
                </div>



            </div>
            <div class="w-1/3">

                droits

            </div>

        </form>
    </div>


</div>


@endsection
