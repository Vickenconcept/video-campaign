<?php

namespace App\Livewire;

use Livewire\Component;

class MapComponent extends Component
{
    public $activeStep;
    public $latitude;
    public $longitude;
    public $zoom;
    public $marker_label;
    public $address;

    public function mount($activeStep = null)
    {
        $this->activeStep = $activeStep;
        $map = is_array($this->activeStep->map_settings) ? $this->activeStep->map_settings : json_decode($this->activeStep->map_settings, true);
        $this->latitude = $map['latitude'] ?? '';
        $this->longitude = $map['longitude'] ?? '';
        $this->zoom = $map['zoom'] ?? 12;
        $this->marker_label = $map['marker_label'] ?? '';
        $this->address = $map['address'] ?? '';
    }

    public function saveMap()
    {
        $map = [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'zoom' => $this->zoom,
            'marker_label' => $this->marker_label,
            'address' => $this->address,
        ];
        $this->activeStep->update([
            'map_settings' => json_encode($map)
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Map settings saved!');
    }

    public function render()
    {
        return view('livewire.map-component');
    }
} 