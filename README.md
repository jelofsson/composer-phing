# Composer Ant Bridge
Composer script that runs Phing build-script for installed packages

## Use

Add script to projects composer.json
```
"scripts": {
    "antbuilder": [
        "ComposerPhing\\Packages::build"
    ]
}
```

Call:

```
composer run-script antbuilder
```

If your Ant build-files has a specific target you want to trigger, you can pass that as an argument:

```
composer run-script antbuilder -- prod
```
