# Coffee Machine

Coffee Machine is an awesome console application that from a few input parameters (drink type, amount of money,
number of sugars, extra hot check) is capable to order a drink and show a cool message of the desired drink.

## How it works

Command

```
app:order-drink 
```

Arguments

| #   | Name      | Type   | Required | Description                                           | Values                 | Default |
|-----|-----------|--------|----------|-------------------------------------------------------|------------------------|---------|
| 1   | drinkType | string | true     | Type of drink                                         | tea, coffee, chocolate |
| 2   | money     | float  | true     | Amount of money given by the user in unit of currency |                        |
| 3   | sugars    | int    | false    | Number of sugars                                      | 0, 1, 2                | 0       |

Options

| Name                       | Type | Required | Description                                       | Values      | Default |
|----------------------------|------|----------|---------------------------------------------------|-------------|---------|
| extraHot (--extra-hot, -e) |      | false    | Flag indicating if the user wants extra hot drink | true, false | false   |

List prices

| Drink     | Price |
|-----------|-------|
| Tea       | 0.4   |
| Coffee    | 0.5   |
| Chocolate | 0.6   |

Validations

* If the drink type is not *tea*, *coffee* or *chocolate*, it shows the following message:

```
The drink type should be tea, coffee or chocolate.
```

* If the amount of money does not reach the price of the drink, a message as the following is displayed:

```
The tea costs 0.4.
```

* If the number of sugars is not between 0 and 2, it shows a message like this:

```
The number of sugars should be between 0 and 2.
```

* If the arguments are right, the displayed message is:

```
You have ordered a coffee
```

* If the number of sugars is greater than 0, it includes the stick to the drink and it shows a message similar tot this:

```
You have ordered a coffee with 2 sugars (stick included).
```

* If it adds extra hot option, the displayed message will be:

```
You have ordered a coffee extra hot with 2 sugars (stick included)    
```

## Current status

This application was implemented by a developer who is no longer in the company.

His legacy is the class `MakeDrinkCommand`. This class handle all the application logic:

* It reads input parameters
* It validates input parameters
* It shows output message

He also implemented an integration test covering all possibilities (`MakeDrinkCommandTest`)

As you can see, this class is a bit messy and we need to adapt it to our coding standards
so that we can create a Merge Request and merge it into master

## What you have to do?

We would like to have a reusable, maintainable and testable code, so **we want to refactor**
this `MakeDrinkCommand` following these principles:

* Clean code
* SOLID principles
* Decoupling
* Design patterns
* Error handling
* Unit testing
* TDD
* Hexagonal architecture

You don't have to implement them all, but make the code better to be more comfortable with it.

Also, if there is _time_, our Product Owner has asked us to implement a new feature
so that we could know how much money we have earned with each type of drink.

Something like the following table would be great:

| Drink     | Money |
|-----------|-------|
| Tea       | 15    |
| Coffee    | 25.75 |
| Chocolate | 36    |

In order to achieve the refactor and adapt the code to our standard feel free to modify the current code!

## Project set up

Install and run the application.

```
docker/build
docker/composer i --ignore-platform-reqs
docker/up
```

Examples of the use of the application.

```
docker/console app:order-drink tea 0.5 1 -e
docker/console app:order-drink coffee 0.5
docker/console app:order-drink chocolate 1 --extra-hot

docker/console app:show-orders
docker/console app:show-orders-amount-by-drink
```

Run tests

```
docker/test
```

---

## How to submit your solution

* Push your code to the `devel` branch - we encourage you to commit regularly to show your thinking process was.
* **Create a new Pull Request** to `main` branch & **merge it**.

Once merged you **won't be able to change or add** anything to your solution, so double-check that everything is as
you expected!

Remember that **there is no countdown**, so take your time and implement a solution that you are proud!
