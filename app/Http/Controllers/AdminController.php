<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalContents = [
            'articles' => Article::count(),
            'comments' => Comment::count(),
        ];
        $totalCategories = Category::count();

        return view('admin.dashboard', compact('totalUsers', 'totalContents', 'totalCategories'));
    }

    // Manage Users
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
