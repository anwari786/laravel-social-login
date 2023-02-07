<?php

namespace App\Http\Controllers;

use App\Mail\MarkdownMailTest;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sendTestMail()
    {
        // dd(new TestMail());
        Mail::to('anwari786@hotmail.de')->send(new TestMail());
        // return new TestMail();

    }

    public function sendMarkdownTestMail()
    {
        // dd(new TestMail());
        Mail::to('anwari786@hotmail.de')->send(new MarkdownMailTest());
        // return new TestMail();

        return redirect('http://advanced-laravel.test:8025');
        // return redirect()->route('home');

    }
}
