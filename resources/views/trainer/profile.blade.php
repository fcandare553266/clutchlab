<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded-lg">
            <h2 class="text-xl font-bold mb-4">Trainer Settings</h2>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf @method('PATCH')
                <div class="mb-4">
                    <label>Working Hours</label>
                    <input type="text" name="working_hours" value="{{ Auth::user()->working_hours }}" placeholder="e.g. 8AM - 4PM" class="w-full border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label>Specialization</label>
                    <select name="specialization" class="w-full border-gray-300 rounded">
                        <option value="Strength Coach">Strength and Conditioning Coach</option>
                        <option value="Workout Instructor">Workout Instructor</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Profile</button>
            </form>
        </div>
    </div>
</x-app-layout>