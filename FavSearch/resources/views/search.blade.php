<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ふぁぼから探すやつ</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <header>
            <h1>ふぁぼから探すやつ</h1>
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
        </header>
        <div class="main">
            
        @foreach ( $matches as $matche )
            <blockquote class="twitter-tweet" data-lang="ja"><p lang="ja" dir="ltr">{{ $matche['text'] }}</a></p>&mdash; {{ $matche['user']['name'] }} (@{{ $matche['user']['screen_name'] }}) <a href="https://twitter.com/{{ $matche['user']['screen_name'] }}/status/{{ $matche['id_str'] }}?ref_src=twsrc%5Etfw">{{ $matche['created_at'] }}</a></blockquote>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

        @endforeach
        </div>
        <footer>
            作った人: <a target="_target" href="https://twitter.com/kyon_g">@kyon_g</a>
        </footer>
    </body>
</html>