@extends('container.app')

@section('includes')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="flex gap-2 items-center text-gray-50 tracking-tighter py-4 mt-2 text-gray-200">
        <a href="{{route('dashboard')}}" class="py-2 w-16 text-center rounded-full bg-green-600 bg-opacity-30 hover:bg-opacity-40 cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </a>
        <i class="fas fa-wrench"></i>
        <div class="text-lg">
            الخصائص
        </div>
    </div>

    <div class="relative flex border rounded-lg overflow-hidden bg-gray-100 shadow">

        <div class="loading hidden absolute top-0 left-0 right-0 bottom-0 bg-gray-800 bg-opacity-20">
            <div class="w-32 mx-auto mt-32 text-4xl text-center">
                <i class="fas fa-spinner fa-spin"></i>
                <div class="text-xl py-2">جاري التسجيل</div>
            </div>
        </div>

        <div class="w-52 border-r border-gray-200 py-4">
            <div class="py-4 text-xl font-bold pl-2">
                Liens
            </div>
            <ul class="links">
                <li data-page="project" class="py-2 px-2 pl-4 border-b text-sm font-bold bg-gray-200 shadow-lg">
                    <i class="fas fa-caret-right"></i>
                    Principal
                </li>
                <li data-page="produit_category" class="py-2 px-2 hover:bg-gray-50 cursor-pointer border-b text-sm">
                    <i class="fas fa-caret-right"></i>
                    Produit Catégorie
                </li>
                <li data-page="produit_marque" class="py-2 px-2 hover:bg-gray-50 cursor-pointer border-b text-sm">
                    <i class="fas fa-caret-right"></i>
                    Produit Marques
                </li>
                <li data-page="produit_color" class="py-2 px-2 hover:bg-gray-50 cursor-pointer border-b text-sm">
                    <i class="fas fa-caret-right"></i>
                    Produit Couleur
                </li>
                <li data-page="produit_status" class="py-2 px-2 hover:bg-gray-50 cursor-pointer border-b text-sm">
                    <i class="fas fa-caret-right"></i>
                    Produit Status
                </li>
                <li data-page="produit_type" class="py-2 px-2 hover:bg-gray-50 cursor-pointer border-b text-sm">
                    <i class="fas fa-caret-right"></i>
                    Produit Types
                </li>
            </ul>
        </div>
        <div class="render flex-1 bg-white bg-opacity-80 px-8 py-4">
            @include('settings.pages.project.index')

        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('ul.links li').click(function(){

                $('ul.links li').removeClass('font-bold bg-gray-200 shadow-lg pl-4')
                $('ul.links li').addClass('hover:bg-gray-50 cursor-pointer')
                $(this).removeClass('hover:bg-gray-50 cursor-pointer')
                $(this).addClass('font-bold bg-gray-200 shadow-lg pl-4 ')

                var page = $(this).data('page');
                $('.loading').removeClass('hidden');
                $.ajax({
                    url:        "/settings/render/"+page,
                    success:    function(data){
                        $('.render').html(data);
                        $('.loading').addClass('hidden');
                    },
                    error: function(data){
                        $('.loading').addClass('hidden');
                    }
                });
            });
        })
    </script>
@endsection
