<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Session Details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow sm:rounded-lg">
                <form action="{{ route('sessions.update', $session) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Session Title</label>
                        <input type="text" name="title" value="{{ $session->title }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date and Time</label>
                        <input type="datetime-local" name="scheduled_at" value="{{ date('Y-m-d\TH:i', strtotime($session->scheduled_at)) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ $session->description }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md shadow-sm text-sm">
                            Update Session
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>