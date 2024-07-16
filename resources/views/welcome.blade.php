<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="flex justify-center items-center h-screen bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h1 class="text-2xl font-bold mb-4">Upload Photo</h1>
            <form id="uploadForm" action="/photos/upload" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="photo" class="block text-gray-700 font-bold mb-2">Choose Photo</label>
                    <input type="file" name="photo" id="photo" class="border border-gray-400 p-2 w-full" required>
                </div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Upload Photo
                </button>
            </form>
        </div>
    </div>





    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    event.target.submit();
                }, function(error) {
                    alert('Geolocation failed: ' + error.message);
                    event.target.submit();
                });
            } else {
                alert('Geolocation is not supported by this browser.');
                event.target.submit();
            }
        });
    </script>
</body>

</html>








