# Composer Ant Bridge
Composer script that runs Phing build-script for installed packages

## Use

Add script to projects composer.json
```
"scripts": {
    "packagebuilder": [
        "ComposerPhing\\Packages::build"
    ]
}
```

Call:

```
composer run-script packagebuilder
```

If your Ant build-files has a specific target you want to trigger, you can pass that as an argument:

```
composer run-script packagebuilder -- prod
```
