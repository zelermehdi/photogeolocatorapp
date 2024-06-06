<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Photo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-center mb-8">Détails de la Photo</h1>
        
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold mb-2">Informations sur la photo</h2>
            </div>
            <ul class="divide-y divide-gray-200">
                <li class="p-4 flex justify-between items-center">
                    <span class="font-semibold">Nom du fichier :</span>
                    <span>{{ $data['photo']['filename'] }}</span>
                </li>
                <li class="p-4 flex justify-between items-center">
                    <span class="font-semibold">Date de prise :</span>
                    <span>{{ $data['photo']['taken_at'] }}</span>
                </li>
                <li class="p-4 flex justify-between items-center">
                    <span class="font-semibold">Latitude :</span>
                    <span>{{ $data['photo']['latitude'] }}</span>
                </li>
                <li class="p-4 flex justify-between items-center">
                    <span class="font-semibold">Longitude :</span>
                    <span>{{ $data['photo']['longitude'] }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold mb-2">Détails de l'adresse</h2>
            </div>
            <div id="map" style="height: 400px;"></div>

            <div class="px-6 py-4">
                <h3 class="text-lg font-semibold mb-2">{{ $data['addressDetails']['title'] }}</h3>
                <p>{{ $data['addressDetails']['address']['label'] }}</p>
                <p class="mt-2"><span class="font-semibold">Ville :</span> {{ $data['addressDetails']['address']['city'] }}</p>
                <p><span class="font-semibold">État :</span> {{ $data['addressDetails']['address']['state'] }}</p>
                <p><span class="font-semibold">Pays :</span> {{ $data['addressDetails']['address']['countryName'] }}</p>
                <p><span class="font-semibold">Code postal :</span> {{ $data['addressDetails']['address']['postalCode'] }}</p>
            </div>
        </div>

        <div class="flex justify-center mb-8">
            <img src="{{ asset('storage/' . $data['photo']['path']) }}" class="max-w-full h-auto" alt="Photo téléchargée">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([{{ $data['photo']['latitude'] }}, {{ $data['photo']['longitude'] }}], 13);
    
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
    
        var marker = L.marker([{{ $data['photo']['latitude'] }}, {{ $data['photo']['longitude'] }}]).addTo(map);
        marker.bindPopup("<b>Location</b><br>Latitude: {{ $data['photo']['latitude'] }}<br>Longitude: {{ $data['photo']['longitude'] }}").openPopup();
    </script>
</body>
</html>
