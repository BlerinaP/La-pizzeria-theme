$ = jQuery.noConflict();

$(document).ready(function() {

   $('.remove_reservation').on('click',function(e) {
      e.preventDefault();

      var id = $(this).attr('data-reservation');

      $.ajax({
         type: 'post',
         data : {
             'action': 'lapizzeria_delete_reservation',
            'id' : id,
            'type' : 'delete'
         },
            url: admin_ajax.ajaxurl,
            success: function(data){
                console.log(data);
            }
      });
   });
});