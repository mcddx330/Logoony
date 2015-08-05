<?php

define("LOGOON_POSTADDR","http://logoon.org/kekka.php"); // 結果ページアドレス

class Logoony{
  public $target_text = null;

  public function setText($text){
    $this->target_text = $text;
  }

  public function run(){
    return self::fetchLogoonResult($this->target_text);
  }

  private function fetchLogoonResult($text=null){
    $lgres = array(); // 最終結果
    $postdata = array(); // POST通信用素材
    $reshtml = array(); // 結果ページ内容管理

    // 0文字判定
    if(mb_strlen($text) === 0){
      return false;
    }

    // POSTデータ作成
    $postdata["data"] = array("q" => $text);
    $postdata["query"] = http_build_query($postdata["data"], "", "&");

    // header
    $postdata["header"] = array(
                                "Content-Type: application/x-www-form-urlencoded",
                                "Content-Length: ".strlen($postdata["data"]["q"])
                               );

    $postdata["context"]  = array(
                                  "http"=>array(
                                                "method"=>"POST",
                                                "header"=>implode("\r\n", $postdata["header"]),
                                                "content"=>$postdata["query"]
                                               )
                                 );

    // POSTアクセス
    $reshtml = file_get_contents(LOGOON_POSTADDR, false, stream_context_create($postdata["context"]));

    $postag = array(
                    "table"=>array("start"=>"<table","end"=>"</table>")
                   );

    $reshtml = preg_replace('/(?:\n|\r|\r\n|<br \/>)/', '', $reshtml);

    // 結果を抽出するときに使用する結果記載テーブルのタグ範囲を計算
    $poscount = array(
                      "start"=>mb_strpos($reshtml,$postag["table"]["start"]),
                      "end"=>mb_strpos($reshtml,$postag["table"]["end"])-mb_strpos($reshtml,$postag["table"]["start"])
                     );

     /* ============================ */
     /* 結果HTMLから結果と評価を抽出 */
     $resmatch = array();
     preg_match_all('/<table class="(hyoka|tokuten)".+?>(.+?)<\/table>/u',$reshtml,$out_html);
     $out_html = $out_html[2]; // 抽出結果のみ

     /*
        [0] : ベスト3
        [1] : ワースト3
        [2] : 解析評価
        [3] : 得点詳細
     */

     $out_titles = $out_scores = array();
     foreach($out_html as $d){
       // th,td,aのみ抽出->空th,tdを削除
       $d = preg_replace("/(<th><\/th>|<td><\/td>)/u","",strip_tags($d,"<th><td><a>"));
       // 中身抽出
       preg_match_all('/<th(.*?)>(.+?)<\/th>/u',$d,$out_th);
       $out_titles[] = $out_th;
       preg_match_all('/<td>(.+?)<\/td>/u',$d,$out_td);
       $out_scores[] = $out_td[1];
     }
     $out_scoredetailtext = $out_titles[3]; // 得点詳細文

     /*
       スコア抽出
       ([0-2])[0] : 著者
       ([0-2])[1] : スコア
     */
     $scores["similar"] = self::fetchScore($out_scores[0]);
     $scores["dissimilar"] = self::fetchScore($out_scores[1]);
     $lgres["scores"] = $scores;

     /*
       解析結果整理
       [0] : 評価対象
       [1] : 得点
     */
     for($i=0;$i<count($out_scores[2]);$i++){
       if($i !== 0 && $i % 2 === 1){
         $lgres["analyze"][] = array($out_scores[2][$i-1],$out_scores[2][$i]);
       }
     }


     // ===== 得点詳細 ===== //

     // 得点数値を整理
     $scoredetail = $detail = array();

     // 得点概要文（マウスオーバー時に出る詳細文）整理
     $scoreunit = null;
     foreach($out_scoredetailtext[1] as $k => $v){
       preg_match("/\"(.+?)\"$/u",$v,$out_scoretitle);
       if(isset($out_scoretitle[1])){
         preg_match_all("/（単位：(.+?)）/u",$out_scoretitle[1],$unit);
         $detail["unit"][$k] = $unit[1][0]; // 単位
         $detail["desc"][$k] = mb_substr($out_scoretitle[1],0,mb_strlen($out_scoretitle[1])-mb_strlen($unit[0][0])); //  概要文
       }
     }

     for($i=0;$i<count($detail["unit"]);$i++){
       $scoredetail[$i]["title"] = $out_scoredetailtext[2][$i];
       $scoredetail[$i]["desc"] = $detail["desc"][$i];
       $scoredetail[$i]["score"] = array_slice($out_scores[3],0,10)[$i].$detail["unit"][$i];
       $scoredetail[$i]["border"] = array_slice($out_scores[3],10,10)[$i];
     }

     $lgres["detail"] = $scoredetail;
     return $lgres;
  }

  // 著者とスコアのみを抽出
  private function fetchScore($preged_array){
    $arrcount = $skipcount = 0;
    $skipnum = 2;
    for($i=0;$i<count($preged_array);$i++){
      // wikipediaリンク等をスキップ
      if($skipcount < $skipnum){
        $skipcount++;
      }else{
        $i++;
        $arrcount++;
        $skipcount=0;
        continue;
      }
      $res[$arrcount][] = $preged_array[$i];
    }
    if(isset($res)){
      return $res;
    }
  }
}
