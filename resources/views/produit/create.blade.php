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
            إضافة منتوج جديد
        </div>
    </div>

    <div class="bg-white border-2 py-4 px-4 rounded mb-4 shadow">
        <div class="mx-auto w-5/6 bg-gray-50">
            <form id="form" method="POST" action="{{route('produit_category.store')}}" class="w-full flex">
                <div class="w-2/3">
                    @csrf
                    <div class="flex gap-4 my-4">
                        <div class="w-40 text-right text-xs text-gray-600 pt-2">
                            Catégorie
                        </div>
                        <div class="flex-1">
                            <input value="" class="is_exists border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="produit_category" id="" required>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 my-4">
                        <div class="w-40 text-right text-xs text-gray-600"></div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="status" class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                            <span class="text-gray-900 font-medium text-xs">Activé</span>
                        </label>
                    </div>
                    <div class="flex items-center gap-4 my-4">
                        <div class="w-40 text-right text-xs text-gray-600"></div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="is_default" class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                            <span class="text-gray-900 font-medium text-xs">Choix Par Défaut</span>
                        </label>
                    </div>


                    <div class="flex items-center gap-4 my-4 mt-8">
                        <div class="w-40 text-right text-xs text-gray-600"></div>
                        <div class="flex flex-1 gap-4">
                            <button type="submit" class="bg-green-400 text-white py-2 px-3 border border-green-500 rounded hover:bg-green-500">Enregistrer</button>
                        </div>
                    </div>
                </div>
                <div class="w-1/3">
                    @csrf
                    <div class="flex gap-4 my-4">
                        <div class="w-40 text-right text-xs text-gray-600 pt-2">
                            Catégorie
                        </div>
                        <div class="flex-1">
                            <input value="" class="is_exists border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="produit_category" id="" required>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 my-4">
                        <div class="w-40 text-right text-xs text-gray-600"></div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="status" class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                            <span class="text-gray-900 font-medium text-xs">Activé</span>
                        </label>
                    </div>
                    <div class="flex items-center gap-4 my-4">
                        <div class="w-40 text-right text-xs text-gray-600"></div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="is_default" class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                            <span class="text-gray-900 font-medium text-xs">Choix Par Défaut</span>
                        </label>
                    </div>


                    <div class="flex items-center gap-4 my-4 mt-8">
                        <div class="w-40 text-right text-xs text-gray-600"></div>
                        <div class="flex flex-1 gap-4">
                            <button type="submit" class="bg-green-400 text-white py-2 px-3 border border-green-500 rounded hover:bg-green-500">Enregistrer</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection
