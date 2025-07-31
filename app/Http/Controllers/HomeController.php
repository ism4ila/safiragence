<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredServices = Service::where('is_featured', true)->take(3)->get();
        $galleryImages = GalleryImage::orderBy('sort_order', 'asc')
                                    ->orderBy('created_at', 'desc')
                                    ->take(8)
                                    ->get();

        return view('home', compact('featuredServices', 'galleryImages'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function about()
    {
        return view('about');
    }
}