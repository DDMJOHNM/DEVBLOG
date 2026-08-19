---
title: System Security
description: 'Threat modeling, authentication, encryption, and cloud security'
category: 'System Design'
author: 'John Mason'
date: '2026-08-19 16:00'
---

Security is a non-functional requirement that becomes more complicated in distributed systems. It covers data in transit and at rest, authentication, secure APIs, and network-level protection.

## CIA triad

- **Confidentiality** — data accessible only to authorized parties
- **Integrity** — data is accurate and unmodified
- **Availability** — systems and data accessible when needed

## Threat modeling

Identify what to protect before building defenses.

- **Attack surface** — all entry points
- **Assets** — data, credentials, infrastructure worth protecting

### STRIDE model

| Threat | Description |
| --- | --- |
| Spoofing | Impersonating a user or system |
| Tampering | Modifying data or code |
| Repudiation | Denying an action took place |
| Information disclosure | Exposing data to unauthorized parties |
| Denial of service | Making the system unavailable |
| Elevation of privilege | Gaining unauthorized access |

### Common attack vectors

- Insecure APIs
- Misconfigured servers
- Poor authentication
- Open ports and services

### Common attacks and mitigations

| Attack | Mitigation |
| --- | --- |
| DDoS | Rate limiting, CDN absorption |
| Man in the middle | HTTPS/TLS |
| Injection | Input validation, parameterized queries, WAF |
| Spoofing | MFA, token-based auth, IP whitelisting |

## Secure SDLC — shift left

Integrate security early in the development lifecycle:

1. **Requirements** — threat modeling
2. **Design** — secure architecture
3. **Development** — secure coding practices
4. **Testing** — fuzzing, penetration testing
5. **Deployment** — secrets management
6. **Maintenance** — patch management

### Best practices

- Security by design
- Use encryption at rest and in transit
- Harden infrastructure (firewalls, VPCs)
- Validate inputs and sanitize outputs
- Monitor and log activity (stored securely)

## Authentication and authorization

- **Authentication** — verify who the user is
- **Authorization** — determine what the authenticated user is allowed to do

### Approaches

| Method | Pros | Cons |
| --- | --- | --- |
| Basic auth | Simple | Insecure without HTTPS |
| Session-based | Easy to implement | Hard to scale in distributed systems |
| Token-based (JWT) | Stateless, scales easily | Requires secure token storage |
| OAuth 2.0 | Delegated access without exposing credentials | Complexity |
| OpenID Connect | Identity layer on OAuth (SSO) | Complexity |

### Access control models

- **RBAC** — role-based; simple and scalable, less granular
- **ABAC** — attribute-based; fine-grained but complex
- **DAC** — resource owner decides access
- **MAC** — central authority based on security policies

### Single sign-on and identity federation

SSO lets users authenticate once across multiple systems. Identity federation uses external identity providers (e.g. Google, Okta) for seamless access.

## Data protection

Breaches and man-in-the-middle attacks threaten user trust. Regulations like GDPR require proper data handling.

### Encryption

Plaintext → ciphertext → decryption using a secret key.

- **At rest** — protects stored data (cloud storage, databases)
- **In transit** — TLS/SSL secures data during transmission

**Symmetric** — one shared key (fast). **Asymmetric** — public/private key pair (secure key exchange). Often used together in TLS handshakes.

### TLS/SSL and HTTPS

HTTPS = HTTP over TLS. Ensures confidentiality, integrity, and authenticity.

TLS handshake: client and server negotiate ciphers, exchange keys asymmetrically, then use symmetric encryption for data transfer.

### Hashing

One-way transformation for storing passwords. **Salting** adds random data to prevent rainbow table attacks. Use bcrypt or Argon2.

### PKI (Public Key Infrastructure)

Manages digital certificates. Certificate Authorities (CAs) sign certificates to establish trust chains.

## Secure API communication

- HTTPS everywhere
- Auth tokens (JWT, OAuth)
- Rate limiting
- IP whitelisting
- Mutual TLS (mTLS) for service-to-service

## Network and infrastructure security

### External threats

DDoS, intrusion, IP spoofing.

### Internal risks

Misconfigured firewalls, lateral movement within the network.

Cloud-native adoption increases attack surface — reliability and user trust depend on proper security.

### Firewalls and reverse proxies

- **Firewalls** — filter traffic by IP, port, protocol (network, host, cloud)
- **Reverse proxies** — route traffic, mask backend identity, rate limiting (Nginx, AWS ALB)

### Network segmentation

DMZ, internal network, database zone. Limit lateral movement with firewalls, subnets, and private VLANs. In cloud: VPCs, security groups, NACLs.

### Zero trust

Never trust, always verify — even within the network. Mutual TLS, least privilege, continuous verification.

## Cloud security

**Shared responsibility model** — the cloud provider secures the infrastructure; you secure your data and configuration.

- IAM with least privilege and MFA
- Encryption (EBS, S3, RDS)
- Audit logging
- CSPM tools for posture management

### Serverless and containers

- **Serverless:** IAM per function, timeouts, API Gateway access control
- **Containers:** regular image scanning, no root user, minimal privileges

### Microservices security

- JWT and mTLS for service-to-service communication
- API gateway for validation, auth, and rate limiting
- Service mesh for fine-grained TLS policies

## OWASP Top 10

Common vulnerabilities to be aware of and mitigate:

- Injection
- Broken authentication
- Sensitive data exposure
- Security misconfiguration
- XSS, CSRF, SSRF

Back to [System Design](/posts/system-design.html).
