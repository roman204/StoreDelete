The README.md file content is generated automatically, see [Magento module README.md](https://github.com/magento/devdocs/wiki/Magento-module-README.md) for more information.

# CopeX_StoreDelete module



## Installation details

For information about a module installation in Magento 2, see [Enable or disable modules](https://devdocs.magento.com/guides/v2.4/install-gde/install/cli/install-cli-subcommands-enable.html).

## Extensibility

Extension developers can interact with the CopeX_StoreDelete module. For more information about the Magento extension mechanism, see [Magento plug-ins](https://devdocs.magento.com/guides/v2.4/extension-dev-guide/plugins.html).

[The Magento dependency injection mechanism](https://devdocs.magento.com/guides/v2.4/extension-dev-guide/depend-inj.html) enables you to override the functionality of the CopeX_StoreDelete module.

## Caution
Delete the configurations for all elements you want to delete before deleting entity.

## Usage
Delete a website with child storeGroup and all child storeViews
`./bin/magento store:website:delete {{websiteId}}`

Delete a storeGroup with child storeViews
`./bin/magento store:group:delete {{storeGroupId}}`

Delete a storeView
`./bin/magento store:view:delete {{storeViewId}}`

## Additional information

For information about significant changes in patch releases, see [Release information](https://devdocs.magento.com/guides/v2.4/release-notes/bk-release-notes.html).
# StoreDelete
