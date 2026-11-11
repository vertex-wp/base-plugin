# Ephpicman Plugin Starter

A reusable starter repository for building Ephpicman WordPress plugins. It provides a minimal plugin entry point, a product lifecycle class, shared Vertex framework integration, translation automation, and basic CI. It intentionally excludes product-specific features and speculative abstractions.

## Platform requirements

The plugin's declared minimum requirements are:

- **PHP 8.0** — declared as `Requires PHP: 8.0` in `index.php`.
- **WordPress 6.3** — declared as `Requires at least: 6.3` in `index.php`.

Keep these values aligned with the plugin header. If a product derived from this template requires newer versions, raise the declarations and update the related documentation, PHPCS configuration, and CI coverage. Do not lower the requirements below what the product code and synchronized Vertex version actually support.

These are minimum compatibility requirements, not recommendations to run outdated software. For production sites, use currently supported PHP and WordPress releases.

## Architecture and request lifecycle

Vertex is the shared framework responsible for orchestrating products built on it. WordPress remains the host platform and continues to own its native plugin hooks.

1. WordPress loads `index.php`, which guards against direct access, defines the plugin file constant, loads the synchronized Vertex bootstrap and the plugin class, and registers the product with `VertexLoader`.
2. The entry point connects the activation and deactivation methods to WordPress and registers the plugin's initialization method on `init`.
3. `src/Plugin.php` registers the active plugin's directory with `Vertex\App` during initialization and loads the plugin's translations.
4. The Vertex bootstrap registers its autoloader during `after_setup_theme` and invokes `Vertex\App::getInstance()->run()` on `wp_loaded`.
5. Keep product behaviour in the product's own source files. Shared framework code belongs in `vertex/` and is maintained by the Vertex synchronization workflow.

The starter's lifecycle methods are intentionally small placeholders. Add behaviour only when the product has a concrete requirement. Do not move WordPress-native activation or deactivation responsibilities into Vertex.

## Repository structure

```text
index.php                              Plugin metadata, bootstrap, and WordPress hooks
src/Plugin.php                         Plugin lifecycle and initialization
vertex/bootstrap.php                   Shared Vertex loader/bootstrap
vertex/src/                            Synchronized Vertex framework source
languages/                             POT template and translated PO/MO catalogues
.github/workflows/php-lint.yml         PHP syntax checks
.github/workflows/translations.yml    Translation catalogue generation and compilation
.github/workflows/sync-vertex.yml      Scheduled and manual Vertex synchronization
phpcs.xml.dist                         WordPress Coding Standards configuration
LICENSE                                GPL-2.0-or-later licence notice
```

The `vertex/` directory is populated by the first successful run of the Vertex synchronization workflow.

## Creating a plugin from this template

Complete this checklist after creating a repository from the template and before treating it as a product repository.

### 1. Rename and identify the plugin

Update all starter identity values, including:

- Plugin name, description, URI, and author details in the header of `index.php`.
- Repository/folder slug and installation instructions.
- Namespace in `src/Plugin.php` and the matching namespace passed to `VertexLoader::register()`.
- Text Domain in `index.php`, every translation call, and translation filenames.
- PHPDoc `@package` annotations.
- The plugin file constant, if you rename it, and every reference to it.
- README title, links, examples, and other product-specific documentation.

Keep the namespace unique to the product. Keep the Text Domain stable and unique, and aligned with the plugin slug under WordPress internationalisation conventions. Update translation workflow paths and filenames whenever the domain or catalogue names change.

### 2. Preserve platform requirements

The template declares **PHP 8.0** and **WordPress 6.3** as its minimum requirements. The same values are reflected in `phpcs.xml.dist` and the PHP lint workflow's minimum-version coverage.

When raising either minimum, update the plugin header, this section, PHPCS configuration where applicable, and CI coverage together. Do not claim compatibility with a version that is not covered by the code and its dependencies.

### 3. Configure translations

- Wrap user-facing translatable strings in WordPress internationalisation functions such as `__()`, `_e()`, `esc_html__()`, and `esc_attr__()`, as appropriate.
- Use the product's Text Domain consistently.
- Keep source `.po` catalogues under version control. The workflow generates the `.pot` template and compiles `.mo` files.
- Review generated changes to ensure existing translations are preserved.
- Remove starter/test strings and test translations that are not part of the product.

The current workflow uses `ephpicman-plugin` and updates `languages/ephpicman-plugin-fa_IR.po` when that file exists. Update `.github/workflows/translations.yml` when renaming the Text Domain or translation catalogues.

### 4. Add product behaviour

Implement product-specific code under `src/`. Keep shared framework code under `vertex/`; this directory is maintained by the Vertex synchronization workflow and must not be used for product-specific classes.

Keep the entry point and main lifecycle class focused on bootstrapping, registration, and lifecycle boundaries. Add abstractions only when they solve a concrete requirement; avoid adding generic infrastructure pre-emptively.

### 5. Handle lifecycle and data safely

The starter connects activation and deactivation callbacks to WordPress and provides an uninstall hook. Add work to these methods only when the product needs it. If the product stores persistent data that should be removed on uninstall, define an explicit cleanup policy before implementing it. Do not add cleanup for data that does not exist.

For product features:

- Validate and sanitise input.
- Check capabilities and nonces for privileged actions.
- Prefer WordPress APIs.
- Escape output where it is rendered.
- Do not commit secrets, credentials, environment-specific configuration, or production data.

### 6. Check CI and repository settings

- Confirm the PHP lint workflow passes. It currently checks syntax with PHP 8.0 and PHP 8.2.
- Run WordPress Coding Standards checks locally or add them to CI if they are part of the product's quality gate.
- Confirm the translation workflow uses the correct Text Domain and catalogue filenames.
- Confirm Vertex synchronization succeeds and that the expected files under `vertex/` are present.
- Ensure GitHub Actions permissions allow only the writes required by the workflows.
- Enable branch protection and require the appropriate checks before merging when the repository is ready for team development.

PHP lint verifies syntax only. It does not prove that WordPress can activate the plugin or that Vertex initializes correctly. Test activation and actual product behaviour in a WordPress environment before release.

## Development

1. Clone the repository into `wp-content/plugins/<plugin-slug>` in a WordPress installation.
2. Complete the customisation checklist above.
3. Activate the plugin in WordPress.
4. Implement product-specific behaviour under `src/`.
5. Run PHP syntax and coding-standard checks before pushing changes.
6. Test the plugin in a real WordPress environment.

## Vertex synchronization

GitHub Actions synchronises `vertex-wp/framework` `main` into `vertex/` daily at **09:00 Asia/Tehran** and supports manual runs through **Actions → Sync Vertex → Run workflow**. The workflow uses `git subtree` with `--squash`, so it does not import the framework's full commit history.

Treat `vertex/` as synchronized framework code rather than a place for local product changes. The first workflow run replaces the former `epm/` copy with the current Vertex framework.

The sync workflow needs repository contents write permission to commit updates. The translation workflow also needs contents write permission to commit generated catalogues.

## Licence

This starter is distributed under **GNU General Public License version 2 or, at your option, any later version (GPL-2.0-or-later)**. See [LICENSE](LICENSE) and the [GNU GPL version 2 text](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html).

## Design principles

- Keep the foundation small and maintainable.
- Treat Vertex as the shared framework and keep product code separate.
- Preserve WordPress's native lifecycle hooks while letting Vertex orchestrate product lifecycle.
- Guard direct access to PHP files.
- Use WordPress APIs and escape output at the point of rendering.
- Validate product ideas and requirements before adding features or abstractions.
- Keep the PHP and WordPress minimums consistent across metadata, configuration, CI, and documentation.
- Never commit secrets or environment-specific configuration.
