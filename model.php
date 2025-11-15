<?php

/**
 * Return list of users.
 */
function get_users($conn)
{
    $statement = $conn->query('SELECT DISTINCT users.id AS \'users.id\', users.name AS \'users.name\'
                                FROM users
                                JOIN user_accounts ON users.id = user_accounts.user_id
                                JOIN transactions ON user_accounts.id = transactions.account_from
                               UNION
                               SELECT DISTINCT users.id AS \'users.id\', users.name AS \'users.name\'
                                FROM users
                                JOIN user_accounts ON users.id = user_accounts.user_id
                                JOIN transactions ON user_accounts.id = transactions.account_to;');
    $users = array(); 
    while ($row = $statement->fetch()) {
        $users[$row['users.id']] = $row['users.name'];
    }

    return $users;
}

/*
 the below two methods are done in two different ways - first: $statement_from->execute(array($user_id, $transaction_month)); and second: $statement_to->bindValue(1, $user_id); $statement_to->bindValue(2, $transaction_month);
 */
function get_user_transactions_from_amounts_for_given_month($user_id, $conn, $transaction_month)
{
    $statement_from = $conn->prepare('SELECT transactions.amount AS \'transactions.amount\'
                                    FROM transactions 
                                    JOIN user_accounts ON transactions.account_from = user_accounts.id
                                    WHERE user_accounts.user_id = ? AND substr(transactions.trdate, 6, 2) = substr("00" || ?, -2, 2);');
    $statement_from->execute(array($user_id, $transaction_month));
    $transactions_from = array(); // outgoing transactions
    while ($row = $statement_from->fetch()) {
        array_push($transactions_from, -$row['transactions.amount']);
    }

    return $transactions_from;
}

function get_user_transactions_to_amounts_for_given_month($user_id, $conn, $transaction_month)
{
    $statement_to = $conn->prepare('SELECT transactions.amount AS \'transactions.amount\'
                                    FROM transactions
                                    JOIN user_accounts ON transactions.account_to = user_accounts.id
                                    WHERE user_accounts.user_id = ? AND substr(transactions.trdate, 6, 2) = substr("00" || ?, -2, 2);');
    $statement_to->bindValue(1, $user_id);
    $statement_to->bindValue(2, $transaction_month);
    $statement_to->execute();
    $transactions_to = array(); // incoming transactions
    while ($row = $statement_to->fetch()) {
        array_push($transactions_to, $row['transactions.amount']);
    }

    return $transactions_to;
}

/**
 * Return transactions balances of given user.
 */
function get_user_transactions_balances($user_id, $conn)
{     
    $transactions_from = array();
    $transactions_to = array();
    $balances = array();
    for ($i = 0; $i < 12; $i++)
    {
        $transactions_from[$i] = get_user_transactions_from_amounts_for_given_month($user_id, $conn, $i + 1);
        $transactions_to[$i] = get_user_transactions_to_amounts_for_given_month($user_id, $conn, $i + 1);

        $balances[$i] = array_sum($transactions_from[$i]) + array_sum($transactions_to[$i]);
    }

    return $balances;
}

?>