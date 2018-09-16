Yii2 Bower Asset
================

The easy way to install and update Bower for Yii2 via Composer

[![Latest Stable Version](https://poser.pugx.org/yidas/yii2-bower-asset/v/stable?format=flat-square)](https://packagist.org/packages/yidas/yii2-bower-asset)
[![Latest Unstable Version](https://poser.pugx.org/yidas/yii2-bower-asset/v/unstable?format=flat-square)](https://packagist.org/packages/yidas/yii2-bower-asset)
[![License](https://poser.pugx.org/yidas/yii2-bower-asset/license?format=flat-square)](https://packagist.org/packages/yidas/yii2-bower-asset)

> Got tired of [fxp/composer-asset-plugin](https://github.com/fxpio/composer-asset-plugin)? It's a good project with nice idea and good implementation. But it has some issues: it slows down composer update a lot and requires global installation, so affects all projects. Also there are Travis and Scrutinizer integration special problems, that are a bit annoying.

According to [Asset Packagist](https://asset-packagist.org/), this package goals to make Bower install by original composer source. Let you install or update Yii2 as soon as possible via Composer. 

---

INSTALLATION
------------

In Yii2 `composer.json`, require `yidas/yii2-bower-asset` before `yiisoft/yii2`.

Example `composer.json`:

```
"require": {
    "php": ">=5.4.0",
    "yidas/yii2-bower-asset": "~2.0.0",
    "yiisoft/yii2": "~2.0.5",
    "yiisoft/yii2-bootstrap": "~2.0.0"
}
```

After above setting, it's same as [yidas/yii2-composer-bower-skip](https://github.com/yidas/yii2-composer-bower-skip) which makes composer to install and update for Yii2 without Bower plugin.

Then you can choose one of install ways below, to setup the installer for activing Bower in Yii2.


### Install via cloning package to Bower vendor

In Yii2 `composer.json`, add script `yidas\\yii2BowerAsset\\Installer::bower` in `post-package-update` event.

```
"scripts": {
    "post-package-update": [
           "yidas\\yii2BowerAsset\\Installer::bower"
    ]
}
```


### Install via setting alias of Bower

In Yii2 `composer.json`, add script `yidas\\yii2BowerAsset\\Installer::setAlias` in `post-update-cmd` event.

```
"scripts": {
    "post-update-cmd": [
           "yidas\\yii2BowerAsset\\Installer::setAlias"
    ]
}
```

> This installation will modify Yii2 file, you can run `yidas\\yii2BowerAsset\\Installer::unsetAlias` to recover back.

---

Finally, command `composer update` then enjoy it.

---

LIMITATION
----------

There are some limitations of this package:

1. Bower vendor limits the packages only for Yii2 without addition, so do not use this if you are using other Bower packages. 

2. The versions of Bower packages are fit to current version of Yii2.
