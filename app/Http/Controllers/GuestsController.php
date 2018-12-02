<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Guest;
use App\Http\Requests\UpdateRsvp;

class GuestsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all()
    {
      return Guest::get();
    }

    /**
  	 * Update an RSVP
  	 *
  	 * @param  UpdateRvsp $request
  	 * @return JSON Response
  	*/
    public function updateRsvp(UpdateRsvp $request)
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
