<?php
//送信メッセージ
$mail_message = <<< EOM
{$offeror} 様
アイデンタルクリニック 事務局です
このたびは当院ウェブサイトよりカウンセリングの申込みをいただきありがとうございます。
以下のご希望で承りましたので、カウンセリングの日程についてのご相談をするため、当院スタッフより電話番号【03-5289-8484】もしくは【03-5289-8562】から折り返しのお電話をいたします。

++ 申込み内容 ++
○カウンセリング希望地: {$councelingPlace}
○第一希望日時: {$requestDate1}
○第二希望日時: {$requestDate2}
○第三希望日時: {$requestDate3}

○相談内容:
{$inquiry}
○過去に無料相談メールを利用:{$mailUsed}

++ {$offeror} 様の情報 ++
お名前フリガナ: {$offeror_furigana}
電話番号: {$_REQUEST["TEL_NO"]}
メールアドレス: {$_REQUEST["EMAIL_ADDRESS"]}

++ 以下はご入力いただいた場合のみ内容が表示されます ++
年齢: {$_REQUEST["OFFEROR_AGE"]}
郵便番号: {$_REQUEST["ZIP_CODE"]}
おすまい: {$address}

++ カウンセリング申込みの注意事項 ++
1.当メールは申込者様のカウンセリングご希望日を伺った内容の確認メールとなります。
ご予約はこちらから折り返しお電話をかけてさせていただき確認をさせていただいて初めて完了となります。
※【03-5289-8484】もしくは【03-5289-8562】の番号より、お電話いたします。
送信いただくだけでは予約は完了しておりませんのでその点ご理解いただき得ますようよろしくお願いたします。

2.各院の診療日時は以下の通りです。
○神田院
月・火・金・土 
10:00〜19:30
(水曜・木曜・日曜・祝日：休診) 

○新宿院
月・火・水・金・土・日
10:00〜19:00
（木曜・祝日：休診）

○横浜院
火・水・金・土・日
10:00〜19:00
（月曜・木曜・祝日：休診）


++ カウンセリング受診にあたっての注意事項 ++ 
1.当院での診療は保険適用外となります、ご了承下さい。 
2.カウンセリングの際にCT撮影していただきます。 
撮影費用は無料ですが、CTデータをコピーする場合は、別途費用がかかりますのでご了承ください。 
3.当院は完全予約制という形を取らさせて頂いております。 
ご予約頂いた後、スケジュール変更・キャンセルの場合は必ずお電話頂けるようよろしくお願いいたします。 

++ 情報の取り扱いと保護に関する当院の方針はこちらをご覧ください ++
http://www.identalclinic.jp/privacy.html

++ 本メールは送信専用アドレスより配信されています ++
このメールにご返信いただきましてもご対応致しかねますので、あらかじめご了承ください。

────────────────────────────────────
医療法人社団　皆星会　アイデンタルクリニック
〒101-0047 東京都千代田区内神田3-21-6山喜ビル2階
TEL:0120-848-479（月曜〜日曜 9:30-19:00）
EOM;
?>