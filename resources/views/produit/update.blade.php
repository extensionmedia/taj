@extends('container.app')

@section('content')
    <div class="flex gap-2 items-center text-gray-50 tracking-tighter py-4 mt-2 mb-6 border-b border-gray-600 text-gray-200">
        <a href="{{route('produit.list')}}" class="py-2 w-16 text-center rounded-full bg-green-600 bg-opacity-30 hover:bg-opacity-40 cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </a>
        <i class="fas fa-tshirt"></i>
        <div class="text-lg">
            تغيير و تخصيص منتوج
        </div>
    </div>

    <div class="bg-white border-2 py-4 px-4 rounded mb-4 shadow">
        <div class="py-6 text-center font-bold text-2xl border-b bg-gray-50 -mx-4 -mt-4">
            تغيير و تخصيص منتوج
            <div class="text-xs text-gray-400 text-center">
                {{$produit->UID}}
            </div>
        </div>
        <div class="w-full xl:mx-auto 2xl:w-5/6 py-8">
            <form id="form" method="POST" action="{{route('produit.update', $produit)}}" class="w-full flex gap-4">
                <div class="w-2/3 py-2 border-r pr-4">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Date
                        </div>
                        <div class="">
                            <input value="{{$produit->date_reception}}" class="border-gray-400 border-2 rounded px-2 py-1" type="date" name="date_reception" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Code
                        </div>
                        <div class="">
                            <input value="{{$produit->code}}" class="is_exists border-gray-400 border-2 rounded px-2 py-1 @error('code') bg-red-100 @enderror" type="text" name="code" id="">
                            @error('code')
                                <div class="text-red-500 text-xs">Code Daroooori</div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-4 my-4">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Barcode
                        </div>
                        <div class="xl:flex gap-2">
                            <input value="{{$produit->barcode}}" class="is_exists border-gray-400 border-2 rounded px-2 py-1 xl:w-48" type="text" name="barcode" id="">
                        </div>
                    </div>
                    <div class="flex gap-4 my-4">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Barcode 2
                        </div>
                        <div class="xl:flex gap-2">
                            <input value="{{$produit->barcode_2}}" class="is_exists border-gray-400 border-2 rounded px-2 py-1 xl:w-48" type="text" name="barcode_2" id="">
                        </div>
                    </div>
                    <div class="flex gap-4 my-4">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Désignation
                        </div>
                        <div class="flex-1">
                            <input value="{{$produit->libelle}}" class="border-gray-400 border-2 rounded px-2 py-1 w-full" type="text" name="libelle" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Taille
                        </div>
                        <div class="">
                            <input value="{{$produit->taille}}" class="border-gray-400 border-2 rounded px-2 py-1" type="text" name="taille" id="">
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Quantité
                        </div>
                        <div class="">
                            <input value="{{$produit->qte}}" class="border-gray-400 border-2 rounded px-2 py-1" type="number" name="qte" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Prix Achat
                        </div>
                        <div class="">
                            <input value="{{$produit->prix_achat}}" class="border-gray-400 border-2 rounded px-2 py-1 text-right font-bold" type="number" name="prix_achat" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Fournisseur
                        </div>
                        <div class="flex-1">
                            <input value="" class="border-gray-400 border-2 rounded px-2 py-1 w-full" type="text" name="fournisseur">
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Prix Vente
                        </div>
                        <div class="">
                            <input value="{{$produit->prix_vente}}" class="border-gray-400 border-2 rounded px-2 py-1 text-right font-bold" type="number" name="prix_vente" id="" required>
                        </div>
                    </div>

                    <div class="flex gap-4 my-4 w-full">
                        <div class="w-32 text-right text-xs text-gray-600 pt-2">
                            Prix Location
                        </div>
                        <div class="">
                            <input value="{{$produit->prix_location}}" class="border-gray-400 border-2 rounded px-2 py-1 text-right font-bold" type="number" name="prix_location" id="" required>
                        </div>
                    </div>

                    @include('tools.upload', ['folder'=>'produits/' . $produit->UID])


                    <div class="flex items-center gap-4 my-4 mt-8">
                        <div class="w-32 text-right text-xs text-gray-600"></div>
                        <div class="flex flex-1 gap-4">
                            <button type="submit" class="bg-green-400 text-white py-2 px-6 border border-green-500 rounded hover:bg-green-500">Enregistrer</button>
                        </div>
                    </div>


                </div>
                <div class="w-1/3">

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="status">Status</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1 bg-green-100" name="produit_status_id">
                            @foreach ($statuses as $s)
                                @if ($produit->produit_status_id == $s->id)
                                    <option selected value="{{$s->id}}">{{$s->produit_status}}</option>
                                @else
                                    <option value="{{$s->id}}">{{$s->produit_status}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="produit_category_id">Catégorie</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1" name="produit_category_id">
                            <option value="-1"> -- catégorie</option>
                            @foreach ($categories as $c)
                                @if ($produit->produit_category_id == $c->id)
                                    <option selected value="{{$c->id}}">{{$c->produit_category}}</option>
                                @else
                                    <option value="{{$c->id}}">{{$c->produit_category}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="produit_marque_id">Marque</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1" name="produit_marque_id">
                            <option value="-1"> -- marque</option>
                            @foreach ($marques as $m)
                                @if ($produit->produit_marque_id == $c->id)
                                    <option selected value="{{$m->id}}">{{Str::upper($m->produit_marque)}}</option>
                                @else
                                    <option value="{{$m->id}}">{{Str::upper($m->produit_marque)}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="produit_color_id">Couleur</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1" name="produit_color_id">
                            <option value="-1"> -- couleur</option>
                            @foreach ($colors as $c)
                                @if ($produit->produit_color_id == $c->id)
                                    <option selected value="{{$c->id}}">{{Str::upper($c->produit_color)}}</option>
                                @else
                                    <option value="{{$c->id}}">{{Str::upper($c->produit_color)}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs text-gray-600" for="produit_type_id">Type</label>
                        <select class="border-gray-400 border-2 rounded w-full px-2 py-1" name="produit_type_id">
                            @foreach ($types as $t)
                                @if ($produit->produit_type_id == $c->id)
                                <option selected value="{{$t->id}}">{{Str::upper($t->produit_type)}}</option>
                                @else
                                    <option value="{{$t->id}}">{{Str::upper($t->produit_type)}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="text-green-500 font-bold text-xl pt-4 pb-2">
                        Magasins
                    </div>
                    @error('magasin')
                        <div class="text-red-500 text-xs">Magasin Daroooori</div>
                    @enderror
                    @foreach ($magasins as $m)
                        @php
                            $checked = '';
                        @endphp
                        <div class="flex items-center gap-4 my-4">
                            <label class="flex items-center space-x-3">
                                @if($produit->magasins())
                                    @foreach ($produit->magasins as $magasin)
                                        @if ($magasin->magasin_id == $m->id)
                                            @php
                                                $checked = 'checked';
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                                <input {{$checked}} type="checkbox" name="magasin[]" value="{{$m->id}}" class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">

                                <span class="text-gray-900 font-medium text-xs">{{$m->magasin_name}}</span>
                            </label>
                        </div>
                    @endforeach

                </div>

            </form>
        </div>


    </div>

@endsection
