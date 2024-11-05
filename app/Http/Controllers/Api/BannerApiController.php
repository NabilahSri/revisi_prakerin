<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\User;
use Illuminate\Http\Request;

class BannerApiController extends Controller
{
    public function show(Request $request){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $banner = Banner::latest()->take(5)->get();
            foreach ($banner as $banners) {
                if ($banners->gambar) {
                    $banners->gambar = asset('storage/'.$banners->gambar);
                }
            }
            return response()->json(['banner' => $banner],200);
        }
    }

    public function showId(Request $request,$id){
        $user = User::where(['login_token' => $request->token])->first();
        if ($request->token == null) {
            return response()->json(['message' => 'Unauthorization user'],401);
        }else{
            $banner = Banner::where('id',$id)->first();
            if ($banner) {
                if ($banner->gambar) {
                    $banner->gambar = asset('storage/'.$banner->gambar);
                }
            }else{
                return response()->json(['message' => 'Banner tidak ditemukan'],404);
            }
            return response()->json(['banner' => $banner],200);
        }
    }
}
