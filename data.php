<?php
include_once('db.php');
include_once('model.php');

$user_id = isset($_GET['user'])
    ? (int)$_GET['user']
    : null;

if ($user_id) 
{
    $conn = get_connect();
    // Get transactions balances
    $balances = get_user_transactions_balances($user_id, $conn);
    // TODO: implement
    $response_data = [
        'balances_associative' => [],
        // 'error' => ""
    ];
    
    $balances_associative = array();
    $balances_associative["Styczeń"] = $balances[0];
    $balances_associative["Luty"] = $balances[1];
    $balances_associative["Marzec"] = $balances[2];
    $balances_associative["Kwiecień"] = $balances[3];
    $balances_associative["Maj"] = $balances[4];
    $balances_associative["Czerwiec"] = $balances[5];
    $balances_associative["Lipiec"] = $balances[6];
    $balances_associative["Sierpień"] = $balances[7];
    $balances_associative["Wrzesień"] = $balances[8];
    $balances_associative["Październik"] = $balances[9];
    $balances_associative["Listopad"] = $balances[10];
    $balances_associative["Grudzień"] = $balances[11];
    
    // print_r($balances_associative["Styczeń"]);
    // echo "{$balances_associative["Styczeń"]}";

    $response_data['balances_associative'] = $balances_associative;
    header('Content-Type: application/json');
    echo json_encode($response_data);
}
// else
// {
//     $response_data['error'] = "Niewybrany użytkownik - użytkownik z transakcjami nie istnieje!";
// }

// header('Content-Type: application/json');
// echo json_encode($response_data);
?>

