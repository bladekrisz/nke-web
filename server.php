<?php

$connection = null;

// write_log( $_GET );
// write_log( $_POST );
// write_log( $_SERVER );


switch( $_GET["action"] ) {
    case "ajax_message": 
        ajax_message();
        break;

    default :
        echo "Hello World!";
        break;
}


function ajax_message() {
    $name = ( isset( $_POST['name'] )) ? $_POST['name'] : 'no name';
    $email = ( isset( $_POST['email'] )) ? $_POST['email'] : '';
    $message = ( isset( $_POST['message'] )) ? $_POST['message'] : '';

    $greeting = "Hi, " . $name . "!";
    
    $response = [
        'greeting' => $greeting
    ];
    
    db_insert( $name, $email, $message, $_SERVER['HTTP_HOST'] );
    
    echo json_encode( $response );
}






function db_init() {
    global $connection;

    $host     = "localhost";
    $username = "root";
    $password = "";
    $dbname   = "orai";

    $connection = new mysqli( $host, $username, $password, $dbname );
    
    if( $connection->connect_error ) {
        return false;
    }

    return true;
}


function db_insert( $name = "", $email = "", $message = "", $ip = "" ) {

    global $connection;

    if( db_init() ) {  
        $name    = mysqli_real_escape_string( $connection, $name );
        $email   = mysqli_real_escape_string( $connection, $email );
        $message = mysqli_real_escape_string( $connection, $message );
        
        $sql = "INSERT INTO messages (name, email, message, ip) VALUES ('$name', '$email', '$message', '$ip')";
        db_query( $sql );
    }
}


function db_query( $query ) {
    global $connection;

    if( $connection->query( $query ) === TRUE ) {
        write_log("New record created successfully");
    } else {
        write_log( "Error: " . $query . "<br>" . $connection->error );
    } 
}




  
function write_log( $log ) {
    if( is_array( $log ) || is_object( $log )) {
        error_log( print_r( $log, true ), 3, "debug.log" );
    } else {
        error_log( $log, 3, "debug.log" );
    }
}


?>