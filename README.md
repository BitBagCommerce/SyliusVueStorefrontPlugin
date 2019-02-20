## BitBag SyliusVueStorefrontPlugin

A bridge for Vue Storefront ([vuestorefront.io](https://vuestorefront.io)) and Sylius.

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
To improve Developer Experience of this Extension, we provide mapped all VueStorefront Models supported by this library. 

**Currently supported models:**

- Product
    - Price
    - Category

### Connection

Static connection between Sylius and `vue-storefront-api` is provided with Elasticsearch. To have the data from Sylius mapped in ES readable by VueStorefront Backend, we have created `Mapper`s providing object translations to ES indexes. 



