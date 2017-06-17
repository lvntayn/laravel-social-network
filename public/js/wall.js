/**
 * Created by lvntayn on 04/06/2017.
 */
$(function() {
    if (WALL_ACTIVE) {
        $('.new-post-box textarea, .panel-post .post-write-comment textarea').each(function () {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        $(window).scroll(function () {
            if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                fetchForOlderPosts();
            }
        });




        setInterval(function(){

            fetchForNewPosts();

        }, 40000);

    }

});


function uploadPostImage(){
    var form_name = '#form-new-post';
    $(form_name+' .image-input').click();
}

function previewPostImage(input){
    var form_name = '#form-new-post';
    $(form_name + ' .loading-post').show();
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(form_name + ' .image-area img').attr('src', e.target.result);
            $(form_name + ' .image-area').show();
        };

        reader.readAsDataURL(input.files[0]);
    }
    $(form_name + ' .loading-post').hide();
}

function removePostImage(){
    var form_name = '#form-new-post';
    $(form_name + ' .image-area img').attr('src', " ");
    $(form_name + ' .image-area').hide();
    resetFile($(form_name + ' .image-input'));
}

function cleanPostForm(){
    var form_name = '#form-new-post';
    $(form_name + ' textarea').val('');
    removePostImage();
}

function newPost(){
    var form_name = '#form-new-post';

    $(form_name + ' .loading-post').show();

    var data = new FormData();
    data.append('data', JSON.stringify(makeSerializable(form_name).serializeJSON()));

    var file_inputs = document.querySelectorAll('.image-input');
    $(file_inputs).each(function(index, input) {
        data.append('image', input.files[0]);
    });

    $.ajax({
        url: BASE_URL+'/posts/new',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function(response){
            if (response.code == 200){
                cleanPostForm();
                $(form_name + ' .loading-post').hide();
                $('.post-list-top-loading').show();
                fetchForNewPosts();
            }else{
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html(response.message);
                $(form_name + ' .loading-post').hide();
            }
        },
        error: function(){
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
            $(form_name + ' .loading-post').hide();
        }
    });

}

var fetch_end = false;
var count_empty_query = 0;
function fetchPost(wall_type, list_type, optional_id, limit, post_min_id, post_max_id, location){
    if (!fetch_end) {
        fetch_end = true;
        $.ajax({
            url: BASE_URL + '/posts/list',
            type: "GET",
            timeout: 5000,
            data: "wall_type=" + wall_type + "&list_type=" + list_type + "&optional_id=" + optional_id + "&limit=" + limit + "&post_min_id=" + post_min_id + "&post_max_id=" + post_max_id + "&div_location=" + location,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function (render) {
                if (render != "") {
                    $('.post-list .post_data_filter_' + location).remove();
                    if (location == 'bottom') {
                        $('.post-list').append(render);
                    } else if (location == 'top') {
                        $('.post-list').prepend(render);
                    } else {
                        $('.post-list').html(render);
                    }
                }else{
                    if (location == 'bottom') {
                        count_empty_query = count_empty_query + 1;
                    }
                }
                $('.post-list-top-loading').hide();
                $('.post-list-bottom-loading').hide();
                fetch_end = false;
            },
            error: function () {
                /*
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong when loading your wall!');*/
                $('.post-list-top-loading').hide();
                $('.post-list-bottom-loading').hide();
                fetch_end = false;
            }
        });
    }
}

function fetchForNewPosts(){
    var wall_type = $('.post-list .post_data_filter_top input[name=wall_type]').val();
    var list_type = $('.post-list .post_data_filter_top input[name=list_type]').val();
    var optional_id = $('.post-list .post_data_filter_top input[name=optional_id]').val();
    var limit = 150000;
    var post_min_id = -1;
    var post_max_id = $('.post-list .post_data_filter_top input[name=post_max_id]').val();
    if (post_max_id > 0 || $('.panel-post').length == 0) {
        fetchPost(wall_type, list_type, optional_id, limit, post_min_id, post_max_id, 'top');
    }
}

function fetchForOlderPosts(){
    var wall_type = $('.post-list .post_data_filter_bottom input[name=wall_type]').val();
    var list_type = $('.post-list .post_data_filter_bottom input[name=list_type]').val();
    var optional_id = $('.post-list .post_data_filter_bottom input[name=optional_id]').val();
    var limit = 5;
    var post_min_id = $('.post-list .post_data_filter_bottom input[name=post_min_id]').val();
    var post_max_id = -1;
    if (post_min_id > 1 && count_empty_query < 5) {
        $('.post-list-bottom-loading').show();
        fetchPost(wall_type, list_type, optional_id, limit, post_min_id, post_max_id, 'bottom');

    }
}


function deletePost(id){

    BootstrapDialog.show({
        title: 'Post Delete!',
        message: 'Are you sure to delete post ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);


                $.ajax({
                    url: BASE_URL+'/posts/delete',
                    type: "POST",
                    timeout: 5000,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        dialog.close();
                        if (response.code == 200){
                            $('#panel-post-'+id).html("Post deleted!");
                        }else{
                            $('#errorMessageModal').modal('show');
                            $('#errorMessageModal #errors').html('Something went wrong!');
                        }
                    },
                    error: function(){
                        dialog.close();
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html('Something went wrong!');
                    }
                });
            }
        }, {
            label: 'No!',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
}


function likePost(id){

    var data = new FormData();
    data.append('id', id);

    $.ajax({
        url: BASE_URL+'/posts/like',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function(response){
            if (response.code == 200){
                if (response.type == 'like'){
                    $('#panel-post-'+id+' .like-text span').html('Unlike!');
                    $('#panel-post-'+id+' .like-text i').removeClass('fa-heart-o').addClass('fa-heart');
                }else{
                    $('#panel-post-'+id+' .like-text span').html('Like!');
                    $('#panel-post-'+id+' .like-text i').removeClass('fa-heart').addClass('fa-heart-o');
                }
                if (response.like_count > 1){
                    $('#panel-post-'+id+' .all_likes span').html(response.like_count+' likes');
                }else{
                    $('#panel-post-'+id+' .all_likes span').html(response.like_count+' like');
                }
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
}

function submitComment(id){

    var data = new FormData();
    data.append('id', id);
    var comment = $('#panel-post-'+id+' #form-new-comment textarea').val();
    data.append('comment', comment);

    if (comment.trim() == ''){
        $('#errorMessageModal').modal('show');
        $('#errorMessageModal #errors').html('Please write comment!');
    }else {
        $.ajax({
            url: BASE_URL + '/posts/comment',
            type: "POST",
            timeout: 5000,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function (response) {
                if (response.code == 200) {
                    $('#panel-post-'+id+' #form-new-comment textarea').val("");
                    $('#panel-post-'+id+' .comments-title').html(response.comments_title);
                    $('#panel-post-'+id+' .post-comments').append(response.comment);
                } else {
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html('Something went wrong!');
                }
            },
            error: function () {
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
            }
        });
    }
}


function removeComment(id, post_id){

    BootstrapDialog.show({
        title: 'Comment Delete!',
        message: 'Are you sure to delete comment ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);


                $.ajax({
                    url: BASE_URL+'/posts/comments/delete',
                    type: "POST",
                    timeout: 5000,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {'X-CSRF-TOKEN': CSRF},
                    success: function(response){
                        dialog.close();
                        if (response.code == 200){
                            $('#post-comment-'+id+' .panel-body').html("<p><small>Comment deleted!</small></p>");
                            $('#panel-post-'+post_id+' .comments-title').html(response.comments_title);
                        }else{
                            $('#errorMessageModal').modal('show');
                            $('#errorMessageModal #errors').html('Something went wrong!');
                        }
                    },
                    error: function(){
                        dialog.close();
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html('Something went wrong!');
                    }
                });
            }
        }, {
            label: 'No!',
            action: function(dialog) {
                dialog.close();
            }
        }]
    });
}



function showLikes(id){

    var data = new FormData();
    data.append('id', id);

    $.ajax({
        url: BASE_URL + '/posts/likes',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                $('#likeListModal .user_list').html(response.likes);
                $('#likeListModal').modal('show');
            } else {
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html('Something went wrong!');
            }
        },
        error: function () {
            $('#errorMessageModal').modal('show');
            $('#errorMessageModal #errors').html('Something went wrong!');
        }
    });
}
