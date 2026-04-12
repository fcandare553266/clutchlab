<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Book a Training Session</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow sm:rounded-lg">
                <form action="{{ route('sessions.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Session Title</label>
                        <input type="text" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Morning Cardio" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date and Time</label>
                        <input type="datetime-local" name="scheduled_at"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Description / Goals</label>
                        <textarea name="description" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="What are we working on?"></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('sessions.index') }}" class="px-4 py-2 text-sm text-gray-600">Cancel</a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md shadow-sm text-sm">
                            Save Session
                        </button>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Session Fee (PHP)</label>
                        <input type="text" value="500.00" class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm"
                            readonly>
                        <p class="text-xs text-gray-500 mt-1">*Fixed rate per session</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select name="payment_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="gcash">GCash</option>
                            <option value="paymaya">Maya</option>
                            <option value="cash">Cash at Gym</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>