<div class="py-4 text-xl font-bold border-b">
    Principal
</div>
<form id="form" method="POST" action="{{route('project.store')}}" class="w-full">
    @csrf
    <div class="flex items-center gap-4 my-4">
        <div class="w-40 text-right text-xs text-gray-600">
            Projet
        </div>
        <div class="flex-1">
            <input value="@if($project){{$project->project_name}}@endif" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="project_name" id="" required>
        </div>
    </div>
    <div class="flex items-center gap-4 my-4">
        <div class="w-40 text-right text-xs text-gray-600">
            Téléphone(s)
        </div>
        <div class="flex flex-1 gap-4">
            <input value="@if($project){{$project->telephone_1}}@endif" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="telephone_1" id="">
            <input value="@if($project){{$project->telephone_2}}@endif" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="telephone_2" id="">
        </div>
    </div>
    <div class="flex items-center gap-4 my-4">
        <div class="w-40 text-right text-xs text-gray-600">

        </div>
        <div class="flex flex-1 gap-4">
            <input value="@if($project){{$project->telephone_3}}@endif" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="telephone_3" id="">
            <input value="@if($project){{$project->telephone_4}}@endif" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="telephone_4" id="">
        </div>
    </div>
    <div class="flex items-center gap-4 my-4">
        <div class="w-40 text-right text-xs text-gray-600">
            Ville
        </div>
        <div class="flex flex-1 gap-4">
            <input value="@if($project){{$project->ville}}@endif" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="ville" id="">
        </div>
    </div>
    <div class="flex items-center gap-4 my-4">
        <div class="w-40 text-right text-xs text-gray-600">
            Adresse
        </div>
        <div class="flex flex-1 gap-4">
            <input value="@if($project){{$project->adresse}}@endif" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="adresse" id="">
        </div>
    </div>
    <div class="flex items-center gap-4 my-4">
        <div class="w-40 text-right text-xs text-gray-600">
            Email
        </div>
        <div class="flex flex-1 gap-4">
            <input value="@if($project){{$project->email}}@endif" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="email" name="email" id="">
        </div>
    </div>
    <div class="flex items-center gap-4 my-4">
        <div class="w-40 text-right text-xs text-gray-600">
            Site Web
        </div>
        <div class="flex flex-1 gap-4">
            <input value="@if($project){{$project->site_web}}@endif" class="border-gray-400 border-2 rounded w-full px-2 py-1" type="text" name="site_web" id="">
        </div>
    </div>


    <div class="flex items-center gap-4 my-4">
        <div class="w-40 text-right text-xs text-gray-600"></div>
        <div class="flex flex-1 gap-4">
            <button type="submit" class="bg-green-400 text-white py-2 px-3 border border-green-500 rounded hover:bg-green-500">Enregistrer</button>
        </div>
    </div>

</form>
<script>
    $(document).ready(function(){
        $('#form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var _type = form.attr('method');
            console.log(form.attr('action'));

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
                }
            });
        })
    })
</script>
