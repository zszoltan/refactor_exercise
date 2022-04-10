# Webshippy refactoring exercise
Please refactor the included service.

## Requirements
* Create a public GitHub repository for the solution
* Use OOP vs sequential programming
* Follow clean code principles
* Commit after each step
* Write unit tests
* Reach maximum possible code coverage
* The behavior of the service can not be changed

## Submit
Send us the url of the GitHub repository.

## Service
"Get fulfillable orders" service returns the fulfillable orders by the input stock
parameter sorted by priority and created date. An order is fulfillable if product
stock is greater than or equal to ordered quantity. Orders are stored in csv,
attached in `order.csv`

### Examples
```
php get_fulfillable_orders.php '{"1":8,"2":4,"3":5}'
product_id          quantity            priority            created_at          
================================================================================
3                   5                   high                2021-03-23 05:01:29
1                   2                   high                2021-03-25 14:51:47
2                   1                   medium              2021-03-21 14:00:26
1                   8                   medium              2021-03-22 09:58:09
3                   1                   medium              2021-03-22 12:31:54
1                   6                   low                 2021-03-21 06:17:20
2                   4                   low                 2021-03-22 17:41:32
2                   2                   low                 2021-03-24 11:02:06
3                   2                   low                 2021-03-24 12:39:58
1                   1                   low                 2021-03-25 19:08:22
```

```
php get_fulfillable_orders.php '{"1":2,"2":3,"3":1}'
product_id          quantity            priority            created_at          
================================================================================
1                   2                   high                2021-03-25 14:51:47 
2                   1                   medium              2021-03-21 14:00:26 
3                   1                   medium              2021-03-22 12:31:54 
2                   2                   low                 2021-03-24 11:02:06 
1                   1                   low                 2021-03-25 19:08:22 
```
