<?php

/**
 * Stripe PHP class used to make payment, save cards on stripe server.
 * @package   PHP
 * @author    Sorav Garg
 */

include('stripe-php-master/init.php');

class Stripe
{
    function __construct()
    {
        $this->secret_key      = 'sk_test_htZuRrdkLDTjNGanHlkK8F1M';
        $this->publishable_key = 'pk_test_KpEfqzfA4YdlqiGb4HPiOsTF';
        \Stripe\Stripe::setApiKey($this->secret_key);
    }
    
    /**
     * [To Create Customer On Stripe Server]
     * @param integer $card_no
     * @param integer $exp_month
     * @param integer $exp_year
     * @param integer $cvv
     * @param string $card_holderName
     * @param string $user_email
     * @param string $description
     */
    public function create_customer($card_no, $exp_month, $exp_year, $cvv, $card_holderName = "", $user_email = "", $description = "")
    {
        $myCard = array(
            'number' => $card_no,
            'exp_month' => $exp_month,
            'exp_year' => $exp_year,
            'name' => $card_holderName
        );
        
        /* Stripe API to create customer */
        try {
            $customer = \Stripe\Customer::create(array(
                "description" => $description,
                "email" => $user_email,
                "card" => $myCard
            ));
            $response = $customer->__toArray(true);
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Customer created successfully',
                'response' => $response
            ));
        }
        catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'message' => $e->getMessage(),
                'response' => array()
            ));
        }
    }
    
    /**
     * [To Save Credit Card On Stripe Server]
     * @param integer $card_no
     * @param integer $exp_month
     * @param integer $exp_year
     * @param integer $cvv
     * @param string $card_holderName
     * @param string $stripe_customer_id
     */
    public function save_card($card_no, $exp_month, $exp_year, $cvv, $card_holderName = "", $stripe_customer_id)
    {
        $myCard = array(
            'number' => $card_no,
            'exp_month' => $exp_month,
            'exp_year' => $exp_year,
            'name' => $card_holderName
        );
        
        /* Stripe API to save credit card */
        try {
            $customer = \Stripe\Customer::retrieve($stripe_customer_id);
            $response = $customer->__toArray(true);
            
            /* Invalid customer id */
            if (isset($response['deleted']) && $response['deleted'] == 1) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Invalid stripe customer id',
                    'response' => array()
                ));
            } else {
                $customer->sources->create(array(
                    'card' => $myCard
                ));
                $response = $customer->__toArray(true);
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Card saved successfully',
                    'response' => $response
                ));
            }
        }
        catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'message' => $e->getMessage(),
                'response' => array()
            ));
        }
    }
    
    /**
     * [To Update Existing Credit Card On Stripe Server]
     * @param string $card_holderName
     * @param string $stripe_customer_id
     * @param string $stripe_card_id
     */
    public function update_card($card_holderName, $stripe_customer_id, $stripe_card_id)
    {
        /* Stripe API to save credit card */
        try {
            $customer = \Stripe\Customer::retrieve($stripe_customer_id);
            $response = $customer->__toArray(true);
            
            /* Invalid customer id */
            if (isset($response['deleted']) && $response['deleted'] == 1) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Invalid stripe customer id',
                    'response' => array()
                ));
            } else {
                $card       = $customer->sources->retrieve($stripe_card_id);
                $response   = $customer->__toArray(true);
                $card->name = $card_holderName;
                $card->save();
                $response = $customer->__toArray(true);
                echo json_encode(array(
                    'status' => 'success',
                    'message' => 'Card updated successfully',
                    'response' => $response
                ));
            }
        }
        catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'message' => $e->getMessage(),
                'response' => array()
            ));
        }
    }
}


?>