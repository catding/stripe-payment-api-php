<?php

/* Require Stripe Class */
require 'Stripe.php';

/* Create object of Stripe class */
$stripeObj = new Stripe();

/* To create customer */
$customer_response = $stripeObj->create_customer('4242424242424242', '8', '2018', '123', 'Sorav Garg', 'soravgarg123@gmail.com', 'Test Card');

/* To save card */
$card_response = $stripeObj->save_card('4111111111111111', '8', '2018', '123', 'Sorav Garg', 'cus_AEYuiEkv6z5f7q');

/* To update card */
$card_response = $stripeObj->update_card('Gaurav Garg', 'cus_AEYuiEkv6z5f7q', 'card_19u5uZA6D6xB5c5v0xPMvql8');


?>