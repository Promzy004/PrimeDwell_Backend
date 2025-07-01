<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function adminAllProperties(Request $request) {
        $status = $request->query('status');

        $property = Property::with('property_images')->orderBy('updated_at', 'desc');
        if($status === 'pending'){
            $pending = $property->where('status', $status)->paginate(15);
            return response()->json([
                'property' => $pending
            ]);
        } 

        if ($status === 'declined') {
            $declined = $property->where('status', $status)->paginate(15);
            return response()->json([
                'property' => $declined
            ]);
        } 

        if ($status === 'approved') {
            $approved = $property->where('status', $status)->paginate(15);
            return response()->json([
                'property' => $approved
            ]);
        } 

        $all = $property->paginate(15);
        return response()->json([
            'property' => $all
        ]);
    }

    public function updateProperty (Request $request, $id) {
        $request->validate([
            'status' => 'required|in:decline,approve'
        ]);
        $status = $request->input('status');

        $property = Property::findOrFail($id);
        $old_status = $property->status;
        if ($old_status === 'pending'){
            if($status === 'decline'){
                $property->update([
                    'status' => 'declined'
                ]);

                return response()->json([
                    'message' => 'Property Declined'
                ]);
            } else {
                $property->update([
                    'status' => 'approved'
                ]);

                return response()->json([
                    'message' => 'Property Approved'
                ]);
            }
        } else{
            return response()->json([
                'message' => 'Can\'t update this property'
            ]);
        }
    }
}
