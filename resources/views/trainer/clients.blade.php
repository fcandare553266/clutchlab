<x-app-layout>
    <div class="py-8 bg-[#0b111b] min-h-screen text-gray-300 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- 1. TOP HEADER -->
            <div class="mb-10">
                <h1 class="text-green-500 font-black text-2xl uppercase tracking-tighter leading-none">MY CLIENT ROSTER</h1>
                <p class="text-gray-600 text-sm font-bold uppercase tracking-tight mt-1">View and manage your assigned trainees and workout schedules</p>
            </div>

            <!-- 2. CLIENT LIST TABLE -->
            <div class="bg-[#161f2c]/30 backdrop-blur-xl border border-white/5 rounded-[2.5rem] overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white/[0.02] text-gray-600 uppercase text-[10px] font-black tracking-[0.3em]">
                            <tr>
                                <th class="px-10 py-6 border-b border-white/5">Client Information</th>
                                <th class="px-10 py-6 border-b border-white/5">Assigned Workout</th>
                                <th class="px-10 py-6 border-b border-white/5 text-center">Schedule Details</th>
                                <th class="px-10 py-6 border-b border-white/5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($sessions as $session)
                            <tr class="hover:bg-white/[0.04] hover:border-l-4 hover:border-green-500 transition-all duration-200 group border-l-4 border-transparent">
                                
                                <!-- Client Info -->
                                <td class="px-10 py-8">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-xl bg-green-600/20 flex items-center justify-center text-green-500 font-black italic text-sm mr-5 shadow-lg group-hover:bg-green-600 group-hover:text-white transition-all">
                                            {{ substr($session->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-white font-black text-lg uppercase italic tracking-tight leading-none">{{ $session->user->name }}</div>
                                            <div class="text-[10px] text-gray-600 font-bold uppercase mt-1 tracking-widest">{{ $session->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Session Title -->
                                <td class="px-10 py-8">
                                    <div class="bg-white/5 border border-white/5 p-4 rounded-2xl inline-block">
                                        <div class="text-green-500 font-black text-xs uppercase italic tracking-widest">{{ $session->title }}</div>
                                        <div class="text-[9px] text-gray-600 font-bold uppercase mt-1">Session ID: #TS-{{ $session->id }}</div>
                                    </div>
                                </td>

                                <!-- Date & Time -->
                                <td class="px-10 py-8 text-center">
                                    <div class="text-white font-black text-sm uppercase italic">{{ \Carbon\Carbon::parse($session->scheduled_at)->format('M d, Y') }}</div>
                                    <div class="text-gray-500 text-[10px] font-black uppercase mt-1">{{ \Carbon\Carbon::parse($session->scheduled_at)->format('h:i A') }}</div>
                                </td>

                                <!-- Status -->
                                <td class="px-10 py-8 text-center">
                                    <span class="px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $session->payment_status == 'paid' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-orange-500/10 text-orange-500 border-orange-500/20' }}">
                                        ● {{ $session->payment_status == 'paid' ? 'Confirmed' : 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-24 text-center">
                                    <p class="text-gray-700 font-black italic uppercase tracking-widest text-xl">No trainees assigned to your queue yet.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>