<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Training Sessions List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                
                <div class="flex justify-between mb-6">
                    <h3 class="text-lg font-bold">Upcoming Sessions</h3>
                    <a href="{{ route('sessions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                        + Book New Session
                    </a>
                </div>

                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Session Title</th>
                            <th class="p-3 border">Scheduled Date</th>
                            <th class="p-3 border">Client Name</th>
                            <th class="p-3 border">Amount</th>
                            <th class="p-3 border text-center">Payment Status</th>
                            <th class="p-3 border text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $session)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 border">{{ $session->title }}</td>
                                <td class="p-3 border">{{ \Carbon\Carbon::parse($session->scheduled_at)->format('M d, Y h:i A') }}</td>
                                <td class="p-3 border">{{ $session->user->name }}</td>
                                <td class="p-3 border font-semibold">₱{{ number_format($session->amount, 2) }}</td>
                                
                                <!-- FIXED: Combined the payment logic into ONE cell -->
                                <td class="p-3 border text-center">
                                    @if($session->payment_status === 'paid')
                                        <span class="px-3 py-1 text-xs font-bold uppercase rounded-full bg-green-100 text-green-700 border border-green-200">
                                            ● Paid
                                        </span>
                                    @elseif($session->payment_status === 'pending')
                                        <span class="px-3 py-1 text-xs font-bold uppercase rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            ● Pending
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-bold uppercase rounded-full bg-red-100 text-red-700 border border-red-200">
                                            Unpaid
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3 border">
                                    <div class="flex justify-center gap-4">
                                        <a href="{{ route('sessions.edit', $session) }}" class="text-indigo-600 hover:underline font-medium">Edit</a>

                                        <!-- RBAC: Only Admin can see the Delete button -->
                                        @if(Auth::user()->role === 'admin')
                                        <form action="{{ route('sessions.destroy', $session) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this session?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <!-- FIXED: Changed colspan to 6 to match the header count -->
                            <td colspan="6" class="p-6 text-center text-gray-500">No sessions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>