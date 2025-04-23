<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <x-seo::meta />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @seo([
        'title' => 'FluenceGrid',
        'description' => 'Influencers Management Hub',
        'image' => asset('images/login-image.png'),
        'site_name' => config('app.name'),
        'favicon' => asset('images/fav-image.png'),
    ])

    <title>Influence</title>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-Dbbx3F5k.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-CE5Kpj__.css') }}"> --}}



    @yield('styles')

    @livewireStyles

    <style>
        /* Hide Google top frame (translation bar) */
        body>.skiptranslate {
            display: none !important;
        }

        /* Prevent page shifting down */
        body {
            top: 0px !important;
        }

        /* Hide the iframe that causes layout shifts */
        iframe.goog-te-banner-frame {
            display: none !important;
        }





        body .goog-te-banner-frame.skiptranslate,
        body .goog-te-balloon-frame,
        body .goog-text-highlight {
            display: none !important;
        }

        /* Prevent any background on translated text */
        .goog-te-gadget {
            color: transparent !important;
        }

        .goog-text-highlight {
            background-color: transparent !important;
            box-shadow: none !important;
        }

        /* Optional: Prevent Google Translate from adding spacing/outline */
        * {
            outline: none !important;
        }

        /* Hide the Google Translate toolbar popup */
        .goog-te-balloon-frame {
            display: none !important;
        }

        /* Hide Google Translate banner */
        .goog-te-banner-frame {
            display: none !important;
        }

        /* Push the body back up since the banner usually pushes it down */
        body {
            top: 0px !important;
        }





        .goog-text-highlight {
            background-color: transparent !important;
            box-shadow: none !important;
            color: inherit !important;
        }

        /* Also target any span Google injects (e.g., during mobile/touch) */
        span.goog-text-highlight {
            background: none !important;
            box-shadow: none !important;
            color: inherit !important;
            pointer-events: none !important;
        }

        /* Optional: Hide the balloon/tooltip completely */
        .goog-te-balloon-frame {
            display: none !important;
        }

        /* Optional: Disable banner at top */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        /* Prevent pointer/click events on translation overlay spans */
        .goog-te-gadget,
        .goog-text-highlight {
            pointer-events: none !important;
        }


        font[class^="VIpgJd"] {
            background-color: transparent !important;
            box-shadow: none !important;
            color: inherit !important;
            pointer-events: none !important;
            text-shadow: none !important;
        }

        font[class*="VIpgJd"] {
            background-color: transparent !important;
            box-shadow: none !important;
            color: inherit !important;
            pointer-events: none !important;
            text-shadow: none !important;
        }
    </style>
</head>

<body class="h-full">
    <marquee direction="right" scrollamount="60" class="z-[10000] fixed w-full hidden" id="hiddenLinearPreloader">
        <div class="bg-gradient-to-r from-[#0F1523] from-70%  to-[#B5FFAB] w-[700px] p-1 rounded-full"></div>
    </marquee>
    {{-- <div id="google_translate_element" class=""></div> --}}
    <div id="google_translate_element"
        class="fixed top-4 right-4 z-50 bg-white shadow-lg rounded-lg p-2 border border-gray-200 hidden"></div>

    {{ $slot }}



    <script>
        // Set the desired language
        // This should come from your backend/session

        // Function to set the googtrans cookie manually
        function setGoogleTranslateCookie(lang) {
            const value = `/en/${lang}`;
            document.cookie = `googtrans=${value}; path=/; domain=${location.hostname};`;
            document.cookie = `googtrans=${value}; path=/;`; // sometimes needed for local dev
        }

        // Call it before loading Google Translate script
        setGoogleTranslateCookie(userLang);
    </script>

    <!-- Google Translate element container -->
    <div id="google_translate_element" class="fixed top-4 right-4 z-50"></div>

    <!-- Google Translate init script -->
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,fr,es,de,ar,zh-CN,hi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>

    <!-- Load the translate script -->
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


    <script>
        // document.addEventListener("livewire:load", () => {
        //     Livewire.hook('message.processed', () => {
        //         const translateSelect = document.querySelector('.goog-te-combo');
        //         if (translateSelect && translateSelect.value !== 'en') {
        //             translateSelect.dispatchEvent(new Event('change'));
        //         }
        //     });
        // });

        document.addEventListener("livewire:load", () => {
            Livewire.hook('message.processed', () => {
                const translateSelect = document.querySelector('.goog-te-combo');
                if (translateSelect && translateSelect.value !== 'en') {
                    // Re-select the current language to re-trigger translation
                    const event = new Event('change');
                    translateSelect.dispatchEvent(event);
                }
            });
        });
    </script>


</body>



<script>
    window.addEventListener('beforeunload', function(event) {
        var hiddenText = document.getElementById('hiddenText');
        hiddenText.classList.remove('hidden');
        hiddenLinearPreloader.classList.remove("hidden");
    });

    document.addEventListener("DOMContentLoaded", function() {
        var hiddenLinearPreloader = document.getElementById("hiddenLinearPreloader");

        hiddenLinearPreloader.classList.remove("hidden");

        setTimeout(function() {
            hiddenLinearPreloader.classList.add("hidden");
        }, 2000);
    });
</script>


@yield('scripts')
@livewireScripts

</html>
