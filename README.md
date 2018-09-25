随机的从 Unsplash 网站下载图片到本地

## 使用方法

1. 注册 [Unsplash](https://unsplash.com) 账户；
2. 在 [开发者中心](https://unsplash.com/developers) 创建应用，并获取 Access Key；
3. 使用 Composer 进行安装

```
composer require dolphin.wang/unsplash-random-download
```

4. 按照以下方式引用，可参考 demo

```php
require __DIR__ . '/vendor/autoload.php';

use Dolphin\Wang\Unsplash\Random;
// 设置 Unsplash Access Key，如果只需要下载单张图片设置一个 KEY 就可以了，如果需要开启自动下载任务，可以设置多个 KEY，程序会自动切换 KEY 来绕过 Unsplash 的接口请求限制。根据 Unsplash 的接口请求限制规则，建议添加 10 个或以上的 KEY。如果是生产版的应用则不需要设置多个。
$access_key_arr = [
    '',
    ''
];

$dir = 'pic';

$random = new Random($access_key_arr, $dir);
// 下载单张图片
var_dump($random->rand());
// 启动自动下载任务：注意 Unsplash API 的请求限制规则，测试版每小时 50 次，生产版每小时 5000 次，超过限制接口返回 403 错误
$random->run();
```
> 变量 `dir` 表示图片保存的文件夹（相对路径），可选，默认值为 `pic`，当然你需要先手动创建它，并且在 `Linux` 系统中设置为可写权限。

下载单张图片时返回的数据格式为：

```json
{
	"code": 0,
	"error": "",
	"data": {
		"id": "jIECjqms_no"
	}
}
```

> 当 `code` 为 0 表示下载成功，不为 0 时表示下载失败，`error` 表示错误原因。