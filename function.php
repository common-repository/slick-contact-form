<?php  
    /* 
    Plugin Name: Slick Contact Form
    Description: Quickly add a slick contact form to your site!
    Author: nCrafts
    Author URI: http://ncrafts.net/
    Plugin URI: http://ncrafts.net/formcraft
    Version: 1
    */
    error_reporting(0);


    if (!isset($_SESSION)) {
        session_start();
    }

    global $wpdb, $slick_builder;
    $slick_builder = $wpdb->prefix . "slick_builder";


    add_action('wp_ajax_slick_cf_update', 'slick_cf_update');
    add_action('wp_ajax_nopriv_slick_cf_update', 'slick_cf_update');

    add_action('wp_ajax_slick_cf_submit', 'slick_cf_submit');
    add_action('wp_ajax_nopriv_slick_cf_submit', 'slick_cf_submit');

    add_action('wp_ajax_slick_cf_test', 'slick_cf_test');
    add_action('wp_ajax_nopriv_slick_cf_test', 'slick_cf_test');


    function slick_cf_settings($links) { 
        $settings_link = '<a href="admin.php?page=slick-form">Settings</a>'; 
        array_unshift($links, $settings_link); 
        return $links; 
    }

    $plugin = plugin_basename(__FILE__); 
    add_filter("plugin_action_links_$plugin", 'slick_cf_settings' );

    function slick_cf_test()
    {

        global $wpdb, $slick_builder;
        error_reporting(0);

        $qry = $wpdb->get_results( "SELECT * FROM $slick_builder WHERE id = '1'", 'ARRAY_A' );

        foreach ($qry as $row) {
            $con = stripslashes($row['con']);
        }

        $con = json_decode($con, 1);

        if (sizeof($con[0]['rec'])==0)
        {
            echo "No email recipient added";
            die();
        }

        if ($con[0]['email_type']=='smtp')
        {

            require_once("php/class.phpmailer.php");

            foreach($con[0]['rec'] as $send_to)
            {

                $mail = new PHPMailer();

                $mail->IsSMTP();
                $mail->Host = $con[0]['smtp_host'];

                $mail->CharSet = 'UTF-8';

                $mail->SMTPAuth = true;
                $mail->Username = $con[0]['smtp_user'];
                $mail->Password = $con[0]['smtp_pass'];
                $mail->FromName = $con[0]['smtp_name'];
                $mail->AddAddress($send_to[val]);
                $mail->From = $con[0]['smtp_email'];
                $mail->IsHTML(true);

                if ($con[0]['smtp_ssl']=='ssl')
                {
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                }

                $mail->Subject = 'Test Email from Slick Forms';
                $mail->Body = 'Test Email from Slick Forms';

                if ($mail->Send())
                {
                    $result = 'Email sent to recipient(s)';
                }
                else
                {
                    $result = 'Email not sent to recipient(s)';
                }

            }

            echo $result;

        } // End of SMTP Email
        else
        {


            $headers = "From: ".$con[0]['php_name']." <".$con[0]['php_email'].">\r\n";
            $headers.= "Reply-To: ".$con[0]['php_email']."\r\n";
            $headers.= 'MIME-Version: 1.0' . "\r\n";
            $headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";

            $subject = 'Test Email from Slick Forms';
            $message = 'Test Email from Slick Forms';

            foreach($con[0]['rec'] as $send_to)
            {
              if (mail($send_to[val], $subject, $message, $headers))
              {
                $result = 'Email sent to recipient(s)';
            }
            else
            {
                $result = 'Email not sent to recipient(s)';
            }
        }

        echo $result;
        die();

        } // End of PHP Function Email

        die();
    }



    function slick_cf_submit()
    {
        error_reporting(0);
        global $errors;
        $conten = file_get_contents('php://input');
        $conten = explode('&', $conten);
        $nos = sizeof($conten);

        $i = 0;
        while ($i<$nos)
        {
            $cont = explode('=', $conten["$i"]);
            $content[$cont[0]]=$cont[1];
            $content_ex = explode('_',$cont[0]);
            if ( !($content_ex[0]=='id') && !($content_ex[0]=='action') )
            {
                $new[$i]['label'] = $content_ex[0];
                $new[$i]['value'] = urldecode($cont[1]);
                $new[$i]['type'] = $content_ex[1];
                $new[$i]['validation'] = $content_ex[2];
                $new[$i]['required'] = $content_ex[3];
                $new[$i]['min'] = $content_ex[4];
                $new[$i]['max'] = $content_ex[5];
                $new[$i]['tooltip'] = $content_ex[6];
                $new[$i]['custom'] = $content_ex[7];
                $new[$i]['custom2'] = $content_ex[8];
                $new[$i]['custom3'] = $content_ex[9];
                $new[$i]['custom4'] = $content_ex[10];
            }
            $i++;
        }

    // Get Form Options
        global $wpdb, $slick_builder;

        $qry = $wpdb->get_results( "SELECT * FROM $slick_builder WHERE id = '1'", 'ARRAY_A' );
        foreach ($qry as $row) {
            $con = stripslashes($row['con']);
        }

        $con = json_decode($con, 1);


    // Run the Validation Functions
        $i = 0;

        $ar_inc = 1;
        while ($i<$nos)
        {

            slick_cf_no_val($new[$i]['value'], $new[$i]['required'], $new[$i]['min'], $new[$i]['max'], $new[$i]['tooltip'], $con[0]);


            if (function_exists('slick_cf_'.$new[$i]['validation']))
            {
                $fncall = 'slick_cf_'.$new[$i]['validation'];
                $fncall($new[$i]['value'], $new[$i]['validation'], $new[$i]['required'], $new[$i]['min'], $new[$i]['max'], $new[$i]['tooltip'], $con[0]);
            }

            $i++;
        }


        if( sizeof($errors) )
        {
            if ($con[0]['error_gen']!=null)
            {
                $errors['errors'] = $con[0]['error_gen'];
            }
            else
            {
                $errors['errors'] = 'none';
            }
            $errors = json_encode($errors);
            echo $errors;
        }
        else
        {   

            global $wpdb, $slick_builder;

            $qry = $wpdb->get_results( "SELECT * FROM $slick_builder WHERE id = '1'", 'ARRAY_A' );
            foreach ($qry as $row) {
                $con = stripslashes($row['con']);
            }
            $con = json_decode($con, 1);






    // Make the Email
            $label_style = "padding: 4px 8px 4px 0px; margin: 0; width: 180px; font-size: 13px; font-weight: bold";
            $value_style = "padding: 4px 8px 4px 0px; margin: 0; font-size: 13px";

            $i=0;
            $att=1;

            $email_body = '';

            while ($i<$nos)
            {


                if ( !(empty($new[$i]['type'])) && !($new[$i]['type']=='captcha') && !($new[$i]['type']=='hidden') && !($new[$i]['label']=='files') && !($new[$i]['label']=='divider') && !($new[$i]['type']=='radio') && !($new[$i]['type']=='check')  && !($new[$i]['type']=='smiley') && !($new[$i]['type']=='stars') && !($new[$i]['type']=='matrix') )
                {
                    $email_body .= "<tr><td style='$label_style'> ".$new[$i]['label']."</td><td style='$value_style'>".$new[$i]['value']."</td></tr>";
                }

                $i++;
            }

            $email_body = "<table style='border: 0px; color: #333; width: 100%'>".$email_body."</table>";



            if ($con[0]['email_type']=='smtp')
            {


                require_once("php/class.phpmailer.php");
                error_reporting(0);


                foreach($con[0]['rec'] as $send_to)
                {

                    $to = $send_to['val'];

                    $mail = new PHPMailer();

                    $mail->IsSMTP();
                    $mail->Host = $con[0]['smtp_host'];
                    $mail->CharSet = 'UTF-8';
                    $mail->SMTPAuth = true;
                    $mail->Username = $con[0]['smtp_user'];
                    $mail->SetFrom($con[0]['smtp_email'], $con[0]['smtp_name']);

                    $mail->Password = $con[0]['smtp_pass'];
                    $mail->FromName = $con[0]['smtp_name'];
                    $mail->AddAddress($to);
                    if ($con[0]['smtp_ssl']=='ssl')
                    {
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;
                    }

                    $mail->AddReplyTo($con[0]['smtp_email']);

                    $mail->From = $con[0]['smtp_email'];

                    $mail->IsHTML(true);


                    $subject = "New Contact Form Submission";

                    $mail->Subject = $subject;
                    $mail->Body = $email_body;

                    if($mail->Send())
                    {
                        $success_sent++;     
                    }

                }

        } // End if mail_type = smtp
        else
        {

            $headers = "From: ".$con[0]['php_name']." <".$con[0]['php_email'].">\r\n";
            $headers.= "Reply-To: ".$con[0]['php_email']."\r\n";
            $headers.= 'MIME-Version: 1.0' . "\r\n";
            $headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";

            $subject = "New Contact Form Submission";

            foreach($con[0]['rec'] as $send_to)
            {
               $to = $send_to['val'];
               if (mail($to,$subject,$email_body,$headers))
               {
                $success_sent++;
            }
        }

        } // End of IF not-SMTP

        $new_json = json_encode($new);

    // Display Success Message if Form Submission Updated in DataBase
        if($success_sent)
        {
            $error['sent']="true";
            $error['msg']="Message Sent";

            if (isset($con[0]['success']))
            {
                $error['msg']=$con[0]['success'];
            }

            echo json_encode($error);
        }
        else
        {
            $error['sent']="false";  
            $error['msg']="The message could not be sent";

            if (isset($con[0]['failure']))
            {
                $error['msg']=$con[0]['failure'];
            }

            echo json_encode($error);
        }

    }
    die();
}

function slick_cf_email($value, $valid, $req, $min, $max, $tool, $con)
{
    error_reporting(0);
    global $errors;
    $a=0;

    if ( (!(empty($value))) && !(filter_var($value, FILTER_VALIDATE_EMAIL)) )
    {
        if (isset($con['validation_email']))
        {
            $errors[$tool][$a] = $con['validation_email'];
        }
        else
        {
            $errors[$tool][$a] = 'Incorrect email format.';
        }
        $a++;
    }

}


function slick_cf_captcha($value, $valid, $req, $min, $max, $tool, $con)
{
    global $errors;
    global $id;
    $a=0;


    if ( !($_SESSION["slick_security"]==$value) )
    {

        if (isset($con["validation_cap"]))
        {
            $errors[$tool][$a] = $con["validation_cap"];
        }
        else
        {
            $errors[$tool][$a] = "Incorrect captcha";
        }
        $a++;
    }


}


function slick_cf_no_val($value, $req, $min, $max, $tool, $con)
{
    global $errors;
    $a=0;

    if ( ( $req==1 || $req=='true' ) && empty($value) && $value!='0' )
    {
        if (isset($con['validation_req']))
        {
            $errors[$tool][$a] = $con['validation_req'];
        }
        else
        {
            $errors[$tool][$a] = 'This field is required';
        }
        $a++;
    }

}




function slick_cf_update() {

    global $wpdb, $table_subs, $slick_builder, $restricted;

    $id = '1';
    $html = mysql_real_escape_string($_POST['content']);
    $con = mysql_real_escape_string($_POST['con']);

    echo 'ass';

    $wpdb->query( "UPDATE $slick_builder SET
      con = '$con',
      html = '$html'
      WHERE id = '$id'" );
    $wpdb->show_errors();

    die();
}



function slick_cf_activate()
{

    error_reporting(0);
    global $wpdb, $slick_builder;


    $sql = "CREATE TABLE $slick_builder (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      html MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      build MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      options MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      con MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      UNIQUE KEY id (id)
      ) CHARACTER SET utf8 COLLATE utf8_general_ci";

$temp2 = $wpdb->insert( $slick_builder, array( 'id' => '1' ) );

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

}


register_activation_hook( __FILE__, 'slick_cf_activate' );



function slick_cf_register_scripts () {


    // BootStrap CSS
    wp_enqueue_style( 'slick-boot', plugins_url( 'css/bootstrap.css', __FILE__ ));

    // Main Form CSS
    wp_enqueue_style( 'slick-main-css', plugins_url( 'css/slick_style.css', __FILE__ ));


    // jQuery
    wp_enqueue_script('jquery');
    
    // Basic JS to handle forms
    wp_enqueue_script( 'slick-main-js', plugins_url( 'js/slick_common.js', __FILE__ ));

    wp_localize_script( 'slick-main-js', 'FormCraftJS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'server' => plugins_url('/slick-contact-form/file-upload/server/php/'), 'locale' => plugins_url('/slick-contact-form/datepicker/js/locales/'), 'other' => plugins_url('/slick-contact-form') ) );

    wp_enqueue_script( 'slick-main-js-2', plugins_url( 'js/slick_form.js', __FILE__ ));

    // BootStrap
    wp_enqueue_script( 'bootjs', plugins_url( 'bootstrap/js/bootstrap.min.js', __FILE__ ));
}


add_shortcode( 'slick_form', 'slick_cf_shortcode' );

function slick_cf_shortcode( $atts, $content = null ){

    slick_cf_register_scripts();

    define('SLICK', true);

    extract( shortcode_atts( array(
        'id' => '1'
        ), $atts ) );


    global $wpdb, $slick_builder;
    
    $myrows = $wpdb->get_results( "SELECT * FROM $slick_builder WHERE id=$id" );


    foreach ($myrows as $row) 
    {
        return stripslashes($row->html);
    }


}

add_action( 'wp_enqueue_scripts', 'slick_cf_register_scripts' );


add_action( 'admin_menu', 'slick_cf_menu' );

function slick_cf_menu() {
    if ( $_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'ncrafts.net'  )
    {
        add_menu_page( 'Slick Contact Form', 'Slick Form', 'read', 'slick-form', 'slick_cf_options', plugins_url('slick-contact-form/images/slick_icon.png' ),'31.28' );
    }
    else
    {
        add_menu_page( 'Slick Contact Form', 'Slick Form', 'remove_user', 'slick-form', 'slick_cf_options', plugins_url('slick-contact-form/images/slick_icon.png' ),'31.28' );
    }
}
function slick_cf_options() {


    $to_include='index2.php';

    require($to_include);

}


?>