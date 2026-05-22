<x-app-layout>
    <div class="py-8 bg-[#0b111b] min-h-screen text-gray-300 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- 1. UNIVERSAL HEADER -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-blue-500 font-black text-[10px] uppercase tracking-[0.3em]">
                    @if(Auth::user()->role === 'admin') PERFORMANCE DASHBOARD 
                    @elseif(Auth::user()->role === 'trainer') TRAINER DASHBOARD
                    @else MY DASHBOARD @endif
                </h2>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">{{ now()->format('M d, Y') }}</p>
            </div>

            <!-- ========================================== -->
            <!-- CLIENT VIEW SECTION (PURPLE THEME) -->
            <!-- ========================================== -->
            @if(Auth::user()->role === 'client')
                <div class="bg-gradient-to-r from-[#1a162c] to-[#161f2c] border border-purple-500/10 p-8 rounded-[2rem] mb-6 flex flex-col md:flex-row justify-between items-center shadow-2xl transition-all duration-500 hover:shadow-purple-500/5">
                    <div>
                        <h1 class="text-3xl font-black text-white italic uppercase leading-none mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                        <div class="flex items-center gap-3">
                            <span class="bg-purple-600/20 text-purple-400 text-[9px] font-black uppercase px-3 py-0.5 rounded border border-purple-500/30">CLIENT</span>
                            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Athlete Level Progress: Active</p>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6 md:mt-0">
                        <a href="{{ route('sessions.index') }}" class="bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase border border-white/10 transition-all hover:scale-105">My History</a>
                        <a href="{{ route('sessions.create') }}" class="bg-[#7c3aed] hover:bg-[#6d28d9] text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase transition-all shadow-lg shadow-purple-900/40 hover:scale-105 hover:shadow-purple-500/50">Book Session</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-purple-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-purple-500/20">
                        <p class="text-gray-500 text-[9px] font-black uppercase tracking-widest">Sessions Booked</p>
                        <h3 class="text-5xl font-black text-white my-2 italic">{{ \App\Models\TrainingSession::where('user_id', Auth::id())->count() }}</h3>
                    </div>
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-green-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-green-500/20">
                        <p class="text-gray-500 text-[9px] font-black uppercase tracking-widest">Sessions Done</p>
                        <h3 class="text-5xl font-black text-white my-2 italic">1</h3>
                    </div>
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-blue-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-blue-500/20">
                        <p class="text-gray-500 text-[9px] font-black uppercase tracking-widest">My Trainer</p>
                        @php $latest = \App\Models\TrainingSession::where('user_id', Auth::id())->with('trainer')->latest()->first(); @endphp
                        <h3 class="text-xl font-black text-blue-500 mt-4 italic uppercase">{{ $latest->trainer->name ?? 'To be assigned' }}</h3>
                    </div>
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-orange-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-orange-500/20">
                        <p class="text-gray-500 text-[9px] font-black uppercase tracking-widest">Total Paid</p>
                        <h3 class="text-4xl font-black text-orange-500 my-3 italic">₱{{ number_format(\App\Models\TrainingSession::where('user_id', Auth::id())->where('payment_status', 'paid')->sum('amount'), 0) }}</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-[#161f2c] p-8 rounded-[2rem] border border-white/5 shadow-2xl transition-all duration-500 hover:shadow-purple-500/5">
                        <h4 class="text-white font-black uppercase italic tracking-tighter text-lg mb-8">My Progress</h4>
                        <div class="space-y-6">
                            <div><div class="flex justify-between text-[9px] font-black uppercase mb-2"><span class="text-gray-500">Attendance Rate</span><span class="text-green-500">100%</span></div><div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden"><div class="h-full bg-green-500" style="width: 100%"></div></div></div>
                        </div>
                    </div>
                    <div class="bg-[#161f2c] p-8 rounded-[2rem] border border-white/5 transition-all duration-500 hover:shadow-blue-500/5">
                        <h4 class="text-white font-black uppercase italic tracking-tighter text-lg mb-6">Payment History</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b border-white/5 pb-4"><span class="text-white font-bold text-sm">Active Subscriptions</span><span class="text-green-500 font-black italic text-sm">₱{{ number_format(\App\Models\TrainingSession::where('user_id', Auth::id())->sum('amount'), 0) }}</span></div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- TRAINER VIEW SECTION (GREEN THEME) -->
            <!-- ========================================== -->
            @if(Auth::user()->role === 'trainer')
                <div class="bg-gradient-to-r from-[#11261d] to-[#161f2c] border border-green-500/10 p-8 rounded-[2rem] mb-6 flex flex-col md:flex-row justify-between items-center shadow-2xl transition-all duration-500 hover:shadow-green-500/5">
                    <div>
                        <h1 class="text-3xl font-black text-white italic uppercase leading-none mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                        <div class="flex items-center gap-3">
                            <span class="bg-green-600 text-white text-[9px] font-black uppercase px-3 py-0.5 rounded">TRAINER</span>
                            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Active Specialization: {{ Auth::user()->specialization }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6 md:mt-0">
                        <a href="{{ route('sessions.index') }}" class="bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase border border-white/10 transition-all hover:scale-105">View Schedule</a>
                    </div>
                </div>

                <div class="bg-[#161f2c] p-6 rounded-3xl border border-white/5 shadow-2xl mb-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-green-500/10">
                    <div class="flex justify-between items-center">
                        <div><h4 class="text-white font-black uppercase italic text-xs tracking-widest">My Queue Capacity</h4><p class="text-gray-500 text-[10px] mt-1 uppercase">Limit: 5 active clients</p></div>
                        <div class="text-right"><span class="text-2xl font-black text-green-500 italic">{{ Auth::user()->activeTrainees ? Auth::user()->activeTrainees->count() : 0 }} / 5</span></div>
                    </div>
                    <div class="w-full h-1.5 bg-white/5 rounded-full mt-4 overflow-hidden"><div class="h-full bg-green-500 shadow-[0_0_10px_#22c55e]" style="width: {{ ((Auth::user()->activeTrainees ? Auth::user()->activeTrainees->count() : 0) / 5) * 100 }}%"></div></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-green-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-green-500/20"><p class="text-gray-500 text-[9px] font-black uppercase">Sessions Today</p><h3 class="text-5xl font-black text-white my-2 italic">{{ \App\Models\TrainingSession::where('trainer_id', Auth::id())->whereDate('scheduled_at', today())->count() }}</h3></div>
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-blue-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-blue-500/20"><p class="text-gray-500 text-[9px] font-black uppercase">Total Sessions</p><h3 class="text-5xl font-black text-white my-2 italic">{{ \App\Models\TrainingSession::where('trainer_id', Auth::id())->count() }}</h3></div>
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-purple-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-purple-500/20"><p class="text-gray-500 text-[9px] font-black uppercase">My Clients</p><h3 class="text-5xl font-black text-white my-2 italic">{{ \App\Models\TrainingSession::where('trainer_id', Auth::id())->distinct('user_id')->count() }}</h3></div>
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-orange-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-orange-500/20"><p class="text-gray-500 text-[9px] font-black uppercase">Completion</p><h3 class="text-5xl font-black text-orange-500 my-2 italic">100%</h3></div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- ADMIN VIEW SECTION (BLUE THEME) -->
            <!-- ========================================== -->
            @if(Auth::user()->role === 'admin')
                <div class="bg-gradient-to-r from-[#161f2c] to-[#1a2635] border border-white/5 p-8 rounded-[2rem] mb-6 flex flex-col md:flex-row justify-between items-center shadow-2xl transition-all duration-500 hover:shadow-blue-500/10">
                    <div>
                        <h1 class="text-3xl font-black text-white italic uppercase leading-none mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                        <div class="flex items-center gap-3">
                            <span class="bg-blue-600 text-white text-[9px] font-black uppercase px-3 py-0.5 rounded shadow-lg">ADMIN</span>
                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">Logged in at {{ now()->format('h:i A') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6 md:mt-0 relative z-10">
                        <a href="{{ route('sessions.create') }}" class="bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase border border-white/10 transition-all hover:scale-105">+ New Session</a>
                        <a href="{{ route('sessions.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase transition-all shadow-lg shadow-blue-900/40 hover:scale-105 hover:shadow-blue-500/50">View Reports</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-blue-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-blue-500/20"><p class="text-gray-500 text-[9px] font-black uppercase">Booked</p><h3 class="text-5xl font-black text-white my-2 italic">{{ \App\Models\TrainingSession::count() }}</h3></div>
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-green-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-green-500/20"><p class="text-gray-500 text-[9px] font-black uppercase">Revenue</p><h3 class="text-5xl font-black text-green-500 my-2 italic">₱{{ number_format(\App\Models\TrainingSession::where('payment_status', 'paid')->sum('amount'), 0) }}</h3></div>
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-purple-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-purple-500/20"><p class="text-gray-500 text-[9px] font-black uppercase">Trainers</p><h3 class="text-5xl font-black text-white my-2 italic">{{ \App\Models\User::where('role', 'trainer')->count() }}</h3></div>
                    <div class="bg-[#161f2c] p-6 rounded-[1.5rem] border-l-2 border-orange-500 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-orange-500/20"><p class="text-gray-500 text-[9px] font-black uppercase">Clients</p><h3 class="text-5xl font-black text-white my-2 italic">{{ \App\Models\User::where('role', 'client')->count() }}</h3></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-[#161f2c] p-8 rounded-[2rem] border border-white/5 shadow-2xl transition-all duration-500 hover:shadow-white/5">
                        <div class="flex justify-between items-center mb-6"><h4 class="text-white font-black uppercase italic tracking-tighter">Recent Sessions</h4><a href="{{ route('sessions.index') }}" class="text-blue-500 text-[10px] font-black uppercase underline">View all ↗</a></div>
                        <div class="space-y-4">
                            @foreach(\App\Models\TrainingSession::with('user')->latest()->take(3)->get() as $session)
                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 transition-all hover:bg-white/10"><p class="text-white font-bold text-sm">{{ $session->user->name }}</p><span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase italic bg-green-500/10 text-green-500 border border-green-500/20">Done</span></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-[#161f2c] p-8 rounded-[2rem] border border-white/5 shadow-2xl transition-all duration-500 hover:shadow-white/5">
                        <h4 class="text-white font-black uppercase italic tracking-tighter mb-6">Revenue Performance</h4>
                        <div class="space-y-5">
                            @foreach(['Mon' => 85, 'Tue' => 55, 'Wed' => 15] as $day => $percent)
                            <div class="flex items-center gap-4"><span class="text-[10px] font-black text-gray-500 w-10 uppercase">{{ $day }}</span><div class="flex-1 h-8 bg-white/5 rounded-lg overflow-hidden"><div class="h-full bg-blue-600/80 transition-all duration-1000" style="width: {{ $percent }}%"></div></div></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-[#161f2c] p-8 rounded-[2rem] border border-white/5 shadow-2xl transition-all duration-500 hover:shadow-white/5">
                    <div class="flex justify-between items-center mb-8"><h4 class="text-white text-xl font-black uppercase italic tracking-tighter">All Users</h4><a href="{{ route('users.index') }}" class="text-blue-500 text-[11px] font-black uppercase underline italic">Manage Users ↗</a></div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead><tr class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em] border-b border-white/5"><th class="pb-4">Name</th><th class="pb-4">Role</th><th class="pb-4 text-center">Sessions</th><th class="pb-4">Status</th></tr></thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                                <tr class="hover:bg-white/[0.02] transition">
                                    <td class="py-4 text-white font-bold text-sm">{{ $user->name }}</td>
                                    <td class="py-4"><span class="px-2 py-0.5 rounded text-[8px] font-black uppercase {{ $user->role == 'admin' ? 'bg-blue-500/20 text-blue-500' : ($user->role == 'trainer' ? 'bg-green-500/20 text-green-500' : 'bg-purple-500/20 text-purple-500') }}">{{ $user->role }}</span></td>
                                    <td class="py-4 text-center text-gray-400 font-bold text-sm">{{ $user->role == 'client' ? \App\Models\TrainingSession::where('user_id', $user->id)->count() : \App\Models\TrainingSession::where('trainer_id', $user->id)->count() }}</td>
                                    <td class="py-4"><span class="px-2 py-0.5 rounded text-[8px] font-black uppercase bg-green-500/10 text-green-500">Active</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>