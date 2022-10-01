<script>
  // pusher config
        var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
  cluster: 'ap2',
		encrypted: true
	  });

      Pusher.logToConsole = true;

      var channel = pusher.subscribe('message');
      
            channel.bind('pusher:subscription_succeeded', function(members) {

          alert('Internet Connected');

       });


	  // Subscribe to the channel we specified in our Laravel Event


const left_msg = '<div class="left-chat-message fs-13 mb-2"><p class="mb-0 mr-3 pr-4">$message->bodyto </p><div class="message-options mt-3"><div class="message-time"> $message->created_at->diffForHumans() </div><div class="message-arrow"><i class="text-muted la la-angle-down fs-17"></i></div></div></div>';
const right_msg = '<div class="d-flex flex-row-reverse mb-2"><div class="right-chat-message fs-13 mb-2"><div class="mb-0 mr-3 pr-4"><div class="d-flex flex-row"><div class="pr-2">$message->bodyfrom</div><div class="pr-4"></div></div></div><div class="message-options dark mt-3"><div class="message-time"><div class="d-flex flex-row "> <div class="mr-2 ">$message->created_at->diffForHumans()</div><div class="svg15 double-check"></div></div> </div> <div class="message-arrow"><i class="text-muted la la-angle-down fs-17"></i></div> </div> </div></div>';

const auth_id = '{{ auth()->id() }}';

	  channel.bind('App\\Events\\MessageSentEvent', function(data) {
        if(auth_id == data.data.from_id)
        {
            let date = moment(data.data.created_at);
            $('#appen_message').append('<div class="d-flex flex-row-reverse mb-2"><div class="right-chat-message fs-13 mb-2"><div class="mb-0 mr-3 pr-4 mr-5 mb-2"><div class="d-flex flex-row"><div class="pr-2">'+data.data.body+'</div><div class="pr-4"></div></div></div><div class="message-options dark mt-3"><div class="message-time"><div class="d-flex flex-row "> <div class="mr-2 ">'+date.fromNow()+ '</div><div class="svg15 double-check"></div></div> </div> <div class="message-arrow"><i class="text-muted la la-angle-down fs-17"></i></div> </div> </div></div>');

        }
        if(auth_id != data.data.from_id){
        let date = moment(data.data.created_at);
        
            $('#appen_message').append('<div class="left-chat-message fs-13 mb-2"><p class="mb-0 mr-3 pr-4">'+data.data.body+' </p><div class="message-options mt-3"><div class="message-time"> '+date.fromNow()+ ' </div><div class="message-arrow"><i class="text-muted la la-angle-down fs-17"></i></div></div></div>');

        }
        scroll()
      });


    //   user activity show
      var channel = pusher.subscribe('user-activiy');

      channel.bind('App\\Events\\UserActivity', function(data) {

        $('#status'+data.user.id).html('<i class="active_icon fa-sharp fa-solid fa-circle">Online</i>');
        $('#statusmessage'+data.user.id).html('<p class="sub-caption text-muted text-small mb-0"><i class=" fa-sharp fa-solid fa-circle pr-2" style="color: green"></i>Online</p>');
      });


      $(document).on("keyup", "#body", function (e) {   
        });

</script>