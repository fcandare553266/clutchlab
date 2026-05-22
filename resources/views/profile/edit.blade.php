<x-app-layout>
    @php
        $user = Auth::user();
        $role = $user->role;
        // Determine Theme Color
        $accent = ($role === 'trainer') ? 'green-500' : (($role === 'client') ? 'purple-500' : 'blue-500');
        $accentBg = ($role === 'trainer') ? 'bg-green-500' : (($role === 'client') ? 'bg-[#7c3aed]' : 'bg-blue-600');
        $border = ($role === 'trainer') ? 'border-green-500/20' : (($role === 'client') ? 'border-purple-500/20' : 'border-blue-500/20');
    @endphp

    <div class="py-8 bg-[#0b111b] min-h-screen text-gray-300 font-sans">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- 1. HEADER NAVIGATION -->
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('dashboard') }}" class="p-2.5 bg-white/5 border border-white/10 rounded-xl text-gray-400 hover:text-white transition shadow-2xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-{{ $accent }} font-black text-xl uppercase tracking-tighter leading-none">MY PROFILE</h1>
                    <p class="text-gray-600 text-[10px] font-bold uppercase tracking-tight mt-1">
                        @if($role === 'admin') Manage your admin account details and password @elseif($role === 'trainer') Manage your trainer account, specialization, and password @else Manage your personal details and account security @endif
                    </p>
                </div>
            </div>

            <!-- 2. PROFILE INFORMATION SECTION -->
            <div class="bg-[#161f2c]/30 backdrop-blur-xl border border-white/5 rounded-[2.5rem] p-10 shadow-2xl mb-8">
                <div class="flex items-center gap-4 mb-10">
                    <div class="p-3 bg-white/5 rounded-xl text-{{ $accent }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-white font-black text-lg uppercase italic leading-none">Profile Information</h2>
                        <p class="text-gray-500 text-[10px] font-bold uppercase mt-1">Update your name and email address</p>
                    </div>
                </div>

                <!-- Avatar & Hero Header -->
              <!-- Avatar & Hero Header -->
<div class="bg-white/[0.02] border border-white/5 rounded-[2rem] p-8 mb-10 flex items-center justify-between">
    <div class="flex items-center gap-6">
        <!-- DYNAMIC AVATAR -->
        @if($user->profile_photo)
            <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-20 h-20 rounded-full object-cover border-2 border-{{ $accent }} shadow-2xl">
        @else
            <div class="w-20 h-20 rounded-full {{ $accentBg }} flex items-center justify-center text-white font-black italic text-3xl shadow-2xl">
                {{ substr($user->name, 0, 2) }}
            </div>
        @endif
        
        <div>
            <h3 class="text-2xl font-black text-white uppercase italic tracking-tight">{{ $user->name }}</h3>
            <div class="flex items-center gap-3 mt-2">
                <span class="{{ $accentBg }} text-white text-[8px] font-black px-3 py-0.5 rounded-md uppercase italic">
                    {{ $role }}
                </span>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">Member since {{ $user->created_at->format('F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- HIDDEN FILE INPUT TRIGGERED BY BUTTON -->
    <div>
        <input type="file" name="profile_photo" id="photo_input" class="hidden" onchange="this.form.submit()">
        <button type="button" onclick="document.getElementById('photo_input').click()" class="px-6 py-3 border border-white/10 rounded-xl text-[10px] font-black uppercase italic text-white hover:bg-white/5 transition">
            Change Photo
        </button>
    </div>
</div>

                <!-- ROLE SPECIFIC OVERVIEW SECTION -->
                <div class="mb-10 p-6 bg-{{ $accent }}/5 border {{ $border }} rounded-[2rem]">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-4 h-4 text-{{ $accent }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h4 class="text-[10px] font-black text-{{ $accent }} uppercase tracking-[0.2em]">
                            @if($role === 'admin') SYSTEM OVERVIEW <span class="text-gray-600 ml-2">ADMIN ONLY</span>
                            @elseif($role === 'trainer') TRAINER PROFILE <span class="text-gray-600 ml-2">TRAINER ONLY</span>
                            @else MY FITNESS OVERVIEW <span class="text-gray-600 ml-2 uppercase">MY STATS</span> @endif
                        </h4>
                    </div>

                    @if($role === 'admin')
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-black/20 p-5 rounded-2xl border border-white/5">
                                <p class="text-gray-500 text-[9px] font-black uppercase">Total Users</p>
                                <p class="text-xl font-black text-blue-500 italic mt-1">{{ \App\Models\User::count() }} <span class="text-[10px] text-gray-700 font-bold uppercase">in system</span></p>
                            </div>
                            <div class="bg-black/20 p-5 rounded-2xl border border-white/5">
                                <p class="text-gray-500 text-[9px] font-black uppercase">Sessions</p>
                                <p class="text-xl font-black text-white italic mt-1">{{ \App\Models\TrainingSession::count() }} <span class="text-[10px] text-gray-700 font-bold uppercase">all-time</span></p>
                            </div>
                            <div class="bg-black/20 p-5 rounded-2xl border border-white/5">
                                <p class="text-gray-500 text-[9px] font-black uppercase">Revenue</p>
                                <p class="text-xl font-black text-green-500 italic mt-1">₱{{ number_format(\App\Models\TrainingSession::where('payment_status', 'paid')->sum('amount'), 0) }} <span class="text-[10px] text-gray-700 font-bold uppercase">collected</span></p>
                            </div>
                        </div>
                    @elseif($role === 'trainer')
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div><p class="text-gray-600 text-[8px] font-black uppercase mb-1">Specialization</p><div class="bg-black/30 p-4 rounded-xl text-white font-black text-sm uppercase italic border border-white/5">{{ $user->specialization ?? 'None Set' }}</div></div>
                            <div><p class="text-gray-600 text-[8px] font-black uppercase mb-1">Working Hours</p><div class="bg-black/30 p-4 rounded-xl text-white font-black text-sm uppercase italic border border-white/5">{{ $user->working_hours ?? 'None Set' }}</div></div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-[9px] font-black uppercase mb-1"><span>Sessions Completed</span><span class="text-green-500">2 / 10</span></div>
                                <div class="h-1.5 bg-black/40 rounded-full"><div class="h-full bg-green-500 rounded-full" style="width: 20%"></div></div>
                            </div>
                        </div>
                    @else
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between text-[9px] font-black uppercase mb-1"><span>Session Package</span><span class="text-purple-500">2 / 5 done</span></div>
                                <div class="h-1.5 bg-black/40 rounded-full"><div class="h-full bg-[#7c3aed] rounded-full shadow-[0_0_10px_#7c3aed]" style="width: 40%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-[9px] font-black uppercase mb-1"><span>Attendance Rate</span><span class="text-green-500">100%</span></div>
                                <div class="h-1.5 bg-black/40 rounded-full"><div class="h-full bg-green-500 rounded-full shadow-[0_0_10px_#22c55e]" style="width: 100%"></div></div>
                            </div>
                            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-2 flex items-center gap-2">👤 Assigned trainer: <span class="text-green-500">Frank Clein</span></p>
                        </div>
                    @endif
                </div>

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf @method('patch')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest mb-2 block italic">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="bg-gray-900 border border-white/10 text-white font-black text-sm uppercase italic rounded-xl w-full p-4 focus:ring-{{ $accent }}">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest mb-2 block italic">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="bg-gray-900 border border-white/10 text-white font-black text-sm uppercase italic rounded-xl w-full p-4 focus:ring-{{ $accent }}">
                        </div>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest mb-2 block italic">Role</label>
                        <div class="bg-black/40 border border-white/5 text-gray-500 font-black text-sm uppercase italic rounded-xl w-full p-4">
                            {{ $role }} — {{ $role === 'admin' ? 'Full System Access' : ($role === 'trainer' ? 'Certified Instructor' : 'Gym Member') }}
                        </div>
                        <p class="text-[8px] text-gray-700 font-bold uppercase mt-2 italic">🔒 Role cannot be changed by the user</p>
                    </div>

                    <div class="flex justify-end gap-4 border-t border-white/5 pt-10 mt-10">
                        <button type="reset" class="bg-transparent border border-white/10 text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase italic hover:bg-white/5">Discard</button>
                        <button type="submit" class="bg-white hover:bg-gray-200 text-black px-10 py-3 rounded-xl text-[10px] font-black uppercase italic transition transform hover:scale-105 shadow-2xl">✓ Save Profile</button>
                    </div>
                </form>
            </div>

            <!-- 3. UPDATE PASSWORD SECTION -->
            <div class="bg-[#161f2c]/30 backdrop-blur-xl border border-white/5 rounded-[2.5rem] p-10 shadow-2xl mb-8">
                <div class="flex items-center gap-4 mb-10">
                    <div class="p-3 bg-white/5 rounded-xl text-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-white font-black text-lg uppercase italic leading-none">Update Password</h2>
                        <p class="text-gray-500 text-[10px] font-bold uppercase mt-1">Use a long, random password to stay secure</p>
                    </div>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf @method('put')
                    <div class="mb-6">
                        <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest mb-2 block italic">Current Password</label>
                        <input type="password" name="current_password" class="bg-gray-900 border border-white/10 text-white font-black text-sm uppercase italic rounded-xl w-full p-4 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest mb-2 block italic">New Password</label>
                            <input type="password" name="password" class="bg-gray-900 border border-white/10 text-white font-black text-sm uppercase italic rounded-xl w-full p-4 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-gray-600 uppercase tracking-widest mb-2 block italic">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="bg-gray-900 border border-white/10 text-white font-black text-sm uppercase italic rounded-xl w-full p-4 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 pt-6">
                        <button type="submit" class="bg-white hover:bg-gray-200 text-black px-10 py-3 rounded-xl text-[10px] font-black uppercase italic transition shadow-2xl">✓ Update Password</button>
                    </div>
                </form>
            </div>

            <!-- 4. DELETE ACCOUNT SECTION (DANGER ZONE) -->
            <div class="bg-red-500/5 border border-red-500/10 rounded-[2.5rem] p-10 shadow-2xl">
                <div class="flex items-center gap-4 mb-8">
                    <div class="p-3 bg-red-500/10 rounded-xl text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-white font-black text-lg uppercase italic leading-none">Delete Account</h2>
                        <p class="text-gray-600 text-[10px] font-bold uppercase mt-1">Permanently remove your account and all data</p>
                    </div>
                </div>

                <div class="bg-red-500/10 border border-red-500/20 p-6 rounded-2xl mb-8">
                    <p class="text-red-500 font-black text-[10px] uppercase tracking-widest mb-2 italic">⚠️ This action is permanent and irreversible</p>
                    <p class="text-red-200/50 text-[10px] font-bold uppercase italic leading-relaxed">
                        @if($role === 'admin') Deleting your admin account will remove all associated data. All sessions, user records, and revenue history managed under this account will be permanently lost.
                        @elseif($role === 'trainer') Deleting your account will remove your trainer profile, specialization, and session history. Your assigned clients will be unlinked and need to be reassigned by the admin.
                        @else Deleting your account will remove your profile, all booked sessions, and payment history. Any upcoming sessions will be automatically cancelled. @endif
                    </p>
                </div>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf @method('delete')
                    <button type="submit" onclick="return confirm('WARNING: Are you absolutely sure?')" class="bg-transparent border border-red-500/30 text-red-500 px-8 py-3 rounded-xl text-[10px] font-black uppercase italic hover:bg-red-500 hover:text-white transition">
                        🗑 Delete My Account
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>