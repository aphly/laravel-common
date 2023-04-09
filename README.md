**laravel common**<br>

包含 user credit category filter<br>

环境<br>
php8.0+<br>
laravel9.0+<br>
mysql5.7+<br>

安装<br>
`composer require aphly/laravel-common` <br>
`php artisan vendor:publish --provider="Aphly\LaravelCommon\CommonServiceProvider"` <br>
`php artisan migrate` <br>

1、config/auth.php<br>
数组guards中 添加<br>
`'user' => [
'driver' => 'session',
'provider' => 'user'
]`
<br>数组providers中 添加<br>
`'user' => [
'driver' => 'eloquent',
'model' => Aphly\LaravelCommon\Models\User::class
]`
