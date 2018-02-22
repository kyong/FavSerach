<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tweet店長</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="{{ asset('/js/bootstrap.js') }}"></script>
        <script>
        $(document).ready(function(){
            $('.nav').find('li').eq(0).addClass('active');
            $('#tabs a').tab('show');
        });
        </script>
    </head>
    <body>
        <div class="center-block">
            <header>
                @inject('ShopTenant', 'App\Models\ShopTenant')
                <ul id="tabs" class="nav nav-tabs">
                @foreach ( $contents as $content_type => $content_list )
                    <li><a href="#{{ $content_type }}" data-toggle="tab">{{ $ShopTenant::toTenantTypeLabel($content_type) }}</a></li>
                @endforeach
                </ul>
            </header>
            <div id="myTabContent" class="tab-content col-sm-6 col-md-6">
            @foreach ( $contents as $content_type => $content_list )
                <div class="tab-pane fade in" id="{{ $content_type }}">
                    <h2>{{ $ShopTenant::toTenantTypeLabel($content_type) }}</h2>
                    <form enctype="multipart/form-data" action="{{ route('shop.post') }}" method="POST">
                        {!! csrf_field() !!}
                        <input name="tenant_type" type="hidden" value="{{ $content_type }}">
                        <div class="form-group">
                            <label for="content_url">リンクURL</label>
                            <input type="text" name="content_url">
                        </div>
                        <div class="form-group">
                            <label for="content_text" rows="5">テキスト</label>
                            <textarea name="content_text"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image_file">画像</label>
                            <input type="file" name="image_file">
                        </div>
                        <input class="btn btn-primary btn-md" type="submit" value="追加する">
                    </form>
                    <div></div>
                    @foreach($content_list as $content)
                    <div class="">
                        <a href="{{ $content['resources']['text1']->content_url }}">{{ $content['resources']['text1']->content_text }}
                        @if ( array_key_exists('image1', $content['resources']))
                            <br><img height="100" src="{{ Storage::url('public/upload_images/'.$content['resources']['image1']->content_image_filename) }}">
                        @endif</a>
                        <div>
                            <form action="{{ route('shop.delete') }}" method="POST">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="DELETE">
                                <input name="content_uuid" type="hidden" value="{{ $content['content']->content_uuid }}">
                                <input class="btn btn-danger" type="submit" value="削除"> 
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endforeach
            </div>
        </div>
    </body>
</html>
