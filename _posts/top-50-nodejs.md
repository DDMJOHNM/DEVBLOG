---
title: 'Top 50 Node.js'
description: 'Node.js interview questions covering the event loop, modules, streams, scaling, and production patterns'
category: Interviewing
author: 'John Mason'
date: '2026-08-19 15:42'
---

Interview notes for Node.js. Answers are short enough to revise from, with code where it helps.

## 1. What is Node.js?

Node.js is a JavaScript runtime built on Chrome's V8 engine. It runs JavaScript outside the browser and is designed around non-blocking, event-driven I/O so a single thread can handle many concurrent connections.

## 2. How does Node.js differ from browser JavaScript?

| | Browser | Node.js |
| --- | --- | --- |
| Globals | `window`, `document` | `global`, `process` |
| APIs | DOM, `fetch`, Web APIs | `fs`, `http`, `net`, `crypto` |
| Modules | ES modules in browsers | CommonJS and ESM |
| Use | UI | Servers, CLIs, tooling |

Both use V8 and share language features (promises, async/await, classes).

## 3. What is the event loop?

The event loop is how Node.js runs asynchronous callbacks on a single JavaScript thread. Synchronous code runs on the call stack. When that stack is empty, the loop takes work from queues (microtasks, then timers, I/O, `setImmediate`) and runs those callbacks.

This is why Node.js can serve many clients without one thread per request: waiting on I/O does not block the thread.

## 4. What is libuv?

libuv is the C library Node.js uses for the event loop, thread pool, and async I/O (files, DNS, some crypto). JavaScript talks to libuv through Node's C++ bindings. Heavy work that cannot be done asynchronously in the OS is offloaded to libuv's thread pool (default size 4, via `UV_THREADPOOL_SIZE`).

## 5. Call stack, microtasks, and macrotasks

- **Call stack:** currently executing functions (LIFO).
- **Microtasks:** `process.nextTick`, Promise `.then` / `queueMicrotask`. Drained before the next macrotask.
- **Macrotasks:** `setTimeout`, `setInterval`, I/O callbacks, `setImmediate`.

```js
console.log('sync');
setTimeout(() => console.log('timeout'), 0);
setImmediate(() => console.log('immediate'));
Promise.resolve().then(() => console.log('promise'));
process.nextTick(() => console.log('nextTick'));
// sync, nextTick, promise, then timeout/immediate (order of the last two depends on context)
```

## 6. `process.nextTick` vs `setImmediate` vs `setTimeout`

- `process.nextTick(fn)` — runs before the rest of the current event-loop phase finishes. Can starve the loop if you keep queueing nextTicks.
- `setImmediate(fn)` — runs in the check phase, after I/O callbacks.
- `setTimeout(fn, 0)` — runs in the timers phase. Not exactly "zero delay"; it is a minimum delay.

Prefer `setImmediate` over recursive `nextTick` when you want to yield to I/O.

## 7. What is an error-first callback?

Node's older async style: the first argument is an `Error` or `null`, the rest are results.

```js
fs.readFile('file.txt', 'utf8', (err, data) => {
  if (err) return console.error(err);
  console.log(data);
});
```

Always handle `err`. Unhandled callback errors are a common production bug.

## 8. Promises and async/await in Node.js

Modern Node APIs return promises (`fs.promises`, `fetch` on recent Node). `async/await` is syntactic sugar over promises.

```js
import { readFile } from 'node:fs/promises';

try {
  const data = await readFile('file.txt', 'utf8');
  console.log(data);
} catch (err) {
  console.error(err);
}
```

Avoid mixing callbacks and promises without wrapping (`util.promisify`).

## 9. CommonJS vs ES modules

- **CommonJS:** `require` / `module.exports`. Synchronous, cached, still the default in many codebases.
- **ESM:** `import` / `export`. Static, supports top-level await, tree-shaking in bundlers.

A file is ESM if it has `"type": "module"` in `package.json` or a `.mjs` extension. CJS uses `.cjs` when the package is ESM by default.

## 10. `require` vs `import`

`require` is a function you can call conditionally. `import` is hoisted and statically analysed. You cannot `require` an ESM module from CJS without a dynamic `import()`. From ESM, use `createRequire` if you must load CJS.

## 11. `module.exports` vs `exports`

`exports` is an alias for `module.exports`. Assigning `exports.foo = 1` works. Replacing `exports = { foo: 1 }` breaks the alias — the module still exports the original `module.exports` object. Prefer `module.exports = ...` when exporting a single value.

## 12. What is `package.json`?

The manifest for a Node project: `name`, `version`, `scripts`, `dependencies`, `devDependencies`, `type`, `engines`, `exports`, `main`. npm/yarn/pnpm use it to install and run the project.

## 13. npm, yarn, pnpm, and npx

- **npm:** default client, ships with Node.
- **yarn / pnpm:** alternative clients; pnpm uses a content-addressable store and hard links.
- **npx:** runs a package binary without a global install (`npx prisma studio`).

Lockfiles (`package-lock.json`, `yarn.lock`, `pnpm-lock.yaml`) pin exact versions for reproducible installs.

## 14. What is the `EventEmitter`?

The observer pattern used throughout Node (`http.Server`, streams). Objects emit named events; listeners subscribe with `on` / `once`.

```js
import { EventEmitter } from 'node:events';

const bus = new EventEmitter();
bus.on('ready', (name) => console.log('ready', name));
bus.emit('ready', 'api');
```

Always handle the `error` event or the process can crash. `setMaxListeners` warns about leaks when too many listeners are attached.

## 15. What are streams?

Streams process data in chunks instead of loading everything into memory.

- **Readable:** `fs.createReadStream`, HTTP request
- **Writable:** `fs.createWriteStream`, HTTP response
- **Duplex:** sockets
- **Transform:** zlib gzip, crypto cipher

```js
import { createReadStream, createWriteStream } from 'node:fs';
import { pipeline } from 'node:stream/promises';

await pipeline(
  createReadStream('in.txt'),
  createWriteStream('out.txt'),
);
```

Prefer `pipeline` over `.pipe()` so errors and cleanup are handled.

## 16. What is a Buffer?

A Buffer is a fixed-length chunk of binary data (outside V8's heap strings). Used for files, TCP, and crypto. In modern Node, `Buffer` is a subclass of `Uint8Array`.

```js
const buf = Buffer.from('hello', 'utf8');
console.log(buf.toString('hex'));
```

Do not concatenate untrusted input into buffers without size limits (DoS).

## 17. The `fs` module

Filesystem APIs: `readFile` / `writeFile`, `stat`, `mkdir`, `watch`, streams. Use `node:fs/promises` in new code. Synchronous `readFileSync` blocks the event loop — fine in startup scripts, not in a request handler.

## 18. The `path` module

Joins and normalises paths in a cross-platform way: `path.join`, `path.resolve`, `path.basename`, `path.extname`. Never concatenate paths with `/` if you care about Windows. `path.posix` / `path.win32` exist when you need a specific style.

## 19. Building an HTTP server

```js
import http from 'node:http';

const server = http.createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'application/json' });
  res.end(JSON.stringify({ ok: true }));
});

server.listen(3000);
```

Frameworks (Express, Fastify, Nest, Hono) add routing, middleware, and validation on top of `http`.

## 20. Middleware

A function `(req, res, next)` that runs before the route handler: logging, auth, parsing JSON, CORS. Call `next()` to continue, `next(err)` to jump to error middleware.

```js
app.use((req, res, next) => {
  console.log(req.method, req.url);
  next();
});
```

Order matters. Error middleware has four arguments: `(err, req, res, next)`.

## 21. Express vs Fastify vs NestJS

- **Express:** minimal, huge ecosystem, callback-style middleware.
- **Fastify:** schema-based, faster JSON, first-class plugins and hooks.
- **NestJS:** opinionated architecture (modules, DI, decorators) on Express or Fastify.

Pick Express for small APIs, Fastify for performance-sensitive JSON APIs, Nest when you want structure on a large team.

## 22. REST APIs in Node.js

Map HTTP verbs and URLs to resources: `GET /users`, `POST /users`, `GET /users/:id`. Return JSON, correct status codes (200, 201, 400, 401, 404, 500), and validate input. Keep handlers thin; put business logic in services.

## 23. Error handling

- Operational errors (bad input, network): handle and return a response.
- Programmer errors (undefined is not a function): crash in development; log and restart in production (process manager).

```js
process.on('unhandledRejection', (reason) => {
  console.error('unhandledRejection', reason);
  process.exit(1);
});
```

Do not swallow errors. Use a single error-mapping layer so clients get a consistent JSON shape.

## 24. Uncaught exceptions vs unhandled rejections

- `uncaughtException` — thrown error with no `try/catch`. The process is in an unknown state; log and exit.
- `unhandledRejection` — a rejected promise with no `.catch`. Same advice on modern Node: treat it as fatal.

## 25. Environment variables

Config that changes per environment: `PORT`, `DATABASE_URL`, `NODE_ENV`. Load with `process.env`, optionally `dotenv` in development. Never commit secrets. Validate env at startup (zod, envalid) so the app fails fast.

## 26. The `process` object

Runtime info and control: `process.env`, `process.argv`, `process.cwd()`, `process.exit()`, `process.memoryUsage()`, `process.pid`, signals (`SIGINT`, `SIGTERM`). Handle `SIGTERM` for graceful shutdown in Kubernetes/Docker.

## 27. Cluster module

`cluster` forks worker processes that share a port. Each worker is a full Node process with its own event loop and memory. The primary process distributes connections.

Useful on multi-core machines. State is not shared — use Redis or a database for sessions. PM2 and Kubernetes often replace hand-rolled clustering.

## 28. Worker threads

`worker_threads` run JavaScript in parallel threads that share memory via `SharedArrayBuffer` or `MessageChannel`. Use them for CPU-heavy work (hashing, image processing) so the main event loop stays free. Not a replacement for `cluster` for HTTP scale-out.

## 29. Child processes

`child_process.spawn`, `exec`, `execFile`, `fork`. `fork` is specialised for Node children with an IPC channel. Use `spawn` for streaming output; `exec` buffers everything (dangerous for large output). Sanitize arguments to avoid command injection.

## 30. Blocking vs non-blocking I/O

Non-blocking: `fs.readFile`, `http`, most network APIs — the thread continues while the OS works. Blocking: `fs.readFileSync`, tight CPU loops, large JSON.parse on huge payloads. One blocking call stalls every request on that process.

## 31. CORS

Cross-Origin Resource Sharing. Browsers block frontend JS on `app.com` from calling `api.com` unless the API sends `Access-Control-Allow-Origin` (and friends). Handle preflight `OPTIONS` requests. In Express, the `cors` package is the usual approach. Never use `*` with credentials.

## 32. Authentication: JWT vs sessions

- **Sessions:** server stores session id in a cookie; state lives in Redis/DB. Easy to revoke.
- **JWT:** client stores a signed token. Stateless, harder to revoke without a denylist or short TTL.

Use `httpOnly`, `Secure`, `SameSite` cookies. Hash passwords with bcrypt/argon2. HTTPS everywhere.

## 33. Rate limiting

Protects against brute force and abuse. Token bucket / sliding window in memory (single instance) or Redis (multiple instances). Return `429 Too Many Requests`. Place it early in the middleware stack.

## 34. Security basics

- Helmet (HTTP headers)
- Validate and sanitise input (NoSQL/SQL injection, XSS)
- Parameterised queries / ORMs
- Limit payload size
- Keep dependencies updated (`npm audit`)
- Do not run as root
- Secrets in a vault or env, not source

## 35. File uploads

Use a dedicated parser (`multer`, `busboy`). Stream to disk or S3; do not buffer entire files in memory. Check MIME type and size. Store uploads outside the web root. Virus-scan when needed.

## 36. WebSockets

Persistent bidirectional sockets (`ws`, Socket.IO). The HTTP server upgrades the connection. Sticky sessions or a pub/sub adapter (Redis) are needed behind multiple Node processes. Heartbeats detect dead clients.

## 37. Caching

- In-process: fast, not shared, lost on restart.
- Redis: shared, TTL, good for sessions and hot keys.
- HTTP: `Cache-Control`, ETags, CDNs for static assets.

Cache expensive reads; invalidate on writes. Stampede protection (locks or singleflight) matters at scale.

## 38. Databases and connection pooling

Keep a pool of DB connections per process (`pg`, `mysql2`, Prisma). Pool size × process count must not exhaust the database. Use transactions for multi-step writes. Prefer migrations over ad-hoc schema changes.

## 39. Testing

- **Unit:** Jest / Vitest / node:test
- **HTTP:** Supertest against the app without a real port
- **Integration:** testcontainers or a dedicated test DB

Mock I/O at boundaries. Keep tests deterministic; avoid depending on wall-clock time without fakes.

## 40. Debugging

`node --inspect` + Chrome DevTools, VS Code attach, `console.log` with care in prod. `NODE_DEBUG=http` for core modules. OpenTelemetry / pino for structured logs. Heap snapshots for leaks; `clinic.js` for event-loop delay.

## 41. Memory leaks

Typical causes: global caches that grow, EventEmitter listeners not removed, unclosed streams, closures holding large objects, detached DOM (less relevant in Node). Monitor `process.memoryUsage()` and restart when RSS climbs without bound.

## 42. Garbage collection and V8

V8 manages heap memory. Young generation collects often; old generation less often. Large objects and many hidden classes hurt performance. `--max-old-space-size` raises the heap limit. CPU profiling shows hot functions; heap snapshots show retained objects.

## 43. The V8 engine

Compiles JavaScript to machine code (Ignition interpreter + TurboFan optimiser). Node embeds V8 and adds libuv. Language features land in Node after V8 supports them. `node --version` vs V8 version are related but not the same number.

## 44. REPL

`node` with no file drops you into a Read-Eval-Print Loop. Useful for trying APIs. `_` holds the last result. `.exit` to quit. `NODE_REPL_HISTORY` controls history.

## 45. Global objects in Node.js

`global` / `globalThis`, `process`, `Buffer`, `console`, `setTimeout`, `setImmediate`, `URL`, `fetch` (modern Node), `__dirname` and `__filename` in CJS only. In ESM use `import.meta.url` and `fileURLToPath`.

## 46. Scaling Node.js

Vertical: faster CPU, more RAM, larger libuv pool. Horizontal: more processes (cluster, PM2) or more machines (load balancer, Kubernetes). Stateless APIs scale easily; sticky sessions and local disk do not. Offload CPU to workers or another service.

## 47. PM2

A process manager: cluster mode, zero-downtime reload, logs, restart on crash, startup scripts. In Kubernetes you often run one Node process per container and let the orchestrator restart — PM2 is more common on VMs.

## 48. Graceful shutdown

On `SIGTERM`: stop accepting new connections, drain in-flight requests, close DB pools, then `process.exit(0)`. Kubernetes sends SIGTERM then SIGKILL after `terminationGracePeriodSeconds`.

```js
server.close(async () => {
  await db.end();
  process.exit(0);
});
```

## 49. When should you not use Node.js?

CPU-heavy number crunching, tight real-time deadlines, or workloads that need many threads sharing memory without a worker model. Node shines at I/O-bound APIs, tooling, and realtime apps. Use Go, Rust, or Java when the bottleneck is CPU or you need a different concurrency model.

## 50. Typical Node.js interview checklist

- Event loop phases and `nextTick` vs Promises vs timers
- Streams + `pipeline` vs buffering whole files
- CJS vs ESM
- Error handling and process crash policy
- Cluster vs worker threads
- Security headers, injection, rate limits
- How you would scale a chat API or a file-upload service

## References

- [Node.js docs](https://nodejs.org/docs/latest/api/)
- [libuv](https://libuv.org/)
- [Node.js event loop](https://nodejs.org/en/learn/asynchronous-work/event-loop-timers-and-nexttick)
