---
title: Reliability and Availability
description: 'Redundancy, backup, disaster recovery, and graceful degradation'
category: 'System Design'
author: 'John Mason'
date: '2026-08-19 16:00'
---

How gracefully does a system handle failure? Reliability covers correctness, consistency, fault tolerance, and uptime.

## Reliability dimensions

- **Functional reliability** — the system does what it is supposed to do
- **Availability reliability** — the system is online when users need it
- **Performance reliability** — the system stays responsive under load

### Key metrics

- **MTBF** (Mean Time Between Failures) — how long the system runs before failing
- **MTTR** (Mean Time To Recover) — how long it takes to restore service
- **SLAs** — formal commitments on availability, response time, and error rate

## Availability vs durability

- **Availability (online)** — accessible and responsive when the user needs it
- **Durability (safe)** — data is saved and not lost or corrupted

### Design decisions

- Redundancy
- Health checks and monitoring
- Retry mechanisms and circuit breakers
- Distributed design patterns

### Challenges and solutions

| Challenge | Solution |
| --- | --- |
| Network partitions | CAP-aware design |
| Node failures | Fault isolation |
| Eventual consistency | Replication and consensus algorithms |

### Cloud infrastructure

Design for failure:

- Transient failures → retries
- Auto-scaling and self-healing
- Chaos engineering to test resilience

## Redundancy

Prevents single points of failure.

**Types:** hardware, network, services.

**Patterns:**

- **N+1** — one extra node to handle load or failure
- **Active–active** — all nodes handle traffic; requires load balancing and sync; one node failure is tolerated
- **Active–passive** — standby node promoted on failure; simpler and cost-effective; failover latency applies

### Graceful degradation

Continue functioning during partial failures. Offer core functionality or prioritize critical features to preserve user experience, resilience, and business continuity.

### High availability patterns

- **Load balancers** — distribute traffic across healthy nodes
- **Replication** — copy data to multiple locations
- **Failover** — switch to a backup service or node automatically

### Designing for redundancy

- Redundant components at every layer
- Geographical redundancy across regions
- Automated failover
- Health monitoring compared against baseline
- Self-healing (common in cloud-native systems)

## Backup and recovery

Required for compliance and business continuity.

### Backup types

- **Full** — complete copy of all data
- **Incremental** — only changes since last backup (restore is harder)
- **Differential** — changes since last full backup

### Recovery types

| Type | Description | Cost |
| --- | --- | --- |
| Cold | Restore from offline backups | Low |
| Warm | Partially running standby | Medium |
| Hot | Fully running standby | High |

### RTO and RPO

- **RTO** (Recovery Time Objective) — how quickly service must be restored
- **RPO** (Recovery Point Objective) — how much data loss is acceptable

Shorter RTO/RPO means higher cost. Balance recovery speed against complexity, backup frequency, retention, business criticality, and compliance needs.

### Best practices

- Automate backups and test restoration regularly
- Encrypt backups at rest and in transit
- Monitor backup success and failure
- Apply the **3-2-1 rule**: 3 copies, 2 media types, 1 offsite

## Disaster recovery

- Downtime has real cost
- Protects against regional outages
- Complements backup strategies
- Required for compliance

**Failover + backup = true resilience.** Include both in your DR plan.

### Testing and automation

Automate failover switching, data validation after restore, and notifications/logging. Run DR drills regularly.

### Challenges

- Data consistency across regions
- Latency during sync and failover
- Regulatory constraints (data locality)
- Coordinating multi-region failovers

### Geo-redundancy

Deploy services across multiple regions. Use quorum-based design — a minimum number of servers must acknowledge distributed operations for success.

Back to [System Design](/posts/system-design.html).
