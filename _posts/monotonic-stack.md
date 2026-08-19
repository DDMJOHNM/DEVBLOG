---
title: 'Monotonic Stack'
description: 'Next greater or next smaller element in O(n)'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-19 16:13'
---

A monotonic stack stays sorted (increasing or decreasing). Use it to find the next greater or next smaller element for every index in one pass.

**Time:** O(n + m)  
**Space:** O(n)

Brute force nested loops are O(n²). Each index is pushed once and popped at most once, so the inner `while` is amortized O(1).

`stack.append(i)` belongs **after** the `while`, not inside it. If the stack starts empty and you only append inside the loop, the condition never becomes true.

## Example — Next Greater Element I

LeetCode 496. `nums1` is a subset of `nums2`. For each value in `nums1`, find the first greater number to its right in `nums2`. None → `-1`.

`nums1 = [4, 1, 2]`, `nums2 = [1, 3, 4, 2]` → `[-1, 3, -1]`

Scan **nums2**. When a bigger value arrives, it is the next greater for everything you pop. Store that in a map, then look up **nums1**. Do not write `result[stack.pop()]` if the stack holds nums2 indices and `result` is aligned with nums1.

| i | nums2[i] | action | next_greater |
| --- | --- | --- | --- |
| 0 | 1 | push | `{}` |
| 1 | 3 | 3 > 1 → pop | `{1: 3}` |
| 2 | 4 | 4 > 3 → pop | `{1: 3, 3: 4}` |
| 3 | 2 | 2 < 4 | 4 and 2 stay `-1` |

## Code

```python
from typing import List

class Solution:
    def nextGreaterElement(self, nums1: List[int], nums2: List[int]) -> List[int]:
        stack = []
        next_greater = {}
        for i in range(len(nums2)):
            while stack and nums2[i] > nums2[stack[-1]]:
                next_greater[nums2[stack.pop()]] = nums2[i]
            stack.append(i)
        return [next_greater.get(num, -1) for num in nums1]
```

The two scans are over **different** arrays (nums2 then nums1), not two passes of the same array.

## When to use

- Next greater / next smaller element
- Daily temperatures, largest rectangle in histogram
- Any "nearest greater/smaller to the right/left" query

`stack[-1]` is the last element (the top).

Back to [LeetCode patterns](/posts/leetcode.html).
