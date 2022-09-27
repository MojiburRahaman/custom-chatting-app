(function($) {
    "use strict";
    $('.scrollable-chat-panel').perfectScrollbar();
    var position = $(".chat-search").last().position().top;
    $('.scrollable-chat-panel').scrollTop(position);
    $('.scrollable-chat-panel').perfectScrollbar('update');
    $('.pagination-scrool').perfectScrollbar();

    // $('.chat-upload-trigger').on('click', function(e) {
    //   $(this).parent().find('.chat-upload').toggleClass("active");
    // });
    // $('.user-detail-trigger').on('click', function(e) {
    //   $(this).closest('.chat').find('.chat-user-detail').toggleClass("active");
    // });
    $('.user-undetail-trigger').on('click', function(e) {
      $(this).closest('.chat').find('.chat-user-detail').toggleClass("active");
    });
  })(jQuery); 


  $(document).on("click", ".chat-upload-trigger", function () {   

    $(this).parent().find('.chat-upload').toggleClass("active");
  });
  $(document).on("click", ".user-detail-trigger", function () {   

    $(this).closest('.chat').find('.chat-user-detail').toggleClass("active");

  });


//   document.querySelector(".chat-item").addEventListener('click',function(){
//     // alert(122);
//     const id = $(this).attr('data-id');
//     alert(id);
// },false)