---
title: LeetCode
description: 'Interview patterns and Big O growth rates'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-19 12:00'
---

## Passing LeetCode interviews

- Learn patterns
- Practice tagged questions
- Understand data structures

## Asymptotic notations

There are mainly three asymptotic notations:

- **Big O (O):** Worst-case upper bound
- **Big Omega (Ω):** Best-case lower bound
- **Big Theta (Θ):** Tight bound for average or exact growth

## Growth rates

| Complexity | Name | Growth Rate | Feasibility for Large N |
| --- | --- | --- | --- |
| O(1) | Constant | Flat | Excellent |
| O(log n) | Logarithmic | Very slow growth | Excellent |
| O(n) | Linear | Steady growth | Good |
| O(n log n) | Linearithmic | Moderate growth | Good |
| O(n²) | Quadratic | Rapid growth | Poor (for very large N) |
| O(2ⁿ) | Exponential | Extremely rapid growth | Very poor |

Understanding these complexities is vital for choosing the most efficient algorithm for a given problem. More efficient algorithms (those higher up on this list) are crucial for handling large data sets effectively.

### O(1) — Constant Time

The execution time stays exactly the same, no matter how much data you throw at it.

**Example:** Looking up an item in an array by its index, or checking if a number is even or odd.

### O(log n) — Logarithmic Time

The execution time grows by one step every time the input size doubles. This is highly efficient for massive datasets.

**Example:** Binary search in a sorted array.

### O(n) — Linear Time

The execution time grows in direct proportion to the size of the input. If the data doubles, the time doubles.

**Example:** A single `for` loop searching for a specific item in an unsorted list.

### O(n log n) — Linearithmic Time

This is slightly worse than linear time but still very efficient. It usually happens when you divide a problem into smaller pieces, solve them, and then combine them.

**Example:** Efficient sorting algorithms like Merge Sort and Quick Sort.

### O(n²) — Quadratic Time

The execution time grows proportionally to the square of the input size. If the data doubles, the time quadruples (\(2^2 = 4\)). It becomes very slow for large datasets.

**Example:** Nested loops, like checking every element in a list against every other element (e.g. Bubble Sort).

### O(2ⁿ) — Exponential Time

The execution time doubles with every single element added to the input. This quickly becomes unusable, even for small inputs.

**Example:** Finding all subsets of a set, or the naive recursive calculation of Fibonacci numbers.

## References

- [Neo Kim (LinkedIn)](https://lnkd.in/p/ekpGg3rN)
- [YouTube: Big O](https://www.youtube.com/watch?v=DjYZk8nrXVY)
- [YouTube: Complexity](https://www.youtube.com/watch?v=k-BVLx3oh1g&t=57s)
- [Leetcode Patterns](https://blog.algomaster.io/p/15-leetcode-patterns)

## The 12 patterns you should learn

These are the patterns that show up constantly in real SaaS work — and they map directly to product-engineering experience.

Practice notes:

- [Two pointers](/posts/two-pointers.html)
- [Fast and slow pointers](/posts/fast-slow-pointers.html)
- [Sliding window](/posts/sliding-window.html)
- [Monotonic stack](/posts/monotonic-stack.html)
- [Linked list in-place reversal](/posts/linked-list-inplace-reversal.html)
- [Prefix sums](/posts/prefix-sums.html)
- [Overlapping intervals](/posts/overlapping-intervals.html)
- [Top K elements](/posts/top-k-elements.html)
- [Modified binary search](/posts/modified-binary-search.html)

### 1. Hash-based lookup

Used everywhere:

- caching
- deduplication
- routing
- config maps
- user/session lookup

**DS:** HashMap, Set

**Why:** Already used in Node, Go, PHP.

### 2. Queue-based processing

Critical for:

- Kafka
- SQS
- background jobs
- async workflows
- retry logic

**DS:** Queue, Circular Queue

**Why:** Kafka pipelines and async job processing.

### 3. Graph traversal

Shows up in:

- dependency resolution
- workflow engines
- routing
- relationships
- permissions

**DS:** Graph, adjacency list

**Patterns:** BFS, DFS

**Why:** Useful for product-workflow logic.

### 4. Tree structures

Used in:

- UI component trees
- JSON parsing
- ASTs
- hierarchical data
- menus, org charts, categories

**DS:** Tree, Trie

**Patterns:** recursion, depth traversal

### 5. Sliding window

Perfect for:

- rate limiting
- analytics
- monitoring
- token usage tracking

**DS:** Deque

**Why:** Shows up in observability and product analytics.

**Notes:** [Sliding window](/posts/sliding-window.html)

### 6. Two-pointer pattern

Useful for:

- merging sorted data
- deduplication
- pagination
- stream processing

**DS:** Arrays, linked lists

**Why:** Shows up in backend data pipelines.

**Notes:** [Two pointers](/posts/two-pointers.html) · [Fast and slow pointers](/posts/fast-slow-pointers.html) · [In-place reversal](/posts/linked-list-inplace-reversal.html)

### 7. Binary search

Used for:

- feature flags
- config lookup
- sorted data
- performance-critical search

**DS:** Sorted arrays, trees

**Why:** Essential for performance tuning.

**Notes:** [Modified binary search](/posts/modified-binary-search.html)

### 8. Dynamic programming (lightweight)

Not heavy LeetCode DP — just:

- caching subresults
- memoization
- avoiding repeated expensive calls

**DS:** HashMap

**Why:** Useful in AI workflows, LangChain, and caching.

### 9. Greedy algorithms

Used in:

- scheduling
- batching
- resource allocation
- workflow optimisation

**DS:** Arrays, heaps

**Why:** Shows up in distributed systems and product logic.

**Notes:** [Overlapping intervals](/posts/overlapping-intervals.html) · [Top K elements](/posts/top-k-elements.html)

### 10. Topological sorting

Critical for:

- dependency ordering
- build pipelines
- workflow steps
- DAG-based systems (Airflow)

**DS:** Graph

**Why:** Directly relevant to Airflow and workflow orchestration.

### 11. Union-Find / Disjoint Sets

Useful for:

- grouping
- clustering
- connected components
- merging datasets

**DS:** Disjoint set

**Why:** Shows up in data-heavy product features.

### 12. Caching patterns

The most important for SaaS:

- LRU cache
- LFU cache
- write-through
- write-back
- cache invalidation

**DS:** HashMap + LinkedList

**Why:** Core to distributed systems.

## The 5 patterns that matter most for interviews

The interview-ready list:

1. HashMap / Set
2. Queue / Stack — [monotonic stack](/posts/monotonic-stack.html)
3. Binary Search
4. Sliding Window — [sliding window](/posts/sliding-window.html)
5. Graph traversal (BFS/DFS)

These cover 80% of real interview questions.

## Product-engineer-specific patterns

These are the ones that differentiate you:

- Event-driven architecture
- CQRS + event sourcing
- Saga pattern
- Circuit breaker
- Retry + backoff
- Idempotency
- Distributed locking
- Workflow orchestration (DAGs)

These matter far more than LeetCode for product-engineering roles.
