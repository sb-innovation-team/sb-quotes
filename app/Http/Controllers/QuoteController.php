<?php

namespace App\Http\Controllers;

use App\Quote;
use Illuminate\Http\Request;

/**
 * Class QuoteController
 * @package App\Http\Controllers
 */
class QuoteController extends Controller
{

    /**
     * @param null $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function get ($id = null)
    {

        if (empty ($id))
            return response (Quote::inRandomOrder ()->first ());

        $quote = Quote::find ($id);

        if ( ! $quote)
            return $this->throwError ("QuoteNotFound");

        return response ($quote);

    }

    /**
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function getAll ()
    {

        return response (Quote::all ());

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create (Request $request)
    {

        $quote  = $request->input ("quote");
        $author = $request->input ("author");

        if (empty ($quote) && empty ($author))
            return response ()->json (INVALID_PARAMETERS_ERROR);

        $newQuote = new Quote ();
        $newQuote->quote = $quote;
        $newQuote->author = $author;

        if ( ! $newQuote->save ())
            return $this->throwError ("CouldNotCreateQuote");

         return response ()->json (["status" => "success"]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function delete ($id)
    {

        $quote = Quote::find ($id);

        if ( ! $quote)
            return $this->throwError ("CouldNotFindQuote");

        if ( ! $quote->delete ())
            return $this->throwError ("CouldNotDeleteQuote");

        return response (["status" => "success"]);

    }

}
