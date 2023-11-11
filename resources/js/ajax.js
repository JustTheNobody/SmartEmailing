$(document).ready(function() {
    //NEW ajax used in sort date/price for products
    //form data send
    $(document).on('click', '.ajax', function(event) {

        //$div = $($(this).data('div'));
        event.preventDefault();

        id = $(this).attr('id');
        $href = $(this).attr('href'); //complete URL
        element = 'pidTable';

        if(id == 'custom'){
            console.log('tete');
            inputs = $(this).closest('span').find('input');
            console.log(inputs);
        }


        $.get($href, {element: element}).done(function(response) { //append data
           if( element.length != '' ){

                    $html = $(response).find( '#' + element ).html();
                    $('#' + element).html($html);

            }

        });
    });
});