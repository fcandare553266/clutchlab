<x-app-layout>
    @php
        $role = Auth::user()->role;
        $accentColor = ($role === 'trainer') ? 'green-500' : (($role === 'client') ? '[#7c3aed]' : 'blue-500');
        $hoverColor = ($role === 'trainer') ? 'green-600' : (($role === 'client') ? '[#6d28d9]' : 'blue-600');
    @endphp

    <div class="py-8 bg-[#0b111b] min-h-screen text-gray-300 font-sans">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- 1. TOP HEADER -->
            <div class="mb-8">
                <h1 class="text-{{ $accentColor }} font-black text-2xl uppercase tracking-tighter leading-none">
                    @if($role === 'trainer') LOG A TRAINING SESSION @else BOOK A TRAINING SESSION @endif
                </h1>
                @if ($errors->any())
    <div class="bg-red-500/20 border border-red-500 text-red-500 p-4 rounded-xl mb-6">
        <ul>
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <p class="text-gray-600 text-sm font-bold uppercase tracking-tight mt-1">
                    @if($role === 'trainer') Record details for a completed or upcoming session with your client @else Choose your workout type, pick a time, and we'll assign your trainer @endif
                </p>
            </div>

            <div class="bg-[#161f2c]/30 backdrop-blur-xl border border-white/5 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden">
                
                <!-- 2. ROLE-SPECIFIC INFO BOXES -->
                @if($role === 'trainer')
                    <div class="mb-8 bg-orange-500/10 border border-orange-500/20 p-4 rounded-xl flex items-start gap-4">
                        <span class="text-orange-500 mt-1">⚠️</span>
                        <p class="text-orange-200/70 text-[11px] font-bold leading-relaxed uppercase italic">
                            As a trainer, you can only log sessions for your assigned clients. Session fees and payments are managed by the admin.
                        </p>
                    </div>
                @elseif($role === 'client')
                    <div class="mb-8 bg-purple-500/10 border border-purple-500/20 p-4 rounded-xl flex items-start gap-4">
                        <span class="text-purple-500 mt-1">ℹ️</span>
                        <p class="text-purple-200/70 text-[11px] font-bold leading-relaxed uppercase italic">
                            Your trainer will be assigned by the admin after booking. The session fee is fixed at ₱500 per session.
                        </p>
                    </div>
                @endif

                <!-- 3. STEPPER PROGRESS -->
                <div class="flex items-center justify-between mb-12 max-w-2xl mx-auto">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-{{ $accentColor }} text-white flex items-center justify-center font-black text-xs shadow-lg shadow-{{ $accentColor }}/20">1</span>
                        <span class="text-[10px] font-black uppercase text-white tracking-widest">@if($role === 'trainer') Session Info @else Session @endif</span>
                    </div>
                    <div class="flex-1 h-[1px] bg-white/10 mx-4"></div>
                    <div class="flex items-center gap-3 opacity-40">
                        <span class="w-8 h-8 rounded-full bg-gray-800 text-gray-400 flex items-center justify-center font-black text-xs">2</span>
                        <span class="text-[10px] font-black uppercase tracking-widest">Schedule</span>
                    </div>
                    <div class="flex-1 h-[1px] bg-white/10 mx-4"></div>
                    <div class="flex items-center gap-3 opacity-40">
                        <span class="w-8 h-8 rounded-full bg-gray-800 text-gray-400 flex items-center justify-center font-black text-xs">3</span>
                        <span class="text-[10px] font-black uppercase tracking-widest">@if($role === 'trainer') Notes @else Payment @endif</span>
                    </div>
                </div>

                <form action="{{ route('sessions.store') }}" method="POST">
                    @csrf
                    
                    <!-- 4. SESSION TYPE CARDS -->
                    <div class="mb-10">
                        <label class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em] mb-4 block">@if($role === 'client') Choose Session Type @else Session Type @endif</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="hidden" name="title" id="selected_title" value="Boxing & MMA">
                            
                            @php
                                $types = [
                                    ['name' => 'Boxing & MMA', 'emoji' => '🥊'],
                                    ['name' => 'Yoga & Flex', 'emoji' => '🧘‍♀️'],
                                    ['name' => 'Strength', 'emoji' => '🏋️‍♂️']
                                ];
                            @endphp

                            @foreach($types as $type)
                            <button type="button" onclick="selectType('{{ $type['name'] }}', this)" 
                                    class="type-card p-6 rounded-2xl border transition-all text-left {{ $loop->first ? 'border-'.$accentColor.' bg-'.$accentColor.'/10' : 'border-white/5 bg-white/5' }}">
                                <span class="text-2xl mb-2 block">{{ $type['emoji'] }}</span>
                                <h4 class="text-white font-black uppercase italic text-sm">{{ $type['name'] }}</h4>
                                <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">60 min</p>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- 5. DYNAMIC FORM FIELDS BASED ON ROLE -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Left Column -->
                        <div>
                            <label class="text-gray-500 text-[10px] font-black uppercase tracking-[0.1em] mb-2 block italic">
                                @if($role === 'trainer') CLIENT (YOUR ASSIGNED) @else CLIENT @endif
                            </label>
                            @if($role === 'client')
                                <input type="text" value="{{ Auth::user()->name }}" class="bg-gray-900 border border-white/10 text-gray-500 text-sm rounded-xl w-full p-4 cursor-not-allowed" readonly>
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            @else
                                <select name="user_id" class="bg-gray-900 border border-white/10 text-gray-300 text-sm rounded-xl w-full p-4 focus:ring-{{ $accentColor }}">
                                    <option value="">Select client...</option>
                                    @foreach(\App\Models\User::where('role', 'client')->get() as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <!-- Right Column -->
                        <div>
                            <label class="text-gray-500 text-[10px] font-black uppercase tracking-[0.1em] mb-2 block italic">
                                TRAINER @if($role === 'admin') <span class="text-blue-500">(ADMIN ONLY)</span> @endif
                            </label>
                            @if($role === 'trainer')
                                <input type="text" value="{{ Auth::user()->name }} (You)" class="bg-gray-900 border border-white/10 text-gray-500 text-sm rounded-xl w-full p-4 cursor-not-allowed" readonly>
                                <input type="hidden" name="trainer_id" value="{{ Auth::id() }}">
                            @elseif($role === 'admin')
                                <select name="trainer_id" class="bg-gray-900 border border-white/10 text-gray-300 text-sm rounded-xl w-full p-4 focus:ring-blue-500">
                                    <option value="">Choose trainer...</option>
                                    @foreach(\App\Models\User::where('role', 'trainer')->get() as $trainer)
                                        <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="bg-gray-900 border border-white/10 text-gray-600 text-sm rounded-xl w-full p-4 italic">
                                    To be assigned by admin after booking
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- 6. DATE & TIME -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="text-gray-500 text-[10px] font-black uppercase tracking-[0.1em] mb-2 block italic">DATE</label>
                            <input type="date" name="date" class="bg-gray-900 border border-white/10 text-gray-300 text-sm rounded-xl w-full p-4" required>
                        </div>
                        <div>
                            <label class="text-gray-500 text-[10px] font-black uppercase tracking-[0.1em] mb-2 block italic">@if($role === 'client') PREFERRED TIME @else TIME @endif</label>
                            <input type="time" name="time" class="bg-gray-900 border border-white/10 text-gray-300 text-sm rounded-xl w-full p-4" required>
                        </div>
                    </div>

                    <!-- 7. DESCRIPTION / NOTES -->
                    <div class="mb-10">
                        <label class="text-gray-500 text-[10px] font-black uppercase tracking-[0.1em] mb-2 block italic">
                            @if($role === 'trainer') SESSION NOTES / GOALS @elseif($role === 'client') COALS / NOTES @else DESCRIPTION / GOALS @endif
                        </label>
                        <textarea name="description" rows="4" placeholder="@if($role === 'trainer') What did we work on? Progress, areas to improve... @else What do you want to work on? Weight loss, endurance, flexibility... @endif" class="bg-gray-900 border border-white/10 text-gray-300 text-sm rounded-xl w-full p-4"></textarea>
                    </div>

                    <!-- 8. PAYMENT & STATUS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10 border-t border-white/5 pt-10">
                        <div>
                            <p class="text-gray-500 text-[9px] font-black uppercase tracking-widest mb-1 italic">SESSION FEE</p>
                            <div class="flex items-center gap-3">
                                <h3 class="text-3xl font-black text-green-500 italic">₱500</h3>
                                <span class="text-[9px] bg-green-500/10 text-green-500 px-2 py-1 rounded border border-green-500/20 font-black uppercase">🔒 Fixed</span>
                            </div>
                            <p class="text-gray-600 text-[9px] mt-2 italic font-bold">@if($role === 'trainer') Managed by admin @else Fixed rate — cannot be changed @endif</p>
                        </div>
                        <div>
                           <label class="text-gray-500 text-[10px] font-black uppercase tracking-[0.1em] mb-2 block italic">
    @if(Auth::user()->role === 'trainer') SESSION STATUS @else PAYMENT METHOD @endif
</label>

<!-- We will use 'payment_method' as the name for both to avoid errors -->
<select name="payment_method" class="bg-gray-900 border border-white/10 text-gray-300 text-sm rounded-xl w-full p-4 shadow-xl" required>
    @if(Auth::user()->role === 'trainer')
        <option value="completed">Completed</option>
        <option value="scheduled">Scheduled</option>
    @else
        <option value="" disabled selected>Select method...</option>
        <option value="gcash">GCash</option>
        <option value="paymaya">Maya</option>
        <option value="cash">Cash at Gym</option>
    @endif
</select>
                        </div>
                    </div>

                    <!-- 9. BUTTONS -->
                    <div class="flex justify-between items-center border-t border-white/5 pt-10">
                        <a href="{{ route('sessions.index') }}" class="px-8 py-3 rounded-xl border border-white/10 text-white text-[10px] font-black uppercase hover:bg-white/5 transition italic">← Back</a>
                        <button type="submit" class="bg-white hover:bg-gray-200 text-black px-10 py-3 rounded-xl text-[10px] font-black uppercase transition shadow-2xl flex items-center gap-2 italic">
                            ✓ @if($role === 'trainer') Log Session @elseif($role === 'client') Submit Booking @else Save Session @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS for Card Selection (Role Aware) -->
    <script>
        function selectType(title, element) {
            const role = "{{ $role }}";
            const activeClass = (role === 'trainer') ? 'border-green-500' : ((role === 'client') ? 'border-[#7c3aed]' : 'border-blue-600');
            const activeBg = (role === 'trainer') ? 'bg-green-500/10' : ((role === 'client') ? 'bg-[#7c3aed]/10' : 'bg-blue-600/10');

            document.getElementById('selected_title').value = title;
            document.querySelectorAll('.type-card').forEach(card => {
                card.classList.remove('border-blue-600', 'border-green-500', 'border-[#7c3aed]', 'bg-blue-600/10', 'bg-green-500/10', 'bg-[#7c3aed]/10');
                card.classList.add('border-white/5', 'bg-white/5');
            });
            element.classList.remove('border-white/5', 'bg-white/5');
            element.classList.add(activeClass, activeBg);
        }
    </script>
</x-app-layout>