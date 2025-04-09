<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <p>Select File types to be allowed</p>
    <div class="grid grid-cols-3 gap-4">
        <!-- PDF -->
        <label for="pdf" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('pdf', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>pdf</span>
            <input id="pdf" type="checkbox" value="pdf" wire:model.live="file_type" class="hidden">
        </label>

        <!-- DOC -->
        <label for="doc" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('doc', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>doc</span>
            <input id="doc" type="checkbox" value="doc" wire:model.live="file_type" class="hidden">
        </label>

        <!-- DOCX -->
        <label for="docx" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('docx', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>docx</span>
            <input id="docx" type="checkbox" value="docx" wire:model.live="file_type" class="hidden">
        </label>

        <!-- PPT -->
        <label for="ppt" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('ppt', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>ppt</span>
            <input id="ppt" type="checkbox" value="ppt" wire:model.live="file_type" class="hidden">
        </label>

        <!-- PPTX -->
        <label for="pptx" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('pptx', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>pptx</span>
            <input id="pptx" type="checkbox" value="pptx" wire:model.live="file_type" class="hidden">
        </label>

        <!-- XLS -->
        <label for="xls" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('xls', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>xls</span>
            <input id="xls" type="checkbox" value="xls" wire:model.live="file_type" class="hidden">
        </label>

        <!-- XLSX -->
        <label for="xlsx" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('xlsx', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>xlsx</span>
            <input id="xlsx" type="checkbox" value="xlsx" wire:model.live="file_type" class="hidden">
        </label>

        <!-- TXT -->
        <label for="txt" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('txt', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>txt</span>
            <input id="txt" type="checkbox" value="txt" wire:model.live="file_type" class="hidden">
        </label>

        <!-- CSV -->
        <label for="csv" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('csv', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>csv</span>
            <input id="csv" type="checkbox" value="csv" wire:model.live="file_type" class="hidden">
        </label>

        <!-- ZIP -->
        <label for="zip" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('zip', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>zip</span>
            <input id="zip" type="checkbox" value="zip" wire:model.live="file_type" class="hidden">
        </label>

        <!-- RAR -->
        <label for="rar" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('rar', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>rar</span>
            <input id="rar" type="checkbox" value="rar" wire:model.live="file_type" class="hidden">
        </label>

        <!-- JSON -->
        <label for="json" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('json', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>json</span>
            <input id="json" type="checkbox" value="json" wire:model.live="file_type" class="hidden">
        </label>

        <!-- XML -->
        <label for="xml" wire:click="saveFileType()"
            class="text-center bg-slate-100 rounded-md p-2 cursor-pointer hover:shadow-lg hover:bg-slate-300 transition duration-500 ease-in-out  
            @if (in_array('xml', $file_type)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
            <span>xml</span>
            <input id="xml" type="checkbox" value="xml" wire:model.live="file_type" class="hidden">
        </label>


    </div>
</div>
