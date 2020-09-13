$(function() {
    //Start of top nav bar notification
    function notification() {
        $.ajax({
            url: '/notification',
            type: 'GET',
            success: function (data) {
                if (data) {
                    $('#notification').html(data);
                }
            },
            complete: function () {
                // Schedule the next request when the current one's complete
                setTimeout(notification, 8000);
            }
        });
    }
    //End
    notification();
});