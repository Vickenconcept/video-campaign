<x-app-layout>
    <div class=" mx-auto px-3 pb-32 overflow-y-auto h-screen max-w-3xl pt-5">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-2xl font-bold mb-2 text-indigo-700">Copy Email Content</h1>
            <p class="mb-4 text-gray-600">Below is a live preview of your campaign email. Click the button to copy the content, then paste it into your email client's compose window (Gmail, Outlook, etc). The formatting, images, and links will be preserved.</p>
            <div class="mb-4 flex justify-between items-center">
                <span class="font-semibold text-gray-800">Campaign: {{ $campaign->title }}</span>
                <button id="copy-content-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition-colors">Copy Email Content</button>
            </div>
            <div id="copy-success" class="hidden text-green-600 mb-4 font-semibold">Copied!</div>
            <div id="email-preview" class="border rounded bg-gray-50 overflow-x-auto p-2">
                {!! $html !!}
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <strong>Instructions:</strong> After copying, go to your email client, start a new message, and paste (Ctrl+V or Cmd+V) into the message body. <br>
                <span class="text-amber-600">Note: Some email clients may not support all styles or layouts. For best results, use Gmail, Outlook.com, or Apple Mail.</span>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('copy-content-btn').addEventListener('click', function() {
            const preview = document.getElementById('email-preview');
            // Create a range and select the preview content
            const range = document.createRange();
            range.selectNodeContents(preview);
            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            try {
                document.execCommand('copy');
                document.getElementById('copy-success').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('copy-success').classList.add('hidden');
                }, 2000);
            } catch (err) {
                alert('Copy failed. Please select and copy manually.');
            }
            selection.removeAllRanges();
        });
    </script>
</x-app-layout> 