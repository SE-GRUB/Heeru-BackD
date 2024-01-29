<?php

namespace App\Http\Controllers;

use App\Models\infographic_image;

class InfographicImageController extends Controller
{
    public function destroy(infographic_image $infographic_image){
        $infographic_image->delete();
        return redirect()->back()->with('success', 'Infographic image deleted successfully.');
    }
}
