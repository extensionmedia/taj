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


    <div class="relative border rounded-lg overflow-hidden bg-gray-100 shadow">
        <div class="border-b py-4 px-4 font-bold text-lg bg-gray-50">
            (5) Utilisateurs Disponibles
        </div>
        <div class="grid grid-cols-4 md:grid-cols-8 gap-4 w-full py-8 px-4">
            @for ($i = 0; $i < 5; $i++)
                <div class="hover:bg-white hover:bg-opacity-20">
                    <div class="relative w-32 h-32 mx-auto rounded-full overflow-hidden border border-white shadow">
                        @if($i==0)
                            <img class="inline object-cover w-32 h-32 rounded-full" src="https://image.freepik.com/free-photo/close-up-attractive-man-black-suit-smiling-amazed-looking-advertisement-standing-white-background_1258-66338.jpg" alt="">  
                            <div class="absolute top-0 right-0 h-4 w-4 rounded-full bg-green-500 m-4"></div>  
                            @elseif($i==1)
                            <img class="inline object-cover w-32 h-32 rounded-full" src="https://image.freepik.com/free-photo/business-finance-people-concept-satisfied-asian-businessman-with-teeth-braces-showing-thumbs-up-office-worker-recommend-product-compliment-good-work-white-background_1258-57161.jpg" alt="">
                            <div class="absolute top-0 right-0 h-4 w-4 rounded-full bg-green-500 m-4"></div>  
                            @else
                            <img class="inline object-cover w-32 h-32 rounded-full" src="https://image.freepik.com/free-photo/christmas-concept-handsome-businessman-wear-santa-hat-showing-thump-up-white-isolated-wall_1258-44643.jpg" alt="">
                            <div class="absolute top-0 right-0 h-4 w-4 rounded-full bg-red-500 m-4"></div>  
                        @endif  
                    </div>
                    <div class="text-center py-4 text-green-400">
                        User
                    </div>
                </div>
            @endfor            
        </div>

    </div>
    <script>
        $(document).ready(function(){

        })
    </script>
@endsection
