@extends('New.new')

@section('content')
<div class="ms-body" id="">
    <div class="action-header clearfix">
        <div class="visible-xs" id="ms-menu-trigger">
            <i class="fa fa-bars"></i>
        </div>

        <div class="pull-left hidden-xs">
            <img src="{{ Avatar::create($user->name)->toBase64()  }}" alt="{{ $user->name }}" class="img-avatar m-r-10">
            <div class="lv-avatar pull-left">

            </div>
            <span>{{ $user->name }}</span>
            <span  class="last_seen_chat" id="last_seen{{ $user->id }}"><i class="fa fa-clock-o"></i> {{ $user->last_seen->diffForHumans() }}</span>
        </div>
    </div>
    <div class="chat-body" id="scroll">
        @forelse ($messages as $message)
        @if ($message->from_id != auth()->id())

        <div class="message-feed media">
            <div class="pull-left">
                <img src="{{ Avatar::create($user->name)->toBase64()  }}" alt="{{ $user->name }}" class="img-avatar">
            </div>
            <div class="media-body">
                <div class="mf-content">
                    {{$message->body}}
                </div>
                <small class="mf-date"><i class="fa fa-clock-o"></i> {{ $message->created_at }}</small>
            </div>
        </div>
        @endif
        @if ($message->from_id == auth()->id())

        <div class="message-feed right">
            <div class="pull-right">
                <img src="{{ Avatar::create(auth()->user()->name)->toBase64()  }}" alt="" class="img-avatar">
            </div>
            <div class="media-body">
                <div class="mf-content">
                    {{$message->body}}
                </div>
                <small class="mf-date"><i class="fa fa-clock-o"></i> {{ $message->created_at }}</small>
            </div>
        </div>
        @endif
        @empty
        <div class="text-center">
            No Conversation Yet
        </div>
        @endforelse
        <div id="append_message">

        </div>
    </div>
    <div class="msb-reply">
        <form action="{{ route('SendMessage') }}" method="POST" id="SendTextForm">
            @csrf
            <input type="hidden" name="to_id" value="{{ $user->id }}">
            <textarea name="body" placeholder="Send Message" id="body"></textarea>
            <button type="submit"><i class="fa fa-paper-plane-o"></i></button>
        </form>
    </div>
</div>

@endsection
@section('script_js')
<script>
    scroll();


// var intervalId = window.setInterval(function(){
// }, 5000);

    $(document).on("submit", "#SendTextForm", function () {
                  event.preventDefault();
                 const form = $(this);

                const actionUrl = '{{ route('SendMessage') }}';
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                {


                $(this).focusout();
                    $('#body').val('');
                    scroll();
                },
                error:function (response) {
                    alert('Server Error');
                    }
                        });
       });
</script>

@endsection