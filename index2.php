<?php 

global $wpdb, $slick_builder;
$slick_builder = $wpdb->prefix . "slick_builder";

$qry = $wpdb->get_results( "SELECT * FROM $slick_builder WHERE id = '1'" );
foreach ($qry as $row) {
	$build = stripcslashes($row->build);
	$options = stripcslashes($row->options);
	$con = stripcslashes($row->con);
	$rec = stripcslashes($row->recipients);
}
$conf = json_decode($con);



/////////////////// CSS //////////////////////

// BootStrap CSS
wp_enqueue_style( 'slick_bs', plugins_url( 'bootstrap/css/bootstrap.min.css', __FILE__ ));


// Form Builder CSS
wp_enqueue_style( 'slick_main_css', plugins_url( 'css/slick_style.css', __FILE__ ));


/////////////////// JavaScripts //////////////////////


// Load Angular JS
wp_deregister_script('slick-angular');
wp_register_script( 'slick-angular', plugins_url( 'js/angular.min.js', __FILE__ ));
wp_enqueue_script('slick-angular');

wp_register_script( 'slick-angular-2', plugins_url( 'js/angular-sanitize.min.js', __FILE__ ));
wp_enqueue_script('slick-angular-2');


// Main Form Builder JS
wp_enqueue_script( 'json.jquery', plugins_url( 'js/jquery.json.js', __FILE__ ));

$ul = plugins_url();
wp_enqueue_script( 'slick-main', plugins_url( 'js/slick_builder.js', __FILE__ ));
wp_localize_script( 'slick-main', 'J', array( 'B' => $build, 'O' => $options, 'C' => $con, 'R' => $rec, 'I' => $ul, 'ide' => $id  ) );

// BootStrap JS
wp_enqueue_script( 'slick-bs', plugins_url( 'bootstrap/js/bootstrap.min.js', __FILE__ ) );

// Forms Main JS
wp_enqueue_script( 'slick-common-js', plugins_url( 'js/slick_common.js', __FILE__ ));
wp_localize_script( 'slick-common-js', 'FormCraftJS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'server' => plugins_url('/slick-contact-form/file-upload/server/php/'), 'locale' => plugins_url('/slick-contact-form/datepicker/js/locales/'), 'other' => plugins_url('/slick') ) );

wp_enqueue_script( 'slick-build-js', plugins_url( 'js/slick_builder.js', __FILE__ ));
wp_localize_script( 'slick-build-js', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

?>
<!--[if IE]>
<style>
.main_builder textarea, .main_builder input[type="text"], .main_builder input[type="password"], .main_builder input[type="date"], .main_builder input[type="month"], .main_builder input[type="week"], .main_builder input[type="number"], .main_builder input[type="email"], .main_builder input[type="url"], .main_builder input[type="search"], .main_builder input[type="tel"], .main_builder .uneditable-input
{
	min-height: 28px !important;
}
</style>
<![endif]-->

<div ng-app="compile" ng-controller="bob_the_builder" class="ffcover bootstrap">


	<div class='ff_c_t'>

		<div class="preview_form" style="height: 420px; display: inline-block; width: 360px">



			<div class='html_here'>
				<?php $form_id = "123$_GET[id]"; ?>




				<form class="nform bootstrap a_1231992 placeholder" action="javascript:submit_slick(1231992);" id="1231992" style="width: 350px; background-image: url(<?php echo plugins_url( 'jean.png', __FILE__ ); ?>);">

					<input type="hidden" class="form_id ng-pristine ng-valid" val="108" ng-model="con[0].form_main_id">

					<div id="fe_title" class="nform_li form_title none" style="font-size: 34px; color: rgb(68, 136, 238);  font-weight: normal; background-image: url(<?php echo plugins_url( 'jean.png', __FILE__ ); ?>); text-align: left; border-bottom: 1px solid #e8e8e8">{{con[0].head_label}}</div>

					<ul class="form_ul clearfix" id="form_ul">

						<li class="nform_li" ng-show='con[0].name_show'>

							<input type="text" place="{{con[0].name_label}}" name="Name_text__{{con[0].name_req}}_0_300_field0_" class="hasPlaceholder" style="width: 100%; font-size: 15px;">
							<span class='valid_show field0'>
							</span>

						</li>

						<li class="nform_li" ng-show='con[0].email_show'>

							<input type="text" ng-style="{fontSize: con[0].field_font, color: con[0].input_color}" place="{{con[0].email_label}}" style="width: 100%; font-size: 15px;" name="Email_email_email_{{con[0].email_req}}___field1____" class="hasPlaceholder">
							<span class='valid_show field1'>
							</span>

						</li>

						<li class="nform_li" ng-show='con[0].comments_show'>

							<textarea rows="3"  place="{{con[0].comments_label}}" name="Comments_para__{{con[0].comments_req}}_0_300_field2_" class="hasPlaceholder" style="width: 100%; font-size: 15px;"></textarea>
							<span class='valid_show field2'>
							</span>

						</li>


						<li class="nform_li image_captcha">

							<img title="{{con[0].captcha_refresh}}" class="slick_image" style="display: inline; height: 37px;" width="145px" height="41px" src="<?php echo plugins_url( 'php/image.php', __FILE__ ); ?>">

							<input type="text" style="width: 145px; margin-left: 19px; display: inline; font-size: 15px;" name="Captcha_captcha_captcha_1___field4" ng-style="{fontSize: con[0].field_font, color: con[0].input_color}" place="{{con[0].captcha_label}}" class="hasPlaceholder">

							<span class="field4 valid_show"></span>

						</li>

						<li id="fe_3_1231992" class="nform_li">

							<button type="submit" class="submit_button nform_btn boots" style="background-color: rgb(68, 136, 238); font-size: 17px; height: 42px; width: 100%; border-top-left-radius: 4px; border-top-right-radius: 4px; border-bottom-right-radius: 4px; border-bottom-left-radius: 4px; font-family: 'Trebuchet MS'; font-weight: normal; color: rgb(255, 255, 255);">{{con[0].submit_label}}</button>

						</li>
					</ul>
					<img src="<?php echo plugins_url( 'tick.png', __FILE__ ); ?>" alt='success' style='width: 60px; display: none; margin: 0px auto 10px auto' class='tick_image'>

					<div id="fe_submit" class="form_submit" style="position: relative; display: block">
						<span style="text-align: center; display: inline;">
							<a class="ref_link" target="_blank" title="Opens in a new tab" href="http://ncrafts.net/formcraft" style='line-height: 28px'>{{con[0].link}}</a>
						</span>
						<div class="response_slick">
						</div>
					</div>
				</form>


			</div>

			<div style='display: block; text-align: center; width: 350px; margin: 20px auto; font-size: 15px'>
				<div style='border-bottom: 1px solid #ddd; color: #aaa; font-size: 13px; margin-bottom: 4px'>shortcode</div>

				<span id='shortcode_click' onClick="selectText('shortcode_click');">[slick_form][/slick_form]</span>

			</div>

		</div>

		<div class='right_cover'>

			<div class='main_builder'>

				<ul class="nav nav-tabs">
					<li class='active'><a href="#name_tab" data-toggle="tab">Name</a></li>
					<li><a href="#email_tab" data-toggle="tab">Email</a></li>
					<li><a href="#comments_tab" data-toggle="tab">Comments</a></li>
					<li><a href="#captcha_tab" data-toggle="tab">Captcha</a></li>
					<li><a href="#not_tab" data-toggle="tab">Notifications</a></li>
					<li><a href="#other_tab" data-toggle="tab">Other</a></li>
				</ul>

				<div class="tab-content" style="width: 478px">
					<div class="tab-pane active" id="name_tab">

						<div class='builder_label_row'>
							<span class='builder_label'>
								Show Field:
							</span>
							<label>
								<input type='checkbox' ng-model='con[0].name_show'>
								Yes, show
							</label>
						</div>

						<div class='builder_label_row'>
							<span class='builder_label'>
								Required?:
							</span>
							<label>
								<input type='checkbox' ng-model='con[0].name_req' ng-true-value='1' ng-false-value='0'>
								Compulsory field
							</label>
						</div>

						<div class='builder_label_row'>
							<span class='builder_label'>
								Label:
							</span>
							<input type='text' ng-model='con[0].name_label' class='update_place'>
						</div>


					</div>
					<div class="tab-pane" id="email_tab">



						<div class='builder_label_row'>
							<span class='builder_label'>
								Show Field:
							</span>
							<label>
								<input type='checkbox' ng-model='con[0].email_show'>
								Yes, show
							</label>
						</div>

						<div class='builder_label_row'>
							<span class='builder_label'>
								Required?:
							</span>
							<label>
								<input type='checkbox' ng-model='con[0].email_req' ng-true-value='1' ng-false-value='0'>
								Compulsory field
							</label>
						</div>

						<div class='builder_label_row'>
							<span class='builder_label'>
								Label:
							</span>
							<input type='text' ng-model='con[0].email_label' class='update_place'>
						</div>


					</div>
					<div class="tab-pane" id="comments_tab">


						<div class='builder_label_row'>
							<span class='builder_label'>
								Show Field:
							</span>
							<label>
								<input type='checkbox' ng-model='con[0].comments_show'>
								Yes, show
							</label>
						</div>

						<div class='builder_label_row'>
							<span class='builder_label'>
								Required?:
							</span>
							<label>
								<input type='checkbox' ng-model='con[0].comments_req' ng-true-value='1' ng-false-value='0'>
								Compulsory field
							</label>
						</div>

						<div class='builder_label_row'>
							<span class='builder_label'>
								Label:
							</span>
							<input type='text' ng-model='con[0].comments_label' class='update_place'>
						</div>


					</div>
					<div class="tab-pane" id="captcha_tab">
						
						
						<div class='builder_label_row'>
							<span class='builder_label'>
								Label:
							</span>
							<input type='text' ng-model='con[0].captcha_label' class='update_place'>
						</div>

						<div class='builder_label_row'>
							<span class='builder_label'>
								Image Title:
							</span>
							<input type='text' ng-model='con[0].captcha_refresh' class='update_place'>
						</div>


					</div>
					<div class="tab-pane" id="not_tab">

						<label><input type='radio' name='type_notification' ng-model='con[0].email_type' value='php' selected>
							<h5 style='display: inline'>PHP Mail Function (default)</h5>
						</label>

						
						<div class='builder_label_row'>
							<span class='builder_label'>
								Sender Name:
							</span>
							<input type='text' ng-model='con[0].php_name' class='update_place'>
						</div>
						<div class='builder_label_row'>
							<span class='builder_label'>
								Sender Email:
							</span>
							<input type='text' ng-model='con[0].php_email' class='update_place'>
						</div>



						<label><input type='radio' name='type_notification' ng-model='con[0].email_type' value='smtp'>
							<h5 style='display: inline'>SMTP Authentication</h5>
						</label>

						
						<div class='builder_label_row'>
							<span class='builder_label'>
								Sender Name:
							</span>
							<input type='text' ng-model='con[0].smtp_name' class='update_place'>
						</div>
						<div class='builder_label_row'>
							<span class='builder_label'>
								Sender Username:
							</span>
							<input type='text' ng-model='con[0].smtp_user' class='update_place'>
						</div>	
						<div class='builder_label_row'>
							<span class='builder_label'>
								Sender Email:
							</span>
							<input type='text' ng-model='con[0].smtp_email' class='update_place'>
						</div>
						<div class='builder_label_row'>
							<span class='builder_label'>
								Password:
							</span>
							<input type='password' ng-model='con[0].smtp_pass' class='update_place'>
						</div>						
						<div class='builder_label_row'>
							<span class='builder_label'>
								Host:
							</span>
							<input type='text' ng-model='con[0].smtp_host' class='update_place'>
						</div>	
						<div class='builder_label_row'>
							<span class='builder_label'>
								SSL:
							</span>
							<label>
								<input type='checkbox' ng-model='con[0].smtp_ssl' class='update_place' ng-true-value='ssl' ng-false-value='0'>
							</label>
						</div>

						<h5>Email Recipients</h5>
						<ol style='font-size: 13px'>
							<li ng-repeat='recipient in con[0].rec' class'anima'>
								<span style='display: inline-block; width: 260px'>
									{{recipient.val}}
								</span>
								<span ng-click='del($index)' style='margin-left: 10px; color: red' class='recipients_btn'>delete</span>
							</li>
						</ol>
						<form>
							<input type='email' ng-model='con[0].add_rec'>
							<button ng-click='add()' style='margin-left: 10px; line-height: 32px; background: none; border: none; color: green' class='recipients_btn' type='submit'>add</button>
						</form>



					</div>
					<div class="tab-pane" id="other_tab">

						<h5>Support this plugin :)</h5>

						<div class='builder_label_row'>
							<span class='builder_label'>
								Link text:
							</span>
							<input type='text' ng-model='con[0].link' class='update_place' placeholder='Get a contact form like this'>
						</div>


						<h5>Labels</h5>
						

						<div class='builder_label_row'>
							<span class='builder_label'>
								Heading:
							</span>
							<input type='text' ng-model='con[0].head_label' class='update_place'>
						</div>

						<div class='builder_label_row'>
							<span class='builder_label'>
								Submit:
							</span>
							<input type='text' ng-model='con[0].submit_label' class='update_place'>
						</div>

						<h5>Validation Errors</h5>
						

						<div class='builder_label_row'>
							<span class='builder_label'>
								Required:
							</span>
							<input type='text' ng-model='con[0].validation_req' class='update_place'>
						</div>		

						<div class='builder_label_row'>
							<span class='builder_label'>
								Email format:
							</span>
							<input type='text' ng-model='con[0].validation_email' class='update_place'>
						</div>						


						<div class='builder_label_row'>
							<span class='builder_label'>
								Captcha:
							</span>
							<input type='text' ng-model='con[0].validation_cap' class='update_place'>
						</div>

						<h5>Form Submission Messages</h5>				


						<div class='builder_label_row'>
							<span class='builder_label'>
								Form Submitted:
							</span>
							<input type='text' ng-model='con[0].success' class='update_place'>
						</div>		

						<div class='builder_label_row'>
							<span class='builder_label'>
								Form Failed to Submit:
							</span>
							<input type='text' ng-model='con[0].failure' class='update_place'>
						</div>	

					</div>
				</div>
				<button id='save_form_btn' style='border: 0px; background: white; margin-top: 4px; border-radius: 4px; padding: 6px 18px; font-size: 13px; margin-right: 0px' ng-click='save()'>Save</button>

				<button id='test_email' style='border: 0px; background: white; margin-top: 4px; border-radius: 4px; padding: 6px 18px; font-size: 13px; margin-right: 0px' onclick='javascript:test_email()'>Send Test Email(s)</button>

				<span id='test_response'></span>


			</div>
			<div class='go_pro bootstrap' style='background-image: url(<?php echo plugins_url( 'jean.png', __FILE__ ); ?>);'>

				<div style='border-bottom: 1px solid #ccc; text-align: center; padding-bottom: 4px'>

					<span style='font-size: 18px; color: #999;'>get</span>
					<span style='font-size: 30px; color: #4488ee;'>FormCraft<span style='color: #999; font-size: 18px'> (an awesome WordPress form builder)</span></span>
				</div>

				<ol>
					<li class='drag_li'>Single page <a id='pop1' class='blue_li pop' data-toggle="popover" data-placement="top" data-content="<img src='<?php echo plugins_url( 'images/drag.png', __FILE__ ); ?>' class='drag_img'>" data-html="true">Drag and drop</a> form builder</li>

					<li>Over <a id='pop2' class='blue_li'>22+ fields</a> to choose from</li>

					<li class='unique_li'>Including unique fields like <a id='pop3' class='blue_li pop' data-toggle="popover" data-placement="top" data-content="<img src='<?php echo plugins_url( 'images/emoticon.png', __FILE__ ); ?>'>" data-html="true">emoticon rating, star rating, thumb rating, sliders</a> (with retina images)</li>

					<li><a id='pop4' class='blue_li pop' data-toggle="popover" data-placement="top" data-content="<img src='<?php echo plugins_url( 'images/mobile.png', __FILE__ ); ?>'>" data-html="true">Responsive forms!</a></li>

					<li class='cl_li'>Seamless <a id='pop5' class='blue_li pop' data-toggle="popover" data-placement="top" data-content="<img src='<?php echo plugins_url( 'images/conditional.png', __FILE__ ); ?>'>" data-html="true">conditional logic</a></li>

					<li class='save_li'><a id='pop6' class='blue_li pop' data-toggle="popover" data-placement="top" data-content="When this option is enabled, the data filled in by users is periodically saved. This allows the users to come back later to finish the form." data-html="true">Saving form progress</a></li>

					<li class='multi_li'>Create <a id='pop7' class='blue_li pop' data-toggle="popover" data-placement="top" data-content="<img src='<?php echo plugins_url( 'images/multi.png', __FILE__ ); ?>'>" data-html="true">multi-column layouts</a></li>

					<li class='news_li'>Integrations with <a id='pop8' class='blue_li pop' data-toggle="popover" data-placement="top" data-content="<span class='create'>create amazing newsletter forms</span><img src='<?php echo plugins_url( 'images/newsletter.png', __FILE__ ); ?>'>" data-html="true">MailChimp, Aweber, and Campaign Monitor</a> to add to your list of subscribers using FormCraft</li>

					<li class='guide_li'>Comprehensive <a id='pop9' class='blue_li pop' data-toggle="popover" data-placement="top" data-content="<img src='<?php echo plugins_url( 'images/getting.png', __FILE__ ); ?>'>" data-html="true">online guide</a></li>

					<li class='file_li'><a id='pop10' class='blue_li pop' data-toggle="popover" data-placement="top" data-content="<img src='<?php echo plugins_url( 'images/upload.png', __FILE__ ); ?>'>" data-html="true">Multiple file-upload field</a></li>

					<li>Send <a id='pop11' class='blue_li' data-html="true">auto-responders</a></li>

				</ol>
				<div style='text-align: center'>

					<a class='f_craft' href='http://ncrafts.net/formcraft/formcraft-wordpress-form-builder-preview/' target='_blank' style='color: #4488ee; border-color: #4488ee'><strong style='font-size: 18px'>try</strong> FormCraft
						<br><span style='font-size: 11px'>(opens in a new window)</span></a>

						<a class='f_craft' href='http://codecanyon.net/item/formcraft-premium-wordpress-form-builder/5335056?ref=ncrafts' target='_blank' style='color: #26B120; border-color: #26B120'><strong style='font-size: 18px'>get</strong> FormCraft
							<br><span style='font-size: 11px'>(opens in a new window)</span></a>
						</div>


					</div>
				</div>
			</div>
		</div><!-- End of Cover -->
		<script>


			function selectText(element) {

				var doc = document
				, text = doc.getElementById(element)
				, range, selection
				;    
    if (doc.body.createTextRange) { //ms
    	range = doc.body.createTextRange();
    	range.moveToElementText(text);
    	range.select();
    } else if (window.getSelection) { //all others
    	selection = window.getSelection();        
    	range = doc.createRange();
    	range.selectNodeContents(text);
    	selection.removeAllRanges();
    	selection.addRange(range);
    }
}

jQuery(document).ready(function(){


	jQuery('.pop').mouseenter(function(){
		jQuery(this).popover('show');
	});
	jQuery('.pop').mouseleave(function(){
		jQuery(this).popover('hide');
	});

});
</script>
