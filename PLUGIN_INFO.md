[![Range Slider for Kirby](https://raw.githubusercontent.com/JonasDoebertin/kirby-range-slider/master/logo.png)](https://github.com/JonasDoebertin/kirby-range-slider/)

**Based on [noUiSlider](https://github.com/leongersen/noUiSlider/).**

[![Release](https://img.shields.io/github/release/jonasdoebertin/kirby-range-slider.svg)](https://github.com/jonasdoebertin/kirby-range-slider/releases)
[![Issues](https://img.shields.io/github/issues/jonasdoebertin/kirby-range-slider.svg)](https://github.com/jonasdoebertin/kirby-range-slider/issues)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JonasDoebertin/kirby-range-slider/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/JonasDoebertin/kirby-range-slider/?branch=develop)
[![License](https://img.shields.io/badge/license-GPLv3-blue.svg)](https://raw.githubusercontent.com/jonasdoebertin/kirby-range-slider/master/LICENSE)
[![Moral License](https://img.shields.io/badge/buy-moral_license-8dae28.svg)](https://gum.co/rangeslider)

This Panel field plugin for [Kirby 2](http://getkirby.com) enables you to use an intuitive and visual range slider without any hazzle. Just drop in the plugin and you're good to go!

## Important Note (Please Read)

Generally, this extension is free to use on both personal and commercial Kirby powered sites. You don't *have* to pay for it. However, please always keep in mind that developing this extension took place in my spare time (and maybe a little bit of the time I should have spend on other work related stuff) and up until now, quite some hours have been spent on it..

If you like what I'm doing for the community and you want to support further development of this and future extensions & plugins for Kirby CMS, please consider [purchasing a moral license](https://gum.co/rangeslider).

**This is especially appreciated whenever you use one of the extensions in a project that you get payed for.**

*Cheers, Jonas*

## Installation

### Copy & Pasting

If not already existing, add a new `fields` folder to your `site` directory. Then copy or link this repositories whole content in a new `rangeslider` folder there. Afterwards, your directory structure should look similar to this:

```
site/
	fields/
		rangeslider/
			assets/
            partials/
			rangeslider.php
```

### Git Submodule

If you are an advanced user and know your way around Git and you already use Git to manage you project, you can make updating this field extension to newer releases a breeze by adding it as a Git submodule.

```bash
$ cd your/project/root
$ git submodule add https://github.com/JonasDoebertin/kirby-range-slider.git site/fields/rangeslider
```

Updating all your Git submodules (eg. the Kirby core modules and any extensions added as submodules) to their latest version, all you need to do is to run these few Git commands:

```bash
$ cd your/project/root
$ git submodule foreach git checkout master
$ git submodule foreach git pull
$ git commit -a -m "Update submodules"
$ git submodule update --init --recursive
```

## Usage

### Within your blueprints

Using the field in your blueprint couldn't be easier. After installing the plugin like explained above, all you need to do is adding any number of `type: rangeslider` fields to your blueprints.

```yaml
fields:
    title:
        label:   Event Name
        type:    text
    duration:
        label:   Event Duration
        type:    rangeslider
        min:     1
        max:     7
        step:    1
        postfix: " days"

```

*Fields related part of the blueprint for the setup shown in the screenshot.*

### Within your templates

You may use any `rangeslider` field you added to your blueprints just like any other standard `number` field.

## Options

### min *(required)*

Set the minimum value for the sliders number range.

```yaml
fields:
    text:
        label: Event Duration
        type:  rangeslider
		min:   1
        max:   7
```

### max *(required)*

Set the maximum value for the sliders number range.

```yaml
fields:
    text:
        label: Event Duration
        type:  rangeslider
		min:   1
        max:   7
```

### step

Set the minimal difference between two slider values. Examples: If set to `1` the user may select integral numbers (1, 2, 3, …). If set to `0.5` the user will be able to select integral numbers or numbers end with `.5`. If a user should be able to pick a price of a product, you'd want to set this to `0.01` so the user can select numbers with to decimals. The `step` options defaults to `1`.

```yaml
fields:
    text:
        label: Product Price
        type:  rangeslider
		min:   1
        max:   99
        step:  0.01
```

### prefix

Setting a `prefix` allows you to make the range slider display even more user-friendly. The prefix will be prepended to the sliders number display (even though it will not be added to the stored value). This is especially useful for adding money symbols when using the range slider to pick prices (see below). The `prefix` and `postfix` options may also be used together.

```yaml
fields:
    text:
        label: Product Price
        type:  rangeslider
		min:   1
        max:   99
		step:  0.01
		prefix: "$ "
```

### postfix

As with the `prefix` option, setting a `postfix` allows you to make the range slider display more user-friendly. The postfix will be appended to the sliders number display (even though it will not be added to the stored value). This is especially useful for adding any kind of unit (durations, distances, etc.) when using the range slider to pick these (see below). The `prefix` and `postfix` options may also be used together.

```yaml
fields:
    text:
        label: Event Duration
        type:  rangeslider
		min:   1
        max:   7
		step:  1
		postfix: " days"
```
