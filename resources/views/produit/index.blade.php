@extends('container.app')

@section('includes')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="flex gap-2 items-center text-gray-50 tracking-tighter py-4 mt-2 mb-6 border-b border-gray-600 text-gray-200">
        <a href="{{route('dashboard')}}" class="py-2 w-16 text-center rounded-full bg-green-600 bg-opacity-30 hover:bg-opacity-40 cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </a>
        <i class="fas fa-tshirt"></i>
        <div class="text-lg">
            المنتجات
        </div>
    </div>

    @include('produit.partials.header')

    @include('produit.table.table')

    <script>
        $(document).ready(function(){
            alert('ready');
        });
    </script>


@endsection
