---
title: Protocols
description: 'TCP, UDP, HTTP, REST, WebSockets, gRPC, and GraphQL'
category: 'System Design'
author: 'John Mason'
date: '2026-08-19 16:00'
---

Transport and application protocols define how services talk to each other. These notes cover the core protocols used in modern system design interviews and production systems.

## TCP and UDP

### TCP (Transmission Control Protocol)

Reliable, ordered, and error-checked. Connection-oriented with a three-way handshake before data transfer.

Use when accuracy matters: web browsing, file transfer, email, APIs, databases.

### UDP (User Datagram Protocol)

Connectionless and faster, but with no delivery guarantees and no retransmission of lost packets.

Use when low latency matters more than perfect reliability: video streaming, online gaming, VoIP, DNS lookups.

## HTTP

HyperText Transfer Protocol defines rules for requesting and transferring resources over TCP/IP (port 80 for HTTP, 443 for HTTPS).

Key features:

- Text-based and easy to debug
- Stateless — each request is independent
- Supports multiple methods (GET, POST, PUT, DELETE, PATCH)

### Request / response cycle

**Request components:** method, URL, headers (user agent, cookies), body.

**Response components:** status code, headers, body.

Because HTTP is stateless, sessions are maintained with cookies, server-side sessions, or tokens.

### HTTP methods

- **GET** — retrieve a resource
- **POST** — create a resource
- **PUT** — replace an existing resource
- **PATCH** — partial update
- **DELETE** — remove a resource

### Status codes

- **1xx** — informational
- **2xx** — success
- **3xx** — redirection
- **4xx** — client errors
- **5xx** — server errors

## HTTPS

HTTP secured with TLS/SSL. Provides confidentiality, integrity, and authentication.

## REST and RESTful API design

Representational State Transfer is an architectural style for designing networked applications with stateless communication.

### REST constraints

- **Client–server** — frontend and backend evolve separately
- **Stateless** — no server-side sessions; each request carries all needed context
- **Cacheability** — responses can be cached for performance
- **Layered system** — load balancers, proxies, and gateways sit between client and server
- **Uniform interface** — standard HTTP methods and URI-based resources

### Design principles

- Resource-based URIs using plural nouns (`/users`, not `/getUser`)
- Avoid verbs in URLs — use HTTP methods instead
- Stateless interactions with JWT or OAuth tokens instead of sessions
- Versioning for backward compatibility
- Pagination with `page` and `limit` parameters
- Proper HTTP status codes

### JSON vs XML

- **JSON** — lightweight, faster parsing, human-readable (Accept header negotiation)
- **XML** — legacy systems, schema validation, formal data structures

Examples: Twitter and GitHub APIs.

## Real-time communication

Traditional HTTP request/response is too slow for chat, live dashboards, and gaming. Alternatives:

### Polling

Client asks for updates at fixed intervals. Simple but increases server load.

### Long polling

Server holds the request open until new data is available, then the client immediately sends another request. Useful when WebSockets are not supported.

### WebSockets

Persistent, full-duplex connection over a single TCP link.

1. Client requests an upgrade (handshake)
2. Server accepts and keeps the connection open
3. Either side can send messages at any time
4. Either party closes when done

Use for high-frequency, bidirectional, low-latency data (chat, gaming, stock feeds).

### Server-Sent Events (SSE)

Unidirectional server-to-client push. Simpler than WebSockets when you only need one-way updates.

| Use case | Protocol |
| --- | --- |
| Twitter notifications | Long polling |
| Slack chat | WebSockets |
| Stock exchange feeds | WebSockets |
| IoT intermittent updates | Long polling |

## Modern API protocols

REST is the default, but it has limitations: over-fetching, under-fetching, multiple round trips, and poor fit for real-time streaming.

### gRPC

High-performance binary protocol built on HTTP/2, optimized for microservices.

- Protocol Buffers (Protobuf) instead of JSON — smaller, faster serialization
- Multiplexed requests over one connection
- Full-duplex streaming
- Auto-generated client and server code across languages

Use for microservices, real-time streaming, IoT, and low-bandwidth environments.

### GraphQL

Flexible query language where clients fetch only the fields they need from a single endpoint.

- Client controls response shape
- One query can replace multiple REST calls
- Schema defines types and relationships

Use for frontend optimization, mobile apps, and aggregating data from multiple services.

Always justify your choice with trade-offs.

## Autoscaling

Automatic adjustment of compute resources based on system load.

**Triggers:** CPU, memory, request rate, queue length.

### Scaling types

- **Horizontal** — add or remove instances
- **Vertical** — resize a single instance

### Scaling policies

- **Reactive** — based on thresholds
- **Predictive** — based on trends and historical data
- **Scheduled** — known traffic patterns

**Cloud tools:** AWS EC2/Lambda/ECS/EKS, GCP MIGs/Cloud Run/GKE/Functions.

**Monitoring:** CloudWatch, Prometheus, Grafana, GCP Operations.

### Cost optimization

- Avoid over-provisioning — scale just enough
- Use spot/preemptible instances for batch workloads
- Apply resource limits and quotas
- Right-size based on actual usage
- Scale to zero for idle services

Back to [System Design](/posts/system-design.html).
