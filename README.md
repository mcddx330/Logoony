# Logoony
[文体診断ロゴーン](http://logoon.org/)のPHPライブラリです。

### 使い方
```php
<?php
require_once("logoony.php");

$text = "評価したい文章"

$logoony = new Logoony();
$logoony->setText($text); // テキストを設定
$result = $logoony->run(); // 実行

var_dump($result);
```

### 結果
```
array(3) {
  ["scores"]=>
  array(2) {
    ["similar"]=>
    array(3) {
      [0]=>
      array(2) {
        [0]=>
        string(12) "浅田次郎"
        [1]=>
        string(4) "71.5"
      }
      [1]=>
      array(2) {
        [0]=>
        string(15) "小林多喜二"
        [1]=>
        string(4) "68.9"
      }
      [2]=>
      array(2) {
        [0]=>
        string(9) "小田実"
        [1]=>
        string(4) "67.5"
      }
    }
    ["dissimilar"]=>
    array(3) {
      [0]=>
      array(2) {
        [0]=>
        string(12) "岡倉天心"
        [1]=>
        string(4) "39.4"
      }
      [1]=>
      array(2) {
        [0]=>
        string(9) "三木清"
        [1]=>
        string(4) "41.9"
      }
      [2]=>
      array(2) {
        [0]=>
        string(12) "新美南吉"
        [1]=>
        string(4) "43.8"
      }
    }
  }
  ["analyze"]=>
  array(4) {
    [0]=>
    array(2) {
      [0]=>
      string(24) "文章の読みやすさ"
      [1]=>
      string(1) "D"
    }
    [1]=>
    array(2) {
      [0]=>
      string(15) "文章の硬さ"
      [1]=>
      string(1) "C"
    }
    [2]=>
    array(2) {
      [0]=>
      string(18) "文章の表現力"
      [1]=>
      string(1) "A"
    }
    [3]=>
    array(2) {
      [0]=>
      string(15) "文章の個性"
      [1]=>
      string(1) "A"
    }
  }
  ["detail"]=>
  array(10) {
    [0]=>
    array(4) {
      ["title"]=>
      string(12) "平均文長"
      ["desc"]=>
      string(24) "一文の平均文字数"
      ["score"]=>
      string(11) "41.31文字"
      ["border"]=>
      string(2) "46"
    }
    [1]=>
    array(4) {
      ["title"]=>
      string(21) "平均句読点間隔"
      ["desc"]=>
      string(45) "句読点と句読点の間の平均文字数"
      ["score"]=>
      string(11) "20.65文字"
      ["border"]=>
      string(2) "58"
    }
    [2]=>
    array(4) {
      ["title"]=>
      string(18) "特殊語出現率"
      ["desc"]=>
      string(36) "文章に占める特殊語の割合"
      ["score"]=>
      string(8) "12.58％"
      ["border"]=>
      string(2) "54"
    }
    [3]=>
    array(4) {
      ["title"]=>
      string(15) "名詞出現率"
      ["desc"]=>
      string(33) "文章に占める名詞の割合"
      ["score"]=>
      string(8) "29.25％"
      ["border"]=>
      string(2) "52"
    }
    [4]=>
    array(4) {
      ["title"]=>
      string(15) "動詞出現率"
      ["desc"]=>
      string(33) "文章に占める動詞の割合"
      ["score"]=>
      string(8) "11.32％"
      ["border"]=>
      string(2) "61"
    }
    [5]=>
    array(4) {
      ["title"]=>
      string(15) "助詞出現率"
      ["desc"]=>
      string(33) "文章に占める助詞の割合"
      ["score"]=>
      string(8) "29.56％"
      ["border"]=>
      string(2) "50"
    }
    [6]=>
    array(4) {
      ["title"]=>
      string(18) "助動詞出現率"
      ["desc"]=>
      string(36) "文章に占める助動詞の割合"
      ["score"]=>
      string(8) "11.32％"
      ["border"]=>
      string(2) "46"
    }
    [7]=>
    array(4) {
      ["title"]=>
      string(21) "ひらがな出現率"
      ["desc"]=>
      string(39) "文章に占めるひらがなの割合"
      ["score"]=>
      string(8) "51.26％"
      ["border"]=>
      string(2) "44"
    }
    [8]=>
    array(4) {
      ["title"]=>
      string(21) "カタカナ出現率"
      ["desc"]=>
      string(39) "文章に占めるカタカナの割合"
      ["score"]=>
      string(7) "6.92％"
      ["border"]=>
      string(3) "112"
    }
    [9]=>
    array(4) {
      ["title"]=>
      string(24) "異なり形態素比率"
      ["desc"]=>
      string(57) "文章中で一度しか出ていない形態素の割合"
      ["score"]=>
      string(8) "49.06％"
      ["border"]=>
      string(2) "96"
    }
  }
}
```

### 既存の問題点
本家のフォームから送った時と診断結果が違う。
（POST通信時に本文データが変わってる？）

### ライセンス
MIT License