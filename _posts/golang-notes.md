---
title: 'Golang Notes'
description: 'Golang Concurrency Patterns'
category: Interviewing
author: 'John Mason'
date: '2026-07-15 23:54'
---

## Golang Style Guide

- [Google Go Style Guide](https://google.github.io/styleguide/go)
- [Style decisions](https://google.github.io/styleguide/go/decisions) (subordinate to the core style guide; link in code reviews)

| Kind | Meaning |
| --- | --- |
| Canonical | Establishes prescriptive and enduring rules |
| Normative | Intended to establish consistency |
| Idiomatic | Common and familiar (pattern easy to recognise) |

## Style Principles (CSCM)

### 1. Clarity

What is the code actually doing?

- Use more descriptive variable names
- Add additional commentary
- Break up the code with whitespace and comments
- Refactor into separate functions/methods to make it more modular
- **Why** is the code doing what it does (readability)? The rationale is often sufficiently communicated by names of variables, functions, methods, or packages. Where it is not, add commentary
- A nuance in the language
- A nuance of business logic — code that stands out (e.g. an unfamiliar pattern) often needs this

### 2. Simplicity

Accomplishes its goal in the most simple way possible, both in terms of behavior and performance.

- Easy to read from top to bottom
- Does not assume that you already know what it is doing
- Does not assume that you can memorize all of the preceding code
- Does not have unnecessary levels of abstraction
- Does not have names that call attention to something mundane
- Makes the propagation of values and decisions clear to the reader
- Has comments that explain **why**, not **what**, the code is doing (to avoid future deviation)
- Has documentation that stands on its own
- Has useful errors and useful test failures
- May often be mutually exclusive with “clever” code

Tradeoffs can arise between **code simplicity** and **API usage simplicity**.

When code needs complexity, add it deliberately. This is typically necessary if additional performance is required, or where there are multiple disparate customers of a particular library or service.

Complexity may be justified, but it should come with accompanying documentation so that clients and future maintainers can understand and navigate it.

If code turns out to be very complex when its purpose should be simple, that is often a signal to revisit the implementation.

#### Least mechanism

1. Aim to use a core language construct
2. If there isn’t one, look for a tool within the standard library
3. Consider whether there is a core library in the Google codebase that is sufficient before introducing a new dependency or creating your own

### 3. Concision

High signal-to-noise ratio. It is easy to discern the relevant details, and the naming and structure guide the reader through these details.

- Repetitive code (e.g. table-driven testing factors out common code). When considering multiple ways to structure code, pick the way that makes important details the most apparent (common constructions and idioms)

```go
// Good:
if err := doSomething(); err != nil { }
```

Avoid:

- Extraneous syntax
- Opaque names
- Unnecessary abstraction
- Whitespace noise

### 4. Maintainability

Maintainable code:

- Is easy for a future programmer to modify correctly
- Has APIs structured so they can grow gracefully
- Is clear about the assumptions it makes, and chooses abstractions that map to the **structure of the problem**, not the structure of the code
- Avoids unnecessary coupling and doesn’t include unused features
- Has a comprehensive test suite so promised behaviors are maintained and important logic is correct, with clear, actionable diagnostics on failure

When using abstractions like interfaces and types — which by definition remove information from the context in which they are used — ensure they provide sufficient benefit.

```go
// Good:
u, err := db.UserByID(userID)
if err != nil {
    return fmt.Errorf("invalid origin user: %s", err)
}
user = u

// Good:
// Gregorian leap years aren't just year%4 == 0.
// See https://en.wikipedia.org/wiki/Leap_year#Algorithm.
var (
    leap4   = year%4 == 0
    leap100 = year%100 == 0
    leap400 = year%400 == 0
)
leap := leap4 && (!leap100 || leap400)
```

- Account for edge cases properly
- Predictable names are another feature of maintainable code
- Minimize dependencies (both implicit and explicit)
- When considering how to structure or write code, think through ways it may evolve. If a given approach is more conducive to easier and safer future changes, that is often a good trade-off, even if it means a slightly more complicated design

### 5. Consistency

Consistent code looks, feels, and behaves like similar code throughout the broader codebase, within a team or package, and even within a single file.

Consistency does not override the principles above, but if a tie must be broken, it is often beneficial to break it in favor of consistency.

Consistency within a **package** is often the most immediately important level. It is jarring if the same problem is approached in multiple ways throughout a package, or if the same concept has many names within a file. Even this should not override documented style principles or global consistency.

#### Formatting

All Go source files must conform to the format outputted by `gofmt`. This format is enforced by a presubmit check in the Google codebase.

Generated code should generally also be formatted (e.g. by using `format.Source`), as it is also browsable in Code Search.

#### MixedCaps

Go source code uses `MixedCaps` or `mixedCaps` (camel case) rather than underscores (snake case) when writing multi-word names.

This applies even when it breaks conventions in other languages. For example, a constant is `MaxLength` (not `MAX_LENGTH`) if exported and `maxLength` (not `max_length`) if unexported.

Local variables are considered **unexported** for the purpose of choosing the initial capitalization.

#### Line length

There is no fixed line length for Go source code. If a line feels too long, prefer refactoring instead of splitting it. If it is already as short as it is practical to be, allow it to remain long.

Do **not** split a line:

- Before an indentation change (e.g. function declaration, conditional)
- To make a long string (e.g. a URL) fit into multiple shorter lines

#### Naming

Naming is more art than science. In Go, names tend to be somewhat shorter than in many other languages, but the same general guidelines apply. Names should:

- Not feel repetitive when they are used
- Take the context into consideration
- Not repeat concepts that are already clear

More specific guidance: [style decisions](https://google.github.io/styleguide/go/decisions).

#### Local consistency

Where the style guide has nothing to say about a particular point of style, authors may choose the style they prefer, unless nearby code (usually the same file or package, sometimes a team or project directory) has taken a consistent stance.

**Valid** local style considerations:

- Use of `%s` or `%v` for formatted printing of errors
- Usage of buffered channels in lieu of mutexes

**Invalid** local style considerations:

- Line length restrictions for code
- Use of assertion-based testing libraries

If the local style disagrees with the style guide but the readability impact is limited to one file, it will generally be surfaced in a code review for which a consistent fix would be outside the scope of the CL. At that point, file a bug to track the fix.

If a change would worsen an existing style deviation, expose it in more API surfaces, expand the number of files in which the deviation is present, or introduce an actual bug, then local consistency is **no longer** a valid justification for violating the style guide for new code. Clean up the existing codebase in the same CL, refactor in advance, or find an alternative that at least does not make the local problem worse.

## Decisions

### Naming

- Underscores
- Package names
- Receiver names
- Constant names
- Initialisms (`URL`)
- Getters
- Variable names (scope)
- Repetition:
  - name vs type
  - package vs exported name
  - external context vs local names

```go
// Good:
// In package "ads/targeting/revenue/reporting"
type Report struct{}

func (p *Project) Name() string
```

### Commentary

- Comment line length
- Doc comments (GoDoc)
- Comment sentences
- Named result parameters
- Package comments

### Imports

- Import renaming
- Import grouping
- Import blank
- Import dot

### Errors

- Returning errors
- Error strings not capitalised
- Handle errors
- In-band errors
- Indent error flow

Go’s support for multiple return values provides a better solution (see the [Effective Go section on multiple returns](https://go.dev/doc/effective_go#multiple-returns)).

Instead of requiring clients to check for an in-band error value, a function should return an additional value to indicate whether its other return values are valid. This return value may be an `error` or a `boolean` when no explanation is needed, and should be the **final** return value.

```go
// Good:
// Lookup returns the value for key or ok=false if there is no mapping for key.
func Lookup(key string) (value string, ok bool)

// Good:
value, ok := Lookup(key)
if !ok {
    return fmt.Errorf("no value for %q", key)
}
return Parse(value)
```

### Language

- Literal formatting
- Matching braces
- Cuddled braces

```go
// Good:
good := []*Type{
    { // Not cuddled — no whitespace between braces
        Field: "value",
    },
    {
        Field: "value",
    },
}
```

- Repeated type names
- Zero-value fields — omit from structure literals
- Concise (struct) & explicit field names
- `nil` slices
- Indentation confusion
- Function formatting
- Conditionals and loops
- Copying
- Don’t panic
- `Must` functions — early on function startup
- Goroutine lifetimes — [slides](https://drive.google.com/file/d/1nPdvhB0PutEJzdCq5ms6UI58dp50fcAN/view)

```go
// Good:
func (w *Worker) Run(ctx context.Context) error {
    var wg sync.WaitGroup
    // ...
    for item := range w.q {
        // process returns at latest when the context is cancelled.
        wg.Add(1)
        go func() {
            defer wg.Done()
            process(ctx, item)
        }()
    }
    // ...
    wg.Wait()  // Prevent spawned goroutines from outliving this function.
}
```

There are other variants of the above that use raw signal channels like `chan struct{}`, synchronized variables, condition variables, and more. The important part is that the goroutine’s end is evident for subsequent maintainers.

In contrast, the following code is careless about when its spawned goroutines finish:

```go
// Bad:
func (w *Worker) Run() {
    for item := range w.q {
        // process returns when it finishes, if ever, possibly not cleanly
        // handling a state transition or termination of the Go program itself.
        go process(item)
    }
}
```

This code may look OK, but there are several underlying problems:

- The code probably has undefined behavior in production, and the program may not terminate cleanly, even if the operating system releases the resources
- The code is difficult to test meaningfully due to the code’s indeterminate lifecycle
- The code may leak resources as described above

See also:

- Never start a goroutine without knowing how it will stop
- Rethinking Classical Concurrency Patterns: [slides](https://drive.google.com/file/d/1nPdvhB0PutEJzdCq5ms6UI58dp50fcAN/view), video
- When Go programs end
- Documentation Conventions: Contexts

### Interfaces

Focus on the required **behavior** rather than just an abstract named pattern.

### Generics

Generics (formally called “Type Parameters”) are allowed where they fulfill your business requirements.

In many applications, a conventional approach using existing language features (slices, maps, interfaces, and so on) works just as well without the added complexity, so be wary of premature use. See the discussion on **least mechanism**. Pass values.

### Receiver type

A [method receiver](https://go.dev/ref/spec#Method_declarations) can be passed either as a value or a pointer, just as if it were a regular function parameter.

The choice between the two is based on which **method set(s)** the method should be a part of.

**Correctness wins over speed or simplicity.** There are cases where you must use a pointer value. In other cases, pick pointers for large types or as future-proofing if you don’t have a good sense of how the code will grow, and use values for simple plain old data.

Also: `switch` and `break`.

### Synchronous functions

### Type aliases

### Common libraries

Flags must only be defined in `package main` or equivalent.

### Logging

`log.Fatal`

### Contexts

When passed to a function or method, `context.Context` is always the first parameter.

`crypto/rand`

### Useful test failures

It should be possible to diagnose a test’s failure without reading the test’s source. Tests should fail with helpful messages detailing:

- What caused the failure
- What inputs resulted in an error
- The actual result
- What was expected

### Assertion libraries

Do not create “assertion libraries” as helpers for testing.

- Identify the function
- Identify the input
- Got before want
- Full structure comparisons
- Compare stable results
- Keep going
- Equality comparison and diffs
- Level of detail
- Print diffs
- Test error semantics

### Test structure

- Subtests
- Table-driven tests
- Data-driven test cases
- Test helpers
- Test package
- Tests in the same package
- Tests in a different package
- Use package `testing`

```go
// Good:
func TestTranslate(t *testing.T) {
    data := []struct {
        name, desc, srcLang, dstLang, srcText, wantDstText string
    }{
        {
            name:        "hu=en_bug-1234",
            desc:        "regression test following bug 1234. contact: cleese",
            srcLang:     "hu",
            srcText:     "cigarettát és egy öngyújtót kérek",
            dstLang:     "en",
            wantDstText: "cigarettes and a lighter please",
        }, // ...
    }
    for _, d := range data {
        t.Run(d.name, func(t *testing.T) {
            got := Translate(d.srcLang, d.dstLang, d.srcText)
            if got != d.wantDstText {
                t.Errorf("%s\nTranslate(%q, %q, %q) = %q, want %q",
                    d.desc, d.srcLang, d.dstLang, d.srcText, got, d.wantDstText)
            }
        })
    }
}
```

Use **table-driven tests** when many different test cases can be tested using similar testing logic.

### Non-decisions

A style guide cannot enumerate positive prescriptions for all matters, nor all matters about which it does not offer an opinion. The readability community has previously debated and not achieved consensus on:

- Local variable initialization with zero value. `var i int` and `i := 0` are equivalent. See also initialization best practices
- Empty composite literal vs. `new` or `make`. `&File{}` and `new(File)` are equivalent. So are `map[string]bool{}` and `make(map[string]bool)`. See also composite declaration best practices
- `got`, `want` argument ordering in `cmp.Diff` calls. Be locally consistent, and include a legend in your failure message
- `errors.New` vs `fmt.Errorf` on non-formatted strings. `errors.New("foo")` and `fmt.Errorf("foo")` may be used interchangeably

---

## Concurrency

**Brian C. Mills — Rethinking Classical Concurrency Patterns**

- [Slides](https://drive.google.com/file/d/1nPdvhB0PutEJzdCq5ms6UI58dp50fcAN/view)

## Concurrency Patterns (Rob Pike)

- [Talk (YouTube)](https://www.youtube.com/watch?v=f6kdp27TYZs)
- [Slides](https://go.dev/talks/2012/concurrency.slide#1)

Concurrency is not parallelism. A program on a single processor can still be concurrent.

Tony Hoare, 1978 CSP paper.

- Go channel as a first-class value

```go
func main() {
    go boring("boring!") // goroutine — independently running function
}

func boring(msg string) {
    for i := 0; ; i++ {
        fmt.Println(msg, i)
        time.Sleep(time.Duration(rand.Intn(1e3)) * time.Millisecond)
    }
}
```

A goroutine has its own stack. It expands and reduces in size as needed — it is not a thread.

### Channels

Channels communicate between goroutines and synchronise.

```go
func main() {
    c := make(chan string)
    go boring("boring!", c)
    for i := 0; i < 5; i++ {
        fmt.Printf("You say: %q\n", <-c) // receive expression is just a value; also blocking
    }
    fmt.Println("You're boring; I'm leaving.")
}

func boring(msg string, c chan string) {
    for i := 0; ; i++ {
        c <- fmt.Sprintf("%s %d", msg, i) // expression to be sent can be any suitable value; blocking
        time.Sleep(time.Duration(rand.Intn(1e3)) * time.Millisecond)
    }
}
```

Buffered channels don’t synchronise on send — that is the exception.

### The Go approach

Don’t communicate by sharing memory; share memory by communicating.

### Generator

A function that returns a channel. Channels are first-class values, just like strings or integers.

```go
c := boring("boring!") // function returning a channel
for i := 0; i < 5; i++ {
    fmt.Printf("You say: %q\n", <-c)
}
fmt.Println("You're boring; I'm leaving.")

func boring(msg string) <-chan string { // returns receive-only channel of strings
    c := make(chan string)
    go func() { // launch the goroutine from inside the function
        for i := 0; ; i++ {
            c <- fmt.Sprintf("%s %d", msg, i)
            time.Sleep(time.Duration(rand.Intn(1e3)) * time.Millisecond)
        }
    }()
    return c // return the channel to the caller
}
```

We can have more instances of the service:

```go
func main() {
    joe := boring("Joe")
    ann := boring("Ann")
    for i := 0; i < 5; i++ {
        fmt.Println(<-joe)
        fmt.Println(<-ann)
    }
    fmt.Println("You're both boring; I'm leaving.")
}
```

### Multiplexing

Let whoever is ready talk.

```go
func fanIn(input1, input2 <-chan string) <-chan string {
    c := make(chan string)
    go func() { for { c <- <-input1 } }()
    go func() { for { c <- <-input2 } }()
    return c
}

func main() {
    c := fanIn(boring("Joe"), boring("Ann"))
    for i := 0; i < 10; i++ {
        fmt.Println(<-c)
    }
    fmt.Println("You're both boring; I'm leaving.")
}
```

### Restoring sequencing

Send a channel on a channel, making a goroutine wait its turn.

Receive all messages, then enable them again by sending on a private channel.

First define a message type that contains a channel for the reply:

```go
type Message struct {
    str  string
    wait chan bool
}
```

Each speaker must wait for a go-ahead:

```go
for i := 0; i < 5; i++ {
    msg1 := <-c
    fmt.Println(msg1.str)
    msg2 := <-c
    fmt.Println(msg2.str)
    msg1.wait <- true
    msg2.wait <- true
}

waitForIt := make(chan bool) // shared between all messages
c <- Message{fmt.Sprintf("%s: %d", msg, i), waitForIt}
time.Sleep(time.Duration(rand.Intn(2e3)) * time.Millisecond)
<-waitForIt
```

### Select

A control structure unique to concurrency. The reason channels and goroutines are built into the language.

`select` is another way to handle multiple channels. It is like a `switch`, but each case is a communication:

- All channels are evaluated
- Selection blocks until one communication can proceed, which then does
- If multiple can proceed, `select` chooses pseudo-randomly
- A `default` clause, if present, executes immediately if no channel is ready

```go
select { // like a switch; blocks until a communication is ready
case v1 := <-c1:
    fmt.Printf("received %v from c1\n", v1)
case v2 := <-c2:
    fmt.Printf("received %v from c2\n", v2)
case c3 <- 23:
    fmt.Printf("sent %v to c3\n", 23)
default: // without default, select is blocking
    fmt.Printf("no one was ready to communicate\n")
}
```

Rewrite `fanIn` with `select`:

```go
func fanIn(input1, input2 <-chan string) <-chan string {
    c := make(chan string)
    go func() {
        for {
            select {
            case s := <-input1:
                c <- s
            case s := <-input2:
                c <- s
            }
        }
    }()
    return c
}
```

### Timeout using select

`time.After` returns a channel that blocks for the specified duration. After the interval, the channel delivers the current time, once.

```go
func main() {
    c := boring("Joe")
    for {
        select {
        case s := <-c:
            fmt.Println(s)
        case <-time.After(1 * time.Second):
            fmt.Println("You're too slow.")
            return
        }
    }
}
```

Timeout for the **whole conversation**: create the timer once, outside the loop. (The previous program timed out each message.)

```go
func main() {
    c := boring("Joe")
    timeout := time.After(5 * time.Second)
    for {
        select {
        case s := <-c:
            fmt.Println(s)
        case <-timeout:
            fmt.Println("You talk too much.")
            return
        }
    }
}
```

### Quit channel

Turn this around and tell Joe to stop when we’re tired of listening:

```go
quit := make(chan bool)
c := boring("Joe", quit)
for i := rand.Intn(10); i >= 0; i-- {
    fmt.Println(<-c)
}
quit <- true

select {
case c <- fmt.Sprintf("%s: %d", msg, i):
    // do nothing
case <-quit:
    return
}
```

#### Receive on quit channel

How do we know it’s finished? Wait for it to tell us it’s done — receive on the quit channel:

```go
quit := make(chan string)
c := boring("Joe", quit)
for i := rand.Intn(10); i >= 0; i-- {
    fmt.Println(<-c)
}
quit <- "Bye!"
fmt.Printf("Joe says: %q\n", <-quit)

select {
case c <- fmt.Sprintf("%s: %d", msg, i):
    // do nothing
case <-quit:
    cleanup()
    quit <- "See you!"
    return
}
```

### Daisy-chain

```go
func f(left, right chan int) {
    left <- 1 + <-right
}

func main() {
    const n = 10000 // fast gophers!!
    leftmost := make(chan int)
    right := leftmost
    left := leftmost
    for i := 0; i < n; i++ {
        right = make(chan int)
        go f(left, right)
        left = right
    }
    go func(c chan int) { c <- 1 }(right)
    fmt.Println(<-leftmost)
}
```

### Google Search examples

A channel is a first-class value and can be used as a mock.

```go
func Google(query string) (results []Result) {
    c := make(chan Result)
    go func() { c <- Web(query) }()
    go func() { c <- Image(query) }()
    go func() { c <- Video(query) }()

    for i := 0; i < 3; i++ {
        result := <-c
        results = append(results, result)
    }
    return
}
```

Don’t wait for slow servers. No locks. No condition variables. No callbacks like Node.js.

```go
c := make(chan Result)
go func() { c <- Web(query) }()
go func() { c <- Image(query) }()
go func() { c <- Video(query) }()

timeout := time.After(80 * time.Millisecond)
for i := 0; i < 3; i++ {
    select {
    case result := <-c:
        results = append(results, result)
    case <-timeout:
        fmt.Println("timed out")
        return
    }
}
return
```

#### Fan-in with timeout — avoid discarding slow servers

**Q:** How do we avoid discarding results from slow servers?

**A:** Replicate the servers. Send requests to multiple replicas, and use the first response.

```go
func First(query string, replicas ...Search) Result {
    c := make(chan Result)
    searchReplica := func(i int) { c <- replicas[i](query) }
    for i := range replicas {
        go searchReplica(i)
    }
    return <-c
}

c := make(chan Result)
go func() { c <- First(query, Web1, Web2) }()
go func() { c <- First(query, Image1, Image2) }()
go func() { c <- First(query, Video1, Video2) }()
timeout := time.After(80 * time.Millisecond)
for i := 0; i < 3; i++ {
    select {
    case result := <-c:
        results = append(results, result)
    case <-timeout:
        fmt.Println("timed out")
        return
    }
}
return
```

### Summary

In just a few simple transformations we used Go's concurrency primitives to convert a program that is:

- slow
- sequential
- failure-sensitive

into one that is:

- fast
- concurrent
- replicated
- robust

There are endless ways to use these tools, many presented elsewhere:

- Chatroulette toy: [go.dev/s/chat-roulette](https://go.dev/s/chat-roulette)
- Load balancer: [go.dev/s/load-balancer](https://go.dev/s/load-balancer)
- Concurrent prime sieve: [go.dev/s/prime-sieve](https://go.dev/s/prime-sieve)
- Concurrent power series (by McIlroy): [go.dev/s/power-series](https://go.dev/s/power-series)

### Don’t overdo it

They’re fun to play with, but don’t overuse these ideas.

Goroutines and channels are big ideas. They’re tools for program construction.

But sometimes all you need is a reference counter. Go has `sync` and `sync/atomic` packages that provide mutexes, condition variables, etc. They provide tools for smaller problems.

Often, these things will work together to solve a bigger problem. Always use the right tool for the job.

## Conclusions

Goroutines and channels make it easy to express complex operations dealing with:

- multiple inputs
- multiple outputs
- timeouts
- failure

And they’re fun to use.

## References

- Go Home Page: [go.dev](https://go.dev)
- Go Tour: [go.dev/tour](https://go.dev/tour)
- Package documentation: [go.dev/pkg](https://pkg.go.dev)
- Articles: [go.dev/doc](https://go.dev/doc)
- Concurrency is not parallelism: [go.dev/s/concurrency-is-not-parallelism](https://go.dev/s/concurrency-is-not-parallelism)
- Microservice patterns: [19 essential microservices patterns](https://www.designgurus.io/blog/19-essential-microservices-patterns-for-system-design-interviews)

Rob Pike, Google — [go.dev](https://go.dev)

## Go 1.26 (February 2026)

Go 1.26 is the latest stable release as of February 2026. It focuses on automated modernization, performance optimizations, and enhanced security.

Key features include advanced `go fix` code modernization, experimental SIMD support (`simd`/`archsimd`), and a new garbage collector ("Green Tea") enabling higher efficiency, particularly with AVX-512.

### Key features

- **Automated modernization:** The `go fix` command has been rewritten to act as a "modernizer," automatically identifying and fixing code to use newer language features, including a `//go:fix inline` directive.
- **Experimental SIMD (`simd`/`archsimd`):** Introduces access to "single instruction, multiple data" operations for specialized performance optimization.
- **Runtime/secret management:** An experimental `runtime/secret` package facilitates secure erasure of temporary data used in cryptographic operations.
- **Compiler and linker upgrades:** Further refinements to the compiler and linker (building on Go 1.25's slice optimization) improve general performance.

### Recent prior releases (Go 1.25–1.24)

- **"Green Tea" garbage collector (Go 1.25/1.26):** Reduces GC overhead by 10%–40%, with further improvements slated for AVX-512 in 1.26.
- **Container-aware `GOMAXPROCS` (Go 1.25):** The runtime better detects CPU limits in Docker/Kubernetes, simplifying concurrency management.
- **Generic type aliases and map performance (Go 1.24):** Fully supports parameterized type aliases and includes a redesigned, faster map implementation.
- **FIPS 140-3 compliance (Go 1.24):** Introduces the Go Cryptographic Module for improved security compliance.

### Standard library enhancements

- **New packages:** Addition of `crypto/hpke`, `crypto/mlkem/mlkemtest`, and `testing/cryptotest`.
- **Iterators:** Improvements to the `bytes` package with new iterator functions like `Lines` and `SplitSeq`.
 
