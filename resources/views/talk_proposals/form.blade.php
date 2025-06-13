<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="mb-4">
        <label class="block font-medium">Title</label>
        <input type="text" name="title" class="w-full mt-1 p-2 border rounded"
               value="{{ old('title', $talkProposal->title ?? '') }}">
        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label class="block font-medium">Description</label>
        <textarea name="description" class="w-full mt-1 p-2 border rounded" rows="5">{{ old('description', $talkProposal->description ?? '') }}</textarea>
        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label class="block font-medium">Presentation PDF (optional)</label>
        <input type="file" name="presentation_pdf" class="w-full mt-1">
        @if ($isEdit && $talkProposal->presentation_pdf)
            <p class="mt-2 text-sm">
                Existing file:
                <a href="{{ asset('storage/' . $talkProposal->presentation_pdf) }}" target="_blank" class="text-blue-500 underline">View PDF</a>
            </p>
        @endif
        @error('presentation_pdf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label class="block font-medium">Tags (comma-separated)</label>
        <input type="text" name="tags" class="w-full mt-1 p-2 border rounded"
               value="{{ old('tags.0', isset($talkProposal) ? $talkProposal->tags->pluck('name')->implode(', ') : '') }}">
        @error('tags') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-{{ $isEdit ? 'blue' : 'green' }}-600 text-white px-4 py-2 rounded hover:bg-{{ $isEdit ? 'blue' : 'green' }}-700">
            {{ $isEdit ? 'Update' : 'Submit' }}
        </button>
    </div>
</form>
