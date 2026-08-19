---
title: System Performance
description: 'Caching, messaging, concurrency, and database optimization'
category: 'System Design'
author: 'John Mason'
date: '2026-08-19 16:00'
---

Performance measures how well a system meets functional requirements under load. The goal is to balance speed, capacity, and efficiency.

## Key metrics

- **Latency** — time to process one request (lower is better)
- **Throughput** — requests processed per second (higher is better)
- **Scalability** — handling increased load without degradation
- **Responsiveness** — how quickly the system responds to each request

### SLAs, SLOs, and SLIs

- **SLA** (Service Level Agreement) — commitment to the customer
- **SLO** (Service Level Objective) — what the engineering team aims for
- **SLI** (Service Level Indicator) — the actual measured value

### Percentiles

- **p50** — median latency
- **p95** — 95% of requests are faster than this
- **p99** — tail latency; critical for user experience

Performance should be a first-class design goal. You cannot improve what you do not measure.

### Performance testing

- **Load testing** — baseline load
- **Stress testing** — beyond expected capacity
- **Spike testing** — sudden traffic bursts
- **Endurance testing** — sustained load over time (soak)

### Monitoring

APM tools (Datadog, New Relic), logs and metrics (Prometheus, Grafana).

Track latency, throughput, error rates, and resource usage.

## Caching

Reduces latency, eases load on backend services, and improves scalability. Caching is foundational to modern applications.

### Cache layers

- **Client-side** — browser cache, localStorage
- **Server-side** — in-memory (Redis, Memcached)
- **CDN** — static content close to users
- **Database** — cached result sets, materialized views

### Caching strategies

| Strategy | Behavior |
| --- | --- |
| Write-through | Write to cache and DB simultaneously |
| Write-back | Write to cache first, DB updated later |
| Lazy loading | Cache populated on demand (cache-aside) |
| Explicit | Developer controls what and when to cache |

Choose based on read/write patterns and tolerance for stale data.

### Eviction policies

- **LRU** — least recently used
- **LFU** — least frequently used
- **FIFO** — first in, first out
- **TTL** — auto-expire after a set time

### Redis

In-memory key-value store supporting pub/sub. Common uses: user sessions, search results, API response caching in microservices.

## Messaging and decoupling

Asynchronous messaging enables loose coupling, scalability, and resilience.

**Key concepts:** message, producer, broker/queue, consumer, topic, acknowledgment.

**Use message queues for:**

- Bursty workloads
- Decoupled services
- Background jobs
- Rate-limited or expensive operations
- Traffic buffering

| Tool | Pattern | Strength |
| --- | --- | --- |
| RabbitMQ | Push-based broker | Traditional message queuing |
| Kafka | Pull-based streaming | Event logs, replay, high throughput |

### Delivery guarantees

- **At least once** — may duplicate
- **At most once** — may lose messages
- **Exactly once** — no duplicates or losses (Kafka with careful design)

**Best practices:** idempotent consumers, dead letter queues, monitor queue length and processing time, secure brokers with auth and encryption.

## Concurrency and parallelism

- **Concurrency** — multiple tasks start, run, and complete in overlapping time periods
- **Parallelism** — multiple tasks execute simultaneously on different CPU cores

### Processes vs threads

- **Processes** — independent, own memory space (isolated)
- **Threads** — share memory within a process (lightweight, but race conditions possible)

**Patterns:** thread pools, worker models with shared task queues, async/non-blocking I/O.

### Modern web servers

Traditional Apache spawned a new thread/process per request — not scalable at high traffic. Modern servers (Node.js, ASP.NET Core, Nginx) use async non-blocking I/O with event loops or thread pools.

### Pitfalls

- **Race conditions** — multiple threads modify shared data concurrently
- **Deadlocks** — threads waiting on each other indefinitely

**Guidelines:** prefer async for I/O-bound tasks, use thread pools, synchronize shared data with locks/mutexes, use timeouts to avoid deadlocks.

## Database performance

### Replication

Database copies in multiple places for high availability, load balancing, and disaster recovery.

- **Master/slave** — writes to master, reads from slaves
- **Master/master** — writes to either node

### Sharding and partitioning

- **Sharding** — split a large dataset across multiple databases
- **Partitioning** — divide data within one database (range or hash partitioning)

### Indexes

Data structures that improve query performance: B-tree, hash, full-text, bitmap (low cardinality).

Balance read-heavy (more indexes) vs write-heavy (fewer indexes) workloads.

### Normalization vs denormalization

- **Normalization** — reduce redundancy, organize into tables; complex joins
- **Denormalization** — introduce redundancy to reduce joins; better for reporting and read-heavy workloads

Choose based on system use case.

### Other techniques

- **Connection pooling** — reuse established connections to reduce overhead
- **Query optimization** — avoid N+1 queries, use indexes, minimize complex joins
- **Materialized views** — precomputed query results stored as tables
- **Batching** — bulk inserts or updates
- **Pagination** — return smaller sets of data in pages

Back to [System Design](/posts/system-design.html).
