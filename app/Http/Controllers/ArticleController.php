<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    use AuthorizesRequests;

    // 顯示登入使用者的所有文章
    public function index()
    {
        $articles = Auth::user()->articles()->latest()->paginate(10);

        return view('articles.index', compact('articles'));
    }

    // 顯示新增表單
    public function create()
    {
        return view('articles.create');
    }

    // 儲存文章
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048', // 驗證圖片格式與大小
        ]);

        $data = $request->only('title', 'content');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('article_images', 'public');
        }

        Auth::user()->articles()->create($data);

        return redirect()->route('articles.index')->with('success', '文章新增成功');
    }

    // 編輯文章
    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        return view('articles.edit', compact('article'));
    }

    // 更新文章
    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
        ]);

        $article->update($request->only('title', 'content'));

        return redirect()->route('articles.index')->with('success', '文章更新成功');
    }

    // 軟刪除
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();

        return redirect()->route('articles.index')->with('success', '文章已移至回收桶');
    }

    // 回收桶（只顯示自己的被刪除文章）
    public function trash()
    {

        $articles = Auth::user()->articles()->onlyTrashed()->latest()->paginate(10);

        return view('articles.trash', compact('articles'));
    }

    // 還原文章
    public function restore($id)
    {
        $article = Auth::user()->articles()->onlyTrashed()->findOrFail($id);
        $article->restore();

        return redirect()->route('articles.trash')->with('success', '已還原文章');
    }

    // 永久刪除文章
    public function forceDelete($id)
    {
        $article = Auth::user()->articles()->onlyTrashed()->findOrFail($id);
        $article->forceDelete();

        return redirect()->route('articles.trash')->with('success', '已永久刪除文章');
    }
}
