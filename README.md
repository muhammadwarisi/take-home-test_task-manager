
# Task Manager

Task Manager ini dibuat untuk  memanage tugas-tugas kita sehari-hari agar bisa lebih produktif dalam menjalani hari.




## Features

- Autentikasi Login
- Manajemen Task
- Widget Task


## Require Stack

php 8.2, composer


## Installation

Install Project dengan salin command dibawah

```bash
  git clone git@github.com:muhammadwarisi/take-home-test_task-manager.git
  cd take-home-test_task-manager
```
lalu ketikan
```
composer Install
```
setelah itu
```
php artisan migrate
php artisan db:seed
```
copy file **env.example** lalu ubah menjadi **.env**

Lalu jangan lupa untuk generate APP_KEY
```
php artisan key:generate
```

terakhir
```
php artisan serve
```


    
## Email & Password


```
  email: admin@example.com
  pw: admin1234
```


## License

[MIT](https://choosealicense.com/licenses/mit/)

