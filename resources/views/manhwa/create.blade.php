@extends('manhwa.layout')

@section('title', 'Add New Series')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb & Header -->
    <div class="mb-12">
        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-purple-500 transition-colors flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            BACK TO LIST
        </a>
        <h1 class="text-5xl font-black tracking-tight leading-none mb-2">
            Add New <span class="text-gradient">Adventure</span>
        </h1>
        <p class="text-gray-400 italic text-lg">Select a series and document your current progress.</p>
    </div>

    <form action="{{ route('manhwa.store') }}" method="POST" class="flex flex-col gap-8">
        @csrf
        
        <!-- Selection Area -->
        <div class="glass p-10 rounded-5xl flex flex-col gap-8 relative z-50">
            <div class="flex flex-col gap-3 relative" x-data="malSearch()">
                <label for="title" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Search MyAnimeList</label>
                <div class="flex gap-4">
                    <input type="text" name="title" id="title" required 
                        class="flex-1 h-14 glass rounded-2xl px-6 font-bold text-white focus:outline-none focus:border-purple-500/50 transition-colors" 
                        placeholder="Search for a manhwa/manga/manhua..."
                        @input.debounce.500ms="search()"
                        x-model="query">
                    <div class="w-14 h-14 glass rounded-2xl flex items-center justify-center text-purple-500 animate-pulse" x-show="loading">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                </div>

                <!-- Results Dropdown -->
                <div class="absolute top-full left-0 right-0 z-[60] mt-4 glass rounded-3xl overflow-hidden shadow-2xl border border-white/10" 
                    x-show="results.length > 0 && showResults" 
                    @click.away="showResults = false">
                    <template x-for="item in results" :key="item.mal_id">
                        <div @click="selectSeries(item)" class="p-4 flex gap-4 hover:bg-white/10 cursor-pointer transition-colors border-b border-white/5 last:border-0">
                            <img :src="item.images.jpg.small_image_url" class="w-12 h-16 object-cover rounded-lg shadow-lg">
                            <div class="flex flex-col justify-center">
                                <span class="font-black text-white leading-tight" x-text="item.title"></span>
                                <span class="text-[10px] uppercase tracking-widest text-gray-500 font-bold" x-text="item.type + ' • ' + (item.chapters || '?') + ' Chs'"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Selected Preview -->
                <div x-show="selected" class="mt-6 p-6 rounded-3xl bg-purple-500/10 border border-purple-500/20 flex gap-6 items-center animate-in fade-in slide-in-from-top-4 duration-500">
                    <img :src="selected?.images.jpg.large_image_url" class="w-20 h-28 object-cover rounded-2xl shadow-2xl">
                    <div class="flex-1">
                        <h4 class="text-xl font-black italic text-gradient" x-text="selected?.title"></h4>
                        <p class="text-xs text-gray-400 line-clamp-2 mt-1" x-text="selected?.synopsis"></p>
                    </div>
                    <button type="button" @click="clearSelection()" class="p-2 text-gray-500 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>

                <!-- Hidden MAL Data -->
                <input type="hidden" name="mal_id" :value="selected?.mal_id">
                <input type="hidden" name="cover_image" :value="selected?.images.jpg.large_image_url">
                <input type="hidden" name="description" :value="selected?.synopsis">
                <input type="hidden" name="total_chapters" :value="selected?.chapters">

                @error('title') <p class="text-red-500 text-xs font-bold uppercase tracking-wider ml-2">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex flex-col gap-3">
                    <label for="status" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Current Status</label>
                    <select name="status" id="status" class="w-full h-14 glass rounded-2xl px-6 appearance-none font-bold text-white focus:outline-none focus:border-purple-500/50 transition-colors cursor-pointer">
                        <option value="Reading">Reading</option>
                        <option value="Plan to Read">Plan to Read</option>
                        <option value="Completed">Completed</option>
                        <option value="On-hold">On-hold</option>
                        <option value="Dropped">Dropped</option>
                    </select>
                </div>

                <div class="flex flex-col gap-3">
                    <label for="last_read_chapter" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Last Read Chapter</label>
                    <input type="number" name="last_read_chapter" id="last_read_chapter" value="0" min="0" class="w-full h-14 glass rounded-2xl px-6 font-black text-white focus:outline-none focus:border-purple-500/50 transition-colors" placeholder="0">
                    @error('last_read_chapter') <p class="text-red-500 text-xs font-bold uppercase tracking-wider ml-2">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Optional Notes -->
        <div class="glass p-10 rounded-5xl flex flex-col gap-8">
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-2xl font-black italic">Personal <span class="text-gradient">Insights</span></h2>
                <span class="px-3 py-1 rounded-full bg-white/5 text-[8px] font-black uppercase tracking-widest text-gray-500">Optional</span>
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex justify-between items-center px-2">
                    <label for="rating" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Rating Score</label>
                    <span id="ratingValue" class="text-2xl font-black text-yellow-500 italic">5<span class="text-gray-600 font-normal text-sm">/10</span></span>
                </div>
                <input type="range" name="rating" id="rating" min="1" max="10" step="1" value="5" class="w-full h-2 bg-gray-800 rounded-lg appearance-none cursor-pointer accent-purple-500 transition-all" oninput="document.getElementById('ratingValue').innerHTML = this.value + '<span class=\'text-gray-600 font-normal text-sm\'>/10</span>'">
            </div>

            <div class="flex flex-col gap-3">
                <label for="note" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Private Notes</label>
                <textarea name="note" id="note" rows="4" class="w-full glass rounded-3xl p-6 font-bold text-white focus:outline-none focus:border-purple-500/50 transition-colors resize-none" placeholder="What secrets does this archive hold?mc is badass, plot twist in ch.50..."></textarea>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="btn-premium px-12 py-5 rounded-4xl font-black text-xl text-white shadow-2xl shadow-purple-500/30 flex items-center gap-3">
                ARCHIVE SERIES
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function malSearch() {
        return {
            query: '',
            results: [],
            loading: false,
            showResults: false,
            selected: null,

            async search() {
                if (this.query.length < 3) {
                    this.results = [];
                    return;
                }

                this.loading = true;
                this.showResults = true;

                try {
                    const response = await fetch(`https://api.jikan.moe/v4/manga?q=${encodeURIComponent(this.query)}&limit=5`);
                    const data = await response.json();
                    this.results = data.data || [];
                } catch (error) {
                    console.error('MAL Search Error:', error);
                } finally {
                    this.loading = false;
                }
            },

            selectSeries(item) {
                this.selected = item;
                this.query = item.title;
                this.showResults = false;
                this.results = [];
            },

            clearSelection() {
                this.selected = null;
                this.query = '';
            }
        }
    }
</script>
@endpush
