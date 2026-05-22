<x-app-layout>
    <div class="py-8 bg-[#0b111b] min-h-screen text-gray-300 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- ========================================== -->
            <!-- 1. ADMIN VIEW (BLUE THEME) -->
            <!-- ========================================== -->
            @if(Auth::user()->role === 'admin')
                <div class="mb-8">
                    <h1 class="text-blue-500 font-black text-2xl uppercase tracking-tighter leading-none">TRAINING SESSIONS MANAGEMENT</h1>
                    <p class="text-gray-600 text-sm font-bold uppercase tracking-tight mt-1">Manage all workout sessions, schedules, and payments</p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
                    <div class="bg-[#161f2c]/50 border border-white/5 p-6 rounded-2xl border-l-4 border-blue-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-blue-500/10">
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Total Sessions</p>
                        <h3 class="text-4xl font-black text-blue-500 mt-2 italic">{{ $sessions->count() }}</h3>
                    </div>
                    <div class="bg-[#161f2c]/50 border border-white/5 p-6 rounded-2xl border-l-4 border-green-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-green-500/10">
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Revenue</p>
                        <h3 class="text-4xl font-black text-green-500 mt-2 italic">₱{{ number_format($sessions->where('payment_status', 'paid')->sum('amount'), 0) }}</h3>
                    </div>
                    <div class="bg-[#161f2c]/50 border border-white/5 p-6 rounded-2xl border-l-4 border-red-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-red-500/10">
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Unpaid</p>
                        <h3 class="text-4xl font-black text-red-500 mt-2 italic">{{ $sessions->where('payment_status', 'unpaid')->count() }}</h3>
                    </div>
                    <div class="bg-[#161f2c]/50 border border-white/5 p-6 rounded-2xl border-l-4 border-orange-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-orange-500/10">
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Upcoming</p>
                        <h3 class="text-4xl font-black text-orange-500 mt-2 italic">{{ $sessions->where('scheduled_at', '>', now())->count() }}</h3>
                    </div>
                </div>

                <div class="bg-[#161f2c]/30 backdrop-blur-xl border border-white/5 rounded-[2rem] overflow-hidden shadow-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-white/[0.02] text-gray-600 uppercase text-[9px] font-black tracking-[0.3em]">
                            <tr>
                                <th class="px-8 py-6">Workout Session</th>
                                <th class="px-8 py-6">Schedule</th>
                                <th class="px-8 py-6">Client / Trainer</th>
                                <th class="px-8 py-6 text-center">Fee</th>
                                <th class="px-8 py-6 text-center">Status</th>
                                <th class="px-8 py-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($sessions as $session)
                            <!-- HOVER EFFECT ADDED HERE -->
                            <tr class="hover:bg-white/[0.04] hover:border-l-4 hover:border-blue-500 transition-all duration-200 group border-l-4 border-transparent">
                                <td class="px-8 py-6">
                                    <div class="text-white font-black text-base uppercase italic">{{ $session->title }}</div>
                                    <div class="text-[9px] text-gray-600 font-black uppercase mt-1">Ref #{{ str_pad($session->id, 5, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-white font-bold text-sm">{{ \Carbon\Carbon::parse($session->scheduled_at)->format('M d, Y') }}</div>
                                    <div class="text-gray-500 text-[10px] font-bold mt-1">{{ \Carbon\Carbon::parse($session->scheduled_at)->format('h:i A') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-white font-bold text-sm">{{ $session->user->name }}</div>
                                    <div class="text-blue-500 text-[10px] font-black uppercase italic mt-1">Coach: {{ optional($session->trainer)->name ?? 'To be assigned' }}</div>
                                </td>
                                <td class="px-8 py-6 text-center text-white font-black italic">₱{{ number_format($session->amount, 0) }}</td>
                                <td class="px-8 py-6 text-center">
                                    <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase border {{ $session->payment_status == 'paid' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20' }}">
                                        ● {{ $session->payment_status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="flex justify-center gap-4 text-[10px] font-black uppercase italic tracking-tight">
                                        @if($session->payment_status !== 'paid')
                                            <form action="{{ route('sessions.update', $session) }}" method="POST">@csrf @method('PUT') <input type="hidden" name="payment_status" value="paid"> <button class="text-green-500 hover:underline">Mark Paid</button></form>
                                        @endif
                                        <a href="{{ route('sessions.edit', $session) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('sessions.destroy', $session) }}" method="POST">@csrf @method('DELETE') <button class="text-red-600">Cancel</button></form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            <!-- ========================================== -->
            <!-- 2. TRAINER VIEW (GREEN THEME) -->
            <!-- ========================================== -->
            @elseif(Auth::user()->role === 'trainer')
                <div class="mb-8">
                    <h1 class="text-green-600 font-black text-2xl uppercase tracking-tighter leading-none">MY TRAINING SESSIONS</h1>
                    <p class="text-gray-600 text-sm font-bold uppercase tracking-tight mt-1">Sessions assigned to you — view schedule and client info</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-[#161f2c]/30 border border-white/5 rounded-[2rem] overflow-hidden">
                            <table class="w-full text-left">
                                <thead class="bg-white/[0.02] text-gray-600 uppercase text-[9px] font-black tracking-[0.2em]">
                                    <tr><th class="p-6">Session</th><th class="p-6">Schedule</th><th class="p-6">Client</th><th class="p-6 text-center">Status</th></tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach($sessions as $session)
                                    <!-- HOVER EFFECT ADDED HERE (GREEN BORDER) -->
                                    <tr class="hover:bg-white/[0.04] hover:border-l-4 hover:border-green-500 transition-all duration-200 group border-l-4 border-transparent">
                                        <td class="p-6">
                                            <div class="text-white font-black text-base uppercase italic">{{ $session->title }}</div>
                                            <div class="text-[9px] text-gray-600 font-black uppercase mt-1">REF #{{ str_pad($session->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td class="p-6">
                                            <div class="text-white font-bold text-sm">{{ \Carbon\Carbon::parse($session->scheduled_at)->format('M d, Y') }}</div>
                                            <div class="text-gray-500 text-[10px] font-black uppercase">{{ \Carbon\Carbon::parse($session->scheduled_at)->format('h:i A') }}</div>
                                        </td>
                                        <td class="p-6 text-white font-black uppercase text-sm italic">{{ $session->user->name }}</td>
                                        <td class="p-6 text-center">
                                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase border {{ $session->payment_status == 'paid' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-orange-500/10 text-orange-500 border-orange-500/20' }}">
                                                ● {{ $session->payment_status == 'paid' ? 'Done' : 'Upcoming' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-[#161f2c] p-8 rounded-[2rem] border border-white/5 h-fit shadow-2xl transition-all duration-500 hover:shadow-green-500/5">
                        <h4 class="text-white font-black uppercase italic tracking-tighter text-lg mb-6">Today's Schedule</h4>
                        @forelse($sessions->where('scheduled_at', '>=', today())->where('scheduled_at', '<', today()->addDay()) as $today)
                            <div class="p-5 bg-white/5 rounded-2xl border-l-4 border-green-500 mb-4 transition-all hover:bg-white/10">
                                <p class="text-gray-500 text-[10px] font-black uppercase">{{ \Carbon\Carbon::parse($today->scheduled_at)->format('h:i A') }}</p>
                                <h5 class="text-white font-black text-lg italic uppercase">{{ $today->user->name }}</h5>
                            </div>
                        @empty
                            <p class="text-gray-600 font-black italic text-center py-4 uppercase tracking-widest">No more today</p>
                        @endforelse
                    </div>
                </div>

            <!-- ========================================== -->
            <!-- 3. CLIENT VIEW (PURPLE THEME) -->
            <!-- ========================================== -->
            @elseif(Auth::user()->role === 'client')
                <div class="mb-8">
                    <h1 class="text-[#7c3aed] font-black text-2xl uppercase tracking-tighter leading-none">MY TRAINING SESSIONS</h1>
                    <p class="text-gray-600 text-sm font-bold uppercase tracking-tight mt-1">Your personal session history and payment records</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-[#161f2c]/30 border border-white/5 rounded-[2rem] overflow-hidden shadow-2xl mb-8">
                            <table class="w-full text-left">
                                <thead class="bg-white/[0.02] text-gray-600 uppercase text-[9px] font-black tracking-[0.2em]">
                                    <tr><th class="p-6">Session</th><th class="p-6">Schedule</th><th class="p-6">Trainer</th><th class="p-6 text-center">Payment</th></tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach($sessions as $session)
                                    <!-- HOVER EFFECT ADDED HERE (PURPLE BORDER) -->
                                    <tr class="hover:bg-white/[0.04] hover:border-l-4 hover:border-[#7c3aed] transition-all duration-200 group border-l-4 border-transparent">
                                        <td class="p-6"><div class="text-white font-black text-base uppercase italic leading-none">{{ $session->title }}</div><p class="text-[8px] text-gray-700 font-black uppercase mt-1 tracking-widest">REF #{{ str_pad($session->id, 5, '0', STR_PAD_LEFT) }}</p></td>
                                        <td class="p-6 text-white font-bold text-sm">{{ \Carbon\Carbon::parse($session->scheduled_at)->format('M d, Y') }}</td>
                                        <td class="p-6 text-blue-500 font-black uppercase text-sm italic">{{ optional($session->trainer)->name ?? 'To be assigned' }}</td>
                                        <td class="p-6 text-center">
                                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase border {{ $session->payment_status == 'paid' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20' }}">● {{ $session->payment_status }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-[#161f2c] p-8 rounded-[2rem] border border-white/5 shadow-2xl h-fit transition-all duration-500 hover:shadow-purple-500/5">
                        <h4 class="text-white font-black uppercase italic tracking-tighter text-lg mb-8">My Progress</h4>
                        <div class="space-y-6">
                            <div><div class="flex justify-between text-[10px] font-black uppercase mb-2"><span class="text-gray-500">Attendance</span><span class="text-green-500">100%</span></div><div class="w-full h-1.5 bg-white/5 rounded-full"><div class="h-full bg-green-500 shadow-[0_0_10px_#22c55e]" style="width: 100%"></div></div></div>
                            <div><div class="flex justify-between text-[10px] font-black uppercase mb-2"><span class="text-gray-500">Amount Paid</span><span class="text-blue-500">₱{{ number_format($sessions->where('payment_status', 'paid')->sum('amount'), 0) }}</span></div><div class="w-full h-1.5 bg-white/5 rounded-full"><div class="h-full bg-blue-500 shadow-[0_0_10px_#3b82f6]" style="width: 50%"></div></div></div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>