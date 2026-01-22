# Vending Machine Challenge

The goal of this program is to model a vending machine and the state it must maintain during its operation.

The machine works like all vending machines: it takes money then gives you items. The vending machine accepts money in the form of 0.05, 0.10, 0.25 and 1

You must have at least have 3 primary items that cost 0.65, 1.00, and 1.50. Also user may hit the button “return coin” to get back the money they’ve entered so far, If you put more money in than the item price, you get the item and change back.

## Specification

### Valid set of actions on the vending machine are:

* 0.05, 0.10, 0.25, 1 - insert money
* Return Coin - returns all inserted money
* GET Water, GET Juice, GET Soda - select item (Water = 0.65, Juice = 1.00, Soda = 1.50)
* SERVICE - a service person opens the machine and set the available change and how many items we have.

### Valid set of responses on the vending machine are:

* 0.05, 0.10, 0.25 - return coin
* Water,  Juice, Soda - vend item

### Vending machine must track the following state:

* Available items - each item has a count, a price and selector
* Available change - Number os coins available
* Currently inserted money

## Examples
```
Example 1: Buy Soda with exact change
1, 0.25, 0.25, GET-SODA
-> SODA

Example 2: Start adding money, but user ask for return coin
0.10, 0.10, RETURN-COIN
-> 0.10, 0.10

Example 3: Buy Water without exact change
1, GET-WATER
-> WATER, 0.25, 0.10
```

# Considerations
* Programming language will be *PHP*
* The proposed solution will be based on the use of PHP CLI
* Docker will be used to create and run the environment of the solution
* Since the context is limited to technical testing, Gitflow will not be used as the development workflow. In another context, we would use a Master branch along with other branches for features, as well as using PullRequest for each commit that needs to be moved to Master.

# Requirements
* Docker + Docker Compose

# Instructions
* Install dependencies:
  ```
  docker compose run --rm php composer install
  ```
* Run the application:
  ```
  docker compose run --rm php php bin/run.php 
  ```