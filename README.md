## BitBag SyliusVueStorefrontPlugin

A bridge between Vue Storefront ([vuestorefront.io](https://vuestorefront.io)) and Sylius.

## Installation

```bash
$ composer require bitbag/vue-storefront-plugin
```

## Usage

TBD.

## Architecture

### Summary 

VueStorefront fetches data in two ways - **Staticly** and **Dynamically**. Less frequently updated data such as **Products** and **Categories** (Sylius Taxons) are stored in _Elasticsearch_. 
Data like **Cart** (Sylius Order), **Orders** and **Users** (Sylius ShopUser) are fetched dynamically using API calls.

### Connection

Static connection between Sylius and Vue Storefront API is provided with Elasticsearch. 
To have the data from Sylius mapped in ES and readable by VS API, we have created `Transformer`s providing object translations to ES indexes. 

### Using the plugin within Sylius Standard app, with VS and VS API

Steps that need to be taken to make this happen are described in readme file of [SyliusVueStorefrontDemo repository](https://github.com/BitBagCommerce/SyliusVueStorefrontDemo).

### Development

To be able to contribute to the plugin make sure that you familiarize yourself with:
 1. [Vue Storefront Custom Integration Tutorial](https://github.com/DivanteLtd/vue-storefront-integration-sdk/)
 2. [Sylius Shop API Plugin](https://github.com/Sylius/ShopApiPlugin/). 
 
 Then take a look at [the roadmap](https://github.com/BitBagCommerce/SyliusVueStorefrontPlugin/projects/1) to see where you might be able to help.
