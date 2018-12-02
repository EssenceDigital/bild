<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Guest;
use App\Http\Requests\SaveRsvp;
use App\Http\Requests\UpdateRsvp;

class RsvpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index()
    {
      // Set up 'antibot' style 'captcha' for contact form
      $numberConversion = array(
          0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
          6 => 'six', 7 => 'seven', 8 =>'eight', 9 => 'nine', 10 => 'ten'
      );
      // Produce random numbers
      $numberOne = rand( 0, 6 );
      $numberTwo = rand( 0, 6 );
      // Add to the session for usage later
      session(['antibotquestion' => 'What is ' . $numberConversion[$numberOne] .
                ' added to ' . $numberConversion[$numberTwo] . ' *', 'antibotanswer' => $numberOne + $numberTwo]);

      return view('rsvp');
    }

    /**
  	 * Send an RSVP
  	 *
  	 * @param  SaveRvsp $request
  	 * @return JSON Response
  	*/
    public function send(SaveRsvp $request)
    {
      if(session('antibotanswer') != $request->captcha){
  			// Return error is save didnt work
        return response()->json([
          'result' => 'error',
          'errors' => ['captcha' => ['Captcha answer is incorrect.']]
        ], 422);
      }

      // Start booking
  		$guest = new Guest;
  		// Fill booking
  		$guest->fill($request->except(['captcha']));
  		// Save booking
  		if(! $guest->save()){
  			// Return error is save didnt work
        return response()->json([
            'result' => 'error'
        ], 404);
  		}

      // Return success if everything worked
      return response()->json([
          'result' => 'success'
      ], 200);

    }

    /**
  	 * Send an RSVP
  	 *
  	 * @param  UpdateRvsp $request
  	 * @return JSON Response
  	*/
    public function update(UpdateRsvp $request)
    {
      // Start booking
  		$guest = Guest::findOrFail($request->id);
  		// Fill booking
  		$guest->fill($request->toArray());
  		// Save booking
  		if(! $guest->save()){
  			// Return error is save didnt work
        return response()->json([
            'result' => 'error'
        ], 404);
  		}

      // Return success if everything worked
      return response()->json([
          'result' => 'success',
          'rsvp' => $guest
      ], 200);

    }
}
