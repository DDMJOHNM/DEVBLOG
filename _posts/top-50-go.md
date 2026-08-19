---
title: 'Top 50 Go'
description: 'Go interview questions covering language basics, concurrency, interfaces, and the runtime'
category: Interviewing
author: 'John Mason'
date: '2026-08-19 15:59'
---

Interview notes for Go (1.22+). Numbered questions with short answers and examples.

- [Go by Example](https://gobyexample.com/)
- [roadmap.sh Golang questions](https://roadmap.sh/questions/golang)

## Beginner

## 1. What is Go?

Go is a compiled, statically typed language developed at Google to address slow compilation and complex dependency management.

## 2. What is the difference between `var` and `:=`?

- `var` is an explicit declaration. It can be used at package or function scope, and the type can be stated or inferred.
- `:=` is short variable declaration. It is only valid inside functions, infers the type, and must initialize at least one new variable.

## 3. What is a zero value?

The default value assigned to a declared but uninitialized variable. Examples: `0` for numeric types, `false` for `bool`, `""` for `string`, and `nil` for pointers, slices, maps, channels, functions, and interfaces.

## 4. How are packages and modules different?

- A **package** is a collection of source files in one directory that share the same `package` name.
- A **module** is a collection of packages versioned together and tracked by a `go.mod` file.

## 5. What are the primary data types?

Numeric types (integers and floats), `bool`, and `string`, plus derived types: array, slice, map, struct, pointer, channel, function, and interface.

## 6. How do you export functions?

Capitalize the first letter of the identifier. `Foo` is exported (visible outside the package); `foo` is not.

## 7. What is a pointer?

A variable that stores the memory address of another value. `&x` takes the address of `x`; `*p` dereferences pointer `p`.

## 8. What is the role of `main`?

`func main()` in package `main` is the program's entry point.

## 9. Explain the `init()` function.

A special function that runs automatically before `main()` (and before other packages use this package) to initialize package state. A file may have more than one `init`.

## 10. What are raw versus interpreted string literals?

A string literal is either double-quoted `""` (interpreted) or backtick-quoted `` ` ` `` (raw).

- Interpreted literals support escape sequences (`\n`, `\t`) and cannot span multiple lines.
- Raw string literals do not process escapes, cannot contain backticks, and can span multiple lines.

## 11. How do you handle errors in Go?

Go uses explicit error checking. Functions typically return an `error` as the last result, and callers check it immediately:

```go
result, err := doWork()
if err != nil {
    return err
}
```

## 12. Can Go have multiple return values?

Yes. Functions often return a result and an error:

```go
func divide(a, b int) (int, error) {
    if b == 0 {
        return 0, errors.New("division by zero")
    }
    return a / b, nil
}
```

## 13. What is the difference between `GOROOT` and `GOPATH`?

- `GOROOT` is where the Go toolchain and standard library live.
- `GOPATH` was the old workspace for projects. Modules (`go.mod`) largely superseded it; `GOPATH` is now mainly a cache location (`pkg/mod`).

## 14. What is the `range` keyword?

Used to iterate over elements in arrays, slices, strings, maps, or channels:

```go
for i, v := range nums {
    fmt.Println(i, v)
}
```

## 15. What is a struct?

A composite type that groups fields of different types into a single unit:

```go
type User struct {
    Name string
    Age  int
}
```

## 16. How do you create a constant?

Use `const`. Values must be known at compile time:

```go
const MaxRetries = 3
```

## 17. What is the difference between an array and a slice?

Arrays have a fixed size that is part of the type (`[5]int`). Slices are dynamic views into an underlying array (`[]int`) with a length and capacity.

```go
var a [5]int      // array
s := []int{1, 2}  // slice
```

See [Go by Example: Arrays](https://gobyexample.com/arrays).

## 18. Explain the `iota` keyword.

A predeclared identifier that increments by 1 in a `const` block, starting at 0. Useful for enumerations:

```go
type Season int

const (
    Spring Season = iota
    Summer
    Autumn
    Winter
)

s := Summer
fmt.Println(s) // 1
```

See [constants and iota](https://dlintw.github.io/gobyexample/public/constants-and-iota.html).

## 19. What is type conversion?

Explicitly changing a value from one type to another. Go has no implicit numeric conversion:

```go
x := 1
f := float64(x)
```

## 20. Is Go an object-oriented language?

Not in the class/inheritance sense. Go prefers composition and interfaces over classes and inheritance.

## Concurrency and intermediate

## 21. What is a goroutine?

A lightweight concurrent function managed by the Go runtime, not by the OS as a 1:1 thread. Start one with `go f()`.

## 22. Explain channels.

Typed pipes for communication and synchronization between goroutines. Send with `ch <- v`, receive with `v := <-ch`.

## 23. Buffered vs unbuffered channels?

- **Unbuffered** (`make(chan int)`): send blocks until a receiver is ready (and vice versa).
- **Buffered** (`make(chan int, n)`): send blocks only when the buffer is full; receive blocks when it is empty.

## 24. What is the `select` statement?

Multiplexes multiple channel operations, similar to a switch over channels. It blocks until one case can run; a `default` case makes it non-blocking.

```go
select {
case msg := <-ch:
    fmt.Println(msg)
case <-time.After(time.Second):
    fmt.Println("timeout")
}
```

## 25. How do you stop a goroutine?

Goroutines cannot be killed from the outside. Signal them to exit with a done channel or `context.Context` cancellation, and return from the function.

## 26. What is a mutex?

A mutual exclusion lock that prevents concurrent access to shared data.

- `sync.Mutex`: exclusive lock for all access.
- `sync.RWMutex`: many concurrent readers, or one writer.

## 27. What is a race condition?

When two or more goroutines access the same memory concurrently and at least one access is a write, without synchronization.

## 28. How do you detect race conditions?

Use Go's built-in race detector (ThreadSanitizer):

```bash
go run -race .
go test -race ./...
```

It instruments memory access at runtime and reports unsynchronized concurrent reads and writes. Look for check-then-act, read-modify-write (`counter++`), and shared mutable state without a lock or channel.

## 29. What is an interface?

A set of method signatures. A type satisfies an interface by implementing those methods.

```go
type Reader interface {
    Read(p []byte) (n int, err error)
}
```

## 30. How are interfaces implemented in Go?

Implicitly. If a type has the required methods, it implements the interface. There is no `implements` keyword.

## 31. What is a type assertion?

A way to retrieve the concrete value from an interface:

```go
s, ok := val.(string)
if !ok {
    // val is not a string
}
```

## 32. What is type embedding?

Including one type inside another so the outer type promotes the inner type's fields and methods. This is composition, not inheritance:

```go
type Logger struct{}

func (Logger) Log(msg string) {}

type Server struct {
    Logger
}
```

## 33. What is a receiver function?

A method: a function with a receiver, associated with a type:

```go
func (u User) Name() string {
    return u.name
}
```

## 34. Value vs pointer receivers?

- **Pointer receivers** (`func (u *User)`) can modify the receiver and avoid copying large structs.
- **Value receivers** (`func (u User)`) operate on a copy. If any method uses a pointer receiver, typically all methods on that type should.

## 35. What is the `defer` keyword?

Schedules a function call to run just before the surrounding function returns. Multiple defers run in LIFO order. Common for `Close()`, `Unlock()`, and cleanup.

## 36. Explain `panic` and `recover`.

- `panic` stops normal execution and starts unwinding the stack.
- `recover` is only useful inside `defer`; it stops the panic and returns the panic value. Prefer errors for expected failures; reserve panic for truly unrecoverable states.

## 37. What are anonymous functions?

Functions without a name, often used as closures:

```go
add := func(a, b int) int {
    return a + b
}
```

## 38. What is an empty struct (`struct{}`) used for?

It occupies zero bytes. Typical uses: signaling on channels (`chan struct{}`), implementing sets (`map[T]struct{}`), and embedding as a marker type.

## 39. How do you write a unit test?

Create a file named `*_test.go` in the same package (or `package foo_test` for an external test) and use `testing.T`:

```go
func TestAdd(t *testing.T) {
    got := Add(1, 2)
    if got != 3 {
        t.Fatalf("Add(1, 2) = %d, want 3", got)
    }
}
```

Run with `go test`.

## Advanced architecture and runtime

## 40. Explain the G-M-P scheduler.

Go's scheduler maps **G** (goroutines) onto **P** (logical processors / scheduler contexts) which run on **M** (OS threads). This M:N model lets many goroutines share a smaller set of OS threads.

## 41. What is escape analysis?

The compiler decides whether a variable can live on the stack or must "escape" to the heap (for example because a pointer to it is returned or stored). Heap allocation is slower and visible to the garbage collector; `go build -gcflags="-m"` prints escape decisions.

## 42. How does the garbage collector work?

Go uses a concurrent tri-color mark-and-sweep collector. It marks reachable objects while the program runs, then sweeps unmarked memory, aiming for short stop-the-world pauses.

## 43. What is inlining?

A compiler optimization that replaces a function call with the function body to reduce call overhead. Small, simple functions are typical inline candidates.

## 44. How do you use the `context` package?

Pass deadlines, cancellation, and request-scoped values across API boundaries:

```go
ctx, cancel := context.WithTimeout(context.Background(), 2*time.Second)
defer cancel()

req, _ := http.NewRequestWithContext(ctx, http.MethodGet, url, nil)
```

Downstream work should select on `ctx.Done()` and return `ctx.Err()`.

## 45. What is reflection?

Examining and manipulating types and values at runtime via the `reflect` package (`reflect.TypeOf`, `reflect.ValueOf`). Useful for encoding, ORMs, and generic helpers; it is slower and less type-safe than ordinary code.

## 46. How do you handle JSON?

Use `encoding/json`: `json.Marshal` to encode, `json.Unmarshal` to decode. Struct field tags control names:

```go
type User struct {
    Name string `json:"name"`
    Age  int    `json:"age"`
}
```

## 47. What is `sync.Pool`?

A concurrent pool of reusable objects. `Get` / `Put` reduce allocation and GC pressure for short-lived, frequently allocated items (for example buffers). Cached items may be discarded at any time, so do not store important state there.

## 48. How do you implement a graceful shutdown?

Listen for signals (`os.Interrupt`, `SIGTERM`), cancel a root context, stop accepting new work, and wait for in-flight goroutines (often with `sync.WaitGroup` or `errgroup`) before exiting. For HTTP, use `http.Server.Shutdown`.

## 49. Explain range over integers (Go 1.22).

`for i := range n` iterates `i` from `0` to `n-1`:

```go
for i := range 10 {
    fmt.Println(i) // 0 through 9
}
```

## 50. What is `make` vs `new`?

- `new(T)` allocates a zero value of `T` and returns `*T`.
- `make` initializes slices, maps, and channels (the built-in types that need runtime setup) and returns a ready-to-use value, not a pointer.

```go
p := new(int)           // *int, value 0
s := make([]int, 0, 10) // slice with cap 10
m := make(map[string]int)
ch := make(chan int, 1)
```
