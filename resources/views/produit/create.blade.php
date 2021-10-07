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
        <div class="w-full xl:mx-auto xl:w-5/6 bg-yellow-50">
            <form id="form" method="POST" action="{{route('produit_category.store')}}" class="w-full flex gap-4">
                <div class="w-2/3 py-2">
                    @csrf

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-48 text-right text-xs text-gray-600 pt-2">
                            Date
                        </div>
                        <div class="">
                            <input value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" class="border-gray-400 border-2 rounded px-2 py-1" type="date" name="date_reception" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-48 text-right text-xs text-gray-600 pt-2">
                            Code
                        </div>
                        <div class="">
                            <input value="" class="is_exists border-gray-400 border-2 rounded px-2 py-1" type="text" name="produit_category" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4">
                        <div class="min-w-48 w-48 text-right text-xs text-gray-600 pt-2">
                            Code à barre
                        </div>
                        <div class="flex gap-2">
                            <input value="" class="is_exists border-gray-400 border-2 rounded px-2 py-1" type="text" name="produit_category" id="" required>
                            <input value="" class="is_exists border-gray-400 border-2 rounded px-2 py-1" type="text" name="produit_category" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-48 text-right text-xs text-gray-600 pt-2">
                            Désignation
                        </div>
                        <div class="flex-1">
                            <input value="" class="border-gray-400 border-2 rounded px-2 py-1 w-full" type="text" name="produit_category" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-48 text-right text-xs text-gray-600 pt-2">
                            Taille
                        </div>
                        <div class="">
                            <input value="" class="border-gray-400 border-2 rounded px-2 py-1" type="text" name="produit_category" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-48 text-right text-xs text-gray-600 pt-2">
                            Quantité
                        </div>
                        <div class="">
                            <input value="" class="border-gray-400 border-2 rounded px-2 py-1" type="number" name="produit_category" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-48 text-right text-xs text-gray-600 pt-2">
                            Prix Achat
                        </div>
                        <div class="">
                            <input value="" class="border-gray-400 border-2 rounded px-2 py-1" type="number" name="produit_category" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-48 text-right text-xs text-gray-600 pt-2">
                            Prix Vente
                        </div>
                        <div class="">
                            <input value="" class="border-gray-400 border-2 rounded px-2 py-1" type="number" name="produit_category" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-48 text-right text-xs text-gray-600 pt-2">
                            Prix Location
                        </div>
                        <div class="">
                            <input value="" class="border-gray-400 border-2 rounded px-2 py-1" type="number" name="produit_category" id="" required>
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

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="status">Status</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1 bg-green-100" name="status" id="category">
                            <option value="-1"> -- status</option>
                            @foreach ($statuses as $s)
                                <option @if($s->is_default) selected  @endif value="{{$s->id}}">{{$s->produit_status}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="category">Catégorie</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1" name="category" id="category">
                            <option value="-1"> -- catégorie</option>
                            @foreach ($categories as $c)
                                <option value="{{$c->id}}">{{$c->produit_category}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="marque">Marque</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1" name="marque" id="marque">
                            <option value="-1"> -- marque</option>
                            @foreach ($marques as $m)
                                <option value="{{$m->id}}">{{Str::upper($m->produit_marque)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="color">Couleur</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1" name="color" id="marque">
                            <option value="-1"> -- couleur</option>
                            @foreach ($colors as $c)
                                <option value="{{$c->id}}">{{Str::upper($c->produit_color)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="type">Type</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1" name="type" id="marque">
                            <option value="-1"> -- type</option>
                            @foreach ($types as $t)
                                <option value="{{$t->id}}">{{Str::upper($t->produit_type)}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </form>
        </div>

    </div>

@endsection
