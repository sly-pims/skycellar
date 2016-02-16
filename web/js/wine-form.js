// Javascript Module Pattern
var Wine = (function() {

    // Private properties and methods

    var region = $('#region');
    var country = $('#country');
    var region_option = region.find('option');
    var country_option = country.find('option');
    var onRegionChange = function() {
        country.change(function() {
            var code = $(this).find(':selected').data('code');

            resetRegion();

            // Show its own region
            region_option.each(function() {
                var currentOption = $(this);
                if (currentOption.data('code') == code) {
                    currentOption.show();
                }
            });
        });
    };

    var emptyRegion = function() {
        region_option.eq(0).prop('selected', true);
    };

    // Select empty item
    var emptySelect = function() {
        emptyRegion();
        country_option.eq(0).prop('selected', true);
    };

    var resetRegion = function() {
        emptyRegion();

        // Hide all regions by default
        region_option.each(function () {
            var currentOption = $(this);
            if (currentOption.data('code') != undefined) {
                currentOption.hide();
            }
        })
    };

    var filterNumber = function() {
        $('input[type="number"]').on('keydown keyup', function() {
            var self = $(this);
            self.val(self.val().replace('/[^0-9]/', ''));
        });
    };

    // Public methods (json style)
    return {
        initialize: function() {
            emptySelect();
            resetRegion();
            onRegionChange();
            filterNumber();
        }
    };
})();