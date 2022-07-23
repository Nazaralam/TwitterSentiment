<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Figure;
use App\Models\Sentiment;
use App\Models\Tweet;
use Illuminate\Support\Facades\Request as Request1;
use Illuminate\Support\Facades\Hash;
use Session;

class IndexController extends Controller
{
    private $flask_base_url = 'http://127.0.0.1:5000/';

    public function index()
    {
        if(!Session::has('pengguna'))
            return view('login');
        $flask_api = $this->flask_base_url.'api/sentiment/';
        return view('index', ['flask_api' => $flask_api]);
    }

    public function pf() {
        return response()->json(Figure::pluck('name'));
    }

    public function search_latest($figureName = "", $userId = 0) {
        $json = array();
        $figureModel = Figure::where('name', $figureName)->first();
        if($figureModel != null) {
            $figureModel->access = $figureModel->access + 1;
            $figureModel->save();
            $sentiment = Sentiment::where('figure_id', $figureModel->id)->where('user_id', $userId)->orderBy('created_at', 'desc')->first();
            if($sentiment != null) {
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
            } else {
                return response()->json(["success" => false, "msg" => "There is no local data for this public figure"]);
            }
        } else {
            return response()->json(["success" => false, "msg" => "Public figure is not exists"]);
        }
        return response()->json(["success" => true, "data" => $json]);
    }
    
    public function comparison() 
    {
        if(!Session::has('pengguna'))
            return redirect()->route('index');
        $flask_api = $this->flask_base_url.'api/sentiment/';
        return view('comparison', ['flask_api' => $flask_api]);
    }

    public function save_res(Request $request)
    {
        $pengguna = $request->pengguna;
        $figure = $request->figure;
        $data = $request->data;
        $figureModel = Figure::where('name', $figure)->first();
        $figureModel->access = $figureModel->access + 1;
        $figureModel->save();
        $sentiment = new Sentiment;
        $sentiment->user_id = $pengguna["id"];
        $sentiment->figure_id = $figureModel->id;
        $sentiment->status = $data["attitude"];
        if($sentiment->save()) {
            for($i = 0; $i < count($data["data"]); $i++) {
                $sentimentResult = 2;
                if($data["data"][$i]["sentiment"] == "--")
                    $sentimentResult = 0;
                else if($data["data"][$i]["sentiment"] == "-")
                    $sentimentResult = 1;
                else if($data["data"][$i]["sentiment"] == "+")
                    $sentimentResult = 3;
                else if($data["data"][$i]["sentiment"] == "++")
                    $sentimentResult = 4;
                $tweet = new Tweet;
                $tweet->sentiment = $sentimentResult;
                $tweet->sentiment_id = $sentiment->id;
                $tweet->subjectivity = $data["data"][$i]["subjectivity"];
                $tweet->content = $data["data"][$i]["tweet"];
                $tweet->save();
            }
        } else {
            return response()->json(["success"=>false]);
        }
        return response()->json(["success"=>true]);
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if($user != null) {
            if(Hash::check($request->pass, $user->password)) {
                Session::put('pengguna', $user);
            } else {
                Request1::flashExcept('pass');
                return view('login', ['alert_msg' => 'Password isn\'t correct']);
            }
        } else {
            return view('login', ['alert_msg' => 'Username doesn\'t exists']);
        }
        return redirect()->route('index');
    }

    public function logout() 
    {
        Session::flush();
        return redirect()->route('index');
    }

    public function total_attitude() 
    {
        $good_pf = 0;
        $bad_pf = 0;
        $neutral_pf = 0;
        $sentiment = Sentiment::whereIn('created_at', function($query) {
            $query->selectRaw('MAX(created_at) AS created_at')
                ->from('sentiment as s1')
                ->whereRaw('s1.figure_id = sentiment.figure_id');
        })->get();
        $good_pf = $sentiment->where('status', 'Good!')->count();
        $bad_pf = $sentiment->where('status', 'Bad!')->count();
        $neutral_pf = $sentiment->where('status', 'Neutral')->count();
        return response()->json([
            'good_pf' => $good_pf,
            'bad_pf' => $bad_pf,
            'neutral_pf' => $neutral_pf
        ]);
    }

    public function figure_detail($figureName = "")
    {
        $figure = Figure::where('name', $figureName)->first();
        return response()->json($figure);
    }
}
