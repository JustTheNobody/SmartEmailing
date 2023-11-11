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
});
