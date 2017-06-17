/**
 * Created by lvntayn on 03/06/2017.
 */



function findMyLocation(){
    var form_name = '#form-profile-information';

    $('.loading-page').show();
    location_finder = "not-running";
    found_location = "";

    getLocation();


    var timer =setInterval(function(){

        if (location_finder == 'not-found'){
            clearInterval(timer);
            $('.loading-page').hide();
        }else if (location_finder == 'found'){

            $.ajax({
                url: BASE_URL+'/find-my-location',
                type: "GET",
                timeout: 5000,
                data: "latitude="+found_location.latitude+"&longitude="+found_location.longitude,
                contentType: false,
                cache: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': CSRF},
                success: function(response){
                    if (response.code == 200){
                        $(form_name+' .location-input').val(response.address);
                        $(form_name+' .map-info').val(response.map_info);
                        $(form_name+' .map-place').html('<div id="map-render"></div>');
                        var map = new GMaps({
                            el: '#map-render',
                            lat: found_location.latitude,
                            lng: found_location.longitude,
                        });
                        map.addMarker({
                            lat: found_location.latitude,
                            lng: found_location.longitude,
                            infoWindow: {
                                content: response.address
                            }
                        });
                    }else{
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html('Something went wrong!');
                    }
                },
                error: function(){
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html('Something went wrong!');
                }
            });

            clearInterval(timer);
            $('.loading-page').hide();
        }

    }, 1);
}


function saveInformation(){
    var form_name = '#form-profile-information';

    $('.loading-page').show();

    var data = new FormData();
    data.append('information', JSON.stringify(makeSerializable(form_name).serializeJSON()));




    $.ajax({
        url: REQUEST_URL+'/save/information',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function(response){
            if (response.code == 200){
                window.location.reload(true);
            }else{
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html(response.message);
                $('.loading-page').hide();
            }
        },
        error: function(){
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
            $('.loading-page').hide();
        }
    });

}



function uploadProfilePhoto(){
    var div_name = '.profile-image';
    var form_name = '#form-upload-profile-photo';
    $(form_name+' input').click();
    $(form_name+' input').change(function (){

        $(div_name+ ' .loading-image').show();
        $(div_name+ ' .change-image').hide();

        var data = new FormData();
        data.append('photo', JSON.stringify(makeSerializable(form_name).serializeJSON()));


        var file_inputs = document.querySelectorAll('.profile_photo_input');
        $(file_inputs).each(function(index, input) {
            data.append('image', input.files[0]);
        });


        $.ajax({
            url: REQUEST_URL+'/upload/profile-photo',
            type: "POST",
            timeout: 5000,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function(response){
                if (response.code == 200){
                    $(div_name+ ' .image-profile').attr('src', response.image_thumb);
                    $(div_name+ ' .image-profile').parent().attr('href', response.image_big);
                    $(div_name+ ' .loading-image').hide();
                }else{
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html(response.message);
                    $(div_name+ ' .loading-image').hide();
                }
            },
            error: function(){
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
                $(div_name+ ' .loading-image').hide();
            }
        });
    });
}

function uploadCover(){
    var div_name = '.cover';
    var form_name = '#form-upload-cover';
    $(form_name+' input').click();
    $(form_name+' input').change(function (){

        $(div_name+ ' .loading-cover').show();

        var data = new FormData();
        data.append('photo', JSON.stringify(makeSerializable(form_name).serializeJSON()));


        var file_inputs = document.querySelectorAll('.cover_input');
        $(file_inputs).each(function(index, input) {
            data.append('image', input.files[0]);
        });


        $.ajax({
            url: REQUEST_URL+'/upload/cover',
            type: "POST",
            timeout: 5000,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function(response){
                if (response.code == 200){
                    $(div_name).css('background-image', 'url('+response.image+')');
                    $(div_name+ ' .loading-cover').hide();
                    $(div_name).removeClass('no-cover');
                }else{
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html(response.message);
                    $(div_name+ ' .loading-cover').hide();
                }
            },
            error: function(){
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
                $(div_name+ ' .loading-cover').hide();
            }
        });
    });
}
