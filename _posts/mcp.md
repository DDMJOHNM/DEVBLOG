---
title: MCP
description: 'Using Model Context Protocol to inject private knowledge without training on your data'
category: 'Agentic AI'
author: 'John Mason'
date: '2026-08-19 12:55'
---

You can use a Model Context Protocol (MCP) server to inject private knowledge into an AI agent while ensuring that information is not used by OpenAI to train its models.

By running an MCP server locally or within your own infrastructure (e.g. behind a firewall), you maintain control over the data. The AI client (like Claude Desktop) only retrieves the necessary context from your private database, such as SQL or local Markdown files, without transferring the entire repository to the model provider.

## How to Ensure Data Privacy with MCP

To keep a private knowledge base out of OpenAI training, use these safeguards:

- **Run local MCP servers:** Local MCP servers act as a bridge between your agent and your private data. The agent can read local files, search documentation, or query local databases (like SQLite) without sending the data to the cloud.
- **Use Zero Data Retention (ZDR) keys:** When using OpenAI's API, enable Zero Data Retention so OpenAI does not store your input data for training.
- **Require human-in-the-loop approvals:** Configure the agent to require approval before executing any MCP tool call. This gives you visibility and control over what data is shared with the model.
- **Use secure in-memory data access:** The MCP server can perform semantic search (using local embeddings) on your data and only inject the relevant snippets into the prompt, rather than sending the entire private document.

## Important Considerations and Risks

MCP is useful for this purpose, but it is not without risks:

- **Data exfiltration:** If the MCP server is not properly secured, an attacker could potentially trick the agent into exfiltrating private data.
- **Insecure defaults:** By default, some MCP servers may lack authentication or encryption. Use Transport Layer Security (TLS) and robust authentication (like OAuth) to protect the connection.
- **Prompt injection:** A malicious prompt could, in theory, cause the agent to reveal the private data it has accessed via the MCP server.

For the highest level of security, use a reputable, self-hosted MCP server implementation and follow the principle of least privilege, so the agent only has access to the specific data it needs.

## Agentic AI Guardrails for MCP

Agentic AI guardrails for MCP servers are security measures, policies, and monitoring tools designed to govern how AI agents interact with external tools, APIs, and databases. As MCP becomes the standard protocol for connecting AI agents to real-world systems, these guardrails are crucial for preventing unauthorized data access, preventing "confused deputy" problems, and restricting harmful actions.

### The Need for MCP Security Guardrails

While MCP allows agents to perform tasks like running code or updating CRM systems, it also exposes new, significant risks:

- **"Toxic flow" and chaining hazards:** Agents can chain multiple tool calls, leading to unintended and dangerous interactions between different services.
- **Over-permissioning:** Agents may hold broad API tokens that provide more access than needed.
- **Malicious or vulnerable servers:** Third-party or poorly developed MCP servers can be compromised, feeding malicious data to the agent (poisoned context).
- **Unmonitored activity:** Local or rogue MCP server connections can run without enterprise visibility.

### Key Types of MCP Guardrails

- **MCP scanning and inventory:** Security tools (like Snyk) are used to scan and inventory active MCP servers, mapping which tools are connected, their origins, and their configurations.
- **Policy-driven access control:** Enforcing least-privilege access, where an agent's ability to call specific tools is restricted based on user or context.
- **Runtime protection and inspection:** Using an MCP gateway (e.g. Prompt Security, NOMA) to intercept, inspect, and filter traffic between the LLM and the MCP server, blocking harmful commands in real-time.
- **AI Bill of Materials (AI-BOM):** Cataloging all MCP servers, datasets, and models in use to identify vulnerabilities in the dependency chain.
- **Human-in-the-loop (HITL):** Requiring human approval for high-risk actions (e.g. deleting files, modifying production databases).

### Top Tools and Platforms for MCP Security

Several companies are now providing specialized solutions to manage MCP risk:

- **Snyk:** Offers MCP scanning to detect vulnerabilities in local or remote MCP servers.
- **Prompt Security:** Provides an AI gateway that acts as a secure proxy to inspect and sanitize MCP traffic.
- **NOMA Security:** Provides security posture management and runtime protection for MCP tool calling.
- **Harmonic Security:** Offers an MCP gateway for visibility and control over agentic workflows.
- **PointGuard AI:** Provides a platform for OAuth 2.0 authentication and granular tool authorization for MCPs.
- **Dynamo AgentWarden:** Provides risk detection and evaluation for AI agents and connected MCP servers.

### Best Practices for Securing MCP

1. **Validate before use:** Verify if an MCP server is on a trusted, official list, or test it in a sandboxed environment.
2. **Use a proxy/gateway:** Route all MCP traffic through a secure gateway to monitor and block malicious actions.
3. **Implement least privilege:** Scope permissions to the absolute minimum required for the agent to function.
4. **Log all activity:** Ensure full audit logging and traceability of the "chain of thought" from user query to tool execution.
