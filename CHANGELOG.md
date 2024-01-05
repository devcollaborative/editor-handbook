# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

### Changed

### Deprecated

### Removed

### Fixed

### Security

## [2.0.0] - 2024-01-05

- Changed: Order handbook posts by title ASC
- Changed: Set page.php as default for displaying handbook pages
- Added: Add readme.txt & update plugin headers
- Removed: reference to DevCollab Helpdesk

## [1.2.0] - 2023-06-06

### Added
- Custom capabilities for the Handbook post type
- Plugin activation & update hooks for managing capabilities

### Changed
- Handbook pages can now be viewed (but not edited) by Authors
- The default capability for viewing the handbook admin page is now `read_private_handbooks`
- Show helpdesk info only for users who can edit handbook posts

## [1.1.0] - 2023-01-30

### Added
- This changelog file
- GitHub Plugin URI to main plugin file to allow this plugin to be updated with the Git Updater plugin

## [1.0.0] - 2023-01-18

### Added

- Initial release

[unreleased]: https://github.com/devcollaborative/editor-handbook/compare/v2.0.0...HEAD
[2.0.0]: https://github.com/devcollaborative/editor-handbook/compare/v1.2.0...v2.0.0
[1.2.0]: https://github.com/devcollaborative/editor-handbook/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/devcollaborative/editor-handbook/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/devcollaborative/editor-handbook/releases/tag/v1.0.0
