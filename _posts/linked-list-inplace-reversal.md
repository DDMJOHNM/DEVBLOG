---
title: 'Linked List In-Place Reversal'
description: 'Reverse a singly linked list with three pointers and O(1) extra space'
category: 'Data Structures and Algorithms'
author: 'John Mason'
date: '2026-08-19 16:14'
---

Reverse a linked list by flipping each node's `next` pointer as you walk. Three pointers: `prev`, `current`, `next`.

**Time:** O(n)  
**Space:** O(1)

Copying into an array and walking it backwards uses O(n) extra space and extra passes. In-place reversal uses constant extra memory.

## Example — Reverse Linked List

LeetCode 206. `1 → 2 → 3 → 4 → 5` becomes `5 → 4 → 3 → 2 → 1`.

Start with `prev = None`, `current = head`. Each step:

1. Save `next = current.next`
2. Point `current.next` at `prev`
3. Advance `prev` and `current`

When `current` is `None`, `prev` is the new head.

## Code

```python
from typing import Optional

class ListNode:
    def __init__(self, val=0, next=None):
        self.val = val
        self.next = next

class Solution:
    def reverseList(self, head: Optional[ListNode]) -> Optional[ListNode]:
        prev = None
        current = head
        while current is not None:
            nxt = current.next
            current.next = prev
            prev = current
            current = nxt
        return prev
```

## When to use

- Reverse entire list or a sublist (`m` to `n`)
- Palindrome linked list (reverse the second half)
- Reorder list / reverse in groups of k

Related: [fast and slow pointers](/posts/fast-slow-pointers.html)

Back to [LeetCode patterns](/posts/leetcode.html).
