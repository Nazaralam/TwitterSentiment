<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sentiment;
use App\Models\Tweet;
use Session;

class SentimentController extends Controller
{
    public function index()
    {
        if(!Session::has('pengguna'))
            return redirect()->route('index');
        $data = Sentiment::with('figure')->
            where('user_id', Session::get('pengguna')->id)->
            orderBy('created_at', 'desc')->get();
        return view('sentiment', ['data' => $data]);
    }
    
    public function detail($id = 0)
    {
        if(!Session::has('pengguna'))
            return redirect()->route('index');
        $json = array();
        $sentiment = Sentiment::find($id);
        $json["attitude"] = $sentiment->status;
        $json["sentiment"] = [
            Tweet::where('sentiment_id', $sentiment->id)->where('sentiment', 4)->count(),
            Tweet::where('sentiment_id', $sentiment->id)->where('sentiment', 3)->count(),
            Tweet::where('sentiment_id', $sentiment->id)->where('sentiment', 2)->count(),
            Tweet::where('sentiment_id', $sentiment->id)->where('sentiment', 1)->count(),
            Tweet::where('sentiment_id', $sentiment->id)->where('sentiment', 0)->count()
        ];
        $json["data"] = array();
        foreach(Tweet::where('sentiment_id', $sentiment->id)->get() as $key => $value) {
            $sLogo = "0";
            if($value->sentiment == 0)
                $sLogo = "--";
            else if($value->sentiment == 1)
                $sLogo = "-";
            else if($value->sentiment == 3)
                $sLogo = "+";
            else if($value->sentiment == 4)
                $sLogo = "++";
            array_push($json["data"], [
                "sentiment" => $sLogo,
                "subjectivity" => $value->subjectivity,
                "tweet" => $value->content
            ]);
        }
        return view('sentiment_detail', ['data' => collect($json), 'pf_name' => Sentiment::with('figure')->find($id)->figure->name]);
    }

    public function delete($id = 0) {
        $rowAffected = Sentiment::where('id', $id)->delete();
        return response()->json(['row' => $rowAffected]);
    }
}
