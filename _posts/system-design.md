---
title: 'System Design'
description: 'Course notes and framework'
category: 'System Design'
author: 'John Mason'
date: '2026-07-15 01:48'
---

## Overview

Course notes to be added.

## System Design Trade-offs

System design trade-offs are essential engineering decisions, where improving one attribute—such as latency, scalability, or availability—inevitably sacrifices another. Common trade-offs include choosing between strong consistency (accuracy) and high availability (speed), or choosing between denormalization (faster reads) and normalization (better integrity).

### Key Trade-offs

- **Consistency vs. Availability (CAP Theorem):** In a distributed system, you can prioritize either immediate data consistency (all nodes see the same data simultaneously) or high availability (the system stays functional even if nodes fail or network issues occur).
- **Latency vs. Throughput:** Optimizing for low latency reduces the time to process a single request, whereas high throughput increases the total amount of data processed per second.
- **Stateful vs. Stateless:** Stateful systems remember past interactions, making them better for personalization but harder to scale. Stateless systems are easier to scale horizontally but require external storage to maintain session data.
- **SQL (Normalized) vs. NoSQL (Denormalized):** SQL ensures data integrity and reduces redundancy. NoSQL databases (e.g. Cassandra) are better at scaling horizontally and handling high-volume write traffic, often sacrificing strict consistency.
- **Sync vs. Async Processing:** Synchronous calls (e.g. HTTP) are simpler but create dependencies. Asynchronous processing (e.g. messaging queues) decouples services for better performance, but increases complexity.
- **Monolith vs. Microservices:** Monoliths are simpler to develop and deploy initially. Microservices offer better scalability and flexibility but are much harder to manage and debug.
- **Caching (Performance) vs. Memory (Cost):** Adding cache (e.g. Redis) improves read speeds (lowers latency) but increases cost, complexity, and the risk of data inconsistency.

### How to Approach Trade-offs in Interviews

1. **Understand requirements:** Define if the system is read-heavy or write-heavy.
2. **Highlight trade-offs:** Always explain what is gained and what is lost when choosing a technology.
3. **Justify decisions:** Base decisions on specific product needs (e.g. banking needs consistency, social media needs availability).
## Load Balancers

A load balancer is a dedicated hardware appliance or software service that acts as a reverse proxy, distributing incoming network traffic across multiple servers. It maximizes application reliability, prevents server overloads, and minimizes latency by ensuring no single machine is overwhelmed.

### Key Benefits

- **High Availability:** If a backend server goes offline, the load balancer automatically reroutes traffic to healthy servers, preventing downtime.
- **Scalability:** It allows administrators to seamlessly add or remove servers from the backend pool without interrupting user access.
- **Security:** Acting as an intermediary, it hides backend server identities and can help mitigate Distributed Denial of Service (DDoS) attacks.

### Common Load Balancing Algorithms

Different methods are used to determine which server receives the next incoming request:

- **Round Robin:** Distributes requests sequentially across the server pool in a revolving loop.
- **Least Connections:** Routes traffic to the server with the fewest active connections, making it ideal if requests vary greatly in processing time.
- **IP Hash:** Uses the client's IP address to consistently route them to the same server, preserving session data.

### Load Balancer Tiers

Load balancing generally operates at two primary network levels:

- **Layer 4 (Transport Layer):** Routes traffic based on IP addresses and TCP/UDP ports without inspecting the actual content of the packets. It is highly performant.
- **Layer 7 (Application Layer):** Makes highly intelligent routing decisions based on request attributes like HTTP headers, cookies, or URL paths, making it ideal for microservices.
