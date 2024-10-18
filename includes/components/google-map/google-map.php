<?php
    $api_key = get_field('google_map_api_key','options');
?>
<section class="google-map">
    <div id="map"></div>
    <script
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>&callback=initMap&v=weekly"
    defer></script>
</section>