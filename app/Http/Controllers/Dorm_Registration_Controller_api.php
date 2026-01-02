<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dorm_registration_submission;
use App\Models\User;

use App\Models\Dorm;


class Dorm_Registration_Controller_api extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {

        $Fields =  $request->query('fields');
        if (!$Fields){
            return response()->json([
                'error' => "No fields specified, please provide specific fields"
            ], 400);

        }
        $requestedFields = explode(",", $Fields);
        $submission = Dorm_registration_submission::select($requestedFields)->where('id', $id)->first();

        if(!$submission){
            return response()->json([
                'error'=>'Submission not found'
            ], 404);
        }

        return response()->json($submission);

    }

    public function update_status(Request $request, $submission_id, $final_verdict){
        $infos = Dorm_registration_submission::find($submission_id);
        if(!$infos){
                return response()->json([
                'error' => "No such submission found",

                ], 400);
        }
        
        $infos->update([
            'status'=>$final_verdict
        ]);
        if($final_verdict !== 'Approved'){
            return response()->json([
                'status' => true,
                'success_message' => "Application {$final_verdict}"
            ]);
        }
        $add_new_dorm = Dorm::create([
            // FK
            "owner_id" => $infos->owner_id,
        
            // Basic info
            "name"         => $infos->dorm_name,
            "dorm_hotline" => $infos->dorm_hotline,
            "location"     => $infos->dorm_location,
        
            // Geo
            "latitude"  => $infos->latitude,
            "longitude" => $infos->longitude,
        
            // Rules / preferences
            "student_only" => $infos->student_only ?? 'No',
            "gender_preference" => $infos->gender_preference ?? 'Not Gender Specified',
            "expected_marital_status" => $infos->expected_marital_status ?? 'Not Specified',
        
            // Documents & images
            "owner_passport" => $infos->passport,
            "property_document" => is_array($infos->property_ownership_doc)
                ? json_encode($infos->property_ownership_doc)
                : $infos->property_ownership_doc,
        
            "dorm_images" => is_array($infos->dorm_pictures)
                ? json_encode($infos->dorm_pictures)
                : $infos->dorm_pictures,
        
            // Rooms & facilities
            "number_of_rooms" => $infos->number_of_rooms,
        
            "room_types" => is_array($infos->room_types)
                ? json_encode($infos->room_types)
                : $infos->room_types,
        
            "facilities" => is_array($infos->facilities)
                ? json_encode($infos->facilities)
                : $infos->facilities,
        
            // Reviews / ratings
            "dorm_review" => json_encode([]), // empty review list initially
            "dorm_rating" => 0.00,
        
            // Business fields
            "rent"   => 0.00,
            "status" => $infos->status === 'Approved' ? 'Running' : 'Closed',
        ]);

        if(!$add_new_dorm){
                return response()->json([
                'error' => "Update failed!!! Some error occured!!!",

                ], 404);        }
        return response()->json([
            'status' => true,
            'success_message' => "Application {$final_verdict}"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
