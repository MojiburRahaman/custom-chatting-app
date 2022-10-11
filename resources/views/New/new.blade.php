<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('Frontend/new/style.css') }}">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <div class="container bootstrap snippets bootdey">
        <div class="tile tile-alt" id="messages-main">
            <div class="ms-menu">
                <div class="ms-user clearfix">
                    <img src="{{ Avatar::create(auth()->user()->name)->toBase64()  }}" alt=""
                        class="img-avatar pull-left">
                    <div>Signed in as <br> {{ auth()->user()->name }}</div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search User" id="search_input">
                </div>

                <div class="list-group lg-alt" id="chat_user">
                    @foreach ($users as $user)
                    <a class="list-group-item media" href="{{ route('ChatFetchUserview',$user->slug) }}">
                        <div class="pull-left">
                            <img src="{{ Avatar::create($user->name)->toBase64()  }}" alt="{{ $user->name }}"
                                class="img-avatar">
                        </div>
                        <div class="media-body">
                            <small class="list-group-item-heading">{{ $user->name }}
                                <span id="status{{ $user->id }}" class="status offline"><i
                                        class="fa fa-circle"></i></span>
                            </small>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="list-group lg-alt" id="searchPage" style="display: none">

                </div>
            </div>
            @yield('content')
            @if (url()->current() == route('Chatview'))
            <div class="ms-body">
                <div class="action-header clearfix">
                    <div class="visible-xs" id="ms-menu-trigger">
                        <i class="fa fa-bars"></i>
                    </div>
                </div>
                <div id="scroll" style="height: 95vh">
                    <div id="connected" style="display: none" class="text-center alert alert-success">Internet Connected
                    </div>
                    <div id="disconnected" style="display: none" class="text-center alert alert-danger">Internet not
                        Connected</div>
                    <h4 class="text-center" style="margin-top:36px ">
                        Please select a chat to start messaging
                    </h4>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.7/js/min/perfect-scrollbar.jquery.min.js">
    </script>

    <script>
        $('#search_input').on('keyup', function(){
            search();
        });

        $('#search_input').on('focus', function(){
            search();
        });
     
        function search(){
            var searchKey = $('#search_input').val();
            if(searchKey.length > 0){
                $('#chat_user').hide();
                $('#searchPage').show();
                $.post('{{ route("ChatSearchUser") }}', { _token: '{{ csrf_token() }}', search:searchKey}, function(data){
                        $('#searchPage').html(data.view);
                });
            }
            else {
                $('#searchPage').hide();
                $('#chat_user').show();
            }
        }

     scroll()
              function scroll(){
           var objDiv = document.getElementById('scroll');
           objDiv.scrollTop = objDiv.scrollHeight
    }
    </script>

    <script type="text/javascript">
        $(function(){
   if ($('#ms-menu-trigger')[0]) {
        $('body').on('click', '#ms-menu-trigger', function() {
            $('.ms-menu').toggleClass('toggled'); 
        });
    }
});

    </script>
    @include('Frontend.Chat.pusher')
    @yield('script_js')

</body>

</html>