<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            我的記事列表
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('articles.trash') }}" class="text-gray-700 hover:underline ml-4">🗑️ 回收桶</a>
            <a href="{{ route('articles.create') }}"
                class="bg-blue-500 text-gray-800 px-4 py-2 rounded mb-4 inline-block">新增文章</a>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
            @endif

            @foreach ($articles as $article)
                <div class="border p-4 mb-2 rounded">
                    <h2 class="text-xl font-semibold">{{ $article->title }}</h2>
                    <p>{{ Str::limit($article->content, 100) }}</p>

                    @if ($article->image_path)
                        <img src="{{ asset('storage/' . $article->image_path) }}" alt="文章圖片"
                            class="mt-2 w-64 rounded">
                    @endif
                </div>

                <div class="mt-2 flex gap-3">
                    @can('update', $article)
                        <a href="{{ route('articles.edit', $article) }}" class="text-blue-600 hover:underline">編輯</a>
                    @endcan
                    @can('delete', $article)
                        <form action="{{ route('articles.destroy', $article) }}" method="POST"
                            onsubmit="return confirm('確定要刪除嗎？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">刪除</button>
                        </form>
                    @endcan
                </div>
            @endforeach

            {{ $articles->links() }}
        </div>
    </div>
</x-app-layout>
