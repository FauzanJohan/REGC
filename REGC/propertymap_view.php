<!DOCTYPE html>
<html lang="en">

<head>
    <title>Real Estate Map</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Add your custom styles if needed -->
    <link rel="shortcut icon" type="image/x-icon" href="RealEstate Logo Icon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><strong>Real Estate Map</strong></a>
        </nav>
    </header>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title">Interactive Map</h5>
                <div id="map" style="height: 500px; border-radius: 10px;"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var map;

        function getData() {
            console.log("getData function called");
            $.ajax({
                url: "propertymap_geocode_api.php",
                async: true,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    // load map
                    init_map(data);
                }
            });
        }

        function init_map(data) {
            var map_options = {
                zoom: 10,
                center: new google.maps.LatLng(data[0].latitude, data[0].longitude)
            };
            map = new google.maps.Map(document.getElementById("map"), map_options);

            for (var i = 0; i < data.length; i++) {
                var marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(data[i].latitude, data[i].longitude)
                });

                var infowindow = new google.maps.InfoWindow({
                    content: data[i].formatted_address
                });

                google.maps.event.addListener(marker, "click", function () {
                    infowindow.open(map, marker);
                });
            }
        }

        function centerMapToAddress(address) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': address }, function (results, status) {
                if (status == 'OK') {
                    var location = results[0].geometry.location;
                    map.setCenter(location);
                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdbXPcmyhunUNCayLaJvzFL5_s2keehJs&callback&callback=getData"></script>
</body>

</html>
