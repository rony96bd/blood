<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use App\Models\Blood;
use App\Models\City;
use App\Models\Division;
use App\Models\Donor;
use App\Models\Location;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class BloodRequestController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Blood Request List";
        $emptyMessage = "No data found";

        $bloodRequests = BloodRequest::latest()->with('blood', 'division', 'city', 'location', 'donor')
            ->paginate(getPaginate());

        $data['divisions'] = Division::get(["name", "id"]);
        $cities = City::where('status', 1)->select('id', 'name')->with('location')->get();
        $bloods = Blood::where('status', 1)->select('id', 'name')->get();
        $donors = Donor::latest()->with('blood', 'location')->paginate(getPaginate());

        return view('admin.blood_request.index', $data, compact('pageTitle', 'emptyMessage', 'donors', 'cities', 'bloods', 'bloodRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Donor Create";
        $data['divisions'] = Division::get(["name", "id"]);
        $donor = Auth::guard('donor')->user();
        $cities = City::where('status', 1)->select('id', 'name')->with('location')->get();
        $bloods = Blood::where('status', 1)->select('id', 'name')->get();
        return view($this->activeTemplate . 'admin.create_blood_request', $data, compact('pageTitle', 'donor', 'cities', 'bloods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'division' => 'required|exists:divisions,id',
            'city' => 'required|exists:cities,id',
            'location' => 'required|exists:locations,id',
            'blood' => 'required|exists:bloods,id',
            'donate_date' => 'required',
            'donate_time' => 'required',
            'donate_address' => 'required',
            'phone' => 'required',
        ]);

        $donor_id = 0;
        $donor = new BloodRequest();
        $donor->donor_id = $donor_id;
        $donor->division_id = $request->division;
        $donor->city_id = $request->city;
        $donor->location_id = $request->location;
        $donor->blood_id = $request->blood;
        $donor->problem = $request->problem;
        $donor->amount_of_blood = $request->amount_of_blood;
        $donor->donate_date = $request->donate_date;
        $donor->donate_time = $request->donate_time;
        $donor->donate_address =  $request->donate_address;
        $donor->phone = $request->phone;
        $donor->message = $request->message;
        $donor->save();

        // $division = Division::where('id', $request->division)->select('id', 'name')->value('name');
        // $city = City::where('id', $request->city)->select('id', 'name')->value('name');
        // $location = Location::where('id', $request->location)->select('id', 'name')->value('name');
        // $blood = Blood::where('id', $request->blood)->select('id', 'name')->value('name');
        // $requrlid = $donor->id;

        // $url = "http://bulksmsbd.net/api/smsapi";
        // $api_key = env('BULKSMS_API');
        // $senderid = "8809617612994";

        // $numbers = Donor::where('division_id', $request->division)
        //     ->where('city_id', $request->city)
        //     ->where('location_id', $request->location)
        //     ->where('blood_id', $request->blood)
        //     ->pluck('phone');

        // $collection = new Collection($numbers);

        // $array = $collection->toArray();

        // $arrayWithNumber = array_map(function ($item) {
        //     return '88' . $item;
        // }, $array);

        // $commaSeparatedNumbers = implode(',', $arrayWithNumber);

        // $sendmess = "From, https://roktodin.com \nEmargency Need Blood:\nDivision: " . $division . "\nDistrict: " . $city . "\nUpazila: " . $location . "\nBlood Group: " . $blood . "\nContact: " . $request->phone;
        // $message = "$sendmess";
        // $data = [
        //     "api_key" => $api_key,
        //     "senderid" => $senderid,
        //     "number" => $commaSeparatedNumbers,
        //     "message" => $message
        // ];

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // $response = curl_exec($ch);
        // curl_close($ch);
        $notify[] = ['success', 'Your Requested Submitted'];
        // $notify[] = ['success', $response];
        return back()->withNotify($notify);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function show(BloodRequest $bloodRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = "Edit Blood Request";
        $emptyMessage = "No data found";
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequests = BloodRequest::latest()->with('blood', 'division', 'city', 'location', 'donor')
        ->paginate(getPaginate());

        $data['divisions'] = Division::get(["name", "id"]);
        $cities = City::where('status', 1)->select('id', 'name')->with('location')->get();
        $bloods = Blood::where('status', 1)->select('id', 'name')->get();
        $donors = Donor::latest()->with('blood', 'location')->paginate(getPaginate());

        return view('admin.blood_request.edit', $data, compact('pageTitle', 'emptyMessage', 'donors', 'cities', 'bloods', 'bloodRequests', 'bloodRequest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'division' => 'required|exists:divisions,id',
            'city' => 'required|exists:cities,id',
            'location' => 'required|exists:locations,id',
            'blood' => 'required|exists:bloods,id',
            'donate_date' => 'required',
            'donate_time' => 'required',
            'donate_address' => 'required',
            'phone' => 'required',
        ]);

        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->division_id = $request->division;
        $bloodRequest->city_id = $request->city;
        $bloodRequest->location_id = $request->location;
        $bloodRequest->blood_id = $request->blood;
        $bloodRequest->problem = $request->problem;
        $bloodRequest->amount_of_blood = $request->amount_of_blood;
        $bloodRequest->donate_date = $request->donate_date;
        $bloodRequest->donate_time = $request->donate_time;
        $bloodRequest->donate_address =  $request->donate_address;
        $bloodRequest->phone = $request->phone;
        $bloodRequest->message = $request->message;
        $bloodRequest->save();
        $notify[] = ['success', 'Blood Request has been updated'];
        return back()->withNotify($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BloodRequest  $bloodRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $bloodRequest = BloodRequest::where('id', $request->bloodrequest_id)->first();
            $bloodRequest->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Blood Request Deleted Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Something went wrong'
            ]);
        }
    }
}
