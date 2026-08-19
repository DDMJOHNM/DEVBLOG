---
title: 'Top 50 PHP'
description: 'PHP and Laravel interview questions covering language basics, OOP, and the request lifecycle'
category: Interviewing
author: 'John Mason'
date: '2026-08-19 15:42'
---

Interview notes for PHP, with Laravel follow-ups. Numbered questions with short answers and examples.

## Current version

The current stable version of PHP is 8.5, with version 8.5.5 being the most recent maintenance release as of April 9, 2026

## Key New Features in PHP 8.5

The 8.5 release (November 2025) introduced several functional programming enhancements and utility improvements:

**Pipe Operator (|>):**

Allows chaining multiple functions in a readable left-to-right manner.
It passes the result of the left expression as the first argument to the next function.

**Built-in URI Extension:**

A new, standards-compliant extension for parsing, validating, and normalizing URLs based on RFC 3986.

**Clone With:** modify specific properties while cloning an object in a single expression: `clone $obj with ['prop' => 'value']`.

**New Array Functions:**

Native array_first() and array_last()
functions provide a cleaner way to retrieve the first and last elements of an array compared to older methods like reset() or end().

**Fatal Error Backtraces:**

Fatal errors, such as memory exhaustion or execution timeouts, now provide a full stack trace to simplify debugging.

**[NoDiscard] Attribute:**

A new attribute that triggers a warning if a function's return value is ignored by the caller.

## Previous Major Highlights (PHP 8.4)

Released in late 2024, PHP 8.4 introduced several fundamental changes to the language's object model:

**Property Hooks:**

Support for get and set hooks on class properties, reducing the need for boilerplate getters and setters.

**Asymmetric Visibility:**

Allows different visibility levels for reading and writing a property (e.g., public private(set)).

- HTML5 Support: A new, standards-compliant HTML5 parser within the DOM extension.

- New Array Search Functions: Addition of array_find(), array_find_key(), array_any(), and array_all().

### Basic

## 1. What is PHP?

PHP stands for Hypertext Preprocessor.
It is an open-source, server-side scripting language designed for creating dynamic web pages.

## 2. What are the common uses of PHP?

PHP is commonly used for:

- Server-side scripting
- Command-line scripting
- Creating dynamic websites
- Interacting with databases (e.g., MySQL)
- Building RESTful APIs

## 3. How do you declare a variable in PHP?

Variables are declared using the $ symbol
e.g., $name = "John";.

## 4. What are PHP data types?

PHP supports:

String
Integer
Float (Double)
Boolean
Array
Object
NULL
Resource - a reference to an external resource

## 5. What is the difference between echo and print?

echo: Outputs data, can take multiple parameters, no return value.
print: Outputs data, returns 1, works like a function.

## 6. How do you define a constant in PHP?

Using the define() function, e.g., define("SITE_NAME", "Shikshatech");.

## 7. What are PHP magic constants?

Special constants starting with double underscores, like:

```php
__LINE__

__FILE__

__DIR__

__FUNCTION__

__CLASS__

define('MIN_VALUE', '0.0');   // RIGHT - Works OUTSIDE of a class definition.
define('MAX_VALUE', '1.0');   // RIGHT - Works OUTSIDE of a class definition.

//const MIN_VALUE = 0.0;         RIGHT - Works both INSIDE and OUTSIDE of a class definition.
//const MAX_VALUE = 1.0;         RIGHT - Works both INSIDE and OUTSIDE of a class definition.
```

## 8. What is the difference between == and ===?

==: Compares values only.

===: Compares values and data types.

## 9. What is a session in PHP?

Sessions allow data to be stored across multiple pages. session_start() is used to initiate a session.

## 10. What is a cookie in PHP?

Cookies are small files stored on the client’s device. Created using setcookie().

### Intermediate

## 11. What is the difference between GET and POST?

GET: Sends data via URL, limited length, less secure.

POST: Sends data via HTTP headers, no limit, more secure.

## 12. What are arrays in PHP?

Arrays are collections of data:

Indexed Arrays: $fruits = array("Apple", "Banana", "Mango");

Associative Arrays: $age = array("John" => 30, "Jane" => 25);
Multidimensional Arrays: $marks = array("John" => array(90, 85), "Jane" => array(78, 88));

## 13. Explain PHP error types.

Notice: Non-critical errors (e.g., undefined variables).

Warning: Recoverable errors (e.g., missing files).

Fatal Error: Non-recoverable errors (e.g., calling undefined functions).

Parse Error: Errors in code structure.

```php
<?php

set_error_handler(function(int $number, string $message) {
   echo "Handler captured error $number: '$message'" . PHP_EOL  ;
});

try {
    echo $x; # notice, handled on callable
    pg_exec(null, null); # warning, handled on callable
    fho(); # fatal error, stop running and catched
} catch (Throwable $e) {
    echo "Captured Throwable: " . $e->getMessage() . PHP_EOL;
}

?>

set_error_handler will also works without try and catch
```

## 14. What is isset()?

Checks if a variable is set and is not NULL. Returns true if the variable exists and is not NULL.

## 15. What is empty()?

Checks if a variable is empty. Returns true if it is NULL, 0, "", false, or an empty array.

## 16. What are PHP filters?

Filters are used to validate and sanitize data. Example: filter_var($email, FILTER_VALIDATE_EMAIL);.

## 17. What is PDO in PHP?

PHP Data Objects (PDO) is a database access layer that provides a uniform interface for multiple databases.

## 18. How do you connect to a MySQL database using PDO?

```php
$pdo = new PDO("mysql:host=localhost;dbname=testdb", "username", "password");
```

## 19. What is SQL Injection? How to prevent it?

SQL Injection is a technique where attackers inject malicious SQL queries.

Prevention: Use prepared statements and parameterized queries.

## 20. What is a trait in PHP?

A trait is a code reuse mechanism used to include methods in a class without inheritance.

### Advanced

## 21. What is Object-Oriented Programming (OOP) in PHP?

A programming model organized around objects rather than actions. Core concepts include classes, objects, inheritance, polymorphism, encapsulation, and abstraction.

### Inheritance

For example, when extending a class, the subclass inherits all of the public and protected methods, properties and constants from the parent class. Unless a class overrides those methods, they will retain their original functionality.

### Abstraction

PHP has abstract classes, methods, and properties. Classes defined as abstract cannot be instantiated, and any class that contains at least one abstract method or property must also be abstract. Methods defined as abstract simply declare the method's signature and whether it is public or protected; they cannot define the implementation

### Polymorphism

Polymorphism is an OOP concept that allows objects of different classes to be treated as instances of a common parent class or interface. The word originates from Greek, meaning "many forms". In practice, a single method call can behave differently depending on the object it acts on.

### Encapsulation

Encapsulation bundles data (properties) and the methods that operate on them into a single unit, usually a class. Its primary purpose is to hide the internal state of an object and only allow interaction through a controlled public interface, which protects data integrity.

### Key Components of Encapsulation

- Access Modifiers: These keywords define the visibility of class members:
- private: Members are only accessible within the class that defines them.
- protected: Members are accessible within the class itself and by its child classes.
- public: Members are accessible from anywhere, both inside and outside the class.
- Getter and Setter Methods: These are public methods used to retrieve (get) or update (set) private properties. - Setters often include validation logic to prevent invalid data from being assigned.
- Data Hiding: By making properties private or protected, you prevent external code from directly modifying them, which protects the object's internal state from accidental damage or misuse

## 22. What are Namespaces in PHP?

Namespaces provide a way to group related classes, functions, and constants to avoid naming conflicts.

## 23. Explain the MVC architecture.

MVC stands for Model-View-Controller. It separates application logic, presentation, and user interaction.

## 24. What is Composer in PHP?

Composer is a dependency manager for PHP, allowing you to manage libraries and packages in your projects.

## 25. What is the difference between include and require?

include(): Produces a warning if the file is missing but continues execution.

require(): Produces a fatal error if the file is missing and stops execution.

## 26. What is json_encode() and json_decode()?

Functions to convert data between JSON format and PHP arrays/objects.

## 27. How to handle file uploads in PHP?

Using the $_FILES superglobal and moving files via move_uploaded_file().

## 28. Explain PHP's session_destroy() function.

Destroys all data registered to a session and deletes the session itself.

## 29. What is OPcache?

built-in caching engine that improves PHP performance by storing precompiled script bytecode in memory.

## 30. How to improve PHP performance?

Use caching (OPcache, Memcached).
Optimize database queries.
Minimize file I/O.
Use CDN for static resources.
Code refactoring.

Yes, PHP is widely classified as an interpreted language. However, its execution process is more complex than simple line-by-line reading; modern PHP uses a hybrid approach involving internal compilation.

### How PHP Execution Works

The standard PHP interpreter, the Zend Engine, processes code in several internal stages to balance development flexibility with speed:

- Lexical Analysis (Tokenizing): The Zend Engine breaks the raw PHP source code into a sequence of small, manageable units called tokens.

- Parsing: These tokens are structured into an Abstract Syntax Tree (AST), which represents the logical structure of your code.

- Internal Compilation (Opcodes): The AST is compiled into intermediate Opcodes (operation codes). These are similar to Java bytecode and are much faster for a computer to process than raw text.

- Execution: The Zend Virtual Machine executes these opcodes step-by-step to produce the final output for the web browser.

## Key Performance Features

To overcome the speed limitations of traditional interpretation, PHP utilizes advanced optimization tools:

- OPcache: Instead of recompiling scripts on every request, OPcache stores the precompiled opcodes in memory, significantly reducing server load and response times.

- Just-In-Time (JIT) Compilation: Introduced in PHP 8, JIT further blurs the line between interpreted and compiled languages. It identifies frequently used code ("hot spots") and compiles them directly into native machine code at runtime for maximum performance.

### Singleton

## Laravel

Laravel interview notes. Numbering here is from the Laravel set, not the PHP questions above.

### What is Artisan?

Artisan is Laravel’s command-line interface (CLI).
It automates common tasks like creating files, running migrations, clearing cache, and starting the server.

Common Artisan commands:

```bash
php artisan serve
php artisan make:controller UserController
php artisan make:model Post -m
php artisan migrate
php artisan cache:clear
```

### How do you create email functionality in Laravel?

Laravel uses Mail classes, Blade templates, and mail drivers (SMTP, Gmail, Mailtrap).

Steps:

- Create a Mail class: php artisan make:mail WelcomeMail
- Design the email using Blade
- Configure mail settings in .env
- Send mail: Mail::to($user->email)->send(new WelcomeMail());

### How do you create a migration without CLI?

You can manually create a migration file in database/migrations/ and define up() and down() methods.

Using Artisan (php artisan make:migration) is recommended for consistency.

### Laravel Architecture

Laravel follows the MVC architecture:

Model — database logic

View — UI (Blade templates)

Controller — request & response

It also uses middleware, routing, and service containers.

### Laravel Request Life Cycle

- Request enters public/index.php
- Goes to HTTP Kernel
- Middleware handles the request
- Route matches the request
- Controller executes
- Response returned to the browser

### Laravel Default Port

Laravel runs on port 8000 by default:

php artisan serve

### What is ORM?

ORM (Object Relational Mapping)

Allows developers to interact with the database using objects instead of writing raw SQL queries.

### What is Eloquent?

Eloquent is Laravel’s built-in ORM.
It provides clean syntax for database operations and supports relationships between models.

### Difference between Raw SQL, Query Builder, and ORM

### Raw SQL

- Written manually
- Fast but hard to maintain
- Not reusable
- No model or relationship support

### Query Builder

- Programmatic SQL
- Cleaner and readable
- Reusable queries
- Limited relationship support

### ORM (Eloquent)

- Object-based using models
- Most readable and maintainable
- Highly reusable
- Supports full model relationships

### SQL Query — Find users with name “ram”

SELECT * FROM users WHERE name LIKE '%ram%';

## Inheritance types

- Single (One child inherits from one parent.)

- Multilevel (A child inherits from a parent, which is also a child of another parent.)

- Hierarchical	(Multiple children inherit from one parent.)

### Does PHP support multiple inheritance?

❌ PHP does not support multiple inheritance using classes.

✅ It can be implemented using Traits.

### What is SQL Injection?

SQL Injection is an attack where malicious SQL code is injected through user input to manipulate the database.

```php
Example (unsafe):

SELECT * FROM users WHERE email = '$email' AND password = '$password';

Safe way (Laravel Eloquent):

User::where('email', $email)->first();
```

### Why do we use CSRF?

CSRF protects the application from unauthorized requests. Laravel uses CSRF tokens to validate forms.

```php
Example:

<form method="POST">
    @csrf
    <button>Submit</button>
</form>
```

### What is Laravel Sanctum?

Sanctum is a lightweight authentication system for APIs, SPAs, and mobile apps using token-based authentication.

```php
Example:

$token = $user->createToken('api-token')->plainTextToken;
```

### Difference between Sanctum and Passport

Sanctum — Simple token-based auth, best for SPAs and mobile apps.

Passport — Full OAuth2, best for large APIs or third-party integrations.

```php
Route::middleware('auth:sanctum')->get('/user', function () {
    return auth()->user();
});
```

### What is Middleware in Laravel?

Middleware acts as a filter between the request and response.
It handles tasks like authentication, authorization, logging, or request modification.

```php
Example:

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
```

## Architecture concepts

## Request Lifecycle

- The entry point for all requests to a Laravel application is the public/index.php file.

- The index.php file loads the Composer generated autoloader definition and then retrieves an instance of the Laravel application from bootstrap/app.php.

- The first action taken by Laravel itself is to create an instance of the application / service container.

## Service Container

The Laravel service container is a powerful tool for managing class dependencies and performing dependency injection. Dependency injection is a fancy phrase that essentially means this: class dependencies are "injected" into the class via the constructor or, in some cases, "setter" methods.

One of the most important kernel bootstrapping actions is loading the service providers for your application. Service providers are responsible for bootstrapping all of the framework's various components, such as the database, queue, validation, and routing components.

Laravel will iterate through this list of providers and instantiate each of them. After instantiating the providers, the register method will be called on all of the providers. Then, once all of the providers have been registered, the boot method will be called on each provider. This is so service providers may depend on every container binding being registered and available by the time their boot method is executed.

Essentially every major feature offered by Laravel is bootstrapped and configured by a service provider. Since they bootstrap and configure so many features offered by the framework, service providers are the most important aspect of the entire Laravel bootstrap process.

While the framework internally uses dozens of service providers, you also have the option to create your own. You can find a list of the user-defined or third-party service providers that your application is using in the bootstrap/providers.php file.

## HTTP / Console Kernels

Next, the incoming request is sent to either the HTTP kernel or the console kernel, using the handleRequest or handleCommand methods of the application instance, depending on the type of request entering the application. These two kernels serve as the central location through which all requests flow. For now, let's just focus on the HTTP kernel, which is an instance of Illuminate\Foundation\Http\Kernel.

The HTTP kernel defines an array of bootstrappers that will be run before the request is executed. These bootstrappers configure error handling, configure logging, detect the application environment, and perform other tasks that need to be done before the request is actually handled. Typically, these classes handle internal Laravel configuration that you do not need to worry about.

The HTTP kernel is also responsible for passing the request through the application's middleware stack. These middleware handle reading and writing the HTTP session, determining if the application is in maintenance mode, verifying the CSRF token, and more. We'll talk more about these soon.

The method signature for the HTTP kernel's handle method is quite simple: it receives a Request and returns a Response. Think of the kernel as being a big black box that represents your entire application. Feed it HTTP requests and it will return HTTP responses.

## Routing

Once the application has been bootstrapped and all service providers have been registered, the Request will be handed off to the router for dispatching. The router will dispatch the request to a route or controller, as well as run any route specific middleware.

Finally, once the response travels back through the middleware, the HTTP kernel's handle method returns the response object to the handleRequest of the application instance, and this method calls the send method on the returned response. The send method sends the response content to the user's web browser. We've now completed our journey through the entire Laravel request lifecycle!

## Facades

Throughout the Laravel documentation, you will see examples of code that interacts with Laravel's features via "facades". Facades provide a "static" interface to classes that are available in the application's service container. Laravel ships with many facades which provide access to almost all of Laravel's features.

## Helper Functions

To complement facades, Laravel offers a variety of global "helper functions" that make it even easier to interact with common Laravel features. Some of the common helper functions you may interact with are view, response, url, config, and more. Each helper function offered by Laravel is documented with their corresponding feature; however, a complete list is available within the dedicated helper documentation.

## When to Utilize Facades

Facades have many benefits. They provide a terse, memorable syntax that allows you to use Laravel's features without remembering long class names that must be injected or configured manually. Furthermore, because of their unique usage of PHP's dynamic methods, they are easy to test.

However, some care must be taken when using facades. The primary danger of facades is class "scope creep". Since facades are so easy to use and do not require injection, it can be easy to let your classes continue to grow and use many facades in a single class. Using dependency injection, this potential is mitigated by the visual feedback a large constructor gives you that your class is growing too large. So, when using facades, pay special attention to the size of your class so that its scope of responsibility stays narrow. If your class is getting too large, consider splitting it into multiple smaller classes.

## Facades vs. Dependency Injection

One of the primary benefits of dependency injection is the ability to swap implementations of the injected class. This is useful during testing since you can inject a mock or stub and assert that various methods were called on the stub.

Typically, it would not be possible to mock or stub a truly static class method. However, since facades use dynamic methods to proxy method calls to objects resolved from the service container, we actually can test facades just as we would test an injected class instance. For example, given the following route:

## Testing

- HTTP Tests
- Console Tests
- Browser Tests
- Database
- Mocking

## Laravel event system

## Events:

These are simple PHP classes that serve as a signal that something important has happened, such as a user registering or an order being placed.

## Listeners:

These are classes that contain the logic to respond to a specific event. For instance, an OrderPlaced event might have separate listeners for SendOrderConfirmation and UpdateInventory.

## Event Dispatcher:

The central hub that connects events to their registered listeners.

### Core Benefits

### Decoupling:

Business logic (e.g., creating a user) remains separate from side effects (e.g., sending a welcome SMS), leading to cleaner, more modular code.

### Asynchronous Processing:

You can offload time-consuming tasks to Laravel Queues by simply having a listener implement the ShouldQueue interface.

### Scalability:

New functionality can be added by creating a new listener without modifying the original code that triggers the event.

### Model Events:

Laravel provides built-in events for Eloquent Models (creating, saving, updating, deleting), allowing you to automate tasks whenever data changes.

Implementation Workflow

Generate the Event:
Use Artisan to create the event class: php artisan make:event UserRegistered.

### Generate the Listener:

Create a listener and link it to the event: php artisan make:listener SendWelcomeEmail --event=UserRegistered.

### Dispatch the Event:

Trigger the event from your controller or service: event(new UserRegistered($user));.
Define Logic: Add the reaction logic inside the listener's handle() method.

### Advanced Patterns

Observers:
If you are listening to many events on a single Eloquent model, you can group them into an Observer Class.

Broadcasting: For real-time updates (like chat or live notifications), Laravel can broadcast events over
WebSockets using tools like Pusher or Laravel Reverb.

Event Sourcing:
For complex systems requiring a full audit trail, you can treat every change as an immutable event to reconstruct state at any point in time.

## References

- <https://www.php.net/>
- <https://dev.to/robin-ivi/top-50-php-interview-questions-4p69#:~:text=PHP%20is%20one%20of%20the,What%20are%20PHP%20magic%20constants?>
- <https://refactoring.guru/design-patterns/singleton/php/example>
- <https://medium.com/@aakriticodes/laravel-interview-questions-quick-notes-for-developers-74541f0f5b5e>
- <https://laravel.com/>
- <https://api.laravel.com/docs/13.x/index.html>
