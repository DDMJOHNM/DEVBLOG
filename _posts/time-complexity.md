---
title: Time Complexity
description: 'Must-know time complexity patterns from O(1) to O(n!)'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-19 12:52'
---

Ten time complexity patterns every engineer should recognize, ordered from fastest to slowest.

## Fastest

- **O(1)** — Hash lookups and index access. Time does not grow with input size.
- **O(log n)** — Halving loops (binary search). The problem is cut in half each step.

## Linear

- **O(n)** — Single loops over the input.
- **O(n + m)** — Sequential loops over two independent inputs.

## Sorting standard

- **O(n log n)** — Divide and conquer (merge sort, heap sort). Typical bound for comparison sorts.

## Quadratic

- **O(n²)** — Nested loops: for each of n items, scan n items.
- **O(n²)** — Triangular loops: the inner loop shrinks (`j = i + 1` to `n`), but it is still quadratic.

If something is slow, check nested loops first.

## Slowest

- **O(2ⁿ)** — Branching recursion (each call makes two recursive calls). Avoid for large n.
- **O(n!)** — Permutations. Factorial growth; unusable on large datasets.

Recognizing these structures is how you pass technical interviews and write scalable production code.
