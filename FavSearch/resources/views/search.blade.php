<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ふぁぼ</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="main">
        <form method="get" action="/">
            <input type="text" name="keyword" value="{{ $keyword }}">
            <input type="submit" value="検索">
        </form>
        @foreach ( $matches as $matche )
            <blockquote class="twitter-tweet" data-lang="ja"><p lang="ja" dir="ltr">{{ $matche['text'] }}</a></p>&mdash; {{ $matche['user']['name'] }} (@{{ $matche['user']['screen_name'] }}) <a href="https://twitter.com/{{ $matche['user']['screen_name'] }}/status/{{ $matche['id_str'] }}?ref_src=twsrc%5Etfw">{{ $matche['created_at'] }}</a></blockquote>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

        @endforeach
        </div>
    </body>
</html>