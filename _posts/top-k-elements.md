---
title: 'Top K Elements'
description: 'Find the largest elements with a heap or Quickselect'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-27 09:55'
---

Top K problems ask for the largest or smallest `k` values without fully sorting the input.

A min-heap of size `k` finds all k largest elements in **O(n log k)** time and **O(k)** space. Quickselect finds the kth largest value in **O(n)** average time, with an **O(n²)** worst case.

## Example — Kth Largest Element

LeetCode 215:

```text
nums = [3, 2, 1, 5, 6, 4], k = 2
answer = 5
```

Choose a pivot and split the values into `greater`, `equal`, and `smaller` partitions. Only continue into the partition containing the kth largest value.

With pivot `5`, `greater = [6]` and `equal = [5]`. Since `k = 2` falls in `greater + equal`, the answer is `5`.

## Code

```python
from typing import List

class Solution:
    def findKthLargest(self, nums: List[int], k: int) -> int:
        pivot = nums[len(nums) // 2]
        greater = [x for x in nums if x > pivot]
        equal = [x for x in nums if x == pivot]
        smaller = [x for x in nums if x < pivot]

        if k <= len(greater):
            return self.findKthLargest(greater, k)

        if k <= len(greater) + len(equal):
            return pivot

        return self.findKthLargest(
            smaller,
            k - len(greater) - len(equal),
        )
```

Subtracting `len(greater) + len(equal)` converts `k` into its rank within the `smaller` partition.

## When to use

- Kth largest or kth smallest value
- Top k frequent elements
- K closest points
- Streaming leaderboards

Use a heap when you need all k values or process a stream. Use Quickselect when you need one ranked value from an in-memory array.

Back to [LeetCode patterns](/posts/leetcode.html).
