<?php
    function lapizzeria_delete_reservation() {
        if($_POST['type'] == 'delete'):
            global $wpdb;
            $table = $wpdb->prefix . 'reservation';
            $id_reservation = $_POST['id'];

            $result = $wpdb->delete($table, array('id' => $id_reservation), array('%d'));

            if($result == 1){
                $response = array(
                    'response' => 'success',
                    'id' => $id_reservation
                );
            } else {
                $response = array(
                    'response' => 'error'
                );
            }
        endif;

        die(json_encode($response));
    }
    add_action('wp_ajax_lapizzeria_delete_reservation', 'lapizzeria_delete_reservation');


 function lapizzeria_save_reservation() {

    if(isset($_POST['reservation']) && $_POST['hidden'] == "1"){
        //Read value from recaptcha
        $captcha = $_POST['g-recaptcha-response'];

        //Send the values to the server
        $fields = array(
          'secret' => '6LeDGsEUAAAAALiPfPDzxXWrFMUlA8EaxVQXYAlI',
          'response' => $captcha,
          'remoteip' => $_SERVER['REMOTE_ADDR']
        );
        //Start the request to the server
            $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');

        //configure the request
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);

         //Send the encode values ine the url
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

         //Read the return value
            $response = json_decode(curl_exec($ch));
            if($response->success){
                    global $wpdb;
                    $name = sanitize_text_field( $_POST['name'] ) ;
                    $date = sanitize_text_field( $_POST['date'] );
                    $email = sanitize_email( $_POST['email'] );
                    $phone = sanitize_text_field( $_POST['phone'] );
                    $message = sanitize_text_field( $_POST['message'] );

                    $table = $wpdb->prefix . 'reservation';

                    $data = array(
                        'name' => $name,
                        'date' => $date,
                        'email' => $email,
                        'phone' => $phone,
                        'message' => $message
                    );
                    $format = array(
                        '%s' ,
                        '%s' ,
                        '%s' ,
                        '%s' ,
                        '%s' ,
                    );
                    $wpdb->insert($table, $data, $format);

                    $url = get_page_by_title('Thanks for your reservation!');
                    wp_redirect( get_permalink($url) );
                    exit();
                }
           }
       }

 add_action('init', 'lapizzeria_save_reservation');
?>