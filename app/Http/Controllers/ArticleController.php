<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;



class ArticleController extends Controller
{
    public function index()
{
    $articles = Article::with('user')->get();
    $categories = Category::all();

    return view('articles.all_articles', compact('articles', 'categories'));
}



    public function show(Article $article)
    {
        // Load the comments with the article
        $comments = $article->comments()->withCount('likes')->get();

        return view('articles.view_articles', compact('article', 'comments'));
    }

    public function like(Article $article)
    {
        $user = auth()->user();

        // Check if the user has already liked the article
        $like = $article->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // If the user has liked it, delete the like
            $like->delete();
        } else {
            // Otherwise, create a new like
            $article->likes()->create(['user_id' => $user->id]);
        }

        return redirect()->back();
    }

    public function edit(Article $article)
{
    // Get the categories for the dropdown selection
    $categories = Category::all();

    // Return the view with the article and categories data
    return view('articles.edit_article', compact('article', 'categories'));
}


    /**
     * Show the create article form.
     */
    public function create()
    {
        $categories = Category::all(); // To pass available categories
        return view('articles.create_article', compact('categories'));
    }

    /**
     * Store the newly created article in the database.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required',
        'category_id' => 'required|exists:categories,id', // Ensure category_id is included
        'image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'video' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:20000',
    ]);

    // Store the uploaded image
    if ($request->hasFile('image')) {
        $validatedData['pic_path'] = $request->file('image')->store('images', 'public');
    }

    // Store the uploaded video
    if ($request->hasFile('video')) {
        $validatedData['vid_path'] = $request->file('video')->store('videos', 'public');
    }

    // Add the user_id to the validated data
    $validatedData['user_id'] = auth()->id();

    // Create the article with the validated data, including category_id
    Article::create($validatedData);

    return redirect()->route('articles.index')->with('success', 'Article created successfully.');
}
// app/Http/Controllers/ArticleController.php

public function destroy(Article $article)
{
    // Ensure that only the owner of the article can delete it
    if (auth()->id() !== $article->user_id) {
        abort(403, 'Unauthorized action.');
    }

    $article->delete();

    return redirect()->route('profile.show')->with('success', 'Article deleted successfully.');
}



public function update(Request $request, Article $article)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'video' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:20000',
    ]);

    // Update the image if a new one is uploaded
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($article->pic_path) {
            Storage::disk('public')->delete($article->pic_path);
        }
        // Store new image
        $validatedData['pic_path'] = $request->file('image')->store('images', 'public');
    }

    // Update the video if a new one is uploaded
    if ($request->hasFile('video')) {
        // Delete old video if exists
        if ($article->vid_path) {
            Storage::disk('public')->delete($article->vid_path);
        }
        // Store new video
        $validatedData['vid_path'] = $request->file('video')->store('videos', 'public');
    }

    $article->update($validatedData);

    return redirect()->route('articles.show', $article->id)->with('success', 'Article updated successfully.');
}



}
