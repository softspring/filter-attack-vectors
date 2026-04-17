# Filter Attack Vectors Features

Functional definition for `softspring/filter-attack-vectors`.

This file defines the expected behavior and functional scope of the component. It describes what the package should do when it is loaded in an application.

## Purpose

- Stop a small set of obviously unwanted requests before the application continues processing them.
- Provide a very small defensive layer for common noisy attack patterns seen in public PHP applications.

## Main Features

- Load through Composer autoload so the filter is applied early in the request lifecycle.
- Return a `404 Not Found` response for blocked requests.
- Stop execution immediately when a request matches a blocked pattern.
- Block a very small set of clearly unwanted probe requests that do not belong to the application.
- Focus on recurring attack-noise patterns that are low risk to block in a normal front-controller PHP application.

## Expected Usage

- Install the package in applications that want a very small early filter for common probe requests.
- Let Composer autoload include the package without extra framework configuration.
- Use it as a coarse first layer, not as a complete security solution.

## Operational Expectations

- Safe requests should continue normally.
- Blocked requests should stop before the main application handles them.
- The package should stay easy to audit because the filtering rules are intentionally small and explicit.

## Current Limits

- The package is intentionally simple and not configurable.
- It uses a fixed list of internal patterns.
- It is not a replacement for firewall, WAF, routing, or application-level security checks.
