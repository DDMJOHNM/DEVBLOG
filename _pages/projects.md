---
title: Projects
description: 'Selected project write-ups'
---

# Projects

## Positive Thought Counselling Onboarding Module

Voice-first client onboarding and counsellor matching. Staff sign in, a client speaks name and email, GPT-4o extracts those fields for review, then free-text concerns are matched to a practitioner and saved on the client record.

Next.js BFF on AWS Amplify, OpenAI (Whisper + gpt-4o + embeddings), Chroma locally / Pinecone in production, Go backend with DynamoDB.

[Full write-up: architecture, file map, and trade-offs](posts/positive-thought-counselling.html)

```mermaid
flowchart LR
  User["User"] --> UI["Next.js VoiceAgent"]
  UI --> Whisper["Whisper"]
  UI --> GPT["gpt-4o extract"]
  UI --> Rec["Vector match"]
  Rec --> Store["Chroma or Pinecone"]
  UI --> Go["Go API"]
  Go --> DDB["DynamoDB"]
```

## Positive Thought Counselling Dental Module

```mermaid
flowchart LR
  A[Idea] --> B[Build]
  B --> C[Ship]
```

## Logging and Subscription System

```mermaid
flowchart LR
  A[Idea] --> B[Build]
  B --> C[Ship]
```

## Serverless Online Shopping Cart

```mermaid
flowchart LR
  A[Idea] --> B[Build]
  B --> C[Ship]
```
