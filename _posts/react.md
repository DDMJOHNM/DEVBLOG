---
title: React
description: 'React interview notes'
category: Frontend
author: 'John Mason'
date: '2026-08-19 12:00'
---

## Debounce vs Throttle

| | Debounce | Throttle |
| --- | --- | --- |
| Behavior | Wait until activity stops, then run once | Run at most once per interval |
| Analogy | Elevator waits for everyone to board | Train leaves every N minutes |
| Typical use | Search input, resize "done" | Scroll, mousemove, API rate limits |

```js
function debounce(fn, delay) {
  let id;
  return (...args) => {
    clearTimeout(id);
    id = setTimeout(() => fn(...args), delay);
  };
}

function throttle(fn, limit) {
  let inThrottle = false;
  return (...args) => {
    if (inThrottle) return;
    fn(...args);
    inThrottle = true;
    setTimeout(() => { inThrottle = false; }, limit);
  };
}
```

## Lazy Loading in React

Split code with `React.lazy` and load it inside `Suspense` with a fallback UI.

```jsx
import { lazy, Suspense } from "react";

const Dashboard = lazy(() => import("./Dashboard"));

function App() {
  return (
    <Suspense fallback={<div>Loading…</div>}>
      <Dashboard />
    </Suspense>
  );
}
```

Route-level lazy loading (React Router):

```jsx
const Settings = lazy(() => import("./pages/Settings"));

<Route
  path="/settings"
  element={
    <Suspense fallback={<Spinner />}>
      <Settings />
    </Suspense>
  }
/>
```

Bundlers (Vite/Webpack) emit separate chunks; the chunk loads when the component is first rendered.

For images: `loading="lazy"` or Intersection Observer.

## Valid Parentheses (Stack)

```js
function isValid(s) {
  const stack = [];
  const pairs = { ")": "(", "]": "[", "}": "{" };

  for (const ch of s) {
    if (ch === "(" || ch === "[" || ch === "{") {
      stack.push(ch);
    } else {
      if (stack.pop() !== pairs[ch]) return false;
    }
  }
  return stack.length === 0;
}

// isValid("()[]{}")  → true
// isValid("([)]")    → false
```

Complexity: **O(n)** time, **O(n)** space for the stack.

## `call()`, `apply()`, and `bind()`

All control `this` for a function.

```js
function greet(greeting, punct) {
  return `${greeting}, ${this.name}${punct}`;
}

const user = { name: "Ada" };

// call — invoke now; args as list
greet.call(user, "Hi", "!");   // "Hi, Ada!"

// apply — invoke now; args as array
greet.apply(user, ["Hello", "."]); // "Hello, Ada."

// bind — returns new function with fixed this (and optional partial args)
const bound = greet.bind(user, "Hey");
bound("?");  // "Hey, Ada?"
```

Borrowing methods:

```js
const nums = [1, 2, 3];
Math.max.apply(null, nums);  // 3 — today: Math.max(...nums)
```

React class components (legacy): `this.handleClick = this.handleClick.bind(this)` so handlers keep the instance as `this`.

## React Fiber Architecture

Before Fiber, React reconciled **synchronously** in one pass — long updates could block the main thread and hurt UX.

**Fiber** reworks reconciliation into **units of work** that can be:

- Paused, resumed, and prioritized (user input > animations > off-screen updates)
- Split across frames (concurrent rendering)
- Discarded if a higher-priority update arrives

Each fiber node ≈ one component instance with:

- `type`, `props`, `state`
- Links: `child`, `sibling`, `return` (parent)
- `alternate` (current vs work-in-progress tree)

### Phases

1. **Render** (interruptible): build work-in-progress tree, diff, mark effects
2. **Commit** (synchronous): apply DOM changes, run `useLayoutEffect`, paint, then `useEffect`

Fiber enables Concurrent Features (`startTransition`, `Suspense` for data fetching boundaries, etc.).

## Closures in JavaScript

A **closure** is when a function retains access to variables from its **lexical scope** even after the outer function has returned.

```js
function makeCounter() {
  let count = 0;
  return function () {
    return ++count;
  };
}

const counter = makeCounter();
counter(); // 1
counter(); // 2
```

The inner function “closes over” `count`.

### Common pitfalls

```js
// var in a loop — all closures share same i
for (var i = 0; i < 3; i++) {
  setTimeout(() => console.log(i), 0); // 3, 3, 3
}

// let — new binding per iteration
for (let i = 0; i < 3; i++) {
  setTimeout(() => console.log(i), 0); // 0, 1, 2
}
```

## Closures in Real Projects

Patterns interviewers expect:

1. **Module / private state** — factory or IIFE exposing only a public API; hide tokens or counters
2. **Event handlers & hooks** — `useEffect` callbacks close over props/state from that render; stale closures are a real bug (fix with deps array or refs)
3. **Debounced search / cached fetch** — outer scope holds `timeoutId` or `cache` Map; inner handler reads/writes it
4. **Currying / partial application** — `const logError = logger.bind(null, 'ERROR')` or custom middleware factories
5. **React custom hooks** — `useRef` + closure to keep latest callback without re-subscribing on every render
6. **Once-init singletons** — lazy init guarded by a closed-over `initialized` flag

### Debounced search hook

```js
function useDebouncedValue(value, delay) {
  const [debounced, setDebounced] = useState(value);
  useEffect(() => {
    const id = setTimeout(() => setDebounced(value), delay);
    return () => clearTimeout(id); // closure cleans up previous timer
  }, [value, delay]);
  return debounced;
}
```

## `Promise.all()` vs `Promise.allSettled()`

```js
const p1 = Promise.resolve(1);
const p2 = Promise.reject(new Error("fail"));
const p3 = Promise.resolve(3);

// Promise.all — fails fast on first rejection
await Promise.all([p1, p2, p3]); // rejects with Error("fail")

// Promise.allSettled — always waits for all; never rejects (unless sync throw)
const results = await Promise.allSettled([p1, p2, p3]);
// [
//   { status: "fulfilled", value: 1 },
//   { status: "rejected", reason: Error("fail") },
//   { status: "fulfilled", value: 3 }
// ]
```

| | `Promise.all` | `Promise.allSettled` |
| --- | --- | --- |
| Resolves when | All fulfill | All finish (any outcome) |
| Rejects when | First rejection | Essentially never* |
| Result | Array of values | Array of `{ status, value \| reason }` |

\*Unless a non-promise throws during setup.

Also know:

- `Promise.race` — first settle wins
- `Promise.any` — first fulfillment wins; rejects only if all reject (`AggregateError`)

## Promise APIs in Production

| API | Production use |
| --- | --- |
| `Promise.all` | Parallel independent requests that must all succeed (load dashboard widgets; upload multiple files; fan-out GraphQL) |
| `Promise.allSettled` | Batch jobs where partial failure is OK (send notifications to many users; bulk import rows; report per-item status) |
| `Promise.race` | Timeouts: `Promise.race([fetch(url), sleep(5000)])`; first config source wins |
| `Promise.any` | Fallback CDNs / mirrors — use first healthy endpoint |
| `async/await` + `try/catch` | Readable service layer; one failure path |
| Sequential `for await` | When order or rate limits matter (pagination chains) |

### Timeout wrapper

```js
function withTimeout(promise, ms) {
  return Promise.race([
    promise,
    new Promise((_, reject) =>
      setTimeout(() => reject(new Error("Timeout")), ms)
    ),
  ]);
}
```

### Graceful degradation

```js
const [user, prefs] = await Promise.allSettled([
  fetchUser(id),
  fetchPrefs(id),
]);
if (user.status === "fulfilled") renderProfile(user.value);
if (prefs.status === "rejected") useDefaultPrefs();
```

### Anti-patterns

- `Promise.all` for dependent steps (use sequential `await`)
- Unhandled rejections in fire-and-forget promises
- Not cancelling in-flight fetch on unmount (`AbortController`)

## Quick revision checklist

- Virtual DOM = React diff layer; Shadow DOM = browser encapsulation
- Prefer `slice()` over `substr()` / `substring()` unless you need `substring`’s swap behavior
- Reconciliation = diff + keys + commit; Fiber = schedulable units of that work
- Debounce = after pause; throttle = max rate
- Lazy load = `lazy` + `Suspense` (+ route splitting)
- Valid parentheses = stack + map of closers
- `call`/`apply` invoke; `bind` returns a bound function
- Closures = lexical scope + real hooks/handlers/debounce patterns
- `all` = all or fail; `allSettled` = full report, partial failure OK


https://www.linkedin.com/in/petarivanovv9

22 React component principles that separate seniors from juniors:

Most "clean React" advice is vibes. These I'd defend in a code review.
Save this one for your next review, then steal what you're missing:

1/ Default to function components.

2/ Name every component — no anonymous default exports.

3/ Keep helpers that don't touch props or state outside the component.

4/ Drive repetitive markup from config objects, not copy-paste.

5/ Keep components small. One job each.

6/ Destructure props right in the signature.

7/ Too many props is a design smell, not a feature.

8/ Group related props into one object.

9/ Never nest ternaries. Pull the logic out.

10/ Give list items their own component, not inline JSX in the map.

11/ Reach for hooks before HOCs or render props.

12/ Move reusable logic into custom hooks.

13/ Learn closures — stale values in handlers and effects will bite you.

14/ Turn "render functions" into real components — they get their own state, props, and memoization.

15/ Use useReducer when state transitions get gnarly.

16/ Hide reducer wiring behind a custom hook.

17/ Pair Context with useReducer for shared complex state.

18/ Kill prop drilling with composition and children.

19/ Derive state during render. Don't sync it with useEffect.

20/ Use guard clauses and early returns over nested ifs.

21/ Just use TypeScript. "Consider" is doing a lot of work.

22/ Pick one component style and stay consistent.

Open your messiest component and count how many of the 22 it breaks. What number did you get?