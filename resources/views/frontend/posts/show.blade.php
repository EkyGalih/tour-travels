<x-guest-layout>
    <x-slot name="nav">
        <x-header title="{{ $post->title }}" breadcrumb="Blog > {{ $post->title }}" />
    </x-slot>

    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">
            @if ($post)
                <div class="grid md:grid-cols-3 gap-8 animate-fade-in">
                    <!-- Kolom Konten -->
                    <div class="md:col-span-2 space-y-6">
                        <div
                            class="group relative bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl">
                            <div class="overflow-hidden">
                                <img src="{{ $post->media?->first()?->url ?? asset('defaults/no-image.jpg') }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-[600px] object-cover">
                            </div>
                        </div>

                        <p class="text-lg flex justify-start font-medium text-gray-500 mt-4 mb-2 animate-slide-in-left">
                            {{ \Carbon\Carbon::parse($post->created_at)->locale(app()->getLocale())->translatedFormat('d F Y') }}
                            / by {{ $post->author->name }}
                        </p>

                        <h1
                            class="text-3xl font-bold mb-4 text-left text-gray-900 animate-slide-in-right transition-transform duration-700 hover:translate-x-2">
                            {{ $post->title }}
                        </h1>

                        <div class="text-justify text-slate-900 animate-fade-in">
                            {!! $post->content !!}
                        </div>
                    </div>

                    <!-- Kolom Sidebar -->
                    <div class="space-y-6">
                        <!-- Search -->
                        <div
                            class="bg-blue-100 p-4 rounded-lg animate-slide-in-up transition-all duration-700 hover:scale-[1.02]">
                            <h2 class="font-bold text-left mb-4 text-3xl text-slate-900 animate-fade-in delay-100">
                                Search</h2>
                            <form action="#" method="GET" class="flex items-center space-x-2">
                                <input type="text" name="q"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                                    placeholder="Search posts..." value="{{ request('q') }}">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300">
                                    Search
                                </button>
                            </form>
                        </div>

                        <!-- Recent Posts -->
                        <div
                            class="bg-blue-100 p-4 rounded-lg animate-slide-in-up transition-all duration-700 hover:scale-[1.02]">
                            <h2 class="font-bold text-left mb-4 text-3xl text-slate-900 animate-fade-in delay-300">Recent Posts</h2>

                            <div class="space-y-4">
                                @php
                                    $recentPosts = [
                                        [
                                            'title' => 'Blue Sea Adventure Activities',
                                            'created_at' => now()->subDays(1),
                                            'image' => asset('defaults/no-image.jpg'),
                                            'url' => '#',
                                        ],
                                        [
                                            'title' => 'Top Tourist Destinations',
                                            'created_at' => now()->subDays(3),
                                            'image' => asset('defaults/no-image.jpg'),
                                            'url' => '#',
                                        ],
                                        [
                                            'title' => 'Tips For Family Vacation',
                                            'created_at' => now()->subWeek(),
                                            'image' => asset('defaults/no-image.jpg'),
                                            'url' => '#',
                                        ],
                                    ];
                                @endphp

                                @foreach ($recentPosts as $recent)
                                    <div
                                        class="flex gap-3 items-start animate-fade-in p-2 rounded transition">
                                        <!-- Thumbnail -->
                                        <div class="w-24 h-20 flex-shrink-0 overflow-hidden rounded">
                                            <img src="{{ $recent['image'] }}" alt="{{ $recent['title'] }}"
                                                class="w-full h-full object-cover">
                                        </div>

                                        <!-- Judul & waktu -->
                                        <div class="flex flex-col text-left">
                                            <a href="{{ $recent['url'] }}"
                                                class="font-semibold text-2xl text-teal-900 hover:text-teal-800 hover:underline">
                                                {{ \Illuminate\Support\Str::limit($recent['title'], 40) }}
                                            </a>
                                            <span class="text-lg text-teal-600 mt-1">
                                                {{ \Carbon\Carbon::parse($recent['created_at'])->locale(app()->getLocale())->translatedFormat('d F Y') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tags -->
                        <div
                            class="bg-blue-100 p-4 rounded-lg animate-slide-in-up transition-all duration-700 hover:scale-[1.02]">
                            <h2 class="font-bold text-left mb-4 text-3xl text-slate-900 animate-fade-in delay-200">
                                Tags</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($post->tags as $dest)
                                    <span
                                        class="bg-teal-900 text-white text-sm px-4 py-1 rounded-full hover:bg-lime-400 hover:text-slate-900 transition-all duration-500 animate-fade-in">
                                        {{ $dest }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-gray-500 animate-fade-in">Belum ada paket tour tersedia.</p>
            @endif
        </div>
    </section>

</x-guest-layout>
