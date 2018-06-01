# yii2-cronmanager
```
    'modules' => [
    ...
        'cron' => [
            'class' => \basbeheertje\yii2\cronmanager\Module::class,
        ]
    ...
    ]
```

# Crontab
Add the following line to your crontab:
```
* * * * * /usr/local/bin/php /home/<USERNAME>/domains/<DOMAINNAME>/public_html/yii cron/run
```