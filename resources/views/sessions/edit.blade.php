<x-app-layout>
    <div class="py-8 bg-[#0b111b] min-h-screen text-gray-300 font-sans">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- 1. HEADER NAVIGATION -->
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('sessions.index') }}" class="p-2.5 bg-white/5 border border-white/10 rounded-xl text-gray-400 hover:text-white transition shadow-2xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-blue-500 font-black text-xl uppercase tracking-tighter leading-none">EDIT SESSION DETAILS <span class="text-gray-600 ml-4 text-xs font-bold tracking-widest uppercase italic">REF #{{ str_pad($session->id, 5, '0', STR_PAD_LEFT) }}</span></h1>
                    <p class="text-gray-600 text-[10px] font-bold uppercase tracking-tight mt-1">Make changes to the session below and click Update Session to save</p>
                </div>
            </div>

            <form action="{{ route('sessions.update', $session) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- 2. MAIN CARD -->
                <div class="bg-[#161f2c]/30 backdrop-blur-xl border border-white/5 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
                    
                    <!-- Summary Top Bar -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 pb-8 border-b border-white/5">
                        <div class="flex items-center gap-4">
                            <div>
                                <h2 class="text-white font-black text-2xl uppercase italic leading-none">{{ $session->title }}</h2>
                                <p class="text-gray-500 text-[10px] font-bold uppercase mt-2">Editing session details - Client: <span class="text-gray-300">{{ $session->user->name }}</span></p>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $session->payment_status == 'paid' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20' }}">
                            ● {{ $session->payment_status }}
                        </span>
                    </div>

                    <!-- Mini Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                        <div class="flex items-center gap-4 text-gray-500 bg-white/[0.02] p-4 rounded-2xl border border-white/5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <div>
                                <p class="text-[8px] font-black uppercase tracking-widest">Scheduled</p>
                                <p class="text-xs font-bold text-gray-300">{{ \Carbon\Carbon::parse($session->scheduled_at)->format('M d, Y - h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-gray-500 bg-white/[0.02] p-4 rounded-2xl border border-white/5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <div>
                                <p class="text-[8px] font-black uppercase tracking-widest">Trainer</p>
                                <p class="text-xs font-bold text-gray-300">{{ $session->trainer->name ?? 'TBA' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-gray-500 bg-white/[0.02] p-4 rounded-2xl border border-white/5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="text-[8px] font-black uppercase tracking-widest">Session Fee</p>
                                <p class="text-xs font-bold text-green-500">₱{{ number_format($session->amount, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Input Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <div>
                            <label class="text-gray-600 text-[9px] font-black uppercase tracking-[0.2em] mb-3 block">Session Title</label>
                            <input type="text" name="title" value="{{ $session->title }}" class="bg-gray-900 border border-white/10 text-white font-black text-sm uppercase italic rounded-xl w-full p-4 focus:ring-blue-500 transition">
                        </div>
                        <div>
                            <label class="text-gray-600 text-[9px] font-black uppercase tracking-[0.2em] mb-3 block">Date & Time</label>
                            <input type="datetime-local" name="scheduled_at" value="{{ date('Y-m-d\TH:i', strtotime($session->scheduled_at)) }}" class="bg-gray-900 border border-white/10 text-white font-black text-sm uppercase italic rounded-xl w-full p-4 focus:ring-blue-500 transition">
                        </div>
                    </div>

                    <!-- Trainer Assignment Card (Green) -->
                    @if(Auth::user()->role === 'admin')
                    <div class="mb-10 p-6 bg-green-500/5 border border-green-500/20 rounded-[1.5rem] relative">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <label class="text-[10px] font-black text-green-500 uppercase tracking-widest">Assign / Change Trainer <span class="text-gray-600 ml-2 font-bold opacity-50">ADMIN ONLY</span></label>
                        </div>
                        <select name="trainer_id" class="bg-[#0b111b] border border-white/10 text-white font-black text-sm uppercase italic rounded-xl w-full p-4 focus:ring-green-500 transition shadow-inner">
                            <option value="">No Trainer Assigned</option>
                            @foreach(\App\Models\User::where('role', 'trainer')->get() as $trainer)
                                <option value="{{ $trainer->id }}" {{ $session->trainer_id == $trainer->id ? 'selected' : '' }}>{{ $trainer->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-[9px] text-gray-600 mt-3 font-bold italic">ⓘ Only trainers specialized in "{{ $session->title }}" are listed above</p>
                    </div>
                    @endif

                    <!-- Payment Status Selectors (Card Style) -->
                    <div class="mb-12">
                        <label class="text-gray-600 text-[9px] font-black uppercase tracking-[0.2em] mb-4 block">Update Payment Status</label>
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Paid -->
                            <label class="cursor-pointer group">
                                <input type="radio" name="payment_status" value="paid" class="hidden peer" {{ $session->payment_status == 'paid' ? 'checked' : '' }}>
                                <div class="bg-gray-900 border border-white/10 p-6 rounded-2xl text-center transition-all peer-checked:border-green-500 peer-checked:bg-green-500/10 group-hover:bg-white/5">
                                    <div class="bg-green-500 text-white w-6 h-6 rounded-md flex items-center justify-center mx-auto mb-3 shadow-lg opacity-40 peer-checked:opacity-100">✓</div>
                                    <p class="text-[10px] font-black uppercase text-gray-500 peer-checked:text-green-500 tracking-widest">Paid</p>
                                </div>
                            </label>
                            <!-- Pending -->
                            <label class="cursor-pointer group">
                                <input type="radio" name="payment_status" value="pending" class="hidden peer" {{ $session->payment_status == 'pending' ? 'checked' : '' }}>
                                <div class="bg-gray-900 border border-white/10 p-6 rounded-2xl text-center transition-all peer-checked:border-orange-500 peer-checked:bg-orange-500/10 group-hover:bg-white/5">
                                    <div class="bg-orange-500 text-white w-6 h-6 rounded-md flex items-center justify-center mx-auto mb-3 shadow-lg opacity-40 peer-checked:opacity-100">⌛</div>
                                    <p class="text-[10px] font-black uppercase text-gray-500 peer-checked:text-orange-500 tracking-widest">Pending</p>
                                </div>
                            </label>
                            <!-- Unpaid -->
                            <label class="cursor-pointer group">
                                <input type="radio" name="payment_status" value="unpaid" class="hidden peer" {{ $session->payment_status == 'unpaid' ? 'checked' : '' }}>
                                <div class="bg-gray-900 border border-white/10 p-6 rounded-2xl text-center transition-all peer-checked:border-red-500 peer-checked:bg-red-500/10 group-hover:bg-white/5">
                                    <div class="bg-red-500 text-white w-6 h-6 rounded-md flex items-center justify-center mx-auto mb-3 shadow-lg opacity-40 peer-checked:opacity-100">✕</div>
                                    <p class="text-[10px] font-black uppercase text-gray-500 peer-checked:text-red-500 tracking-widest">Unpaid</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="mb-12">
                        <label class="text-gray-600 text-[9px] font-black uppercase tracking-[0.2em] mb-4 block">Description / Coach's Notes</label>
                        <textarea name="description" rows="4" placeholder="Add session goals, trainer notes, or special instructions..." class="bg-gray-900 border border-white/10 text-gray-300 text-sm rounded-xl w-full p-6 focus:ring-blue-500 shadow-inner">{{ $session->description }}</textarea>
                    </div>

                    <!-- Form Buttons -->
                    <div class="flex flex-col md:flex-row justify-between items-center border-t border-white/5 pt-10 gap-4">
                        <button type="button" onclick="confirm('Cancel entire session?') ? document.getElementById('del-form').submit() : ''" class="bg-transparent text-gray-600 hover:text-red-500 text-[10px] font-black uppercase italic tracking-widest flex items-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Cancel Session
                        </button>
                        
                        <div class="flex items-center gap-6">
                            <a href="{{ route('sessions.index') }}" class="text-white text-[10px] font-black uppercase italic tracking-widest hover:underline transition">Discard Changes</a>
                            
                            <!-- YOUR NEW BUTTON ADDED HERE -->
                            <button type="submit" class="bg-white hover:bg-gray-200 text-black px-10 py-3 rounded-xl text-[10px] font-black uppercase transition-all duration-300 hover:scale-105 hover:shadow-[0_0_20px_rgba(255,255,255,0.4)]">
                                ✓ Update Session
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Hidden Delete Form -->
            <form id="del-form" action="{{ route('sessions.destroy', $session) }}" method="POST" class="hidden">
                @csrf @method('DELETE')
            </form>

        </div>
    </div>
</x-app-layout>