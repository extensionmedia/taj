
<div class="create_form">
    
</div>


<div class="flex justify-between items-center py-4 text-xl font-bold border-b">
    Produit Categories
    <button class="create bg-blue-400 py-2 px-3 text-white rounded border border-blue-500 text-sm hover:bg-blue-500">
        <i class="far fa-plus-square mr-1"></i>
        Ajouter
    </button>
</div>
<div class="w-full">
    @include('settings.pages.produit_category.partials.header')

    @include('settings.pages.produit_category.table.table')
</div>
<script>
    $(document).ready(function(){
        $('.create').click(function(){
            $('.loading').removeClass('hidden');
            $.get(
                "{{route('produit_category.create')}}",
                function(data){
                    $('.create_form').html(data);
                    $('.loading').addClass('hidden');
                }
            )
        });
    })
</script>
