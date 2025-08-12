<div class="space-y-4 w-full">

    <div>
        <a href="https://www.latlong.net/" target="_blank" class="text-blue-600 underline text-xs">Find your latitude and
            longitude on latlong.net</a>
    </div>
    <div>
        <label class="block text-sm font-bold mb-1">Latitude</label>
        <input type="text" wire:model.defer="latitude" class="form-control" placeholder="e.g. 37.7749" />
    </div>
    <div>
        <label class="block text-sm font-bold mb-1">Longitude</label>
        <input type="text" wire:model.defer="longitude" class="form-control" placeholder="e.g. -122.4194" />
    </div>
    <div>
        <label class="block text-sm font-bold mb-1">Zoom Level</label>
        <input type="number" min="1" max="20" wire:model.defer="zoom" class="form-control" />
    </div>
    <div>
        <label class="block text-sm font-bold mb-1">Marker Label</label>
        <input type="text" wire:model.defer="marker_label" class="form-control"
            placeholder="e.g. Creator's Location" />
    </div>
    <div>
        <label class="block text-sm font-bold mb-1">Address (optional)</label>
        <input type="text" wire:model.defer="address" class="form-control" placeholder="e.g. 123 Main St, City" />
    </div>
    <div>
        <button class="btn cursor-pointer" wire:click="saveMap" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="saveMap">Save Map Settings</span>
            <span wire:loading wire:target="saveMap">Saving...</span>
        </button>
    </div>
</div>
