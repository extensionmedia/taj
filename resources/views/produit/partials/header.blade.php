<form id="idSearch" method="GET" action="{{route('produit.search')}}" class="flex items-center justify-between gap-4 py-1 bg-white bg-opacity-0">
    <div class="w-36 flex items-center gap-1">
        <input type="text" placeholder="البحث" name="text" id="text" class="border py-1 px-2 bg-white rounded">
        <button class="bg-green-600 text-white py-1 px-4 rounded text-xl">إبحث</button>
    </div>

    <div class="flex items-center gap-4">
        <select name="category" id="category" class="submit_me w-28 border rounded py-2 px-2 text-xs">
            <option value="-1">-- Catégories</option>
            @foreach ($produit_categories as $c)
                <option value="{{$c->id}}">{{ Str::upper( $c->produit_category )}} ({{ $c->produits->count() }})</option>
            @endforeach
        </select>
        <select name="marque" id="marque" class="submit_me w-28 border rounded py-2 px-2 text-xs">
            <option value="-1">-- Marques</option>
            @foreach ($produit_marques as $m)
                <option value="{{$m->id}}">{{ Str::upper( $m->produit_marque )}}</option>
            @endforeach
        </select>
        <select name="magasin" id="magasin" class="submit_me w-28 border rounded py-2 px-2 text-xs">
            <option value="-1">-- Magasins</option>
            @foreach ($magasins as $m)
                <option value="{{$m->id}}">{{ Str::upper( $m->magasin_name )}}</option>
            @endforeach
        </select>
        <select name="status" id="status" class="submit_me w-28 border rounded py-2 px-2 text-xs">
            @foreach ($statuses as $s)
                <option @if($s->id == 1) selected @endif value="{{$s->id}}">{{ Str::upper( $s->produit_status )}}</option>
            @endforeach
        </select>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#idSearch").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            $('.loading').removeClass('hidden');
            $.ajax({
                type: "GET",
                url: url,
                data: form.serialize(),
                success: function(data){
                    $('table tbody').html(data.trs);
                    $('.count').html('Total : ' + data.count);
                    $('.loading').addClass('hidden');
                }
            });
        });

        $(".submit_me").change(function(){
            $("#idSearch").trigger('submit');
        })
    });
</script>
