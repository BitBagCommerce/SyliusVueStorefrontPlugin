## BitBag SyliusVueStorefrontPlugin

A bridge between Vue Storefront ([vuestorefront.io](https://vuestorefront.io)) and Sylius.  
Depending on your preferences, the plugin can also fully replace [VSF API](https://github.com/DivanteLtd/vue-storefront-api/) - you will only need VSF if you choose so.

## Vue Storefront + Sylius Demo

We've created a demo app that showcases usage of this plugin. Visit [vsf.bitbag.shop](vsf.bitbag.shop) to check it out!  
The Sylius admin panel is accessible at [syliusvsf.bitbag.shop/admin](syliusvsf.bitbag.shop/admin). Admin credentials: `sylius : sylius`.


## Installation

### Requirements

We work on stable, supported and up-to-date versions of packages. We recommend you to do the same.  
Please also check [Vue Storefront requirements](https://docs.vuestorefront.io/guide/installation/linux-mac.html#requirements).

| Package       | Version        |
|:-------------:|:--------------:|
| PHP           |  7.3           |
| MySQL         |  8.0.x (>= 5.7)|
| Elasticsearch |  6.8.x         |
| Vue Storefront|  1.11          |

First add this plugin as dependency to your Sylius project. 
 
 ```
 $ composer require bitbag/vue-storefront-plugin
 ```

Add plugin to `config/bundles.php`:

```
return [
    ...
    FOS\ElasticaBundle\FOSElasticaBundle::class => ['all' => true],
    BitBag\SyliusVueStorefrontPlugin\SyliusVueStorefrontPlugin::class => ['all' => true],
    Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle::class => ['all' => true],
    Gesdinet\JWTRefreshTokenBundle\GesdinetJWTRefreshTokenBundle::class => ['all' => true],
    Nelmio\CorsBundle\NelmioCorsBundle::class => ['all' => true],
];
```

Copy `etc/vsf-config/local.json` file from this repository to `config/local.json` of Vue Storefront project directory.  
In that file you only need to replace every occurence of `<insert-your-hostname>` with URL of your store.  
Other than that, sensible defaults are provided by us, that are proven to work in Vue Storefront v1.11. 


## Architecture

VueStorefront fetches data in two ways - **statically** and **dynamically**.  
Less frequently updated data is stored in **Elasticsearch**: 
1. Products
2. Categories (Sylius taxons)
3. Attributes (Sylius product options)  
 
Everything else is fetched dynamically using provided API, including: 
* customers' accounts (Sylius Customer, ShopUser)
* carts, orders (Sylius Order)
* shipping methods
* payment methods
* and more ...

### Connection

To have the data from Sylius mapped in ES, we have created `Transformer`s providing object translations to ES indexes.  
Schema of indexes is described in files stored in `Document` directory. 

### Using the plugin within Sylius Standard app, with VSF

Steps that need to be taken to make this happen are described in readme file of [SyliusVueStorefrontDemo repository](https://github.com/BitBagCommerce/SyliusVueStorefrontDemo).

### Development

To be able to contribute to the plugin make sure that you familiarize yourself with:
 1. [Vue Storefront Custom Integration Tutorial](https://github.com/DivanteLtd/vue-storefront-integration-sdk/)
 2. [Vue Storefront](Shttps://github.com/DivanteLtd/vue-storefront)
 3. [Vue Storefront API](Shttps://github.com/DivanteLtd/vue-storefront-api)
 4. [Sylius Shop API Plugin](https://github.com/Sylius/ShopApiPlugin/)
