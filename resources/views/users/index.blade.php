@extends('container.app')

@section('includes')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <div class="flex gap-2 items-center text-gray-50 tracking-tighter py-4 mt-2 text-gray-200">
            <a href="{{route('dashboard')}}" class="py-2 w-16 text-center rounded-full bg-green-600 bg-opacity-30 hover:bg-opacity-40 cursor-pointer">
                <i class="fas fa-arrow-left"></i>
            </a>
            <i class="fas fa-user-friends"></i>
            <div class="text-lg">
                المستخدمون
            </div>
        </div>
        <button class="create bg-blue-400 py-2 px-3 text-white rounded border border-blue-500 text-sm hover:bg-blue-500">
            <i class="far fa-plus-square mr-1"></i>
            Ajouter
        </button>
    </div>


    <div class="relative flex border rounded-lg overflow-hidden bg-gray-100 shadow">
        add
    </div>
    <script>
        $(document).ready(function(){

        })
    </script>
@endsection
