# CONTRIBUTING

此文件說明該如何一起協作，讓此函式庫更強大！

## 基本規範

### 開發流程

Git 流程採用 TBD ( Trunk Based Development ， [參考網頁](http://paulhammant.com/2013/04/05/what-is-trunk-based-development/) ) 。 Mainline 名稱固定為 `master` ，原始碼的所有測試會在 `master` 上。

Git Commit 的內容沒有特別規範，但請先參考[這份文件](https://blog.louie.lu/2017/03/21/%E5%A6%82%E4%BD%95%E5%AF%AB%E4%B8%80%E5%80%8B-git-commit-message/)。

開發建議使用 [Fork + Pull Request](https://git-scm.com/book/zh-tw/v2/GitHub-%E5%8F%83%E8%88%87%E4%B8%80%E5%80%8B%E5%B0%88%E6%A1%88) 並使用 Squash and Merge 合併。當發 PR 時， Travis 也會幫您測試。

最後， Assignees 目前定義會是發 PR 的人，因為理論上發 PR 的人應該會最了解所有狀況。

### 目錄結構

```yaml
# 所有原始碼
- src

# 測試程式
- tests
```

## 環境建置

開發需要的工具如下：

* [Composer][]
* [Makefile][]  (Optional)

安裝 Composer 套件：

    $ composer install

## Coding Style

開發請遵守 [PSR-2](http://www.php-fig.org/psr/psr-2/) 規範，檢查指令如下：

    $ php vendor/bin/phpcs

自動修正的指令：

    $ php vendor/bin/phpcbf

其他細節規範如下：

* Array 實字請使用 `[]` ，不要使用 `array()`
* variable 、 function 、 property 、 method 等，均使用 `camelCase` 風格 

PHP Document 建議參考 [104 Guideline][] 上的說明。

### 版本標識

某些方法或屬性可能未來不使用了，而用新方法來取代，這時需要加上棄用註解。

```php
/**
 * @return array
 * @deprecated 將於 2.0 刪除，請改用 getAllData()
 */
public function getData()
```

如果使用棄用註解，必須說明什麼時候會被刪除，與該換用哪些方法來取代。

## Testing

測試使用 [PHPUnit][] 套件，執行測試指令如下

    $ php vendor/bin/phpunit

或是使用 `make` 指令，預設將只測 PHP 7.0 版 

    $ make tests

## 版號定義

使用最常見的 [`major.minor.build`](http://www.ithome.com.tw/voice/85505) 的定義。舉例如下

* 當整體架構調整時，比方說未來使用 git subtree 切分各子專案，會增加 `major` 。
* 當任一元件增加新功能，或是改變行為時，會增加 `minor` 。
* 修正 bug ，會增加 `build` 。

只要修改有需要立即使用時，都可以更新版號。

[PHPUnit]: https://phpunit.de/
[Composer]: https://getcomposer.org/
[Makefile]: https://www.gnu.org/software/make/manual/make.html
[104 Guideline]: https://github.com/104corp/guideline-draft/blob/master/language/php/phpdoc.md
