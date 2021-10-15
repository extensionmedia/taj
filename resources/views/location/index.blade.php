@extends('container.app')

@section('content')
    <div class="flex justify-between gap-2 items-center text-gray-50 tracking-tighter py-4 mt-2 mb-6 border-b border-gray-600 text-gray-200">
        <div class="flex gap-2 items-center">
            <a href="{{route('dashboard')}}" class="py-2 w-16 text-center rounded-full bg-green-600 bg-opacity-30 hover:bg-opacity-40 cursor-pointer">
                <i class="fas fa-arrow-left"></i>
            </a>
            <i class="fas fa-tshirt"></i>
            <div class="text-lg">
                Location
            </div>
        </div>
        <a href="{{route('location.create')}}" class="create bg-blue-400 py-2 px-3 text-white rounded border border-blue-500 text-sm hover:bg-blue-500">
            <i class="far fa-plus-square mr-1"></i>
            Ajouter
        </a>
    </div>

    <div class="relative">

        Location....

    </div>


@endsection
