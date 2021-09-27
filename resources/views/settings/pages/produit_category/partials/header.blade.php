<form id="idSearch" method="GET" action="{{route('produit_category.search')}}" class="flex items-center justify-between gap-4 py-1 bg-white bg-opacity-0">
    <div class="w-36 flex items-center gap-1">
        <input type="text" placeholder="البحث" name="text" id="text" class="border py-1 px-2 bg-white rounded">
        <div class="flex items-center gap-4">
            <select name="status" id="status" class="submit_me w-28 border rounded py-2 px-2 text-xs">
                <option selected value="1">Activé</option>
                <option value="0">Désactivé</option>
            </select>
        </div>
        <button class="bg-green-600 text-white py-1 px-4 rounded text-xl">إبحث</button>
    </div>

    <div class="count text-gray-600">
        Total : @if($categories) {{ $categories->count() }} @endif
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
