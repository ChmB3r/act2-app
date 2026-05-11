@extends('manhwa.layout')

@section('title', $manhwa->series->title)

@section('content')
<div class="relative -mt-8 -mx-6 mb-12 h-[500px] overflow-hidden group">
    <!-- Hero Background Image (Blurred) -->
    @if($manhwa->series->cover_image)
        <img src="{{ $manhwa->series->cover_image }}" class="absolute inset-0 w-full h-full object-cover blur-2xl opacity-30 scale-110">
    @endif
    
    <div class="absolute inset-0 bg-linear-to-t from-[#09090b] via-[#09090b]/80 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-6 h-full flex items-end pb-12 relative z-10">
        <div class="flex flex-col md:flex-row gap-10 items-end w-full">
            <!-- Poster -->
            <div class="w-64 aspect-[3/4] rounded-3xl overflow-hidden shadow-2xl shadow-purple-500/20 border border-white/10 flex-shrink-0 animate-in zoom-in duration-700">
                @if($manhwa->series->cover_image)
                    <img src="{{ $manhwa->series->cover_image }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-800 flex items-center justify-center italic text-gray-600">No Cover</div>
                @endif
            </div>

            <!-- Content -->
            <div class="flex-1 pb-4">
                <div class="flex flex-wrap gap-3 mb-6">
                    <span class="px-4 py-1.5 rounded-full bg-purple-500/20 text-purple-400 text-xs font-black uppercase tracking-[0.2em] border border-purple-500/20">
                        {{ $manhwa->status }}
                    </span>
                    @if($manhwa->privateNote?->rating)
                        <span class="px-4 py-1.5 rounded-full bg-yellow-500/20 text-yellow-500 text-xs font-black uppercase tracking-[0.2em] border border-yellow-500/20 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1.7L9.5 8.3H2.5L8 12.3L5.5 18.9L11 14.9L16.5 18.9L14 12.3L19.5 8.3H12.5L12 1.7Z"/></svg>
                            {{ $manhwa->privateNote->rating }}/10
                        </span>
                    @endif
                </div>

                <h1 class="text-6xl font-black tracking-tighter text-white mb-4 leading-tight">
                    {{ $manhwa->series->title }}
                </h1>

                <div class="flex items-center gap-8">
                    <div>
                        <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-black mb-1">Current Progress</span>
                        <span class="text-3xl font-black italic text-white">
                            Ch. {{ $manhwa->last_read_chapter }}
                            <span class="text-gray-600 font-normal text-sm ml-1">/ {{ $manhwa->series->total_chapters ?? '??' }}</span>
                        </span>
                    </div>
                    <div class="h-10 w-px bg-white/10"></div>
                    <div class="flex gap-2">
                        @foreach($manhwa->series->genres as $genre)
                            <span class="px-3 py-1 rounded-lg bg-white/5 text-[10px] font-bold text-gray-400 border border-white/5 uppercase tracking-wider">{{ $genre->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 pb-4">
                <a href="{{ route('manhwa.edit', $manhwa->id) }}" class="btn-premium px-8 py-4 rounded-2xl font-black text-sm text-white shadow-xl flex items-center gap-3 transition-transform hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    EDIT ARCHIVE
                </a>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Left Column: Story :) -->
    <div class="lg:col-span-2 space-y-12">
        <section class="glass p-10 rounded-5xl">
            <h2 class="text-2xl font-black italic mb-6 text-gradient uppercase tracking-tighter">The Legend</h2>
            <div class="prose prose-invert max-w-none">
                <p class="text-gray-300 leading-relaxed text-lg">
                    {{ $manhwa->series->description ?? 'No description has been chronicled for this series yet.' }}
                </p>
            </div>
        </section>
    </div>

    <!-- Right Column: Notes -->
    <div class="space-y-12">
        <section class="glass p-10 rounded-5xl border-purple-500/10">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-500 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h2 class="text-2xl font-black italic text-gradient uppercase tracking-tighter">Personal Insights</h2>
            </div>

            @if($manhwa->privateNote?->note)
                <div class="relative">
                    <svg class="absolute -top-4 -left-2 text-white/5 w-16 h-16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C20.1216 16 21.017 16.8954 21.017 18V21C21.017 22.1046 20.1216 23 19.017 23H16.017C14.9124 23 14.017 22.1046 14.017 21ZM14.017 13H21.017V10H14.017V13ZM0 21L0 18C0 16.8954 0.89543 16 2 16H5C6.10457 16 7 16.8954 7 18V21C7 22.1046 6.10457 23 5 23H2C0.89543 23 0 22.1046 0 21ZM0 13H7V10H0V13Z"/></svg>
                    <p class="text-xl text-gray-300 italic leading-relaxed relative z-10 pt-4">
                        "{{ $manhwa->privateNote->note }}"
                    </p>
                </div>
            @else
                <p class="text-gray-500 italic">No secret insights have been documented for this journey.</p>
                <a href="{{ route('manhwa.edit', $manhwa->id) }}" class="mt-6 inline-block text-purple-500 font-bold hover:text-purple-400 transition-colors">Add your thoughts →</a>
            @endif
        </section>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 gap-6">
            <div class="glass p-6 rounded-3xl text-center">
                <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-black mb-2">MAL ID</span>
                <span class="text-xl font-black text-white">{{ $manhwa->series->mal_id ?? 'None' }}</span>
            </div>
            <div class="glass p-6 rounded-3xl text-center">
                <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-black mb-2">Chapters</span>
                <span class="text-xl font-black text-white">{{ $manhwa->series->total_chapters ?? '??' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
