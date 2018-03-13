<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Main extends Controller
{
    function index(Request $request)
    {
        $matches = [];
        $keyword = '';

        if(!$request->input('keyword') || !\Session::get('access_token') ){
            return view('search')->with(compact('matches', 'keyword'));
        }else{
            $keyword = $request->input('keyword');

            try{
                $matches = $this->searchApiFavoriteKeyword( $keyword, $matches);
            }
            catch (\Exception $e)
            {
                // dd(Twitter::error());
                // dd();
                $error = \Twitter::logs();
                return view('search')->with(compact('matches', 'keyword', 'error'));
            }
            
            // dd($matches);
            return view('search')->with(compact('matches', 'keyword'));
        }
    }


    const API_REQUEST_LIMIT = 5;
    const API_COUNT = 200;
    function searchApiFavoriteKeyword( $keyword, $matches=[], $more_id=null, $request_count=0 )
    {
        $param = ['count' => self::API_COUNT, 'format' => 'array'];
        if( !is_null($more_id)){
            $param['max_id'] = $more_id;
        }
        $responses = \Twitter::getFavorites($param);
        $r = $this->searchResponsesKeyword( $keyword, $responses, $matches, $more_id );
        
        $matches = $r['matches'];
        
        if ( count($responses)===1 && !is_null($more_id) || $request_count > self::API_REQUEST_LIMIT ){
            return $matches;
        }else{
            return $this->searchApiFavoriteKeyword( $keyword, $matches, $r['last_id'], $request_count+=1);
        }

    }
    function searchResponsesKeyword( $keyword, $responses, $matches, $last_id )
    {
        foreach( $responses as $response ){
            if($response['id_str'] === $last_id ){
                continue;
            }

            if(strpos( $response['text'], $keyword )!==false){
                $matches[] = $response;
            }else if(strpos( $response['user']['name'], $keyword )!==false){
                $matches[] = $response;
            }else if(strpos( $response['user']['screen_name'], $keyword )!==false){
                $matches[] = $response;
            }
        }
        $last = end($responses);
        return [
            'matches' => $matches,
            'last_id' => $last['id_str'],
        ];
    }
}
