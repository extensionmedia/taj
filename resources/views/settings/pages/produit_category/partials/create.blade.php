
<div class="flex items-center justify-between">
    <div class="text-xl font-bold py-4">Ajouter une Catégorie</div>
    <button class="close bg-gray-400 py-2 px-3 text-white rounded border border-gray-500 text-sm hover:bg-gray-500">
        <i class="far fa-window-close mr-1"></i>
        Quitter
    </button>
</div>
<div class="border py-4 px-4 rounded mb-4 shadow bg-gray-50">
    <form class="" id="form" method="POST" action="{{route('produit_category.store')}}" class="w-full">
        @csrf
        <div class="flex items-center gap-4 my-4">
            <div class="w-40 text-right text-xs text-gray-600">
                Catégorie 
            </div>
            <div class="flex-1">
                <input value="" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="produit_category" id="" required>
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
    </form>
</div>

<script>
    $(document).ready(function(){
        $('.close').click(function(){
            $('.loading').removeClass('hidden');
            $('.create_form').html("");
            $('.loading').addClass('hidden');
        });

        $('#form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var _type = form.attr('method');

            $('.loading').removeClass('hidden');
            $.ajax({
                type: _type,
                url: url,
                data: form.serialize(),
                success: function(data){
                    $('.loading').addClass('hidden');
                    $('body').append(`
                    <div class="request_response fixed top-0 left-0 right-0 py-16">
                        <div class="w-32 py-2 bg-green-700 rounded mx-auto text-white shadow text-center">
                            تم التسجيل بنجاح
                        </div>
                    </div>
                    `);
                    var timer = setTimeout(function(){
                        $('.request_response').remove();
                    }, 2500);
                    console.log(data);
                },
                error: function(data){
                    $('.loading').addClass('hidden');
                    $('body').append(`
                    <div class="request_response fixed top-0 left-0 right-0 py-16">
                        <div class="w-32 py-2 bg-red-700 rounded mx-auto text-white shadow text-center">
                            وقع خطء أثناء التسجيل
                        </div>
                    </div>
                    `);
                    var timer = setTimeout(function(){
                        $('.request_response').remove();
                    }, 2500);
                    console.log(data.responseText);
                }
            });

        });
    })
</script>