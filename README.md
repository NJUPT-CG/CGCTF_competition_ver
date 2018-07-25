# CG-CTF
A Simple CTF Practice &amp; Competition Platform
比赛用版本

因为vendor下的东西好像跟本地环境有关,所以不能直接克隆下来使用
请在本地用composer install

访问 "/test" 来生成100个测试用户

访问 "/createChallenges" 来生成100个测试用题, flag 是 1

项目的实际目录是 `./CG-CTF`

### 前端

需要安装依赖，嫌太慢可以挂梯子，或者用cnpm、yarn

```bash
npm install
```

之后同步前端的样式需要运行

```bash
npm run dev
```

### 后端

```bash
composer install
php artisan config:clear
php artisan key:generate
php artisan serve
```