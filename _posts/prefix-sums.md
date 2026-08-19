---
title: 'Prefix Sums'
description: 'Range sum queries in O(1) after an O(n) preprocess'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-19 16:15'
---

A prefix array stores running totals so a range sum is one subtraction, not a scan.

**Preprocess:** O(n)  
**Each query:** O(1)  
**Total for q queries:** O(n + q)

Brute force is O(n · q): each `sumRange` walks from `left` to `right`. Prefix sums pay n once up front, then cheap queries.

O(1) means the query work stays about the same no matter how big the array is.

## Example — Range Sum Query Immutable

LeetCode 303. `nums = [-2, 0, 3, -5, 2, -1]`

```
prefix = [0, -2, -2, 1, -4, -2, -3]
index:    0   1   2  3   4   5   6
```

`prefix[right + 1]` is the sum through index `right`.  
`prefix[left]` is the sum before index `left`.  
Difference is the sum between the two indices.

Python slices are half-open: `x[start:stop]` excludes `stop`, so a closed range `[left, right]` is `x[left:right + 1]`.

LeetCode-style input:

```
["NumArray","sumRange","sumRange","sumRange"]
[[[-2,0,3,-5,2,-1]],[0,2],[2,5],[0,5]]
```

Construct with the inner array, then call `sumRange`.

## Code

```python
class NumArray:
    def __init__(self, nums: list[int]):
        self.prefix = [0]
        for num in nums:
            self.prefix.append(self.prefix[-1] + num)

    def sumRange(self, left: int, right: int) -> int:
        return self.prefix[right + 1] - self.prefix[left]
```

## When to use

- Range sum query (immutable array)
- Cumulative / prefix sums
- Subarray sum equals k (map of prefix frequencies)

Back to [LeetCode patterns](/posts/leetcode.html).
