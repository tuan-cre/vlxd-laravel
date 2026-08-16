<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    public function publicIndex()
    {
        $news = News::with('author')
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('news.index', compact('news'));
    }

    public function index(Request $request)
    {
        $query = News::with('author');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('category', 'like', "%{$keyword}%");
            });
        }

        $news = $query->latest()->paginate(15);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(StoreNewsRequest $request)
    {
        $slug = Str::slug($request->title);
        $count = News::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $thumbnail = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/news'), $filename);
            $thumbnail = 'uploads/news/' . $filename;
        }

        $nguoidung = session('nguoidung');
        $authorId = $nguoidung ? $nguoidung['id'] : null;

        $status = $request->status === 'published' ? 1 : 0;

        News::create([
            'title' => $request->title,
            'slug' => $slug,
            'thumbnail' => $thumbnail,
            'summary' => $request->summary,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $status,
            'views' => 0,
            'author_id' => $authorId,
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);

        return view('admin.news.edit', compact('news'));
    }

    public function update(StoreNewsRequest $request, $id)
    {
        $news = News::findOrFail($id);

        $data = $request->only(['title', 'summary', 'content', 'category']);

        if ($request->filled('title') && $request->title !== $news->title) {
            $slug = Str::slug($request->title);
            $count = News::where('slug', $slug)->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            $data['slug'] = $slug;
        }

        $data['status'] = $request->status === 'published' ? 1 : 0;

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail && File::exists(public_path($news->thumbnail))) {
                File::delete(public_path($news->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/news'), $filename);
            $data['thumbnail'] = 'uploads/news/' . $filename;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->thumbnail && File::exists(public_path($news->thumbnail))) {
            File::delete(public_path($news->thumbnail));
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }
}
