/**
 * Created by lvntayn on 08/06/2017.
 */

$(function() {


    messageNotifications();
    setInterval(function(){

        messageNotifications();

    }, 100000);



});


function messageNotifications(){

    $.ajax({
        url: BASE_URL + '/direct-messages/notifications',
        type: "POST",
        timeout: 5000,
        contentType: false,
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': CSRF},
        success: function (response) {
            if (response.code == 200) {
                $('.direct-messages-notification').html(response.html);
            }
        },
        error: function () {

        }
    });

}