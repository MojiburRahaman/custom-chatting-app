<script>
  // pusher config
  const access_token = $('meta[name="csrf-token"]').attr("content");
        var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
  cluster: 'ap2',
		encrypted: true,
    auth: {
 
 headers: {

     'X-CSRF-Token': access_token

 }

}
	  });

      Pusher.logToConsole = true;

      var channel = pusher.subscribe('message');
      
            channel.bind('pusher:subscription_succeeded', function(members) {
        $('#connected').show();
          // alert('Internet Connected');

       });

       channel.bind('pusher:subscription_error', function(data) {
        $('#disconnected').show();

});
	  // Subscribe to the channel we specified in our Laravel Event

const auth_id = '{{ auth()->id() }}';

	  channel.bind('App\\Events\\MessageSentEvent', function(data) {

        if(auth_id == data.data.from_id)
        {

            let date = moment(data.data.created_at);
            $('#append_message').append('<div class="message-feed right"><div class="pull-right"><img src="{{ Avatar::create(auth()->user()->name)->toBase64()  }}" alt="{{ auth()->user()->name }}" class="img-avatar"></div><div class="media-body"><div class="mf-content">'+data.data.body+'</div><small class="mf-date"><i class="fa fa-clock-o"></i>'+date.fromNow()+'</small></div></div>');
           
        }
        if(auth_id != data.data.from_id){
        let date = moment(data.data.created_at);
        
            $('#append_message').append('<div class="message-feed media"><div class="pull-left"><img src="{{ Avatar::create(session("e"))->toBase64()  }}" alt="" class="img-avatar"></div><div class="media-body"><div class="mf-content">'+data.data.body+'  </div><small class="mf-date"><i class="fa fa-clock-o"></i>  '+date.fromNow()+ '</small></div></div>');
            
        }
        scroll()
      });


    //   user activity show
      var channel = pusher.subscribe('user-activiy');

      channel.bind('App\\Events\\UserActivity', function(data) {
        $('#status'+data.user.id).removeClass('offline');
        $('#status'+data.user.id).addClass('online');
        $('#last_seen'+data.user.id).html('<span  class="status online"><i class="fa fa-circle pr-2"></i></span>Active Now');
         });

</script>