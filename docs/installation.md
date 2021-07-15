<h1 align="center">
    <a href="http://toxsl.com" title="toxsl" target="_blank">
        <img width = "20%" height = "20%" src="https://toxsl.com/themes/toxsl/img/toxsl_logo.png" alt="Toxsl Logo"/>
    </a>
    <hr>
</h1>


## Installation

Make sure you place it in root of your htdocs .

To install the project

```

git clone http://192.168.10.22/yii2/motion-graphic-yii2-1321.git

```
if you have composer.json

```
composer install --prefer-dist --prefer-stable
```

if you need to update vendor again you can use following commands 

```
composer update --prefer-dist --prefer-stable
```


Create your envirenment file(.env)
```
Rename .env.exmaple to .env and fill all the required details i.e. DB credentials and mail etc.
```


Generate unique key 

```
php artisan key:generate
```

Run Migrations 

```
php artisan migrate
```


```
make sure you give READ/WRITE permission to your folder.
```

## License

**www.toxsl.com** 