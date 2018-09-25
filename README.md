随机的从 Unsplash 网站下载图片到本地

## 使用方法

1. 注册 [Unsplash](https://unsplash.com) 账户；
2. 在 [开发者中心](https://unsplash.com/developers) 创建应用，并获取 Access Key；
3. 使用 Composer 安装 Library

```
composer require dolphin836/unsplash-random-download
```

4. 按照以下方式引用；

```php
require __DIR__ . '/vendor/autoload.php';

use Dolphin\Wang\Unsplash\Random;

$access_key = '';

$dir = 'pic';

$random = new Random($access_key, $dir);

$hash = $random->download();

var_dump($hash);
```
> 变量 `dir` 表示图片保存的文件夹（相对路径），可选，默认值为 `pic`，当然你需要先手动创建它。