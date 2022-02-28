<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category) { // afficher les articles par catégorie
        // dd($category);
        $articles = $category->articles()->withCount('comments')->latest()->paginate(5);
        // dd($articles);
        $data = [
            'title' => $description = 'Les articles de la catégorie '. $category->name,
            'description' => $description,
            'category' => $category,
            'articles' => $articles,
        ];

        return view('category.show', $data);
    }
}
