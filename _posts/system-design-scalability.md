---
title: Scalability
description: 'Vertical, horizontal, and diagonal scaling with load balancing'
category: 'System Design'
author: 'John Mason'
date: '2026-08-19 16:00'
---

Scalability is the ability of a system to maintain performance, reliability, and availability under growing load — user base growth, increased data volume, peak events, and SLA targets.

If a system cannot scale, it cannot grow.

## Scaling directions

| Strategy | Approach | Trade-offs |
| --- | --- | --- |
| Vertical (scale up) | Add CPU, RAM, or disk to one server | Simple, but limited by hardware and single point of failure |
| Horizontal (scale out) | Add more servers and distribute load | Requires load balancers and stateless design; more complex |
| Diagonal (hybrid) | Start vertical, then go horizontal | Cost-effective and future-ready; common in cloud-native apps |

### When to use each

- **Startups** — vertical is cheaper and simpler, but has limits
- **Scaling apps** — horizontal for resilience; monolith to microservices needs planning
- **Cloud native** — diagonal hybrid for flexibility and cost control

Be ready to evolve as traffic increases.

## Challenges

1. **Latency** — network hops, slow DB queries, and synchronous calls amplify in distributed systems
2. **Bottlenecks** — the system is only as fast as its slowest part (DB locks, memory limits, single-threaded processing)
3. **Downtime** — more nodes mean more failure points; updates and scaling events can cause outages
4. **Cost** — CPU, RAM, and bandwidth are not free; autoscaling without limits can blow the budget

## Load balancers

Load balancers are enablers of horizontal scaling.

**Benefits:**

- High availability during traffic spikes
- Traffic distribution so no single machine is overloaded
- Improved performance through reduced response times
- Graceful failure handling — redirect traffic from unhealthy nodes
- Supports horizontal scalability

Example: an e-commerce site uses load balancers to handle peak shopping events.

### Types

**By network layer:**

- **Layer 4** (transport) — routes by IP and TCP/UDP port; fast, no content inspection
- **Layer 7** (application) — routes by HTTP headers, URL paths, cookies; content-aware and powerful

**By deployment:**

- **Hardware** — physical appliances (e.g. Citrix)
- **Software** — Nginx, HAProxy, Envoy
- **Cloud-based** — managed services (AWS ELB, GCP GCLB)

### Load balancing strategies

**Static** (predictable workloads):

- Round robin
- Least connections
- IP hashing (sticky sessions)

**Dynamic** (fluctuating workloads):

- Least response time
- Adaptive load balancing (real-time)
- Weighted distribution by server capacity

Dynamic strategies require more monitoring but adapt better to changing load.

### Choosing a load balancer

- **Layer 4** when speed matters and content inspection is not needed
- **Layer 7** when routing decisions depend on request content
- Match the strategy to expected workload and traffic patterns
- Consider security features: SSL termination and DDoS protection

Back to [System Design](/posts/system-design.html).
