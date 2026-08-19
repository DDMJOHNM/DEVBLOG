---
title: Redis
description: 'Redis and RedisInsight local development'
category: Databases
author: 'John Mason'
date: '2026-08-19 12:39'
---

## Local Dev Setup

Start RedisInsight (persists data in a named volume):

```bash
docker run -d --name redisinsight -p 5540:5540 -v redisinsight:/data redis/redisinsight:latest
```

Open [http://localhost:5540](http://localhost:5540)

Stop the container:

```bash
docker stop redisinsight
```

Connection string:

```
redis://default@redis:6379
```
