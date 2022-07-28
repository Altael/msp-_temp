<?php

namespace App\Http\Controllers;

use App\Models\Blog\Category;
use App\Models\Blog\Post;

class ViewsController extends Controller
{

    public function home()
    {
        if (request()->root() === env('AM_URL')) {
            return redirect('/news');
        }

        return view('home');
    }

    public function profile()
    {
        return view('users.profile');
    }

    public function userMissingLessons()
    {
        return view('user.missing-lessons');
    }

    public function requests()
    {
        return view('requests.index');
    }

    public function initiations()
    {
        return view('initiations.index');
    }

    public function conversations()
    {
        if (!auth()->user()->hasRole('acarya')) return abort('Unauthorized');

        return view('conversations.index');
    }

    public function geo()
    {
        return view('geo.index');
    }

    public function users()
    {
        return view('users.index');
    }

    public function statistics()
    {
        return view('statistics.index');
    }

    public function unitStatistics()
    {
        return view('statistics.unitStatistics');
    }

    public function bhuktiStatistics()
    {
        return view('statistics.bhuktiStatistics');
    }

    public function eventsReport()
    {
        return view('practices.eventsReport');
    }

    public function diary()
    {
        return view('diary.index');
    }

    public function diaryRecord()
    {
        return view('diary.record');
    }

    public function diaryDay()
    {
        return view('diary.diary-day');
    }

    public function loginByEmail()
    {
        return view('auth.login-email');
    }

    public function diaryEdit()
    {
        if(auth()->user()->hasRole('diary')) return view('diary.edit');
        return redirect('/');
    }

    public function eEgg()
    {
        return view('easterEgg');
    }

    public function sNames()
    {
        return view('handbooks.spiritualNames');
    }

    public function missingLessons()
    {
        return view('handbooks.missingLessons');
    }

    public function fastings() {
        return view('handbooks.fastingsList');
    }

    public function puzzleEdit() {
        return view('handbooks.dailyPuzzleEditor');
    }

    public function samgiitsEdit() {
        if(auth()->user()->hasRole('singer') || auth()->user()->hasRole('admin')) return view('handbooks.samgiitsEditor');
        return redirect('/');
    }

    public function postsLang() {
        return view('handbooks.postsLang');
    }

    public function postsCategories() {
        return view('handbooks.postsCategories');
    }

    public function posts($category) {


        return view('blog.posts', [
            'category' => $category,
            'title' => Category::where('slug', $category)->value('category_name')
        ]);
    }

    public function lessonReqs() {
        return view('handbooks.lessonRequirements');
    }

    public function unit() {
        return view('geo.unit');
    }

    public function education() {
        return view('blog.education');
    }

    public function news() {
        return view('blog.news');
    }

    public function post($post_slug) {

        $post = Post::where('slug', $post_slug)->first();

        return view('blog.post', [
            'post_slug' => $post_slug,
            'title' => $post->title,
            'category' => $post->categories()->first()->slug
        ]);
    }

    public function category($category_slug) {

        $category = Category::where('slug', $category_slug)->first();

        return view('blog.category', [
            'category_slug' => $category_slug,
            'title' => $category->category_name,
            'subtitle' => $category->category_description,
            'author_name'=> $category['author_name_' . app()->getLocale()]
            //'category' => $category->categories()->first()->slug
        ]);
    }

    public function media() {
        return view('handbooks.mediaLibrary');
    }

    public function programs() {
        return view('handbooks.programs');
    }

    public function unitPrograms() {
        return view('user.unitPrograms');
    }

    public function practices() {
        return view('practices.practices');
    }

    public function dharmacakra() {
        return view('practices.dharmacakra');
    }

    public function adminPanel() {
        if(auth()->user()->hasRole('admin')) return view('adminPanel');
        return redirect('/');
    }

    public function statuses() {
        return view('handbooks.statuses');
    }

    public function curators() {
        return view('handbooks.curators');
    }

    public function samgiitsPage()
    {
        return view('practices.samgiits');
    }

    public function medForEve()
    {
        return view('sadvipra.medForEve');
    }

    public function callRequests()
    {
        return view('sadvipra.callRequests');
    }

    public function callRequest()
    {
        return view('sadvipra.callRequest');
    }

    public function svadhyaya()
    {
        return view('blog.svadhyaya');
    }
}
