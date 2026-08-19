---
title: Web Concepts
description: 'Sessions, authentication, serialization, and CORS'
category: 'System Design'
author: 'John Mason'
date: '2026-08-19 16:00'
---

Web concepts bridge HTTP mechanics and application design. These notes cover state management, data formats, and cross-origin security.

## Web sessions

HTTP is stateless. Sessions maintain state across requests.

### Session-based authentication

Server-side session storage with cookies for session IDs.

- Server maintains session state
- Client holds only a session ID (usually in a cookie)
- Hard to scale in distributed systems without extra infrastructure

**Scaling options:**

- **Sticky sessions** — route a user to the same server
- **Session replication** — copy sessions across servers
- **External session store** — Redis or Memcached accessible by all servers

### Token-based authentication

Session state embedded in the token itself (JWTs, OAuth tokens).

- Server does not need to track user sessions
- Stateless and horizontally scalable
- Token must be stored securely on the client and validated on every request

### Security concerns

| Threat | Mitigation |
| --- | --- |
| Session hijacking | HTTPS, regenerate session after login, short expiration |
| CSRF | CSRF tokens on state-changing requests |
| Cookie theft | `HttpOnly` and `SameSite` flags |

### Best practices

- Sticky sessions when session state must stay on one server
- Distributed session store (Redis, Memcached) for horizontal scaling
- JWT for stateless authentication in microservices

## Serialization

Converting complex objects into a format that can be transferred or stored. Deserialization converts it back.

Essential for distributed systems, caching, and data storage.

### Formats

| Format | Characteristics | Use case |
| --- | --- | --- |
| JSON | Human-readable, text-based, larger payloads | REST APIs |
| XML | Structured, verbose, schema support | Legacy SOAP APIs |
| Protocol Buffers | Binary, compact, requires schema | gRPC, high-performance APIs |

**Trade-offs:** readability vs efficiency vs compatibility (schema evolution).

### In caching and storage

- Redis and Memcached store serialized JSON or Protobuf
- MongoDB uses BSON (Binary JSON)
- Big data pipelines use Protobuf for efficient storage and schema evolution

Choose the format based on ease of use versus performance for your access patterns.

## CORS (Cross-Origin Resource Sharing)

Browsers enforce the Same-Origin Policy (SOP). CORS is the mechanism that allows secure cross-origin communication — the backend must explicitly allow requests from other origins.

### Request types

- **Simple requests** — GET, POST without custom headers
- **Preflight requests** — PUT, DELETE, or custom headers trigger an OPTIONS request first

### CORS headers

- `Access-Control-Allow-Origin` — which origins are permitted
- `Access-Control-Allow-Methods` — allowed HTTP methods
- `Access-Control-Allow-Headers` — custom headers that can be sent

### Preflight flow

1. Browser sends OPTIONS request
2. Server responds with CORS headers
3. Browser sends the actual request if allowed

### Common risks

- Overly permissive `Access-Control-Allow-Origin: *`
- `Access-Control-Allow-Credentials: true` combined with wildcard origin
- Exposing APIs via improper CORS configuration

### Mitigation

- Whitelist specific origins
- Configure CORS policies per API endpoint
- Use reverse proxies or API gateways to centralize CORS handling

### CORS in REST vs GraphQL

REST APIs configure headers on each endpoint. GraphQL also needs CORS handling — preflight requests occur due to complex queries and mutations.

### Alternatives

Handle cross-origin requests internally:

- **Reverse proxy** (e.g. Nginx) — forwards requests to backend, bypassing browser CORS
- **API gateway** — centralized policies for multiple services

Back to [System Design](/posts/system-design.html).
