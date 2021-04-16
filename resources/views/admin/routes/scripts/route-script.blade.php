<script>
    $(document).ready(function(){

        function getTotalTimeTravel()
        {
            var value = 0;
            $('input[name="travel_time[]"]').each(function(){
                value += +$(this).val();
            })
            $('#total').val(value);
        }

        function changeRouteButtons()
        {
            var size = $('.route_buttons').length;

            if(size > 1){
                $('.route_buttons:not(:last) .add_terminal').attr('hidden', true);
                $('.route_buttons:first .remove_terminal').attr('hidden', false);
                $('.route_buttons:last .add_terminal').attr('hidden', false);
            }else{
                $('.route_buttons:first .add_terminal').attr('hidden', false);
                $('.route_buttons:first .remove_terminal').attr('hidden', true);
            }
        }

        function checkRouteSelect()
        {
            var allSelected = $('select[name="routes[]"]').map(function(){
                return $(this).val();
            });

            $('select[name="routes[]"]').each(function(){

                $(this).children('option').each(function(){


                    if(jQuery.inArray($(this).val(), allSelected) !== -1){
                        $(this).attr('hidden', true);
                    }else{
                        $(this).attr('hidden', false);
                    }
                });
            });

        }

        $(document).on('change', 'select[name="routes[]"]', function(event){
            event.preventDefault();
            checkRouteSelect();
        });

        $(document).on('click', '.add_terminal', function(event){
            event.preventDefault();

            var form = '<div class="form-inline mb-3" id="terminal">\
                            <select class="form-control col-md-6 mr-3" name="routes[]">\
                                    <option selected disabled>Terminals</option>\
                                @foreach ($terminals as $terminal)\
                                    <option value="{{ $terminal->id }}">{{ $terminal->terminal_name }}</option>\
                                @endforeach\
                            </select>\
                            <input type="number" class="form-control col-md-4 travel" name="travel_time[]" placeholder="Estimated travel time">\
                            <div class="col-md route_buttons">\
                                <button type="button" class="btn btn-primary remove_terminal"><i class="fas fa-minus"></i></button>\
                                <button type="button" class="btn btn-primary add_terminal"><i class="fas fa-plus"></i></button>\
                            </div>\
                        </div>';
            $('#appends').append(form);
            changeRouteButtons();
            checkRouteSelect();
        });

        $(document).on('click', '.remove_terminal', function(event){
            event.preventDefault();

            if($('.route_buttons').length > 1){
                $(this).closest('div.form-inline').remove();
            }

            getTotalTimeTravel();
            changeRouteButtons();
            checkRouteSelect();
        });

        $(document).keyup('.travel', function(e){
            getTotalTimeTravel();
        });
    });
</script>
