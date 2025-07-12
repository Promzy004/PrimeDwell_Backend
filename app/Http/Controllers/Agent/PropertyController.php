<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Mail\agentPostedMail;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PropertyController extends Controller
{
    public function upload (Request $request) {

            $request->validate([
                'title' => 'required|string|min:5|max:100',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpg,jpeg,png|max:5120',
                'property_type' => 'required|string',
                'location' => 'required',
                'price' => 'required|numeric|min:1',
                'description' => 'required|string',
                'bed' => 'required|numeric|min:1',
                'room' => 'required|numeric|min:1',
                'bath' => 'required|numeric|min:1',
                'square_meter' => 'required|string',
            ]);

            try{
                $images = $request->file('images');
    
                //gets the first image and store it in a variable as thumbnail image
                $thumbnail_path = $images[0]->store('properties', 'public');
        
                $property = Property::create([
                    'title' => $request->title,
                    'thumbnail_image' => $thumbnail_path,
                    'property_type' => $request->property_type,
                    'location' => $request->location,
                    'price' => $request->price,
                    'description' => $request->description,
                    'bed' => $request->bed,
                    'room' => $request->room,
                    'bath' => $request->bath,
                    'square_meter' => $request->square_meter,
                    'user_id' => $request->user()->id
                ]);
    
                //iterate through all images and saves them individually
                foreach ($images as $image) {
                    $path = $image->store('properties', 'public');
                    PropertyImage::create([
                        'images' => $path,
                        'property_id' => $property->id
                    ]);
                }
    
                $prop = $property->with('property_images')->first();

                //stores the property,user that posted it, and proprty images to a variable for mailing
                $mailProperty = $property->load(['user', 'property_images']);

                $admins = User::where('role', 'admin')->get();

                foreach($admins as $admin) {
                    Mail::to($admin->email)->send(new AgentPostedMail($mailProperty));
                }
        
                return response()->json([
                    'message' => 'uploaded successfully',
                    'property' => $prop
                ], 200);
            } catch (ValidationException $e){
                return response()->json([
                    'message' => 'uploaded failed',
                ], 401);
            }

    }

    public function agentProperties(Request $request, $id) {
        $status = $request->query('status');
        // $id = $request->user()->id;

        $property = property::with('property_images')->where('user_id', $id)->orderBy('updated_at', 'desc');
        if($status === 'pending'){
            $pending = $property->where('status', $status)->paginate(15);
            return response()->json([
                'property' => $pending
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
}
