# Stripe Payment [PHP](http://php.net/)

Stripe PHP class used to make payment, save cards on stripe server.

## Test Card Details

```
	Card No - 4242424242424242
	Expiry Month - 8
	Expiry Year - 2018
	CVV - 123
```

## Use

To use this class first you have to require this class then you have to create object of this class, after that you can make payment using class methods.

```
	/* Require Stripe Class */
	require 'Stripe.php';
```

```
	/* Create object of Stripe class */
	$stripeObj = new Stripe();
```

#### To Create Customer On Stripe Server

```
	$stripeObj->create_customer();
```

#### To Save Credit Card On Stripe Server

```
	$stripeObj->save_card();
```

#### To Update Existing Credit Card On Stripe Server

```
	$stripeObj->update_card();
```