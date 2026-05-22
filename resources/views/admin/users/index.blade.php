<x-app-layout>
    <div class="py-8 bg-[#0b111b] min-h-screen text-gray-300 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- 1. TOP HEADER -->
            <div class="mb-8">
                <h1 class="text-blue-500 font-black text-2xl uppercase tracking-tighter leading-none">USER MANAGEMENT</h1>
                <p class="text-gray-600 text-sm font-bold uppercase tracking-tight mt-1">Assign roles, manage trainer profiles, and control system access</p>
            </div>

            <!-- 2. STATS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
                <div class="bg-[#161f2c]/50 border border-white/5 p-6 rounded-2xl border-l-4 border-gray-700 shadow-xl">
                    <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Total Users</p>
                    <h3 class="text-4xl font-black text-blue-500 mt-2 italic">{{ $users->count() }}</h3>
                </div>
                <div class="bg-[#161f2c]/50 border border-white/5 p-6 rounded-2xl border-l-4 border-blue-500 shadow-xl">
                    <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Admins</p>
                    <h3 class="text-4xl font-black text-white mt-2 italic">{{ $users->where('role', 'admin')->count() }}</h3>
                </div>
                <div class="bg-[#161f2c]/50 border border-white/5 p-6 rounded-2xl border-l-4 border-green-500 shadow-xl">
                    <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Trainers</p>
                    <h3 class="text-4xl font-black text-white mt-2 italic">{{ $users->where('role', 'trainer')->count() }}</h3>
                </div>
                <div class="bg-[#161f2c]/50 border border-white/5 p-6 rounded-2xl border-l-4 border-purple-500 shadow-xl">
                    <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Clients</p>
                    <h3 class="text-4xl font-black text-white mt-2 italic">{{ $users->where('role', 'client')->count() }}</h3>
                </div>
            </div>

            <!-- 3. SEARCH & FILTERS -->
            <div class="flex flex-col lg:flex-row justify-between items-center mb-8 gap-6">
                <div class="flex flex-wrap items-center gap-2">
                    @php $currentRole = request('role', 'all'); @endphp
                    <a href="{{ route('users.index', ['role' => 'all', 'search' => request('search')]) }}" class="{{ $currentRole === 'all' ? 'bg-blue-600/20 text-blue-400 border-blue-500/30 shadow-lg' : 'bg-gray-800/40 text-gray-500 border-transparent' }} px-6 py-2.5 rounded-xl text-[11px] font-black uppercase border transition-all hover:text-white">All Users</a>
                    <a href="{{ route('users.index', ['role' => 'admin', 'search' => request('search')]) }}" class="{{ $currentRole === 'admin' ? 'bg-blue-600/20 text-blue-400 border-blue-500/30' : 'bg-gray-800/40 text-gray-500 border-transparent' }} px-6 py-2.5 rounded-xl text-[11px] font-black uppercase border transition-all hover:text-white">Admins</a>
                    <a href="{{ route('users.index', ['role' => 'trainer', 'search' => request('search')]) }}" class="{{ $currentRole === 'trainer' ? 'bg-blue-600/20 text-blue-400 border-blue-500/30' : 'bg-gray-800/40 text-gray-500 border-transparent' }} px-6 py-2.5 rounded-xl text-[11px] font-black uppercase border transition-all hover:text-white">Trainers</a>
                    <a href="{{ route('users.index', ['role' => 'client', 'search' => request('search')]) }}" class="{{ $currentRole === 'client' ? 'bg-blue-600/20 text-blue-400 border-blue-500/30' : 'bg-gray-800/40 text-gray-500 border-transparent' }} px-6 py-2.5 rounded-xl text-[11px] font-black uppercase border transition-all hover:text-white">Clients</a>
                </div>

                <form action="{{ route('users.index') }}" method="GET" class="relative w-full lg:max-w-md group">
                    <input type="hidden" name="role" value="{{ request('role', 'all') }}">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-600 group-focus-within:text-blue-500 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="SEARCH BY NAME OR EMAIL..." class="bg-gray-900 border border-white/5 text-gray-300 text-[11px] rounded-2xl block w-full pl-12 p-4 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 focus:bg-gray-800 transition-all font-black italic tracking-widest shadow-2xl">
                </form>
            </div>

            <!-- 4. HEADER LABELS -->
            <div class="hidden lg:grid grid-cols-12 gap-4 px-10 mb-4 text-gray-600 font-black text-[9px] uppercase tracking-[0.3em]">
                <div class="col-span-4">User Information & Availability</div>
                <div class="col-span-3">Assign Role</div>
                <div class="col-span-3">Trainer Specialization / Hours</div>
                <div class="col-span-2 text-center">Actions</div>
            </div>

            <!-- 5. USER CARD LIST -->
            <div class="space-y-4">
                @foreach($users as $user)
                <div class="bg-[#161f2c]/40 backdrop-blur-xl border border-white/5 rounded-[2rem] p-8 hover:bg-white/[0.03] transition-all group">
                    <form action="{{ route('users.update', $user) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        @csrf @method('PATCH')

                        <!-- User Profile & Queue Status -->
                        <div class="col-span-4 flex items-start">
                            <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-black italic text-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] mr-6 mt-1">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-3">
                                    <h5 class="text-white font-black text-lg uppercase tracking-tight">{{ $user->name }}</h5>
                                    <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase {{ $user->role == 'admin' ? 'bg-blue-500/20 text-blue-500' : ($user->role == 'trainer' ? 'bg-green-500/20 text-green-500' : 'bg-[#7c3aed]/20 text-[#7c3aed]') }}">
                                        {{ $user->role }}
                                    </span>
                                </div>
                                <p class="text-gray-500 text-xs mt-1">{{ $user->email }}</p>

                                <!-- INTEGRATED QUEUE LOGIC FOR TRAINERS -->
                                @if($user->role === 'trainer')
                                    <div class="mt-4 flex items-center gap-2">
                                        @php $load = $user->activeTrainees ? $user->activeTrainees->count() : 0; @endphp
                                        <span class="flex h-2 w-2 rounded-full {{ $load >= 5 ? 'bg-red-500 animate-pulse' : 'bg-green-500' }}"></span>
                                        <p class="text-[9px] font-black uppercase tracking-widest">
                                            Queue: <span class="{{ $load >= 5 ? 'text-red-500' : 'text-green-500' }}">{{ $load >= 5 ? 'FULL (5/5)' : 'READY ('.$load.'/5)' }}</span>
                                        </p>
                                    </div>
                                    <p class="text-[8px] text-gray-600 uppercase mt-1 font-bold italic">
                                        Last Assigned: {{ $user->last_assigned_at ? \Carbon\Carbon::parse($user->last_assigned_at)->diffForHumans() : 'Idle' }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Role Selector -->
                        <div class="col-span-3">
                            <label class="text-[9px] font-black text-gray-700 uppercase mb-2 block tracking-widest">Permission Level</label>
                            <select name="role" class="bg-gray-900 border border-white/10 text-white font-black text-xs uppercase italic rounded-xl w-full p-4 focus:ring-blue-500 transition">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="trainer" {{ $user->role == 'trainer' ? 'selected' : '' }}>Trainer</option>
                                <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>Client</option>
                            </select>
                        </div>

                        <!-- Trainer Specialization Fields -->
                        <div class="col-span-3">
                            @if($user->role === 'trainer')
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-[8px] font-black text-gray-700 uppercase block mb-1">Workout Specialization</label>
                                        <input type="text" name="specialization" value="{{ $user->specialization }}" placeholder="e.g. Boxing & MMA" class="bg-gray-900 border border-white/10 text-white font-bold text-[10px] rounded-xl w-full p-3 uppercase tracking-wider focus:border-green-500">
                                    </div>
                                    <div>
                                        <label class="text-[8px] font-black text-gray-700 uppercase block mb-1">Working Hours</label>
                                        <input type="text" name="working_hours" value="{{ $user->working_hours }}" placeholder="e.g. 8AM - 5PM" class="bg-gray-900 border border-white/10 text-white font-bold text-[10px] rounded-xl w-full p-3 uppercase tracking-wider focus:border-green-500">
                                    </div>
                                </div>
                            @else
                                <div class="bg-black/20 border border-white/5 rounded-2xl p-6 flex flex-col items-center justify-center opacity-40">
                                    <p class="text-[9px] font-black text-gray-600 text-center uppercase tracking-widest italic">Trainer Profile Disabled</p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-span-2 flex flex-col gap-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl text-[10px] font-black uppercase italic shadow-lg transition transform group-hover:scale-105">Sync Data</button>
                            @if($user->id !== Auth::id())
                                <button type="button" class="bg-transparent hover:bg-red-500/10 text-gray-500 hover:text-red-500 border border-white/5 py-3 rounded-xl text-[10px] font-black uppercase transition italic">Deactivate</button>
                            @endif
                        </div>
                    </form>
                </div>
                @endforeach
            </div>

            <!-- 6. PAGINATION FOOTER -->
            <div class="mt-10 flex justify-between items-center text-gray-600">
                <p class="text-[10px] font-bold uppercase tracking-widest">Sync complete: {{ $users->count() }} active directory records</p>
                <div class="flex gap-1">
                    <button class="bg-blue-600 text-white w-10 h-10 rounded-xl text-[10px] font-black uppercase shadow-lg shadow-blue-900/40">1</button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>