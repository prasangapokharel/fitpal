<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan or Upload Barcode</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script> <!-- QuaggaJS -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        #scanner-container, #uploaded-image-preview {
            width: 100%;
            height: 300px;
            background-color: #f3f4f6;
            border: 2px dashed #cbd5e1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .info-container {
            margin-top: 20px;
            text-align: center;
        }
        .info-container h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        .info-container p {
            font-size: 1.1rem;
            margin: 5px 0;
        }
        #uploaded-image-preview img {
            max-height: 100%;
            max-width: 100%;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-center mb-6">Scan or Upload Barcode</h1>

        <!-- Tabs for Camera Scanner and Upload -->
        <div class="flex justify-center mb-6">
            <button id="scan-tab" onclick="showScanner()" class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600">Scan Barcode</button>
            <button id="upload-tab" onclick="showUpload()" class="px-4 py-2 bg-gray-500 text-white rounded shadow ml-2 hover:bg-gray-600">Upload Image</button>
        </div>

        <!-- Barcode Scanner -->
        <div id="scanner-container">
            <p class="text-gray-500">Loading camera...</p>
        </div>

        <!-- Upload Image -->
        <div id="upload-container" class="hidden">
            <input type="file" id="barcode-image" accept="image/*" class="block w-full mb-4">
            <div id="uploaded-image-preview"></div>
        </div>

        <!-- Display Product Information -->
        <div id="product-info" class="info-container hidden">
            <h2 class="text-gray-800">Product Information</h2>
            <p><strong>Food Name:</strong> <span id="food-name"></span></p>
            <p><strong>Protein:</strong> <span id="protein"></span> g</p>
            <p><strong>Calories:</strong> <span id="calorie"></span> kcal</p>
        </div>

        <!-- Error Message -->
        <div id="error-message" class="text-center text-red-500 mt-6 hidden">
            Unable to fetch product details. Please try again.
        </div>
    </div>

    <script>
        const scannerContainer = document.getElementById('scanner-container');
        const uploadContainer = document.getElementById('upload-container');
        const messageContainer = document.getElementById('product-info');
        const errorMessage = document.getElementById('error-message');

        // Initialize Quagga for Camera Scanning
        function initializeQuagga() {
            Quagga.init({
                inputStream: {
                    type: "LiveStream",
                    constraints: {
                        facingMode: "environment" // Use back camera
                    },
                    area: { // Scanning area
                        top: "10%", left: "10%", width: "80%", height: "80%"
                    }
                },
                decoder: {
                    readers: ["ean_reader"] // Support EAN barcodes
                }
            }, function (err) {
                if (err) {
                    console.error(err);
                    errorMessage.classList.remove('hidden');
                    return;
                }
                Quagga.start(); // Start the scanner
            });

            // Handle barcode detection from camera
            Quagga.onDetected(function (result) {
                const barcode = result.codeResult.code;
                fetchProductInfo(barcode);
                Quagga.stop(); // Stop scanning after detection
            });
        }

        // Fetch product information from Open Food Facts API
        async function fetchProductInfo(barcode) {
            const apiUrl = `https://world.openfoodfacts.org/api/v0/product/${barcode}.json`;
            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                if (data && data.product) {
                    messageContainer.querySelector("#food-name").textContent = data.product.product_name || "Unknown";
                    messageContainer.querySelector("#protein").textContent = data.product.nutriments.proteins || "N/A";
                    messageContainer.querySelector("#calorie").textContent = data.product.nutriments.energy_kcal || "N/A";
                    messageContainer.classList.remove("hidden");
                    errorMessage.classList.add("hidden");
                } else {
                    throw new Error("Product not found");
                }
            } catch (error) {
                console.error(error);
                messageContainer.classList.add("hidden");
                errorMessage.classList.remove("hidden");
            }
        }

        // Show scanner or upload interface
        function showScanner() {
            scannerContainer.classList.remove('hidden');
            uploadContainer.classList.add('hidden');
            messageContainer.classList.add('hidden');
            errorMessage.classList.add('hidden');
            initializeQuagga();
        }

        function showUpload() {
            scannerContainer.classList.add('hidden');
            uploadContainer.classList.remove('hidden');
            messageContainer.classList.add('hidden');
            errorMessage.classList.add('hidden');
        }

        // Handle Image Upload and Barcode Detection
        document.getElementById('barcode-image').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.onload = function () {
                        // Display uploaded image
                        const preview = document.getElementById('uploaded-image-preview');
                        preview.innerHTML = '';
                        preview.appendChild(img);

                        // Decode barcode using Quagga
                        Quagga.decodeSingle({
                            src: img.src,
                            numOfWorkers: 0, // Use 0 for synchronous decoding
                            decoder: {
                                readers: ["ean_reader"] // Support EAN barcodes
                            }
                        }, function (result) {
                            if (result && result.codeResult) {
                                fetchProductInfo(result.codeResult.code);
                            } else {
                                errorMessage.classList.remove("hidden");
                            }
                        });
                    };
                };
                reader.readAsDataURL(file);
            }
        });

        // Initialize QuaggaJS on page load
        window.onload = function () {
            showScanner(); // Default to scanner mode
        };
    </script>
</body>
</html>
