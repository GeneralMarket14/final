<?php

namespace App\Http\Controllers\Api\V2\Seller;



use Illuminate\Http\Request;
use App\Models\WorkingHour;
use App\Http\Resources\WorkingHourResource;

class AllWorkingHourController extends Controller
{
    public function index()
    {    
         $workingHour = WorkingHour::all();

        return response()->json([
            'result' => true,
            'working_hour' => [
                'days' => [
                    'start' => $workingHour->start_day,
                    'end' => $workingHour->end_day,
                ],
                'time' => [
                    'start' => $workingHour->start_time,
                    'end' => $workingHour->end_time,
                ]
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        

        $validated = $request->validate([
            'user_id' => 'required',
            'start_day' => 'required|string',
            'end_day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $workingHour = WorkingHour::create($request->all());

        return response()->json([
            'result' => true,
            'working_hour' => [
                'days' => [
                    'start' => $workingHour->start_day,
                    'end' => $workingHour->end_day,
                ],
                'time' => [
                    'start' => $workingHour->start_time,
                    'end' => $workingHour->end_time,
                ]
            ]
        ], 201);
    }

    public function show($id)
    {   
        $workingHour = WorkingHour::where('user_id',$id)->first();
        if($workingHour != null){
              return response()->json([
            'result' => true,
            'working_hour' => [
                'days' => [
                    'start' => $workingHour->start_day,
                    'end' => $workingHour->end_day,
                ],
                'time' => [
                    'start' => $workingHour->start_time,
                    'end' => $workingHour->end_time,
                ]
            ]
        ], 200);
        }else{
             $validatedData['user_id'] = $id;
             $validatedData['start_day'] = $validatedData['start_day'] ?? 'Monday';
        $validatedData['end_day'] = $validatedData['end_day'] ?? 'Friday';
        $validatedData['start_time'] = $validatedData['start_time'] ?? '09:00';
        $validatedData['end_time'] = $validatedData['end_time'] ?? '17:00';

        // Create the WorkingHour record
        $workingHour = WorkingHour::create($validatedData);

        // Return a response
        return response()->json([
            'result' => true,
            'message' => 'Default Values Set',
               'working_hour' => [
                'days' => [
                    'start' => $workingHour->start_day,
                    'end' => $workingHour->end_day,
                ],
                'time' => [
                    'start' => $workingHour->start_time,
                    'end' => $workingHour->end_time,
                ]
            ]
        ], 201);
        }

      
    }

    public function update(Request $request)
    {    
        $request->validate([
            'user_id' => 'string',
            'start_day' => 'string',
            'end_day' => 'string',
            'start_time' => 'string',
            'end_time' => 'string',
        ]);

        $workingHour = WorkingHour::where('user_id',$request->user_id)->first();
        if($workingHour != null){
        $workingHour->update([
            'start_day'=>$request->start_day,
            'end_day'=> $request->end_day,
            'start_time'=> $request->start_time,
            'end_time'=> $request->end_time
            ]);
            
            // $request->all());

        return response()->json([
            'result' => true,
            'working_hour' => [
                'days' => [
                    'start' => $workingHour->start_day,
                    'end' => $workingHour->end_day,
                ],
                'time' => [
                    'start' => $workingHour->start_time,
                    'end' => $workingHour->end_time,
                ]
            ]
        ], 200);
    }else{
             return response()->json([
            'result' => false,
            'message'=>'No Current Working Hours',
             ], 200);
        }
    }

    public function destroy($id)
    {    
        WorkingHour::destroy($id);
        return response()->json(['result' => true], 204);
    }
}
