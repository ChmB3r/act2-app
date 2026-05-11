@extends('manhwa.layout')

@section('title', 'My Tracker')

@section('content')
<div class="flex flex-col gap-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-5xl font-black tracking-tight mb-2">
                My <span class="text-gradient">Reading List</span>
            </h1>
            <p class="text-gray-400 italic text-lg">Keep track of your journey through the realms of Manga, Manhwa, and Manhua.</p>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <span class="text-4xl font-black text-white leading-none">{{ $entries->count() }}</span>
                <p class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold mt-1">Series Tracked</p>
            </div>
        </div>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($entries as $entry)
            <div class="glass group relative overflow-hidden rounded-4xl transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-500/10">
                <a href="{{ route('manhwa.show', $entry->id) }}" class="block">
                    <!-- Cover Image Area -->
                    <div class="aspect-video relative overflow-hidden">
                        @if($entry->series->cover_image)
                            <img src="{{ $entry->series->cover_image }}" alt="{{ $entry->series->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-linear-to-br from-gray-800 to-gray-900 flex items-center justify-center italic text-gray-700">No Cover Art</div>
                        @endif
                        <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/30 to-transparent"></div>
                        
                        <div class="absolute bottom-5 left-6 right-6">
                            <span class="inline-block px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[10px] font-black uppercase tracking-widest text-white mb-2">
                                {{ $entry->status }}
                            </span>
                            <h3 class="text-2xl font-black truncate text-white leading-tight group-hover:text-purple-400 transition-colors">{{ $entry->series->title }}</h3>
                        </div>
                    </div>
                </a>

                <!-- Info Area -->
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-black mb-1">Progress</span>
                            <span class="text-2xl font-black italic text-white">
                                Ch. {{ $entry->last_read_chapter }}
                                <span class="text-gray-600 font-normal text-sm ml-1">/ {{ $entry->series->total_chapters ?? '??' }}</span>
                            </span>
                        </div>
                        @if($entry->privateNote?->rating)
                            <div class="text-right">
                                <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-black mb-1">Rating</span>
                                <span class="text-2xl font-black italic text-yellow-500 flex items-center justify-end gap-1">
                                    {{ $entry->privateNote->rating }}<span class="text-gray-600 font-normal text-sm">/10</span>
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6 min-h-[28px]">
                        @foreach($entry->series->genres as $genre)
                            <span class="px-3 py-1 rounded-lg bg-gray-900 text-[10px] font-bold text-gray-400 border border-gray-800">{{ $genre->name }}</span>
                        @endforeach
                    </div>

                    @if($entry->privateNote?->note)
                        <div class="mb-8 p-4 rounded-2xl bg-white/5 border border-white/5 italic">
                            <span class="block text-[10px] text-gray-500 uppercase tracking-widest font-black mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                INSIGHTS
                            </span>
                            <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed">
                                "{{ $entry->privateNote->note }}"
                            </p>
                        </div>
                    @endif

                    <div class="flex gap-4">
                        <a href="{{ route('manhwa.edit', $entry->id) }}" class="flex-1 glass h-12 flex items-center justify-center rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-white/5 transition-colors">
                            Edit Progress
                        </a>
                        <form action="{{ route('manhwa.destroy', $entry->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Remove this series?')" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center glass rounded-6xl border-dashed border-2 border-gray-800">
                <div class="mb-6 opacity-10 flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M8 7h6"/><path d="M8 11h8"/></svg>
                </div>
                <h2 class="text-3xl font-black mb-3 italic">No Manhwa Tracked Yet</h2>
                <p class="text-gray-500 italic mb-10 max-w-md mx-auto">Your journey through the realms of Manhwa hasn't begun. Select a series to start archiving your legend.</p>
                <a href="{{ route('manhwa.create') }}" class="btn-premium px-10 py-4 rounded-full font-black text-lg text-white shadow-xl shadow-purple-500/20">
                    Browse Series
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
