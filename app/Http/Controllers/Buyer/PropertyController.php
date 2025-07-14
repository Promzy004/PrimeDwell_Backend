<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Mail\BuyerPropertyEnquiryMail;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PropertyController extends Controller
{
    public function buyerAllProperties (Request $request) {
        $user = $request->user();

        //returns a collection of favorited property id's
        $favoritedIds = $user->favoriteProperties()->pluck('properties.id');

        //returns collection of all properties with user that posted it and property images
        $properties = Property::with('user', 'property_images')->where('status', 'approved')->orderBy('updated_at', 'desc')->paginate('15');

        //compare property id if the favorited id match it or not
        foreach ($properties as $property) {

            // if it matches it, it would create a key called favorited and return value true
            // if it does not matches it, it would create a key called favorited and return value false
            $property->favorited = $favoritedIds->contains($property->id);
        }

        return response()->json($properties);
    }

    public function favorite (Request $request, $id) {
        $user = $request->user();
        $propertyId = $id;

        $property = Property::where('id', $propertyId)->first();

        if($property) {
            if(!$user->favoriteProperties->contains($propertyId)) {
                
                $user->favoriteProperties()->attach($propertyId);
                return response()->json([
                    'message' => 'added to favorite'
                ]);
            } else {
                $user->favoriteProperties()->detach($propertyId);
                return response()->json([
                    'message' => 'removed from favorite'
                ]);
            }
        } else {
            return response()->json([
                'message' => 'property does not exist'
            ]);
        }
    }

    public function messageAgent (Request $request, $id) {
        $buyer_datas = $request->validate([
            'buyer_email' => 'required|email',
            'buyer_name' => 'required',
            'buyer_message' => 'required|string|min:10'
        ]);

        $property = Property::with('user:id,firstname,lastname,email', 'property_images')->where('id', $id)->first();

        Mail::to($property->user->email)->send(new BuyerPropertyEnquiryMail($buyer_datas, $property));
        

        return response()->json([
            'message' => 'Email succefully sent'
        ]);
    }

    // public function getFavoritedProperties (Request $request) {
    //     $user = $request->user();

    //     $properties = $user->favoriteProperties()->with(['user:id,firstname,lastname,phone_number,email'])->orderBy('updated_at', 'desc')->paginate(15);

    //     return response()->json([
    //         'properties' => $properties
    //     ]);
    // }
}
