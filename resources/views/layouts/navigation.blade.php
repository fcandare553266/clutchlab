@php
    $user = Auth::user();
    $notifications = [];

    // 1. DATA LOGIC: Fetch notifications based on role
    if ($user->role === 'admin') {
        $newBookings = \App\Models\TrainingSession::with('user')->latest()->take(3)->get();
        foreach($newBookings as $s) {
            $notifications[] = ['title' => 'New Booking', 'desc' => ($s->user->name ?? 'Guest') . ' booked ' . $s->title, 'time' => $s->created_at->diffForHumans(), 'icon' => '🎫', 'color' => 'blue'];
        }
        $notifications[] = ['title' => 'System Login', 'desc' => 'Admin session active since ' . now()->format('h:i A'), 'time' => 'Just now', 'icon' => '🔐', 'color' => 'purple'];
    } 
    elseif ($user->role === 'trainer') {
        $assigned = \App\Models\TrainingSession::where('trainer_id', $user->id)->latest()->take(5)->get();
        foreach($assigned as $s) {
            $notifications[] = ['title' => 'New Assignment', 'desc' => 'You are assigned to ' . ($s->user->name ?? 'Client'), 'time' => $s->created_at->diffForHumans(), 'icon' => '💪', 'color' => 'green'];
        }
    } 
    else {
        $payments = \App\Models\TrainingSession::where('user_id', $user->id)->where('payment_status', 'paid')->latest()->take(5)->get();
        foreach($payments as $s) {
            $notifications[] = ['title' => 'Payment Approved', 'desc' => 'Your ' . $s->title . ' session is confirmed', 'time' => $s->updated_at->diffForHumans(), 'icon' => '✅', 'color' => 'purple'];
        }
    }
@endphp

<nav x-data="{ open: false }" class="bg-[#0b111b] border-b border-white/5 sticky top-0 z-50 shadow-2xl">
    <!-- Primary Navigation Menu (Desktop) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <!-- LEFT SIDE: LOGO & LINKS -->
            <div class="flex items-center gap-10">
                <div class="shrink-0 flex items-center border-r border-white/10 pr-8">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-black italic tracking-tighter text-blue-500 uppercase">
                        CLUTCH<span class="text-white">LAB</span>
                    </a>
                </div>

                <div class="hidden space-x-2 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="px-5 py-2 rounded-xl text-[11px] font-black uppercase italic tracking-widest transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600/10 text-white border-blue-500/50 shadow-lg' : 'text-gray-500 hover:text-gray-300 border-transparent' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('sessions.index')" :active="request()->routeIs('sessions.index')" 
                        class="px-5 py-2 rounded-xl text-[11px] font-black uppercase italic tracking-widest transition-all {{ request()->routeIs('sessions.index') ? 'bg-blue-600/10 text-white border-blue-500/50 shadow-lg' : 'text-gray-500 hover:text-gray-300 border-transparent' }}">
                        {{ __('My Sessions') }}
                    </x-nav-link>

                    @if($user->role === 'admin')
                        <x-nav-link :href="route('sessions.create')" :active="request()->routeIs('sessions.create')" class="px-5 py-2 rounded-xl text-[11px] font-black uppercase italic tracking-widest transition-all {{ request()->routeIs('sessions.create') ? 'bg-blue-600/10 text-white border-blue-500/50 shadow-lg' : 'text-gray-500 hover:text-gray-300 border-transparent' }}">{{ __('Book Training') }}</x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="px-5 py-2 rounded-xl text-[11px] font-black uppercase italic tracking-widest transition-all {{ request()->routeIs('users.index') ? 'bg-blue-600/10 text-white border-blue-500/50 shadow-lg' : 'text-gray-500 hover:text-gray-300 border-transparent' }}">{{ __('Manage Users') }}</x-nav-link>
                    @elseif($user->role === 'trainer')
                        <x-nav-link :href="route('trainer.clients')" :active="request()->routeIs('trainer.clients')" class="px-5 py-2 rounded-xl text-[11px] font-black uppercase italic tracking-widest transition-all {{ request()->routeIs('trainer.clients') ? 'bg-green-600/10 text-white border-green-500/50 shadow-lg' : 'text-gray-500 hover:text-green-500 border-transparent' }}">{{ __('My Clients') }}</x-nav-link>
                    @else
                        <x-nav-link :href="route('sessions.create')" :active="request()->routeIs('sessions.create')" class="px-5 py-2 rounded-xl text-[11px] font-black uppercase italic tracking-widest transition-all {{ request()->routeIs('sessions.create') ? 'bg-blue-600/10 text-white border-blue-500/50 shadow-lg' : 'text-gray-500 hover:text-gray-300 border-transparent' }}">{{ __('Book Training') }}</x-nav-link>
                    @endif
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="flex items-center gap-4">
                
                <!-- NOTIFICATION BELL -->
                <x-dropdown align="right" width="80">
                    <x-slot name="trigger">
                        <button class="p-3 bg-white/5 hover:bg-white/10 rounded-xl text-gray-500 hover:text-white transition relative border border-white/5 group">
                            <svg class="h-5 w-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if(count($notifications) > 0)
                                <span class="absolute top-2.5 right-2.5 h-2 w-2 bg-red-500 rounded-full border border-[#0b111b] animate-pulse"></span>
                            @endif
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="w-80 bg-[#161f2c] border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
                            <div class="p-4 border-b border-white/5 bg-white/[0.02] flex justify-between"><h4 class="text-white font-black uppercase italic text-[10px]">Recent Activity</h4></div>
                            <div class="max-h-96 overflow-y-auto">
                                @forelse($notifications as $note)
                                    <div class="p-4 border-b border-white/5 hover:bg-white/[0.03] transition">
                                        <p class="text-white font-bold text-[11px] uppercase">{{ $note['title'] }}</p>
                                        <p class="text-gray-500 text-[10px]">{{ $note['desc'] }}</p>
                                        <p class="text-gray-600 text-[8px] font-black uppercase mt-1">{{ $note['time'] }}</p>
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-gray-600 text-[10px] uppercase font-black">No alerts</div>
                                @endforelse
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>

                <!-- PROFILE DROPDOWN (DYNAMIC PHOTO) -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 p-1.5 pr-4 bg-[#161f2c] border border-white/5 rounded-2xl group transition">
                            
                            <!-- DYNAMIC PHOTO LOGIC -->
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" class="h-9 w-9 rounded-xl object-cover shadow-lg border border-white/10">
                            @else
                                <div class="h-9 w-9 rounded-xl flex items-center justify-center text-white font-black italic text-xs shadow-lg transition
                                    {{ $user->role === 'admin' ? 'bg-blue-600' : ($user->role === 'trainer' ? 'bg-green-600' : 'bg-[#7c3aed]') }}">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                            @endif

                            <div class="text-left hidden md:block leading-tight">
                                <p class="text-white font-black uppercase italic text-[11px]">{{ $user->name }}</p>
                                <p class="text-[9px] font-black uppercase text-blue-500">{{ $user->role }}</p>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-[10px] font-black uppercase italic">Profile Settings</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-500 text-[10px] font-black uppercase italic">{{ __('Log Out') }}</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

                <!-- Hamburger (Mobile Only) -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile View) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#161f2c] border-t border-white/5">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white uppercase font-black italic text-xs">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('sessions.index')" :active="request()->routeIs('sessions.index')" class="text-white uppercase font-black italic text-xs">My Sessions</x-responsive-nav-link>
            @if($user->role === 'admin')
                <x-responsive-nav-link :href="route('sessions.create')" :active="request()->routeIs('sessions.create')" class="text-white uppercase font-black italic text-xs">Book Session</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="text-white uppercase font-black italic text-xs">Manage Users</x-responsive-nav-link>
            @elseif($user->role === 'trainer')
                <x-responsive-nav-link :href="route('trainer.clients')" :active="request()->routeIs('trainer.clients')" class="text-white uppercase font-black italic text-xs">My Clients</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('sessions.create')" :active="request()->routeIs('sessions.create')" class="text-white uppercase font-black italic text-xs">Book Session</x-responsive-nav-link>
            @endif
        </div>
        
        <!-- Mobile Profile Options -->
        <div class="pt-4 pb-1 border-t border-white/5 px-4">
            <div class="flex items-center gap-3 mb-3">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" class="h-8 w-8 rounded-lg object-cover">
                @endif
                <div class="font-black uppercase italic text-sm text-blue-500">{{ $user->name }}</div>
            </div>
            <div class="text-[10px] text-gray-500 uppercase font-black">{{ $user->email }}</div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="text-red-500 uppercase font-black italic text-xs">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>