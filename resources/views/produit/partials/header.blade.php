<form method="GET" action="{{route('produit.search')}}" class="flex items-center justify-between gap-4 py-1 bg-white bg-opacity-0">
    <div class="w-36 flex items-center gap-2">
        <input type="text" placeholder="البحث" name="text" id="text" class="border py-1 px-2 bg-white rounded">
        <button class="bg-green-600 text-white py-1 px-2">go</button>
    </div>

    <div class="flex items-center gap-4">
        <select name="category" id="category" class="border rounded py-2 px-2 text-xs">
            <option value="-1">-- Catégories</option>
            @foreach ($produit_categories as $c)
                <option value="{{$c->id}}">{{ Str::upper( $c->produit_category )}}</option>
            @endforeach
        </select>
        <select name="category" id="category" class="border rounded py-2 px-2 text-xs">
            <option value="-1">-- Marques</option>
            @foreach ($produit_marques as $m)
                <option value="{{$m->id}}">{{ Str::upper( $m->produit_marque )}}</option>
            @endforeach
        </select>
        <select name="category" id="category" class="border rounded py-2 px-2 text-xs">
            <option value="-1">-- Magasins</option>
            @foreach ($magasins as $m)
                <option value="{{$m->id}}">{{ Str::upper( $m->magasin_name )}}</option>
            @endforeach
        </select>
    </div>
</form>
