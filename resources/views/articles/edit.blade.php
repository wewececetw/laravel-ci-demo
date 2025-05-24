<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            編輯文章
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('articles.update', $article) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block mb-1">標題</label>
                    <input type="text" name="title" id="title" class="border rounded w-full px-3 py-2"
                        value="{{ old('title', $article->title) }}" required>
                </div>

                <div class="mb-4">
                    <label for="image" class="block mb-1">上傳圖片</label>
                    <input type="file" name="image" id="image" class="block">
                </div>

                <div class="mb-4">
                    <label for="content" class="block mb-1">內容</label>
                    <textarea name="content" id="content" rows="5" class="border rounded w-full px-3 py-2">{{ old('content', $article->content) }}</textarea>
                </div>

                <button type="submit" class="bg-blue-600 text-gray-800 px-4 py-2 rounded">更新</button>
            </form>
        </div>
    </div>
</x-app-layout>
