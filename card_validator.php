<?php

// create a class for validation card number

class CardValidator
{
    // static method to validate card number
    // using Luna algorithm
    public static function validate($card_number)
    {
        // remove all non-digit characters
        $card_number = preg_replace('/\D/', '', $card_number);

        // check if card number is empty
        if (empty($card_number)) {
            return false;
        }

        // check if card number is 16 digits
        if (strlen($card_number) != 16) {
            return false;
        }

        // reverse card number
        $card_number = strrev($card_number);

        // calculate sum
        $sum = 0;
        for ($i = 0; $i < strlen($card_number); $i++) {
            $current_num = $card_number[$i];
            // double every second digit
            if ($i % 2 == 1) {
                $current_num *= 2;
            }
            // if doubling of a number results in a
            // two digits number, add up the digits
            // to get a single digit number
            if ($current_num > 9) {
                $first_num = $current_num % 10;
                $second_num = ($current_num - $first_num) / 10;
                $current_num = $first_num + $second_num;
            }
            // add each digit to $sum
            $sum += $current_num;
        }

        // if the total has no remainder it's OK
        return ($sum % 10 == 0);
    }

    // static method to get the card type
    public static function getCardType($card_number)
    {
        // remove all non-digit characters
        $card_number = preg_replace('/\D/', '', $card_number);

        // check if card number is empty
        if (empty($card_number)) {
            return false;
        }

        // check if card number is 16 digits
        if (strlen($card_number) != 16) {
            return false;
        }

        // check card type
        if (preg_match('/^4/', $card_number)) {
            return 'Visa';
        } elseif (preg_match('/^5[1-5]/', $card_number)) {
            return 'MasterCard';
        } elseif (preg_match('/^3[47]/', $card_number)) {
            return 'American Express';
        } elseif (preg_match('/^6011/', $card_number)) {
            return 'Discover';
        } else {
            return false;
        }
    }

    // static method to get pretty output of works of the class
    public static function prettyOutput($card_number)
    {
        // check if card number is valid
        if (self::validate($card_number)) {
            $card_type = self::getCardType($card_number);
            echo "Card number $card_number is valid $card_type card number";
        } else {
            echo "Card number $card_number is not valid";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Card Validator</title>
</head>
<body>
    <h1>Card Validator</h1>
    <form action="" method="post">
        <label for="card_number">Card Number</label>
        <input type="text" name="card_number" id="card_number">
        <input type="submit" value="Validate">
    </form>
    <?php
    // check if form is submitted
    if (isset($_POST['card_number'])) {
        // get card number
        $card_number = $_POST['card_number'];
        // validate card number
        CardValidator::prettyOutput($card_number);
    }
    ?>
</body>
</html>

