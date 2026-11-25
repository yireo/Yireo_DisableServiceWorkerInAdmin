# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.0.3] - 25 November 2026
### Changed
- Requires PHP 8.2 up to 8.5 (PHP 8.1 support dropped) and Magento 2.4 (magento/framework ^103.0); older Magento versions are no longer supported

### Fixed
- Admin script was blocked under a strict Content Security Policy; it is now rendered with a CSP nonce
- Service workers outside the admin scope (e.g. the storefront PWA) were unregistered as well; only workers covering the admin URL are removed now
- Admin page could still be served by the old service worker; the page now reloads once after unregistering
- Removed the unneeded dependency on Magento_Backend

## [0.0.2] - 29 July 2020
### Added
- Magento 2.4 compatibility

## [0.0.1] - Undocumented
