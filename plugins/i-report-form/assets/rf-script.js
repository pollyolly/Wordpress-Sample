jQuery(document).ready(function($){
   $('#report-form').on('submit', function(e){
     e.preventDefault();
     var form = $(this);
         form.hide();
     $('.report-loader').show();
     $('.report-response').hide();
      $.ajax({
          type: 'POST',
          url: ajaxUrl.ajax_url,
          data: {
            title: form.find('#title').val(),
            description: form.find('#description').val(),
            action: 'save_report_form'
          },
          success: function(response){
              $('.report-response').show();
              $('.report-loader').hide();
              if(response == ''){
                form.hide();
                $('.report-response').html('<h2> No operation.</h2>'); }
              form.show();
              $('.report-loader').hide();
              $('.report-response').html('</h2>');
              $('#report-form')[0].reset();
              $('.report-response').html('<h2 style="color: #004421"> Successfully reported. </h2>');},
          error: function(response){
              $('#report-form')[0].reset();
              $('.report-response').show();
              $('.report-response').html(response);}});});
   //Modal
    $('.btn-report').on('click', function(){
      $('.report-modal').fadeIn('slow');
      $('#report-form').trigger('reset');
      $('#report-form')[0].reset();
      $('.report-response').html('</h2>');});
    $('.report-modal-header .close').on('click', function(){
      $('.report-modal').css('display', 'none');});
    $('.report-modal').on('click', function(e){
        if($(e.target).closest('.report-modal-content').get(0) == null){
          $('.report-modal').css('display','none');}});
//Modal
});
