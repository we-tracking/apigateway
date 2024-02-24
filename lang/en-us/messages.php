<?php

return [
    'validation' => [
        'required' => 'The field :field is required',
        'string' => 'The field :field must be a string',
        'minLength' => 'The field :field must have at least :min characters',
        'email' => 'The field :field must be a valid email',
        'same' => 'The field :field must be the same as the :input field',
    ],

    'errors' => [
        'userNotFound' => 'User not found',
        'invalidPassword' => 'Invalid email or password!',
        'userAlreadyExists' => 'User already registered!',
        'productNotFound' => 'Product not found',
        'productAlreadyExists' => 'User already has a product with provided EAN registered!',
        'webSourceNotFound' => 'Web source not found',
    ],

    'success' => [
        'authenticated' => 'User authenticated successfully',
        'productPriceList' => 'Product price list generated successfully',
        'productCreated' => 'Product created successfully',
        'productList' => 'Product list generated successfully',
        'userCreated' => 'User created successfully',
        'webSourceList' => 'Web source list generated successfully',
        'productWebSourceList' => 'Web source list generated successfully',
        'passwordAltered' => 'Password changed successfully',
        'productDeleted' => 'Product deleted successfully'
    ],
];