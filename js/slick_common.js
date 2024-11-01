jQuery(document).ready(function () {

  jQuery('#form_ul').css({
    'height':'auto',
    'opacity': 1
  });

  // Remove Top Border from Forms with No Title
  jQuery('.form_title').each(function(){
    if (!jQuery(this).text())
    {
      jQuery(this).parent('form').find('.form_ul').css({
        'borderTop':'0'
      });
    }
  })

  jQuery('.reason_text').text('');
  jQuery('.reason_cover').css({'display':'none'});

  jQuery('#form_ul').show();
  jQuery('.nform_res').hide();

  jQuery('.click').removeClass('click');

});


function placeholders()
{

  jQuery('.hasPlaceholder').each(function(){

    if ( jQuery(this).val() == '' )
    {
      jQuery(this).val(jQuery(this).attr('place'));

    }
  });

    // Add PlaceHolders
    var active = document.activeElement;
    jQuery('.placeholder :text, .placeholder textarea, .placeholder [type="email"]').focus(function () {
      if (jQuery(this).attr('place') != '' && jQuery(this).val() == jQuery(this).attr('place')) {
        jQuery(this).val('').removeClass('hasPlaceholder');
      }
    }).blur(function () {
      if (jQuery(this).attr('place') != '' && (jQuery(this).val() == '' || jQuery(this).val() == jQuery(this).attr('place'))) {
        jQuery(this).val(jQuery(this).attr('place')).addClass('hasPlaceholder');
      }
    });


    jQuery('.placeholder :text, .placeholder textarea, .placeholder [type="email"]').blur();
    jQuery(active).focus();

    jQuery('form').submit(function () {
      jQuery(this).find('.hasPlaceholder').each(function() {
        if ( jQuery(this).val() == jQuery(this).attr('place') )
        {
          jQuery(this).val('');
        }
      });
    });


    // Remove PlaceHolders
    var active = document.activeElement;
    jQuery('.no_placeholder :text, .no_placeholder textarea, .no_placeholder [type="email"]').each(function () {

      if (jQuery(this).val()==jQuery(this).attr('place'))
      {
        jQuery(this).val('').removeClass('hasPlaceholder');
      }

    });
  }




// Submit the Form
function submit_slick(id)
{

  jQuery('#'+id+' .nform_res').slideUp(200);

  // animate Submit Button
  var sub = jQuery('#'+id+'.nform .submit_button').text();
  jQuery('#'+id+'.nform .submit_button').html('');
  jQuery('#'+id+'.nform .submit_button').prop("disabled",true);


  var pd = jQuery('#'+id+'.nform .submit_button').css('height');

  jQuery('#'+id+'.nform .submit_button').addClass('loading_class');

  jQuery('.response_slick').text('');

  var fid = jQuery('#'+id+' .form_id').attr('val');
  var title = jQuery('#'+id+' .form_title').html();
  jQuery.ajax({
    dataType: 'json',
    type: "POST",
    url: FormCraftJS.ajaxurl,
    data: 'id='+fid+'&action=slick_cf_submit&'+jQuery('#'+id+' :input').not('.no_show').serialize()+'&title='+title,
    success: function (response) {
      jQuery('#'+id+'.nform .submit_button').prop("disabled",false);

      jQuery('#'+id+'.nform .submit_button').text(sub);
      jQuery('#'+id+'.nform .submit_button').removeClass('loading_class');

      jQuery('#'+id+' .valid_show').css('display','none');

      if (response!=null)
      {

        if (response.sent=='false')
        {
          placeholders();
          jQuery('.response_slick').text(response.msg);
        }
        else if (response.sent=='true') // Successfulf Submit
        {
          jQuery('#'+id+' .form_submit').slideUp();
          jQuery('#'+id+'.nform .submit_button').prop("disabled",true);

          var temp = '<div class="nform_res nform_success" style="display: none">'+response.msg+'</div>';
          jQuery(temp).insertAfter('#'+id+' .form_ul');
          jQuery('.nform_res').prepend(jQuery('.tick_image'));
          jQuery('.tick_image').css('display','block');
          jQuery('.nform_res').css('display','block');

          jQuery('#'+id+' .form_title').css({
            'borderBottom':'1px solid #ddd'
          });


          jQuery('#'+id+' .form_ul').animate({ 
            height: '0', 
            paddingTop: '0', 
            paddingBottom: '0', 
            opacity: '0'
          }, 300, function(){
            jQuery('#'+id+' .form_ul').css('display','none');
          });

          jQuery('#'+id+' .form_title').animate({ 
            height: '0', 
            paddingTop: '0', 
            paddingBottom: '0', 
            opacity: '0'
          }, 300);

          if (response.errors!='none')
          {
            jQuery('#'+id+' .nform_res').slideDown(200);
          }
          jQuery('#'+id+' .nform_res').animate({
            'paddingTop': '40px',
            'paddingBottom': '40px'
          }, 200, function(){

            jQuery('#'+id+' .nform_res').animate({
              'paddingTop': '50px',
              'paddingBottom': '50px'
            }, 280);

          });

          jQuery('#'+id+' .nform_res').removeClass('alert alert-success alert-error');

          setTimeout(function () {
            jQuery('.sticky_on').trigger('click');
          }, 1000);

          setTimeout(function () {
            jQuery('.modal_close').trigger('click');
          }, 1000);


          if (response.redirect && !(jQuery('.ff_c_t').length))
          {
           window.location.href=response.redirect;
         }

       }
       else if (response.errors)
       {
        placeholders();
        for (var key in response)
        {
          if (response.hasOwnProperty(key)) 
          {

            if (jQuery(window).width() < 740) 
            {
              var temp = response[key];
              jQuery('#'+id+' .'+key).html(""+temp);

              jQuery('#'+id+' .valid_show.'+key).css({
                'display': 'block'
              });
              jQuery('#'+id+' .valid_show.'+key).slideDown();
            } 
            else 
            {

              var temp = response[key];
              jQuery('#'+id+' .'+key).html(""+temp);

              jQuery('#'+id+' .valid_show.'+key).css('margin-left','100px');
              jQuery('#'+id+' .valid_show.'+key).css('display','inline');
              jQuery('#'+id+' .valid_show.'+key).css('opacity','0');

              var temp = response[key];

              jQuery('#'+id+' .'+key).animate(
              {
                marginLeft:'-5px',
                opacity: .85
              }, 300);

            }


          }   
        }

        jQuery('#'+id+'.nform .submit_button').text(sub);


      }
      else // Do if response.sent and .errors are not true
      {
        jQuery('#'+id+'.nform .submit_button').text(sub);
        jQuery('#'+id+' .nform_res').html('');

        placeholders();
      }


    }
    else // Do if Response = null
    {
      jQuery('#'+id+'.nform .submit_button').text(sub);
      jQuery('#'+id+' .nform_res').html('');
      jQuery('#'+id+' .nform_res').removeClass('alert alert-success alert-error');
      jQuery('#'+id+' .nform_res').addClass('alert alert-error');
      placeholders();
    }

  }, // Success
  error: function (response) 
  {
    jQuery('#'+id+'.nform .submit_button').prop("disabled",false);
    jQuery('#'+id+'.nform .submit_button').text(sub);
    placeholders();
  }
});

}



jQuery(document).ready(function () {


  jQuery('body').on('keyup', '.update_place', function(){

  jQuery('.hasPlaceholder').each(function(){
      jQuery(this).val(jQuery(this).attr('place'));
  });

  });



    // Initialize PlaceHolders
    placeholders();

    jQuery('.nform.no_submit_hidden .is_hidden').each(function(){
      jQuery(this).find('input').addClass('no_show');
      jQuery(this).find('textarea').addClass('no_show');
    });


  jQuery('.valid_show').css('display','none');
  jQuery('.nform_res').css('display','none');
  jQuery('.response_slick').css('display','none');
  jQuery('.upload_ul').html('');


  // Reset Captcha
  jQuery('body').on('click', '.c_image', function () {
    jQuery(this).attr('src', jQuery(this).attr('src')+'_'+Math.random())
  });


});