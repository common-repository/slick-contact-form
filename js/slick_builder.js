function save_form(build, option, con, rec)
{
  window.saving = true;

  jQuery('#save_form_btn').button('loading');

  var build = jQuery.toJSON(build);
  build = encodeURIComponent(build);

  var option = jQuery.toJSON(option);
  option = encodeURIComponent(option);

  var rec = jQuery.toJSON(rec);
  rec = encodeURIComponent(rec);

  var con = jQuery.toJSON(con);
  con = encodeURIComponent(con);

  var html = encodeURIComponent(jQuery('.html_here').html());
  var id = jQuery('.form_id').attr('val');

  jQuery.ajax({
    url: ajaxurl,
    type: "POST",
    data: 'action=slick_cf_update&content='+html+'&build='+build+'&option='+option+'&con='+con+'&rec='+rec+'&id='+id,
    success: function (response) {
      jQuery('#save_form_btn').button('reset');
      window.saving = false;
    },
    error: function (response) {
      jQuery('#save_form_btn').button('error');
      window.saving = false;
    }
  });

}




function add_sliders(options)
{


  jQuery('.add-on').each(function(){

    var he = jQuery(this).prev('input').outerHeight();
    he = parseInt(he);
    jQuery(this).css({'height':he+'px'});

  });


  jQuery('.slick_image').each(function(){

    var he = jQuery(this).next('input').outerHeight();
    he = parseInt(he);
    jQuery(this).css({'height':he+'px'});

  });


  jQuery('.slider').each(function(){

    var id = this.id.split('_');

    if (!(id[3]))
    {
      id[3] = 0;
    }
    if (!(id[4]))
    {
      id[4] = 100;
    }

    if (options && jQuery("#"+this.id).hasClass('ui-slider'))
    {

      jQuery( "#"+this.id ).slider('option', {
        min: parseInt(id[3]),
        max: parseInt(id[4])
      });
    }
    else 
    {
      jQuery( "#"+this.id ).slider({
        min: parseInt(id[3]),
        max: parseInt(id[4]),
        range: 'min',
        value: 0,
        slide: function( event, ui ) 
        {
          jQuery( "#"+this.id+"_val" ).html( ui.value );
          jQuery( "#"+this.id+"_val2" ).val( ui.value );
        }
      });
    }

  });


  jQuery('.slider-range').each(function(){

    var id = this.id.split('_');

    if (!(id[3]))
    {
      id[3] = 0;
    }
    if (!(id[4]))
    {
      id[4] = 100;
    }

    if (options && jQuery("#"+this.id).hasClass('ui-slider'))
    {

      jQuery( "#"+this.id ).slider('option', {
        min: parseInt(id[3]),
        step: Math.max(parseInt(id[4])/100, 1),
        max: parseInt(id[4])
      });
    }
    else 
    {
      jQuery( "#"+this.id ).slider({
        min: parseInt(id[3]),
        step: Math.max(parseInt(id[4])/100, 1),
        max: parseInt(id[4]),
        range: true,
        values: [0, parseInt(id[4])*.3],
        slide: function( event, ui ) 
        {
          jQuery( "#"+this.id+"_val" ).html( ui.values[0]+' - '+ui.values[1] );
          jQuery( "#"+this.id+"_val2" ).val( ui.values[0]+', '+ui.values[1] );
        }
      });
    }

  });


}



// Trigger a Click on 'SAVE' button
var save_slick_cf = function save_slick_cf()
{
  jQuery('#save_form_btn').trigger('click');
}

// declare a new module, and inject the $compileProvider
angular.module('compile', [], function($compileProvider) {


  // configure new 'compile' directive by passing a directive
  // factory function. The factory function injects the '$compile'
  $compileProvider.directive('compile', function($compile) {
    // directive factory creates a link function
    return function(scope, element, attrs) {
      scope.$watch(
        function(scope) {
           // watch the 'compile' expression for changes
           return scope.$eval(attrs.compile);
         },
         function(value) {
          // when the 'compile' expression changes
          // assign it into the current DOM
          element.html(value);

          // compile the new DOM and link it to the current
          // scope.
          // NOTE: we only compile .childNodes so that
          // we don't get into infinite loop compiling ourselves
          $compile(element.contents())(scope);
        }
        );
    };
  });


});



 // Angular JS Function
 function bob_the_builder($scope, $http)
 {

  $scope.add = function() {
    $scope.con[0].rec.push({'val':$scope.con[0].add_rec});
    $scope.con[0].add_rec = '';
  };

  $scope.del = function($index) {

    $scope.con[0].rec.splice($index,1);

  };
 



  if (!(J.C))
  {
    $scope.con = [];
    $scope.con.push({
      name_label:'Name',
      name_show:true,
      name_req:'1',
      email_label:'Email',
      email_show:true,
      email_req:'1',
      comments_label:'Comments',
      comments_show:true,
      comments_req:'1',
      captcha_label:'Captcha',
      captcha_refresh:'Click to Refresh',
      head_label:'Contact Us',
      rec:[],
      success:'Form Sent',
      failure:'Failed',
      submit_label:'Submit',
      email_type:'php'
    });
    $scope.con[0].rec.push({'val':'example@example.com'});
  }
  else 
  {
    $scope.con = jQuery.evalJSON(J.C);
  }

  $scope.save = function()
  {
    save_form($scope.build, $scope.option, $scope.con, $scope.recipients);
  }



}


function test_email()
{

      jQuery('#test_email').button('loading');
    jQuery('#test_response').text('');

    jQuery.ajax({
      url: ajaxurl,
      type: "POST",
      data: 'action=slick_cf_test',
      success: function (response) {
        jQuery('#test_email').button('reset');
        jQuery('#test_response').text(response);
      },
      error: function (response) {
        jQuery('#test_email').button('error');
      }
    });

}
