


    <div class="flex items-center gap-4 my-4 mt-8">
        <div class="w-32 text-right text-xs text-gray-600"></div>
        <div class="relative">
            <div class="images rounded-lg h-40 w-40 overflow-hidden border-2 hover:border-blue-700 cursor-pointer">
                <img class="bg-cover h-40 w-40" src="{{asset('img/upload_image.jpg')}}" alt="">
            </div>
            <div class="reload hidden">reload</div>
            <input name="file" id="poster" type="file" class="hidden">
            <div class="new_image btn p-2 mr-2 text-gray-400 cursor-pointer hover:text-green-600 text-center">
                <i class="fas fa-cloud-upload-alt"></i> changer
            </div>
        </div>

    </div>


<script>
$(document).ready(function(){

    $(document).on('click', '.destroy_image', function(e){
        e.preventDefault();
        var that = $(this);
        new Swal({
            title: 'Supprimer?',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Supprimer`,
            denyButtonText: `Annuler`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:"{{ route('file.destroy') }}",
                    data:{
                        _token:     $('meta[name="csrf-token"]').attr('content'),
                        folder:     "{{$folder}}",
                        file:       that.data('file')
                    },
                    method: 'POST',
                    success: function(response){
                        $('.reload').trigger('click');
                    }
                });

            }
        });
    });

    $('.new_image').on('click', function(){
        $('#poster').trigger('click');
    });

    $('#poster').on('change', function(){
        var data = new FormData();
        jQuery.each(jQuery('#poster')[0].files, function(i, file) {
            data.append('file', file);
        });
        data.append( '_token', $('meta[name="csrf-token"]').attr('content') );
        data.append( 'folder', "{{$folder}}" );
        jQuery.ajax({
            url: "{{ route('file.upload') }}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                console.log(data.response);
                $('.reload').trigger('click');
            }
        });
    });

    $('.reload').on('click', function(){
        var loader = `
            <div class="loader absolute bottom-0 top-0 left-0 right-0 bg-red-100 bg-opacity-40">
                <div class="w-24 mx-auto mt-24 text-center">
                    <i class="fas fa-sync fa-spin"></i>
                </div>
            </div>
        `;
        $('.images').html(loader);
        var image = '';
        $.ajax({
            url:"{{ route('file.read') }}",
            data:{
                _token:     $('meta[name="csrf-token"]').attr('content'),
                folder:     "{{$folder}}"
            },
            method: 'POST',
            success: function(response){
                var empty = `<img class="bg-cover h-40 w-40" src="{{asset('img/upload_image.jpg')}}" alt="">`;

                for (let i = 0; i < response.length; i++) {
                    var image = `
                    <div class="relative">
                        <a href="` + response[i] + `">
                            <img class="border-2 bg-contain bg-center max-h-40 my-2 mr-4" src="` + response[i] + `">
                        </a>
                        <button data-file="` + response[i] + `" class="destroy_image absolute top-0 right-0 m-1 mr-2 bg-red-500 text-white rounded-full p-1 text-xs">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>`;
                    if(i==0){
                        $('.images').html(image);
                    }else{
                        $('.images').append(image);
                    }
                }
                if(response.length==0){
                    $('.images').html(empty);
                    $('.loader').remove();
                }
            }
        });
    });

    $('.reload').trigger('click');

    $('.images').magnificPopup({
        delegate: 'a', // child items selector, by clicking on it popup will open
        type: 'image',
        gallery: {
            enabled: true,
        },
        zoom: {
            enabled: true,
        }
        // other options
    });
});
</script>
