---
title: 'Modified Binary Search'
description: 'Search a rotated sorted array in logarithmic time'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-27 12:00'
---

Modified binary search adapts ordinary binary search for rotated sorted arrays. At each step, determine which half is sorted, then check whether the target lies inside that half.

**Time:** O(log n)  
**Space:** O(1)

## Example — Search in Rotated Sorted Array

LeetCode 33:

```text
Input: nums = [4,5,6,7,0,1,2], target = 0
Output: 4

Input: nums = [4,5,6,7,0,1,2], target = 3
Output: -1

Input: nums = [1], target = 0
Output: -1
```

For the first example, the target `0` is at index `4`. The array is not fully sorted, but one side of every midpoint is always sorted.

## Code

```python
from typing import List

class Solution:
    def search(self, nums: List[int], target: int) -> int:
        low = 0
        high = len(nums) - 1

        while low <= high:
            mid = (low + high) // 2

            if nums[mid] == target:
                return mid

            if nums[low] <= nums[mid]:
                if nums[low] <= target < nums[mid]:
                    high = mid - 1
                else:
                    low = mid + 1
            else:
                if nums[mid] < target <= nums[high]:
                    low = mid + 1
                else:
                    high = mid - 1

        return -1
```

## How it works

- If `nums[low] <= nums[mid]`, the left half is sorted.
- Otherwise, the right half is sorted.
- Search the sorted half when the target is within its bounds.
- Search the other half when it is not.

## When to use

- Search in a rotated sorted array
- Find a rotation point or minimum value
- Find boundaries or peaks in ordered data
- Solve search problems where one half remains sorted

Back to [LeetCode patterns](/posts/leetcode.html).
