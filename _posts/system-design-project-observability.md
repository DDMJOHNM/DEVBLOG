---
title: 'Project: Observability Dashboard'
description: 'System design for a project management logging and cost monitoring tool'
category: 'System Design'
author: 'John Mason'
date: '2026-08-19 16:00'
---

A system to monitor errors, manage project costs, and track separate systems that use OpenAI and AWS.

## Architecture options

Three transport options for ingest and OpenAI integration. All share the same core backend (SQS → Laravel → RDS + S3).

| | **A. HTTPS-only** | **B. WebSocket ingest** | **C. OpenAI Realtime** |
| --- | --- | --- | --- |
| **Role** | Default: `POST` logs, `GET` dashboard + polling | Add `wss://` to your API for server push | Add OpenAI Realtime for voice sessions |
| **OpenAI (product)** | HTTPS chat/embeddings only | Same — no Realtime unless **C** added | Realtime token/session charges |
| **AWS edge** | API Gateway HTTP API only | HTTP + WebSocket routes | Same as A or B for your API |
| **Trade-off** | Simplest ops; polling overhead | Live updates; WS connection billing | Extra OpenAI cost; keep ingest WS separate from Realtime WS |
| **Est. AWS/month (POC)** | ~$35–110 | ~$40–120 | Same AWS as A or B; Realtime billed by OpenAI |

### A. Original — HTTPS-only ingest (default)

- Ingest via `POST /ingest/...` with API key auth
- Admin dashboard via `GET /api/projects/.../events` with polling or refresh
- OpenAI via HTTPS chat completions / embeddings only
- API Gateway HTTP API (REST) only

```mermaid
flowchart TB
  subgraph Clients["Clients"]
    App["Node app\n(POST log batches)"]
    UI["Admin UI\n(GET + poll / refresh)"]
  end

  subgraph OpenAIREST["OpenAI — HTTPS only\n(unless optional C)"]
    Chat["Chat Completions /\nembeddings REST"]
  end

  subgraph AWS["AWS — REST at edge only"]
    GW["API Gateway\nHTTP API only"]
    Ing["Ingestor\nLambda or container\nPOST → validate → SQS"]
    Q["SQS"]
    Lar["Laravel\nworkers + dashboard API"]
    Data["RDS + S3"]
  end

  App -->|"HTTPS POST\ningest_https"| GW
  UI -->|"HTTPS GET\ndashboard / cursor"| GW
  GW --> Ing
  Ing --> Q
  Q --> Lar
  Lar --> Data
  GW --> Lar
  App -->|"HTTPS"| Chat
```

Tag transport as `ingest_https` in metrics.

### B. Optional — WebSocket ingest

Browser/Node connects via `wss://` to **your API** only. Never confuse with `wss://api.openai.com/v1/realtime` (that is **C**).

```mermaid
flowchart LR
  subgraph Clients["Clients"]
    App["Node app\n(logs + business calls)"]
    UI["Admin UI"]
  end

  subgraph OpenAIREST["OpenAI — HTTPS only\n(unless optional C)"]
    Chat["Chat Completions /\nembeddings REST"]
  end

  subgraph AWS["AWS — optional WS edge"]
    GW["API Gateway\nHTTP + WebSocket"]
    L["Lambda ingestor\nvalidate → SQS"]
    Q["SQS"]
    LV["Laravel + tiny RDS\n(+ optional S3)"]
  end

  App -->|"wss ingest only"| GW
  UI --> GW
  GW --> L
  L --> Q
  Q --> LV
  App -->|"HTTPS"| Chat
```

Tag transport as `ingest_websocket`.

### C. Optional — OpenAI Realtime API

Separate WebSocket to OpenAI for voice/low-latency product flows. Observability ingest stays A or B.

```mermaid
flowchart TB
  subgraph Internet["Internet"]
    NodeApp["Node.js application\n(log stream → your API:\nHTTPS A or WebSocket B)"]
    AdminUI["Web admin UI"]
  end

  subgraph External["External — optional C only"]
    OpenAI["OpenAI Realtime API\nwss://api.openai.com/v1/realtime"]
    FutureBilling["Future: Cost Explorer,\nOpenAI Usage API"]
  end

  subgraph Region["AWS region (POC; multi-region later)"]
    subgraph Edge["Edge & access"]
      APIGW["API Gateway\nHTTPS / WebSocket, rate limits"]
    end

    subgraph Core["Ingestion & application"]
      Ingestor["Ingestor service\nvalidate, enrich, classify, route"]
      SQS["SQS"]
      Laravel["Laravel backend\nAPI, workers, RBAC"]
    end

    subgraph Data["Data plane"]
      DB[("Relational DB project / user / service_type,critical & persistent events")]
      S3[("S3 bulk / non-critical logs,~7 day lifecycle")]
      Cache[("Cache dashboard & hot reads")]
      DLQ["DLQ + replay"]
    end
  end

  NodeApp -.->|"optional C:\nRealtime if product needs it"| OpenAI
  NodeApp --> APIGW
  AdminUI --> APIGW
  APIGW --> Ingestor
  Ingestor --> SQS
  SQS --> Laravel
  Laravel --> DB
  Laravel --> Cache
  Laravel --> S3
  Ingestor -.-> DLQ
  SQS -.-> DLQ
  FutureBilling -.->|"future"| Ingestor
```

Name Realtime connections `openai_realtime_ws` in code so they never mix with `ingest_websocket`.

## Functional requirements

| ID | Requirement | A | B | C |
| --- | --- | --- | --- | --- |
| F1 | Ingest observability events via HTTPS `ingest_https` | Yes | Yes | Yes |
| F2 | Optional WebSocket ingest `ingest_websocket` | No | Yes | No |
| F3 | Super-admin UI: dashboard per project with persistent messages | Yes | Yes | Yes |
| F4 | Log identity: per project, per user, per service type | Yes | Yes | Yes |
| F5 | Capture text-to-voice and onboarding correction counts | Yes | Yes | Yes |
| F6 | Toggle logging on/off per project at ingestor | Yes | Yes | Yes |
| F7 | Supplemental metrics: latency, token usage, outcomes | Yes | Yes | Yes |
| F8 | Integrate AWS Cost Explorer (later) | Yes | Yes | Yes |
| F9 | Integrate OpenAI Usage API (later) | Yes | Yes | Yes |
| F10 | Optional OpenAI Realtime sessions | No | No | Yes |

## Non-functional requirements

| ID | Requirement | A | B | C |
| --- | --- | --- | --- | --- |
| NF1 | Scalability: design for growth; POC starts small | Yes | Yes | Yes |
| NF2 | Horizontal scaling path | Yes | Yes | Yes |
| NF3 | Regional placement (start single region) | Yes | Yes | Yes |
| NF4 | API Gateway rate limiting | Yes | Yes | Yes |
| NF5 | Acceptable latency for OpenAI and cross-component calls | Yes | Yes | Yes |
| NF6 | Cache for dashboard / hot reads | Yes | Yes | Yes |
| NF7 | DLQ + replay for failed ingest | Yes | Yes | Yes |
| NF8 | TLS (HTTPS / WSS) for client ↔ API | Yes | Yes | Yes |
| NF9 | RBAC: least-privilege admin | Yes | Yes | Yes |
| NF10 | Logging hygiene: `x-request-id`; no confidential prompt bodies | Yes | Yes | Yes |
| NF11 | Sensitive/token data per security policy | Yes | Yes | Yes |
| NF12 | Authentication on admin and ingest paths | Yes | Yes | Yes |
| NF13 | Live dashboard updates without aggressive polling | Partial | Yes | Partial |

## Constraints

| ID | Constraint | A | B | C |
| --- | --- | --- | --- | --- |
| C1 | Respect OpenAI API limits | Yes | Yes | Yes |
| C2 | AWS POC: low cost, single region, scale-out design | Yes | Yes | Yes |
| C3 | Message broker — Amazon SQS | Yes | Yes | Yes |
| C4 | Laravel for persistence and APIs | Yes | Yes | Yes |
| C5 | Critical events → relational DB | Yes | Yes | Yes |
| C6 | Non-critical logs → S3 (~7-day retention) | Yes | Yes | Yes |
| C7 | Observability does not require OpenAI Realtime | Satisfied | Satisfied | Additive only |

## Event schema

```json
{
  "schema_version": "1.0",
  "event_id": "550e8400-e29b-41d4-a716-446655440000",
  "event_type": "observability.log.v1",
  "severity": "info",
  "occurred_at": "2026-04-08T12:34:56.789Z",
  "project_id": "proj_123",
  "user_id": "usr_456",
  "service_type": "counsellor",
  "request_id": "req-abc-789",
  "tokens_used": 142,
  "latency_ms": 380,
  "has_correction": false,
  "has_recommended": false,
  "has_appointment": false,
  "provider": "openai",
  "model": "gpt-4o-realtime-preview"
}
```

## Load balancing and scaling

When latency rises from growing usage:

- **API Gateway** scales the edge automatically
- Add **multiple ingestor instances** behind the gateway
- Add **multiple Laravel API instances** for dashboard reads
- **Per region:** deploy replicas where customer data lives
- **SQS workers:** scale consumer count rather than load-balancing the queue itself
- **Data layer:** read replicas, RDS Proxy, cached dashboard reads, tenant/region partitioning before expecting load balancers to fix DB-bound latency

Back to [System Design](/posts/system-design.html).
