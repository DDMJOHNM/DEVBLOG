---
title: 'Two Pointers'
description: 'Find a pair in a sorted array in one O(n) pass'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-19 16:10'
---

Two pointers traverse an array or list in a single pass. Use them when you need a pair (or window) that satisfies a condition, instead of a nested loop.

**Time:** O(n)  
**Space:** O(1)

Brute force checking every pair is O(n²). On a **sorted** array, start at both ends and move inward.

## Example — Two Sum II

LeetCode 167. `numbers = [2, 7, 11, 15]`, `target = 9` → `[1, 2]` (1-indexed).

- Sum too small → move `left` right (need a larger number)
- Sum too big → move `right` left (need a smaller number)
- Equal → return the indices

## Code

```python
class Solution:
    def twoSum(self, numbers: list[int], target: int) -> list[int]:
        left, right = 0, len(numbers) - 1
        while left < right:
            total = numbers[left] + numbers[right]
            if total == target:
                return [left + 1, right + 1]
            if total < target:
                left += 1
            else:
                right -= 1
        return []
```

## When to use

- Sorted arrays: pairs, triplets, containers with most water
- Opposite-ends or same-direction scans
- Related: [fast and slow pointers](/posts/fast-slow-pointers.html) for cycles and midpoints

Back to [LeetCode patterns](/posts/leetcode.html).
