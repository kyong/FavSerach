<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=510px, initial-scale=1">
        <meta name="description" content="Twitterの過去1000件ぐらいの自分のいいねから検索します。">
        <meta name="keywords" content="Twitter,いいね,ふぁぼ,お気に入り,検索">
        <title>ふぁぼから探すやつ</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
        <script
            src="https://code.jquery.com/jquery-3.3.1.slim.js"
            integrity="sha256-fNXJFIlca05BIO2Y5zh1xrShK3ME+/lYZ0j+ChxX2DA="
            crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/style.css">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-3633767186289157",
            enable_page_level_ads: true
        });
        $(function(){
            $('form').on('submit', function(){
                $(":submit, :image", this).attr("disabled", true);
                var mask = $('<div>').css({
                    'background': '#000',
                    'opacity': '0.6',
                    'position': 'absolute',
                    'top': '0px',
                    'left' : '0px',
                    'width': $(document).width(),
                    'height': $(document).height()
                });
                $('body').append(mask);
            });
        });
        </script>
    </head>
    <body>
        <header>
            <h1>ふぁぼから探すやつ</h1>
            <p>過去1000件ぐらいから探します。</p>
            @if( !\Session::get('access_token') )
                <a href="{{ route('twitter.login') }}"><button class="btn btn-primary ">ログイン</button></a>
            @else
            <form class="searchbox" method="get" action="/">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                            <input type="text" name="keyword" value="{{ $keyword }}" class="form-control"> 
                        </div>
                        <div class="searchsubmit col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <input type="submit" value="検索" class="btn btn-primary btn-block">
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </header>
        <div class="main">
        @if( isset($error) )
            <div class="error">
            @if($error[6]=='ERROR_CODE : 88')
                API制限（{{$error[7]}}）
            @else
                不明エラー（{{$error[7]}}）
            @endif
            </div>
        @endif
        @foreach ( $matches as $matche )
            <blockquote class="twitter-tweet" data-lang="ja"><p lang="ja" dir="ltr">{{ $matche['text'] }}</a></p>&mdash; {{ $matche['user']['name'] }} (@{{ $matche['user']['screen_name'] }}) <a href="https://twitter.com/{{ $matche['user']['screen_name'] }}/status/{{ $matche['id_str'] }}?ref_src=twsrc%5Etfw">{{ $matche['created_at'] }}</a></blockquote>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        @endforeach
        </div>
        <footer>
            作った人: <a target="_target" href="https://twitter.com/kyon_g">@kyon_g</a>
            <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </footer>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115184817-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-115184817-1');
</script>
    </body>
</html>