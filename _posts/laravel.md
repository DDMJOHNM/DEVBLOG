---
title: Laravel
description: 'Laravel Eloquent, facades, contracts, and request lifecycle'
category: Laravel
author: 'John Mason'
date: '2026-08-19 12:00'
---

## Query Builder and Eloquent

- Query builder
- Query chunking
- Eloquent ORM

Laravel includes Eloquent, an object-relational mapper (ORM). Each database table has a corresponding model. Eloquent models let you insert, update, and delete records from the table.

A **polymorphic relationship** allows the child model to belong to more than one type of model using a single association.

Eloquent makes managing these relationships easy, and supports:

- One to one
- One to many
- Many to many
- Has one through
- Has many through
- One to one (polymorphic)
- One to many (polymorphic)
- Many to many (polymorphic)

All Eloquent methods that return more than one model result return instances of the `Illuminate\Database\Eloquent\Collection` class.

### Accessors, Mutators, and Casting

Accessors, mutators, and attribute casting transform Eloquent attribute values when you retrieve or set them on model instances.

For example, you may use the Laravel encrypter to encrypt a value while it is stored in the database, then automatically decrypt it when you access the attribute on an Eloquent model. Or you may convert a JSON string stored in the database to an array when it is accessed via the model.

An **accessor** transforms an Eloquent attribute value when it is accessed. To define one, create a protected method on your model to represent the accessible attribute. The method name should correspond to the camelCase representation of the underlying model attribute / database column when applicable.

### API Resources

When building an API, you may need a transformation layer between your Eloquent models and the JSON responses returned to users. For example, you may wish to display certain attributes for a subset of users and not others, or always include certain relationships in the JSON representation of your models.

Eloquent's resource classes let you transform models and model collections into JSON.

### Serializing to Arrays

To convert a model and its loaded relationships to an array, use the `toArray` method. This method is recursive, so all attributes and all relations (including the relations of relations) are converted to arrays.

### Model Factories

When testing your application or seeding your database, you may need to insert a few records. Instead of manually specifying the value of each column, Laravel lets you define a set of default attributes for each Eloquent model using model factories.

## Database

Generate a model and migration:

```bash
php artisan make:model Flight --migration
```

Supported databases:

- MariaDB 10.3+
- MySQL 5.7+
- PostgreSQL 10.0+
- SQLite 3.26.0+
- SQL Server 2017+

## Facades and the Service Container

Facades provide a "static" interface to classes that are available in the application's **service container**.

The Laravel service container is a tool for managing class dependencies and performing dependency injection. Dependencies are injected into the class via the constructor or, in some cases, setter methods.

### When to Use Facades

Facades have many benefits. They provide a terse, memorable syntax that lets you use Laravel's features without remembering long class names that must be injected or configured manually. Because of their unique usage of PHP's dynamic methods, they are also easy to test.

Some care is needed. The primary danger of facades is class **scope creep**. Since facades are easy to use and do not require injection, it is easy to let a class grow and use many facades. Dependency injection mitigates this with the visual feedback a large constructor gives you that the class is growing too large.

When using facades, keep the class's scope of responsibility narrow. If it is getting too large, split it into smaller classes.

### Facade Class Reference

A quick map from each facade to its underlying class and service container binding:

| Facade | Class | Service Container Binding |
| --- | --- | --- |
| App | `Illuminate\Foundation\Application` | `app` |
| Artisan | `Illuminate\Contracts\Console\Kernel` | `artisan` |
| Auth (Instance) | `Illuminate\Contracts\Auth\Guard` | `auth.driver` |
| Auth | `Illuminate\Auth\AuthManager` | `auth` |
| Blade | `Illuminate\View\Compilers\BladeCompiler` | `blade.compiler` |
| Broadcast (Instance) | `Illuminate\Contracts\Broadcasting\Broadcaster` | |
| Broadcast | `Illuminate\Contracts\Broadcasting\Factory` | |
| Bus | `Illuminate\Contracts\Bus\Dispatcher` | |
| Cache (Instance) | `Illuminate\Cache\Repository` | `cache.store` |
| Cache | `Illuminate\Cache\CacheManager` | `cache` |
| Config | `Illuminate\Config\Repository` | `config` |
| Context | `Illuminate\Log\Context\Repository` | |
| Cookie | `Illuminate\Cookie\CookieJar` | `cookie` |
| Crypt | `Illuminate\Encryption\Encrypter` | `encrypter` |
| Date | `Illuminate\Support\DateFactory` | `date` |
| DB (Instance) | `Illuminate\Database\Connection` | `db.connection` |
| DB | `Illuminate\Database\DatabaseManager` | `db` |
| Event | `Illuminate\Events\Dispatcher` | `events` |
| Exceptions (Instance) | `Illuminate\Contracts\Debug\ExceptionHandler` | |
| Exceptions | `Illuminate\Foundation\Exceptions\Handler` | |
| File | `Illuminate\Filesystem\Filesystem` | `files` |
| Gate | `Illuminate\Contracts\Auth\Access\Gate` | |
| Hash | `Illuminate\Contracts\Hashing\Hasher` | `hash` |
| Http | `Illuminate\Http\Client\Factory` | |
| Lang | `Illuminate\Translation\Translator` | `translator` |
| Log | `Illuminate\Log\LogManager` | `log` |
| Mail | `Illuminate\Mail\Mailer` | `mailer` |
| Notification | `Illuminate\Notifications\ChannelManager` | |
| Password (Instance) | `Illuminate\Auth\Passwords\PasswordBroker` | `auth.password.broker` |
| Password | `Illuminate\Auth\Passwords\PasswordBrokerManager` | `auth.password` |
| Pipeline (Instance) | `Illuminate\Pipeline\Pipeline` | |
| Process | `Illuminate\Process\Factory` | |
| Queue (Base Class) | `Illuminate\Queue\Queue` | |
| Queue (Instance) | `Illuminate\Contracts\Queue\Queue` | `queue.connection` |
| Queue | `Illuminate\Queue\QueueManager` | `queue` |
| RateLimiter | `Illuminate\Cache\RateLimiter` | |
| Redirect | `Illuminate\Routing\Redirector` | `redirect` |
| Redis (Instance) | `Illuminate\Redis\Connections\Connection` | `redis.connection` |
| Redis | `Illuminate\Redis\RedisManager` | `redis` |
| Request | `Illuminate\Http\Request` | `request` |
| Response (Instance) | `Illuminate\Http\Response` | |
| Response | `Illuminate\Contracts\Routing\ResponseFactory` | |
| Route | `Illuminate\Routing\Router` | `router` |
| Schedule | `Illuminate\Console\Scheduling\Schedule` | |
| Schema | `Illuminate\Database\Schema\Builder` | |
| Session (Instance) | `Illuminate\Session\Store` | `session.store` |
| Session | `Illuminate\Session\SessionManager` | `session` |
| Storage (Instance) | `Illuminate\Contracts\Filesystem\Filesystem` | `filesystem.disk` |
| Storage | `Illuminate\Filesystem\FilesystemManager` | `filesystem` |
| URL | `Illuminate\Routing\UrlGenerator` | `url` |
| Validator (Instance) | `Illuminate\Validation\Validator` | |
| Validator | `Illuminate\Validation\Factory` | `validator` |
| View (Instance) | `Illuminate\View\View` | |
| View | `Illuminate\View\Factory` | `view` |
| Vite | `Illuminate\Foundation\Vite` | |

## Testing

```php
use App\Service;
use Mockery;
use Mockery\MockInterface;

public function test_something_can_be_mocked(): void
{
    $this->instance(
        Service::class,
        Mockery::mock(Service::class, function (MockInterface $mock) {
            $mock->expects('process');
        })
    );
}
```

## Request Lifecycle

### HTTP and Console Kernels

The incoming request is sent to either the HTTP kernel or the console kernel, using the `handleRequest` or `handleCommand` methods of the application instance, depending on the type of request.

These two kernels are the central location through which all requests flow. The HTTP kernel is an instance of `Illuminate\Foundation\Http\Kernel`.

The HTTP kernel defines an array of **bootstrappers** that run before the request is executed. These configure error handling, logging, detect the application environment, and perform other tasks that need to happen before the request is handled. Typically these classes handle internal Laravel configuration.

The HTTP kernel also passes the request through the application's middleware stack. Middleware handle reading and writing the HTTP session, determining if the application is in maintenance mode, verifying the CSRF token, and more.

The HTTP kernel's `handle` method is simple: it receives a `Request` and returns a `Response`. Think of the kernel as a black box that represents your entire application. Feed it HTTP requests and it returns HTTP responses.

### Service Providers

One of the most important kernel bootstrapping actions is loading the **service providers** for your application. Service providers bootstrap the framework's components, such as the database, queue, validation, and routing.

Laravel iterates through this list of providers and instantiates each of them. After instantiating the providers, the `register` method is called on all of them. Then, once all providers have been registered, the `boot` method is called on each provider. This is so service providers may depend on every container binding being registered and available by the time their `boot` method is executed.

Essentially every major Laravel feature is bootstrapped and configured by a service provider. They are the most important aspect of the Laravel bootstrap process.

The framework internally uses dozens of service providers, and you can create your own. User-defined and third-party service providers are listed in `bootstrap/providers.php`.

### Routing

Once the application has been bootstrapped and all service providers have been registered, the `Request` is handed off to the router for dispatching. The router dispatches the request to a route or controller, and runs any route-specific middleware.

### Middleware

Middleware provide a convenient mechanism for filtering or examining HTTP requests entering your application.

For example, Laravel includes middleware that verifies if the user is authenticated. If not, the middleware redirects to the login screen. If the user is authenticated, the request proceeds further into the application.

Some middleware are assigned to all routes, like `PreventRequestsDuringMaintenance`, while some are only assigned to specific routes or route groups.

If the request passes through all of the matched route's assigned middleware, the route or controller method is executed and the response is sent back through the route's chain of middleware.

## Contracts

Laravel **contracts** are a set of PHP interfaces defining core framework services (e.g. mail, cache, queue). They provide a stable, consistent API for implementing, testing, and swapping components, allowing for loose coupling through dependency injection.

- **Definition:** Interfaces located in `Illuminate\Contracts`.
- **Purpose:** Define required methods for a component, so different implementations can be used without changing the consuming code.
- **Usage:** Dependency injection within the service container, such as in controller constructors.

**Benefits:**

- **Loose coupling:** Code relies on interfaces, not concrete classes.
- **Consistency and testing:** Ensures a standard structure across the framework and simplifies unit testing, especially for packages.
- **Interchangeability:** Easily swap implementations (e.g. change cache drivers).

**Contracts vs facades:** Facades offer a simple, static-like syntax for convenience. Contracts provide explicit dependencies for better architecture and testing.

## References

- [illuminate/contracts](https://github.com/illuminate/contracts)
