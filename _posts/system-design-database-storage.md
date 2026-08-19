---
title: Database and Storage
description: 'SQL vs NoSQL, sharding, replication, and object storage'
category: 'System Design'
author: 'John Mason'
date: '2026-08-19 16:00'
---

Storage choices impact performance, reliability, and cost. Every system design starts with understanding your data: structured vs unstructured, access patterns, and scale requirements.

## Storage types

- **Structured data** — predefined schema (relational databases)
- **Unstructured data** — flexible formats (object/blob storage)
- **File storage** — NFS, legacy systems
- **Block storage** — raw storage blocks (e.g. AWS EBS)

## SQL vs NoSQL

### Relational (SQL)

MySQL, PostgreSQL. Data stored in rows and columns with a predefined schema.

**ACID properties:**

- **Atomicity** — all or nothing
- **Consistency** — data integrity maintained
- **Isolation** — transactions do not interfere
- **Durability** — changes survive system failures

**Best for:** complex queries and relationships, strong consistency, structured data (banking, ERP).

**Not ideal for:** rapidly changing schema-less data, large-scale horizontal scaling, deeply nested JSON.

### NoSQL

Flexibility and scale. Schema-less or dynamic schema.

| Type | Examples | Use case |
| --- | --- | --- |
| Document | MongoDB | JSON-like structures, user profiles, CMS |
| Key-value | Redis, DynamoDB | Caching, high-performance lookups |
| Columnar | Cassandra, HBase | Analytics over large datasets |
| Graph | Neo4j | Highly connected data, social networks |

**BASE properties:**

- **Basically available** — always returns a response
- **Soft state** — system may change over time
- **Eventually consistent** — updates propagate through the system

In distributed systems, SQL tends toward **CP** (consistency + partition tolerance). NoSQL often chooses **AP** or BASE (availability over immediate consistency).

### CAP theorem

You can guarantee at most two of three:

- **Consistency** — every request receives the latest write
- **Availability** — every request receives a response
- **Partition tolerance** — system functions despite network failures

Modern architectures often use **polyglot persistence** — the right database for each service.

## Scaling databases

### Vertical scaling

Increase capacity of a single machine.

**Pros:** simple architecture, strong consistency.

**Cons:** limited by hardware, cost grows non-linearly, single point of failure.

### Horizontal scaling

Add more database nodes to distribute data and load.

**Pros:** elastic scalability, handles large traffic, better fault tolerance.

**Cons:** complex architecture, often weaker consistency (eventual).

## Sharding

Splitting data across multiple nodes when a single node reaches its limits.

### Strategies

- **Range-based** — e.g. users 1–1000 on shard A, 1001–2000 on shard B
- **Hash-based** — hash a key like user ID; reduces hotspots but harder for range queries; consistent hashing minimizes remapping when nodes change
- **Geo-based** — shard by region for lower latency

### Vertical sharding

Split by function (users table on one shard, orders on another). Adds complexity.

## Replication

Copying data from one database node to another.

**Benefits:** fault tolerance, improved read performance, data availability.

**Trade-offs:** CAP theorem applies — replication may favor availability; strong consistency may sacrifice availability during lag.

### Leader–follower replication

- Writes go to the leader
- Reads can come from followers
- Async replication means possible read lag

### Read replicas

Scale read-heavy workloads. Not involved in writes. Load-balance read traffic across replicas. Replication lag still applies.

## Object storage

Manages data as objects in buckets with metadata (MIME type, timestamps, custom tags). Scalable, searchable, and cost-effective.

**Providers:** Amazon S3, Google Cloud Storage, Azure Blob Storage.

**Use cases:** media storage, backups and archives, data lakes, static website hosting, IoT and ML pipelines.

**Considerations:**

- Latency and throughput — design for massive parallel access
- Eventual consistency on some platforms (e.g. S3)
- Write-once, read-many access patterns
- Storage class tiers (Standard, Infrequent Access, Archive) and lifecycle rules

## Distributed file systems

Traditional file systems (ext4, NTFS, xfs) are limited to single-node scale.

**Distributed file systems (DFS)** store and access files across multiple nodes but appear as a single system.

Example: **HDFS** (Hadoop) — NameNode manages metadata, DataNodes store replicated blocks.

**Benefits:** horizontal growth, automatic rebalancing, high throughput via parallelism, built-in failure recovery.

**Use cases:** big data processing, log aggregation.

## Big data fundamentals

Datasets too large, fast, or complex for traditional processing tools.

**The 6 Vs:** Volume, Velocity, Variety, Veracity, Value, Variability.

**Limitations of traditional systems:** vertical scaling only, not optimized for parallel access, cost inefficiencies, lack of fault tolerance.

**Processing patterns:**

- **Batch** — large chunks at once (reports, ETL)
- **Stream** — real-time (alerts, live dashboards)
- **Hybrid** — common in production

## Choosing storage

| Property | Question |
| --- | --- |
| Durability | Does data persist after failure? |
| Availability | Does it work during partial outages? |
| Consistency | Do reads always return the latest write? |
| Atomicity | Do multi-record operations succeed or fail as a unit? |

No perfect solution — make trade-offs based on what matters most.

**Examples:**

- E-commerce — structured DB + object storage for images
- Streaming — unstructured media in object storage, user data in NoSQL
- Log aggregation — time-series/columnar DB + object storage

Real-world systems combine multiple storage types.

Back to [System Design](/posts/system-design.html).
