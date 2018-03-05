<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter extends Controller
{
    function index(Request $request)
    {
        $result = \Twitter::get('followers/ids');
        var_dump($result);
        // $this->authTwitter($request);
    }

    public function toggleTwitter(Request $request)
    {
        $shop_code = Admin::user()->username;
        $shop = Shop::where('shop_code', $shop_code)->get()->first();

        $tenant = ShopTenant::where('shop_id', $shop->id)
        ->where('tenant_uuid', $request->tenant_uuid)->get()->first();
        
        $shop_sns = ShopSns::where('tenant_id', $tenant->id)->where('sns_type', ShopSns::SNS_TYPE_TWITTER);
        if($shop_sns->count() > 0){
            $shop_sns->delete();
        }else{
            return $this->authTwitter($request, $request->tenant_uuid);
        }
        return redirect()->route('shop.index');
    }

    public function authTwitter(Request $request)
    {
        $connection = new TwitterOAuth(env('TWITTER_APP_KEY'), env('TWITTER_APP_SECRET'));
        var_dump(route('receive'));
        exit;
        $request_token = $connection->oauth('oauth/request_token', ['oauth_callback' => route('receive')]);

        $request->session()->put('oauth_token', $request_token['oauth_token']);
        $request->session()->put('oauth_token_secret', $request_token['oauth_token_secret']);
        // $request->session()->put('tenant_uuid', $tenant_uuid);
        
        $url = $connection->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));
        return redirect($url);
    }

    public function receiveTwitter(Request $request)
    {
        // $tenant_uuid = $request->session()->get('tenant_uuid');
        // $shop_code = Admin::user()->username;
        // $shop = Shop::where('shop_code', $shop_code)->get()->first();
        // $tenant = ShopTenant::where('shop_id', $shop->id)
        //             ->where('tenant_uuid', $tenant_uuid)->get()->first();

        $request_token = [];
        $request_token['oauth_token'] = $request->session()->get('oauth_token');
        $request_token['oauth_token_secret'] = $request->session()->get('oauth_token_secret');
        if( $request_token['oauth_token'] !== $request->oauth_token ){
            throw new \Exception('token error');
        }

        $connection = new TwitterOAuth(env('TWITTER_APP_KEY'), env('TWITTER_APP_SECRET'), $request_token['oauth_token'], $request_token['oauth_token_secret']);
        $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $request->oauth_verifier));
       
        // ShopSns::create([
        //     // 'shop_id' => $shop->id,
        //     // 'tenant_id' => $tenant->id,
        //     'sns_type' => ShopSns::SNS_TYPE_TWITTER,
        //     'oauth_token' => $access_token['oauth_token'],
        //     'oauth_token_secret' => $access_token['oauth_token_secret'],
        //     'auth_at' => Carbon::now(),
        // ]);

        return redirect()->route('shop.index');
    }

    public function contentPost(Request $request)
    {
        $content = Content::where( 'content_uuid', $request->content_uuid )->get()->first();
        dispatch(new TwetterPostJob($content->id));
        
        return redirect()->route('shop.index');
    }
}
