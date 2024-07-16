<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: { lat: 41.85, lng: -87.65 }
            });
            directionsRenderer.setMap(map);

            var form = document.getElementById('directionsForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                calculateAndDisplayRoute(directionsService, directionsRenderer);
            });
        }

        function calculateAndDisplayRoute(directionsService, directionsRenderer) {
            var origin = document.getElementById('origin').value;
            var destination = document.getElementById('destination').value;
            var travelMode = document.getElementById('travelMode').value;
            directionsService.route(
                {
                    origin: { query: origin },
                    destination: { query: destination },
                    travelMode: google.maps.TravelMode[travelMode]
                },
                function(response, status) {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(response);
                        var route = response.routes[0].legs[0];
                        document.getElementById('distance').innerText = 'Distance: ' + route.distance.text;
                        document.getElementById('duration').innerText = 'Duration: ' + route.duration.text;
                        document.getElementById('directionsLink').href = 'https://www.google.com/maps/dir/?api=1&origin=' + origin + '&destination=' + destination + '&travelmode=' + travelMode.toLowerCase();
                        document.getElementById('directionsLink').innerText = 'View on Google Maps';

                        if (travelMode === 'TRANSIT') {
                            displayTransitDetails(route);
                        } else {
                            document.getElementById('transitDetails').innerHTML = '';
                        }
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                }
            );
        }

        function displayTransitDetails(route) {
            var transitDetailsDiv = document.getElementById('transitDetails');
            transitDetailsDiv.innerHTML = '<h3 class="text-lg font-medium text-gray-700">Transit Details:</h3>';
            
            route.steps.forEach(function(step) {
                if (step.travel_mode === 'TRANSIT') {
                    var transitDetails = step.transit;
                    var details = `
                        <p><strong>Departure:</strong> ${transitDetails.departure_stop.name}</p>
                        <p><strong>Arrival:</strong> ${transitDetails.arrival_stop.name}</p>
                        <p><strong>Line:</strong> ${transitDetails.line.name}</p>
                        <p><strong>Vehicle:</strong> ${transitDetails.line.vehicle.name}</p>
                        <hr class="my-2">
                    `;
                    transitDetailsDiv.innerHTML += details;
                }
            });
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Calcule de route</h1>
        <form id="directionsForm" class="bg-white p-4 rounded shadow-md mb-4">
            <div class="mb-4">
                <label for="origin" class="block text-sm font-medium text-gray-700">Origin:</label>
                <input type="text" id="origin" name="origin" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="destination" class="block text-sm font-medium text-gray-700">Destination:</label>
                <input type="text" id="destination" name="destination" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="travelMode" class="block text-sm font-medium text-gray-700">Mode de transport:</label>
                <select id="travelMode" name="travelMode" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="DRIVING">Voiture</option>
                    <option value="WALKING">Marche</option>
                    <option value="TRANSIT">Transport en commun</option>
                    <option value="BICYCLING">Vélo</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Obtenir des directions</button>
        </form>
        <div class="bg-white p-4 rounded shadow-md mb-4">
            <p id="distance" class="text-lg font-medium text-gray-700"></p>
            <p id="duration" class="text-lg font-medium text-gray-700"></p>
            <a id="directionsLink" target="_blank" class="text-indigo-600 hover:underline"></a>
            <div id="transitDetails" class="mt-4"></div>
        </div>
        <div id="map" class="w-full h-96 bg-gray-300"></div>
    </div>
</body>
</html>
