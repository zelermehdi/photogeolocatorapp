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
            <form action="/photos/upload" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="photo" class="block text-gray-700 font-bold mb-2">Choose Photo</label>
                    <input type="file" name="photo" id="photo" class="border border-gray-400 p-2 w-full" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Upload Photo
                </button>
            </form>
        </div>
    </div>
</body>
</html>
