<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Repositories\{FileRepository};
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    protected $file;
    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quotes.create')->with('title','Post Quote')
        ->with('quoteMenu', true)
        ->with('hicon','fa-quote-right');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuoteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuoteRequest $request)
    {
        $arr = $request->only('post');
        $arr['user_id'] = $request->user()->id;
        $quote = Quote::create($arr);
        if ($request->image) {
            $this->file->create([$request->image], 'quotes', $quote->id, 1);
        }
        return redirect()->route('dashboard')->with('redirect_success', 'Quote Posted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    // public function edit(Quote $quote)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuoteRequest  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    // public function update(UpdateQuoteRequest $request, Quote $quote)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        if($quote->user_id==auth()->user()->id){
            $quote->image()->delete();
            $quote->delete();
        }
        return redirect()->route('dashboard')->with('redirect_success', 'Quote Deleted');
    }

    public function postComments(Request $request, Quote $quote){
        if($quote){
            $quote->comments()->create([
                'user_id' => $request->user()->id,
                'comment' => $request->comment
            ]);
        }
        $quote->load('comments.user');
        return response()->json(['comments' => $quote->comments]);
    }
}
