<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;
use App\Categorie;
use Image;
use Illuminate\Support\Facades\Session;



class AdminController extends Controller
{
    public function displayUsers()
    {
        $usersList = new User;
        $userCollection = $usersList->all();
        return view('adminData')->with('users', $userCollection);
        return view('adminData')->with('users', $usersList);


    }

    public function displayPosts()
    {
        $postsList = new Post;
        $postCollection = $postsList->all();
        return view('adminData')->with('posts', $postCollection);
        return view('adminData')->with('posts', $postsList);
    }

    public function displayComments()
    {
        $commentsList = new Comment;
        $commentCollection = $commentsList->all();
        return view('adminData')->with('comments', $commentCollection);
        return view('adminData')->with('comments', $commentsList);
    }

    public function displayCategories()
    {
        $categoriesList = new Categorie;
        $categorieCollection = $categoriesList->all();
        return view('adminData')->with('categories', $categorieCollection);
        return view('adminData')->with('categories', $categoriesList);
    }

    public function destroy($userId)
    {
        $user = new User();
        $user->destroy($userId);
        return redirect('users');
    }

    public function edit($userId)
    {
        $user = new User();
        $user = $user->where('id', $userId)->get();
        $user = $user[0];
        return view('editUser')->with('profileData', $user);
    }

    public function update(Request $request)
    {
        $user = new User();
        $profileData = $request->all();
        $user = $user->where('id', $profileData['id'])->get();
        $user = $user[0];
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            Image::make($avatar)->resize(600, 400)->save(public_path('/uploads/avatars/' . $filename));

            $user->picture = $filename;
        }

        $user->contact = $request->contact;
        $user->name = $request->name;

        $user->save();

        return redirect('users');
    }


    public function destroyCategory($categoryId)
    {
        $category = new Categorie();
        $category->destroy($categoryId);
        return redirect('allcategories');
    }

    public function editCategory($categoryId)
    {
        $category = new Categorie();
        $categorie = $category->where('id', $categoryId)->get();
        $categorie = $categorie[0];
        return view('editCategory')->with('categoryData', $categorie);
    }

    public function updateCategory(Request $request)
    {
        $category = new Categorie();
        $categoryData = $request->all();
        $category = $category->where('id', $categoryData['id'])->get();
        $category = $category[0];

        $category->title = $request->title;

        $category->save();

        return redirect('allcategories');
    }

    public function addCategory()
    {
        return view('addCategory');
    }

    public function postCategory(Request $request)
    {
        $category = new Categorie($request->all());
        $category->title = $request->title;

        $category->save();

        return redirect('allcategories');
    }
    public function displayStatistics()
    {

        $postCount = Post::count();
        $categoryCount = Categorie::count();
        $commentCount = Comment::count();

        $onlineUsers = collect(Session::all())->pluck('user_id')->unique()->count();
        $totalUsers = User::count();





        return view('statistics')->with([

            'postCount' => $postCount,
            'categoryCount' => $categoryCount,
            'commentCount' => $commentCount,
            'onlineUsers' => $onlineUsers,
            'totalUsers' => $totalUsers,

        ]);
    }
}
