---
title: 'Overlapping Intervals'
description: 'Merge overlapping intervals after sorting by start time'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-27 09:54'
---

Sort intervals by their start value, then compare each interval with the last interval already in the result.

**Time:** O(n log n) for sorting  
**Space:** O(n) for the result

If the last merged interval ends before the current interval starts, there is no overlap, so append the current interval. Otherwise, extend the last interval's end.

## Example — Merge Intervals

LeetCode 56:

```text
Input:  [[1,3], [2,6], [8,10], [15,18]]
Output: [[1,6], [8,10], [15,18]]
```

After sorting, `[1,3]` and `[2,6]` overlap because `3 >= 2`, so they become `[1,6]`. The remaining intervals do not overlap.

## Code

```python
from typing import List

class Solution:
    def merge(self, intervals: List[List[int]]) -> List[List[int]]:
        intervals.sort(key=lambda interval: interval[0])
        merged = []

        for interval in intervals:
            if not merged or merged[-1][1] < interval[0]:
                merged.append(interval)
            else:
                merged[-1][1] = max(merged[-1][1], interval[1])

        return merged
```

The condition uses short-circuit evaluation: when `merged` is empty, Python does not evaluate `merged[-1]`.

## When to use

- Merge overlapping ranges
- Insert a new interval
- Meeting-room and scheduling problems
- Detect gaps or conflicts between time ranges

Back to [LeetCode patterns](/posts/leetcode.html).
