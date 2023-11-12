$(document).ready(function() {
    $('#custom').on('click', function(event){

        event.preventDefault();
        var errorFlag = false;
        id = $(this).attr('id');
        var dateTimeObject = {};
        inputs = $(this).closest('span').find('input');
        inputs.each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            if( !inputValue ){
                $('#messageTimeDate').html('please select ' + inputName);
                errorFlag = true;
            }

            dateTimeObject[inputName] = inputValue;
        });

        if (errorFlag) return;
        $('#messageTimeDate').html('');

        var combinedDateTimeString = dateTimeObject.day + ' ' + dateTimeObject.time;
        var dateObject = new Date(combinedDateTimeString);
        var timestamp = dateObject.getTime() / 1000;

        href = $(this).attr('href');

        $('a#'+id).attr('href',  href + timestamp);
        window.location.href = href + timestamp;
    });

    $('.mapLink').on('click', function(event){
        event.preventDefault();
        lat = $(this).data('lat');
        lon = $(this).data('lon');
        src = $('#mapFrame').attr('src');
        src = src.replace(/(\?q=)[^&]+(&hl=)/, '$1' + lat + ',' + lon + '$2');

        $('#mapFrame').attr('src', src);

        UIkit.modal('#map').show();
    });

    $('#deleteData').on('click', function (event) {
        event.preventDefault();

        var deleteUrl = $(this).attr('href');
        var isConfirmed = confirm('Are you sure you want to delete this item?');

        if (isConfirmed) {
            window.location.href = deleteUrl;
        }
    });
});

function internalMessage(statu, message) {
    if( message ){
        if (isJson(message)) {
            var obj = JSON.parse(message);
            $.each(obj, function(key, value) {

                getMessageWeight( key, value );
            });
        } else {
            getMessageWeight(statu, message );
        }
    }
}

function getMessageWeight( key, message )
{
    if (key == 'success') {
        ico = '<i class="fa fa-check uk-text-success uk-margin-right" aria-hidden="true"></i>'
    } else if (key == 'fail') {
        ico = '<i class="fa fa-times uk-text-danger uk-margin-right" aria-hidden="true"></i>'
    } else {
        ico = '<i class="fa fa-info uk-text-primary uk-margin-right" aria-hidden="true"></i>'
    }
    UIkit.notification({ message: ico + '<span class="uk-text-bolder uk-text-large">' + message.charAt(0).toUpperCase() + message.slice(1) + '</span>', status: key });;
}