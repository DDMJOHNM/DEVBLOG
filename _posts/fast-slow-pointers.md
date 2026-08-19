---
title: 'Fast and Slow Pointers'
description: 'Detect cycles and find the middle of a linked list'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-19 16:11'
---

Two pointers move at different speeds (Floyd's cycle detection / tortoise and hare). The fast pointer moves twice as far as the slow pointer each step.

**Time:** O(n)  
**Space:** O(1)

## What it finds

- **Cycle:** if they meet, the list loops
- **Middle:** when fast reaches the end, slow is at the midpoint
  - Odd length → slow is at the middle
  - Even length → slow is at the start of the second half

## Example — Linked List Cycle

LeetCode 141. Walk until fast cannot take two steps. If `slow` and `fast` land on the same node, there is a cycle.

`return False` belongs **after** the loop, not inside it. Inside the loop it would exit after the first mismatch.

## Code

```python
from typing import Optional

class ListNode:
    def __init__(self, x: int):
        self.val = x
        self.next = None

class Solution:
    def hasCycle(self, head: Optional[ListNode]) -> bool:
        slow = head
        fast = head
        while fast is not None and fast.next is not None:
            slow = slow.next
            fast = fast.next.next
            if slow == fast:
                return True
        return False
```

## When to use

- Cycle detection in a linked list
- Finding the middle node
- Palindrome linked list (find middle, reverse second half)

Related: [two pointers](/posts/two-pointers.html), [in-place reversal](/posts/linked-list-inplace-reversal.html)

Back to [LeetCode patterns](/posts/leetcode.html).
