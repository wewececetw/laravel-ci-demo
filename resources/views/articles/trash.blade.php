<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            回收桶
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('articles.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">← 返回文章列表</a>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
            @endif

            @forelse ($articles as $article)
                <div class="p-4 border rounded mb-3">
                    <h3 class="text-lg font-bold">{{ $article->title }}</h3>
                    <p class="text-sm text-gray-500">刪除時間：{{ $article->deleted_at }}</p>

                    <div class="mt-2 flex gap-4">
                        <form action="{{ route('articles.restore', $article->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-green-600 hover:underline">還原</button>
                        </form>

                        <form action="{{ route('articles.forceDelete', $article->id) }}" method="POST" onsubmit="return confirm('確定要永久刪除這篇文章嗎？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">永久刪除</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-gray-600">回收桶是空的。</div>
            @endforelse

            {{ $articles->links() }}
        </div>
    </div>
</x-app-layout>
