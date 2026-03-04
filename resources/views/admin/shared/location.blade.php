<script
    src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key={{ config('app.google_api_key') }}&libraries=places">
</script>

<script>
    google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('map_desc');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            // place variable will have all the information you are looking for.

            document.getElementById("lat").value = place.geometry['location'].lat();
            document.getElementById("lng").value = place.geometry['location'].lng();
        });
    }
    $('[href="#finish"]').click(function() {
        $('#branchForm').submit();
    })
</script>
