(function ($) {
    "use strict";

    $(document).on('change', '#country_id', function () {
        var country_id = $(this).val();
        if (country_id) {
            // Replace the COUNTRY_ID placeholder in the URL with the actual country_id
            var stateRoute = $(document).find('#state_route').val().replace('COUNTRY_ID', country_id);

            commonAjax('GET', stateRoute, function (response) {
                // Empty the state and city dropdowns
                $('#state_id').empty().append('<option value="">Select State</option>');
                $('#city_id').empty().append('<option value="">Select City</option>');

                // Append states to the #state_id dropdown
                if (response.data && response.data.length) {
                    response.data.forEach(function (state) {
                        $('#state_id').append('<option value="' + state.id + '">' + state.name + '</option>');
                    });
                }
                $('#state_id').niceSelect('update');
                $('#city_id').niceSelect('update');

            }, function (response) {
                // Handle error if needed
            });
        } else {
            // If no country selected, clear the state and city dropdowns
            $('#state_id').empty().append('<option value="">Select State</option>');
            $('#city_id').empty().append('<option value="">Select City</option>');
            $('#state_id').niceSelect('update');
            $('#city_id').niceSelect('update');
        }
    });

    $(document).on('change', '#state_id', function () {
        var state_id = $(this).val();
        if (state_id) {
            // Replace the STATE_ID placeholder in the URL with the actual state_id
            var cityRoute = $(document).find('#city_route').val().replace('STATE_ID', state_id);

            commonAjax('GET', cityRoute, function (response) {
                // Empty the city dropdown
                $('#city_id').empty().append('<option value="">Select City</option>');

                // Append cities to the #city_id dropdown
                if (response.data && response.data.length) {
                    response.data.forEach(function (city) {
                        $('#city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                    });
                }

                $('#city_id').niceSelect('update');
            }, function (response) {
                // Handle error if needed
            });
        } else {
            // If no state selected, clear the city dropdown
            $('#city_id').empty().append('<option value="">Select City</option>');
        }

        $('#city_id').niceSelect('update');
    });

})(jQuery);
