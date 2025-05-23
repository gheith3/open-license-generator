<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6 bg-white shadow-xl rounded-xl">
    <!-- 🎯 LEFT: Form -->
    <div class="space-y-6">
        <h2 class="text-2xl font-bold text-blue-700">📝 License Generator</h2>
        <p class="text-gray-500">Fill in your project details and answer the questions.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">📌 Project Name</label>
                <input type="text" wire:model.live="projectName"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="e.g. MyAwesomeApp">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">📌 Author</label>
                <input type="text" wire:model.live="author"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="e.g. John Doe">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($questions as $question)
            <div>
                <label class="block text-sm text-gray-500 mb-1 leading-snug min-h-[3.5rem]">{{ $question->text
                    }}</label>

                <select wire:model.live="answers.{{ $question->id }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">-- Select --</option>
                    @foreach($question->options as $option)
                    <option value="{{ $option->id }}">{{ $option->label }}</option>
                    @endforeach
                </select>
            </div>
            @endforeach
        </div>
      
    </div>

    <!-- 📄 RIGHT: License Output -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 h-full overflow-auto">
        <h3 class="text-xl font-semibold text-green-700 mb-3">📜 License Preview</h3>

        @if($licenseText)
        <pre class="whitespace-pre-wrap text-sm text-gray-800 font-mono">{{ $licenseText }}</pre>

        <div class="flex justify-end gap-3 mt-4">
            <button wire:click="copyToClipboard"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                </svg>
                Copy to Clipboard
            </button>
            <button wire:click="downloadReadme"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download README.md
            </button>
        </div>
        @else
        <p class="text-gray-400">Your license will appear here after you generate it.</p>
        @endif
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('clipboardCopy', async (event) => {
            try {
                await navigator.clipboard.writeText(event.text);
                alert('License text copied to clipboard successfully!');
                // You could add a toast notification here if you have a notification system
            } catch (err) {
                console.error('Failed to copy text: ', err);
            }
        });
    });
</script>