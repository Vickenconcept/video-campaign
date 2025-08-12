@php
    $map = is_array($step->map_settings) ? $step->map_settings : json_decode($step->map_settings, true);
    $latitude = $map['latitude'] ?? '';
    $longitude = $map['longitude'] ?? '';
    $zoom = $map['zoom'] ?? 12;
    $marker_label = $map['marker_label'] ?? '';
    $address = $map['address'] ?? '';
    // Default to New York City if not set
    if (empty($latitude) || empty($longitude)) {
        $latitude = '40.7128';
        $longitude = '-74.0060';
        $zoom = 12;
        $marker_label = $marker_label ?: 'Default Location';
        $address = $address ?: 'New York, NY, USA';
    }
@endphp

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6 flex flex-col items-center space-y-4">
    <div class="w-full text-center">
        <h2 class="text-2xl font-bold mb-2">Location Map</h2>
        @if($address)
            <p class="text-gray-600 mb-2">{{ $address }}</p>
        @endif
    </div>
    <div id="map-viewer" style="height: 300px; width: 100%; border-radius: 12px;"></div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map-viewer').setView([{{ $latitude }}, {{ $longitude }}], {{ $zoom }});
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
        var marker = L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(map);
        @if($marker_label)
            marker.bindPopup(@json($marker_label)).openPopup();
        @endif
    });
</script> 