<?php

/**
 * Return list of users.
 */
function get_users($conn)
{
    // TODO: implement
    $statement = $conn->query('SELECT DISTINCT `users`.`id` AS \'users.id\', `users`.`name` AS \'users.name\'
                                FROM `users`
                                JOIN `user_accounts` ON `users`.`id` = `user_accounts`.`user_id`
                                JOIN `transactions` ON `user_accounts`.`id` = `transactions`.`account_from`
                               UNION
                               SELECT DISTINCT `users`.`id` AS \'users.id\', `users`.`name` AS \'users.name\'
                                FROM `users`
                                JOIN `user_accounts` ON `users`.`id` = `user_accounts`.`user_id`
                                JOIN `transactions` ON `user_accounts`.`id` = `transactions`.`account_to`;');
    $users = array(); 
    while ($row = $statement->fetch()) {
        $users[$row['users.id']] = $row['users.name'];
    }

    return $users;
}

function get_user_transactions_from_amounts_for_given_month($user_id, $conn, $transaction_month)
{
    $statement_from = $conn->query('SELECT `transactions`.`amount`
                                    FROM `transactions` 
                                    JOIN `user_accounts` ON `transactions`.`account_from` = `user_accounts`.`id`
                                    WHERE `user_accounts`.`user_id` = '.$user_id .' AND substr(`transactions`.`trdate`, 6, 2) = substr("00" || \''.$transaction_month .'\', -2, 2);');
    $transactions_from = array(); // outgoing transactions
    // echo "coś;";
    while ($row = $statement_from->fetch()) {
        // echo "COŚ;";
        array_push($transactions_from, -$row['amount']);
    }
    // echo "Przerwa";

    return $transactions_from;
}

function get_user_transactions_to_amounts_for_given_month($user_id, $conn, $transaction_month)
{
    $statement_to = $conn->query('SELECT `transactions`.`amount`
                                    FROM `transactions` 
                                    JOIN `user_accounts` ON `transactions`.`account_to` = `user_accounts`.`id`
                                    WHERE `user_accounts`.`user_id` = '.$user_id .' AND substr(`transactions`.`trdate`, 6, 2) = substr("00" || \''.$transaction_month .'\', -2, 2);');
    $transactions_to = array(); // incoming transactions
    while ($row = $statement_to->fetch()) {
        array_push($transactions_to, $row['amount']);
    }

    return $transactions_to;
}

function get_balance_for_given_month($balance, $transactions_for_given_month)
{
    for ($i = 0; $i < count($transactions_for_given_month); $i++)
    {
        $balance += $transactions_for_given_month[$i];
    }

    return $balance;
}

/**
 * Return transactions balances of given user.
 */
function get_user_transactions_balances($user_id, $conn)
{     
    // TODO: implement
    $transactions_from = array();
    $transactions_to = array();
    $balances = array();
    for ($i = 0; $i < 12; $i++)
    {
        $transactions_from[$i] = get_user_transactions_from_amounts_for_given_month($user_id, $conn, $i + 1);
        $transactions_to[$i] = get_user_transactions_to_amounts_for_given_month($user_id, $conn, $i + 1);

        $balances[$i] = 0;
        $balances[$i] = get_balance_for_given_month($balances[$i], $transactions_from[$i]);
        // echo $balances[$i];
        $balances[$i] = get_balance_for_given_month($balances[$i], $transactions_to[$i]);
        // echo $balances[$i];
    }

    // print_r('Transactions data<br/>');
    // print_r($transactions);
    // print_r('</br>');
    // echo "{$balances[0]}";

    return $balances;
}