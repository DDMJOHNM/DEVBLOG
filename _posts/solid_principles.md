---
title: 'SOLID Principles'
description: 'Five principles of object-oriented design'
category: Interviewing
author: 'John Mason'
date: '2026-08-19 12:00'
---

## SRP — Single Responsibility Principle

A class should have only one reason to change, meaning it should only have one job or responsibility.

**Example:** Consider a class `Report`. Instead of giving it methods for both generating and printing a report, separate these functions into two classes: `ReportGenerator` and `ReportPrinter`.

## OCP — Open-Closed Principle

Software entities should be **open for extension** but **closed for modification**.

This means you should be able to add new functionality without changing the existing code.

**Example:** An `Invoice` class can be extended to support different types of invoices, like `ProformaInvoice` or `CreditInvoice`, without modifying the original `Invoice` class.

## LSP — Liskov Substitution Principle

Objects of a superclass should be replaceable with objects of its subclasses without affecting the correctness of the program.

**Example:** If `Bird` is a superclass and `Duck` is a subclass, then you should be able to replace `Bird` with `Duck` without altering the program's behavior.

## ISP — Interface Segregation Principle

Clients should not be forced to depend on interfaces they do not use.

This principle suggests splitting large interfaces into smaller ones.

**Example:** Instead of one large `Worker` interface, have separate interfaces like `Workable`, `Feedable`, and `Maintainable` for different types of work.

## DIP — Dependency Inversion Principle

High-level modules should not depend on low-level modules. Both should depend on abstractions.

Additionally, abstractions should not depend on details; details should depend on abstractions.

**Example:** An `OrderProcessor` class should depend on an `IOrder` interface, not on a concrete `Order` class. This makes it easy to introduce new types of orders.

## References

- [The SOLID Principles in Software Development](https://codefinity.com/blog/The-SOLID-Principles-in-Software-Development)
