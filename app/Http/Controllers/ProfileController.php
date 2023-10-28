<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Hobby;
use App\Models\Profile;
use App\Models\UserHobby;
use Illuminate\Http\Request;
use Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::orderBy("id", "desc")->paginate(10);
        $hobbies = Hobby::all();
        $categories = Category::all();
        return view("profile/index", compact("profiles", "hobbies", "categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contact_no' => 'required|digits:10',
            'category' => 'required',
            'profile_image' => 'required|mimes:jpeg,jpg,png,svg|max:20480',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $input = $request->only('name', 'contact_no');
        $input['category_id'] = $request->category;
        $file = $request->file('profile_image');
        $hobbies = $request->hobbies;
        if ($file) {
            $fileName = time() . uniqid() . '.' . $request->profile_image->extension();
            // $fileName = time() . $request->image_file->extension();
            $request->profile_image->move(public_path('/assets/uploads/profile'), $fileName);

            $input['profile_pic'] = $fileName;
        }

        $profile_id = Profile::create($input)->id;
        foreach ($hobbies as $hobbies_id) {
            UserHobby::create([
                'profile_id' => $profile_id,
                'hobby_id' => $hobbies_id,
            ]);
        }
        return response()->json(['status' => 'success', 'message' => 'Profile Added successful'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $hobbies = Hobby::all();
        $categories = Category::all();
        $selectedHobbies = $selectedHobbies = $profile->hobbies->pluck('id')->toArray();

        return view('profile/edit', ['profile' => $profile, 'hobbies' => $hobbies, 'categories' => $categories, 'selectedHobbies' => $selectedHobbies]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Profile $profile, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contact_no' => 'required|digits:10',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!$profile) {
            // Handle the case where the profile does not exist
            return response()->json(['errors' => 'Somthing Went Wrong'], 422);
        }

        $input = $request->only('name', 'contact_no');
        $input['category_id'] = $request->category;
        $hobbies = $request->hobbies;

        // Update the profile data
        $profile->update($input);

        // Update hobbies (first detach existing hobbies, then attach new ones)
        $profile->hobbies()->detach();
        $profile->hobbies()->attach($hobbies);

        // Handle profile image update
        $file = $request->file('profile_image');
        if ($file) {
            $fileName = time() . uniqid() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('/assets/uploads/profile'), $fileName);

            // Update the profile pic field
            $profile->profile_pic = $fileName;
            $profile->save();
        }
        return response()->json(['status' => 'success', 'message' => 'Profile updated successful'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $profile = Profile::find($request->id);
    if (!$profile) {
        return response()->json(['error' => 'Profile not found.'], 404);
    }

    // Detach hobbies associated with the profile
    $profile->hobbies()->detach();

    // Now you can safely delete the profile
    $profile->delete();
    
        return response()->json(['success' => 'Profile deleted successfully.']);
}
}
