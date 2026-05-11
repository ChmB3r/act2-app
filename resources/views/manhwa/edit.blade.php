@extends('manhwa.layout')

@section('title', 'Update Progress')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb & Header -->
    <div class="mb-12">
        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-purple-500 transition-colors flex items-center gap-1 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            BACK TO LIST
        </a>
        <h1 class="text-5xl font-black tracking-tight leading-none mb-2">
            Update <span class="text-gradient">Journey</span>
        </h1>
        <p class="text-gray-400 italic text-lg">Currently documenting: <span class="text-white font-black">{{ $manhwa->series->title }}</span></p>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-6 glass rounded-3xl border-red-500/20 bg-red-500/5 animate-in fade-in slide-in-from-top-4 duration-500">
            <h3 class="text-red-500 font-black uppercase tracking-widest text-xs mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                Archive Error
            </h3>
            <ul class="flex flex-col gap-1">
                @foreach ($errors->all() as $error)
                    <li class="text-gray-400 text-sm font-bold italic">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('manhwa.update', $manhwa->id) }}" method="POST" class="flex flex-col gap-8">
        @csrf
        @method('PUT')
        
        <!-- Selection Area -->
        <div class="glass p-10 rounded-5xl flex flex-col gap-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex flex-col gap-3">
                    <label for="status" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Update Status</label>
                    <select name="status" id="status" class="w-full h-14 glass rounded-2xl px-6 appearance-none font-bold text-white focus:outline-none focus:border-purple-500/50 transition-colors cursor-pointer">
                        <option value="Reading" {{ $manhwa->status == 'Reading' ? 'selected' : '' }}>Reading</option>
                        <option value="Plan to Read" {{ $manhwa->status == 'Plan to Read' ? 'selected' : '' }}>Plan to Read</option>
                        <option value="Completed" {{ $manhwa->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="On-hold" {{ $manhwa->status == 'On-hold' ? 'selected' : '' }}>On-hold</option>
                        <option value="Dropped" {{ $manhwa->status == 'Dropped' ? 'selected' : '' }}>Dropped</option>
                    </select>
                </div>

                <div class="flex flex-col gap-3">
                    <label for="last_read_chapter" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Current Chapter</label>
                    <input type="number" name="last_read_chapter" id="last_read_chapter" value="{{ $manhwa->last_read_chapter }}" min="0" class="w-full h-14 glass rounded-2xl px-6 font-black text-white focus:outline-none focus:border-purple-500/50 transition-colors">
                    @error('last_read_chapter') <p class="text-red-500 text-xs font-bold uppercase tracking-wider ml-2">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Personal Insights -->
        <div class="glass p-10 rounded-5xl flex flex-col gap-8">
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-2xl font-black italic text-gradient">Personal Insights</h2>
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex justify-between items-center px-2">
                    <label for="rating" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Rating Score</label>
                    <span id="ratingValue" class="text-2xl font-black text-yellow-500 italic">{{ $manhwa->privateNote?->rating ?? 5 }}<span class="text-gray-600 font-normal text-sm">/10</span></span>
                </div>
                <input type="range" name="rating" id="rating" min="1" max="10" step="1" value="{{ $manhwa->privateNote?->rating ?? 5 }}" class="w-full h-2 bg-gray-800 rounded-lg appearance-none cursor-pointer accent-purple-500 transition-all" oninput="document.getElementById('ratingValue').innerHTML = this.value + '<span class=\'text-gray-600 font-normal text-sm\'>/10</span>'">
            </div>

            <div class="flex flex-col gap-3">
                <label for="note" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Private Notes</label>
                <textarea name="note" id="note" rows="4" class="w-full glass rounded-3xl p-6 font-bold text-white focus:outline-none focus:border-purple-500/50 transition-colors resize-none">{{ $manhwa->privateNote?->note }}</textarea>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="btn-premium px-12 py-5 rounded-4xl font-black text-xl text-white shadow-2xl shadow-purple-500/30 flex items-center gap-3">
                SAVE ARCHIVE
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            </button>
        </div>
    </form>
</div>
@endsection
