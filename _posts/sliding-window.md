---
title: 'Sliding Window'
description: 'Max subarray of size k in O(n) instead of O(n · k)'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-19 16:12'
---

A sliding window tracks a contiguous subarray (or substring) of size `k`. Add the incoming element, drop the outgoing one. One pass instead of recomputing each window from scratch.

**Time:** O(n)  
**Space:** O(1)

Brute force is O(n · k): for each start index, sum `k` elements.

## Example — max sum of size k

`arr = [3, 2, 7, 5, 9, 6]`, `k = 3` → window `[5, 9, 6]`, sum `20`.

1. Sum the first `k` items
2. Slide: `window_sum = window_sum - arr[i] + arr[i + k]`
3. Keep the best sum and its start index

## Code

```python
def max_sum_subarray(arr, k):
    window_sum = sum(arr[:k])
    max_sum = window_sum
    max_sum_index = 0

    for i in range(len(arr) - k):
        window_sum = window_sum - arr[i] + arr[i + k]
        if window_sum > max_sum:
            max_sum = window_sum
            max_sum_index = i + 1

    return arr[max_sum_index:max_sum_index + k], max_sum
```

## When to use

- Rate limiting, rolling analytics, token usage
- Fixed-size windows (max/min/avg of k)
- Variable-size windows (longest substring with at most k distinct chars) — grow/shrink with two pointers

**DS:** array, sometimes a deque for min/max in the window.

Back to [LeetCode patterns](/posts/leetcode.html).
