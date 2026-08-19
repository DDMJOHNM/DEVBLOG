---
title: System Design Interview Framework
description: 'Four-step approach to system design problems'
category: 'System Design'
author: 'John Mason'
date: '2026-08-19 16:00'
---

System design defines the architecture, components, and interactions of a system to meet its requirements — practically, accurately, efficiently, reliably, and at scale.

The goal is to build scalable and maintainable systems while balancing trade-offs between performance, cost, and complexity.

## What good system design looks like

- Practical and accurate
- Efficient and reliable
- Optimized for the use case
- Scalable over time
- Clear architecture with thoughtful planning

## Step 1 — Understand the problem and define scope

Before drawing boxes, clarify what you are building.

- **Functional requirements** — what the system must do
- **Non-functional requirements** — performance, availability, security, scalability
- **Constraints** — budget, timeline, team size, existing tech stack

Ask clarifying questions. Do not assume requirements the interviewer has not stated.

## Step 2 — Estimate scale and identify bottlenecks

Back-of-the-envelope calculations guide architectural decisions.

- Estimate traffic (requests per second, data volume, storage growth)
- Identify bottlenecks (database, network, single points of failure)
- Plan capacity (how many servers, how much storage, bandwidth needs)

Rough numbers are fine — the reasoning matters more than precision.

## Step 3 — High-level design

Define the core building blocks before diving into implementation details.

- **Core services** — what major components exist and what each does
- **API design** — endpoints, request/response formats, authentication
- **Communication patterns** — sync (REST/gRPC) vs async (queues, events)
- **Service interaction** — how components talk to each other

Consider design patterns where they fit. See [Gang of Four design patterns](https://dev.to/udara_dananjaya/gang-of-four-gof-design-patterns-in-c-a-comprehensive-guide-105i) for reusable solutions.

## Step 4 — Make tech and infrastructure decisions strategically

Choose technologies based on requirements, not familiarity alone.

- **Tech stack** — languages, frameworks, databases
- **Scalability and availability** — load balancing, replication, failover
- **Performance** — caching, CDN, async processing
- **Trade-offs** — justify every choice with what you gain and what you sacrifice

## Summary

1. Clear understanding of requirements and constraints
2. Scale and bottleneck analysis to guide architecture
3. High-level design that balances performance, cost, and complexity
4. Informed infrastructure and tech choices for scalability and availability

## Diagrams for different audiences

| Audience | Diagram type |
| --- | --- |
| Stakeholders | High-level architectural or C4 Context diagrams |
| Developers | Component diagrams, sequence diagrams, ERDs |
| DevOps | Deployment diagrams, CI/CD pipeline diagrams |

Back to [System Design](/posts/system-design.html).
