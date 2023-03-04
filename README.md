![images_spider](https://socialify.git.ci/5ime/images_spider/image?description=1&descriptionEditable=%E6%94%AF%E6%8C%815%E4%B8%AA%E7%9F%AD%E8%A7%86%E9%A2%91%E5%B9%B3%E5%8F%B0%E5%8E%BB%E6%B0%B4%E5%8D%B0%E4%B8%8B%E8%BD%BD&font=Inter&forks=1&language=1&owner=1&pattern=Circuit%20Board&stargazers=1&theme=Light)

目前支持5个平台图集去水印下载，欢迎各位Star，**提交issues时请附带图集链接**。

短视频解析请移步：https://github.com/5ime/video_spider

演示站源码请移步：https://github.com/5ime/vue-page

## 支持平台

| 平台 | 状态| 平台 | 状态| 平台 | 状态| 平台 | 状态| 平台 | 状态|
|  ----  | ----  | ----  | --- |----|----|----|----|----|----|
| 皮皮虾 | ✔ | 抖音短视频 | ✔ | 最右 | ✔| 小红书 | ✔ | 微博 | ✔ |
| 快手 | ✔ |   |  |   |  |   |   |   |   |


## 请求示例

支持GET/POST `url`参数必填，请优先使用 `POST` 请求，`GET` 请求自行 `urlencode` 编码

### 解析思路

请前往博客查看

## FAQ

**为什么小红书/微博/快手会失败**

小红书/微博需要定时更新cookies，快手请求频繁会出现滑块验证

**抖音X-Bogus校验**

目前使用的 https://github.com/B1gM8c/X-Bogus 提供的服务

你也可以基于我的模板 https://github.com/5ime/Tiktok_Signature 一键部署到 vercel，需要修改的地方如下

```php
$url = 'https://tiktok.iculture.cc/X-Bogus';
$data = json_encode(array('url' => 'https://www.douyin.com/aweme/v1/web/aweme/detail/?aweme_id=' . $id[1] . '&aid=1128&version_name=23.5.0&device_platform=android&os_version=2333','userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36'));
$header = array('Content-Type: application/json');
$url = json_decode($this->curl($url, $data, $header), true)['param'];
// 改为
$url = '你的 vercel 地址';
$data = json_encode(array('url' => 'https://www.douyin.com/aweme/v1/web/aweme/detail/?aweme_id=' . $id[1] . '&aid=1128&version_name=23.5.0&device_platform=android&os_version=2333','userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36'));
$header = array('Content-Type: application/json');
$url = json_decode($this->curl($url, $data, $header), true)['data']['url'];
```

## 免责声明

本仓库只为学习研究，如涉及侵犯个人或者团体利益，请与我取得联系，我将主动删除一切相关资料，谢谢！
