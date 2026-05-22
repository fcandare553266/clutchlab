<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Clutch Lab | Personal Training</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-900 text-white font-figtree">
        
        <!-- Navigation -->
        <nav class="fixed w-full z-50 bg-gray-900/90 backdrop-blur-md border-b border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <span class="text-2xl font-black tracking-tighter text-blue-500">CLUTCH<span class="text-white">LAB</span></span>
                    </div>
                    <div class="flex items-center space-x-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-semibold hover:text-blue-500 transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-semibold hover:text-blue-500 transition">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full font-bold transition">Get Started</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <!-- UPDATED IMAGE LINE BELOW -->
                <img src="{{ asset('gym.jpg') }}" class="w-full h-full object-cover opacity-50" alt="Gym Background">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
            </div>
        
            <div class="relative z-10 text-center px-4 max-w-4xl">
                <h1 class="text-5xl md:text-8xl font-black italic tracking-tighter mb-6 uppercase leading-none">
                    Transform Your <span class="text-blue-500">Body</span>, <br>Elevate Your Life.
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-2xl mx-auto shadow-black drop-shadow-lg">
                    Expert personal training tailored to your goals. Book your session today for only ₱500.00.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-full text-lg font-black uppercase transition transform hover:scale-105 shadow-xl">Start
                        Training Now</a>
                    <a href="#specializations"
                        class="border border-white/20 bg-black/20 backdrop-blur-sm hover:bg-white/10 px-10 py-4 rounded-full text-lg font-black uppercase transition">View
                        Programs</a>
                </div>
            </div>
        </section>

        <!-- Specializations Section -->
        <section id="specializations" class="py-24 bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-black mb-16 uppercase italic">Our Specialized <span class="text-blue-500">Workouts</span></h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-gray-800 p-8 rounded-3xl border border-gray-700 hover:border-blue-500 transition group">
                        <div class="w-16 h-16 bg-blue-500/20 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 transition">
                            <svg class="w-8 h-8 text-blue-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Boxing & MMA</h3>
                        <p class="text-gray-400 italic">High-intensity combat training to build agility, power, and mental toughness.</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-gray-800 p-8 rounded-3xl border border-gray-700 hover:border-blue-500 transition group">
                        <div class="w-16 h-16 bg-blue-500/20 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 transition">
                            <svg class="w-8 h-8 text-blue-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Strength & Conditioning</h3>
                        <p class="text-gray-400 italic">Master your lifts and increase muscle mass with expert guidance.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-gray-800 p-8 rounded-3xl border border-gray-700 hover:border-blue-500 transition group">
                        <div class="w-16 h-16 bg-blue-500/20 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 transition">
                            <svg class="w-8 h-8 text-blue-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Yoga & Flexibility</h3>
                        <p class="text-gray-400 italic">Restore your body and improve mobility with dedicated recovery sessions.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="py-24 bg-gray-800">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-4xl font-black mb-6 uppercase">Simple <span class="text-blue-500">Pricing</span></h2>
                <div class="bg-gray-900 border-2 border-blue-600 p-12 rounded-3xl inline-block shadow-2xl">
                    <p class="text-gray-400 font-bold uppercase tracking-widest mb-4 italic">Per Session Rate</p>
                    <div class="text-7xl font-black mb-6 italic">₱500<span class="text-xl text-gray-500 font-normal lowercase">.00</span></div>
                    <ul class="text-left mb-10 space-y-3">
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg> 1-on-1 Personal Coaching</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg> Customized Workout Plan</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg> Access to Specialized Equipment</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full bg-blue-600 hover:bg-blue-700 py-4 rounded-xl font-black uppercase text-xl transition">Book Your First Session</a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 bg-gray-900 border-t border-gray-800 text-center">
            <p class="text-gray-500">© {{ date('Y') }} CLUTCH<span class="text-blue-500">LAB</span>. Your Ultimate Fitness Partner.</p>
        </footer>
    </body>
</html>