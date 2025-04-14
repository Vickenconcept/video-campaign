<!DOCTYPE html>
<html lang="en" class="h-full bg-white ">

<head>
    <x-seo::meta />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @seo([
        'title' => 'Video',
        'description' => 'Influencers Management Hub',
        'image' => asset('images/login-image.png'),
        'site_name' => config('app.name'),
        'favicon' => asset('images/fav-image.png'),
    ])

    <title>Video</title>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    {{-- <script src="https://unpkg.com/@alpinejs/focus" defer></script> --}}

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- 
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script> --}}


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-Dbbx3F5k.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-CE5Kpj__.css') }}"> --}}


    @yield('styles')

    @livewireStyles
</head>

<body class="h-screen ">
    <marquee direction="right" scrollamount="120" class="z-50 fixed w-full hidden" id="hiddenLinearPreloader">
        <div class="bg-gradient-to-r from-[#0F1523] from-70%  to-[#B5FFAB] w-[1500px] p-1 rounded-full"></div>
    </marquee>
    <div id="app" class="h-full  text-gray-700 ">
        <x-notification />
        <x-navbar />
        <x-sidebar />

        <div class="h-full sm:ml-64 bg-white pt-20 overflow-y-hidden">
            {{-- <button id="upload_widget" class="cloudinary-button">Upload files</button> --}}

            <script src="https://upload-widget.cloudinary.com/latest/global/all.js" type="text/javascript"></script>

            {{-- <script type="text/javascript">
                var myWidget = cloudinary.createUploadWidget({
                    cloudName: 'dp0bpzh9b',
                    uploadPreset: 'video-campaign'
                }, (error, result) => {
                    if (!error && result && result.event === "success") {
                        console.log('Done! Here is the image info: ', result.info);
                    }
                })
        
                document.getElementById("upload_widget").addEventListener("click", function() {
                    myWidget.open();
                }, false);
            </script> --}}

            {{-- <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var myWidget = cloudinary.createUploadWidget({
                        cloudName: "dp0bpzh9b",
                        uploadPreset: "video-campaign"
                    }, (error, result) => {
                        if (!error && result && result.event === "success") {
                            console.log("Done! Here is the image info: ", result.info);
                        }
                    });

                    function openWidget() {
                        myWidget.open();
                    }

                    function attachUploadListener() {
                        const uploadButton = document.getElementById("upload_widget");
                        if (uploadButton) {
                            // Remove any existing event listeners to prevent duplicates
                            uploadButton.removeEventListener("click", openWidget);
                            uploadButton.addEventListener("click", openWidget);
                        }
                    }

                    // Initial check if button exists
                    attachUploadListener();

                    // Observe the DOM for button appearing dynamically
                    const observer = new MutationObserver(() => {
                        attachUploadListener();
                    });

                    observer.observe(document.body, {
                        childList: true,
                        subtree: true
                    });
                });
            </script> --}}
            {{ $slot }}
        </div>
    </div>

    @yield('scripts')
    @stack('scripts')

    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('refreshPage', () => {
                location.reload();
            });
        });
    </script>

    {{-- <script>
        window.addEventListener('beforeunload', function(event) {
            var hiddenText = document.getElementById('hiddenText');
            hiddenText.classList.remove('hidden');
        });

        document.addEventListener("DOMContentLoaded", function() {
            var hiddenLinearPreloader = document.getElementById("hiddenLinearPreloader");

            hiddenLinearPreloader.classList.remove("hidden");

            setTimeout(function() {
                hiddenLinearPreloader.classList.add("hidden");
            }, 2000);
        });
    </script> --}}


</body>

</html>
