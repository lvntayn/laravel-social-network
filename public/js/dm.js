/**
 * Created by lvntayn on 08/06/2017.
 */


$(function() {



    fetchPeopleList();
    setInterval(function(){

        fetchPeopleList();
        fetchNewMessages();

    }, 1000);
    setInterval(function(){

        var id = $('.chat input[name=chat_friend_id]').val();
        $('.dm .friends-list .friend').removeClass('active');
        $('.dm .friends-list #chat-people-list-'+id).addClass('active');

    }, 1);



});


function searchUserList() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("modal-search");
    filter = input.value.toUpperCase();
    table = document.getElementById("modal-table");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }


}

function fetchPeopleList(){

    $.ajax({
        url: BASE_URL + '/direct-messages/people-list',
        type: "POST",
        timeout: 5000,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                $('.dm .friends-list .alert').remove();
                $('.dm .friends-list').html(response.html);
                if (initial_dm == 0) {
                    showFirstChat();
                    initial_dm = 1;
                }
            }
        },
        error: function () {

        }
    });

}

function fetchNewMessages(){

    var id = $('.chat input[name=chat_friend_id]').val();

    if (id > 0){


        var data = new FormData();
        data.append('id', id);

        $.ajax({
            url: BASE_URL + '/direct-messages/new-messages',
            type: "POST",
            timeout: 5000,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function (response) {
                if (response.code == 200) {
                    if (response.find == 1) {
                        $('.dm .chat .message-list .alert').remove();
                        $('.dm .chat .message-list').append(response.html);
                        $(".dm .chat .message-list").animate({scrollTop: $('.dm .chat .message-list').prop("scrollHeight")}, 1000);
                    }
                }
            },
            error: function () {

            }
        });
    }

}

function showFirstChat(){
    var id = $('.dm input[name=people-list-first-id]').val();
    console.log(id);
    if (id > 0){
        showChat(id);
    }
}


function showChat(id){

    var data = new FormData();
    data.append('id', id);

    $.ajax({
        url: BASE_URL + '/direct-messages/chat',
        type: "POST",
        timeout: 5000,
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                $('.dm .chat').html(response.html);
                $('#userListModal').modal('hide');
                $(".dm .chat .message-list").animate({ scrollTop: $('.dm .chat .message-list').prop("scrollHeight")}, 0);
            }else{
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


function sendMessage(e){

    if (e.which == 13 && ! e.shiftKey) {
        var id = $('#form-message-write input').val();
        var message = $('#form-message-write textarea').val();

        if (message.trim() != '') {
            var data = new FormData();
            data.append('id', id);
            data.append('message', message);

            $.ajax({
                url: BASE_URL + '/direct-messages/send',
                type: "POST",
                timeout: 5000,
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': CSRF},
                success: function (response) {
                    if (response.code == 200) {
                        $('.dm .chat .message-list .alert').remove();
                        $('#form-message-write textarea').val("");
                        $('.dm .chat .message-list').append(response.html);
                        $(".dm .chat .message-list").animate({ scrollTop: $('.dm .chat .message-list').prop("scrollHeight")}, 1000);
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
        return false;
    }
}

function deleteChat(id){

    BootstrapDialog.show({
        title: 'Chat Delete!',
        message: 'Are you sure to delete chat ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);


                $.ajax({
                    url: BASE_URL+'/direct-messages/delete-chat',
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
                            $('.dm .chat').html(" <p style='padding: 20px;'> Chat deleted! </p> ");
                            $('#chat-people-list-'+id).remove();
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

function deleteMessage(id){

    BootstrapDialog.show({
        title: 'Message Delete!',
        message: 'Are you sure to delete message ?',
        buttons: [{
            label: "Yes, I'm Sure!",
            cssClass: 'btn-danger',
            action: function(dialog) {

                var data = new FormData();
                data.append('id', id);


                $.ajax({
                    url: BASE_URL+'/direct-messages/delete-message',
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
                            $('.dm .chat #chat-message-'+id).remove();
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