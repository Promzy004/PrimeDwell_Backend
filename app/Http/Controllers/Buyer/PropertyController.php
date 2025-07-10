<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function buyerAllProperties () {}

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

    public function getFavoritedProperties (Request $request) {
        $user = $request->user();

        $properties = $user->favoriteProperties()->paginate();

        return response()->json([
            'properties' => $properties
        ]);
    }
}
