<html lang="jp">
	<head>
		<title>保育所-詳細</title>

		<link href="./dist/output.css" rel="stylesheet">
        <link rel="stylesheet" href="./leaflet/leaflet.css">
		<script src="./leaflet/leaflet.js"></script>

        <style>
            #mapid{
                width:500px;
                height:250px;
            }
        </style>
	</head>
	<body>
        
 
            <?php 
                function mbStrPad($input, $pad_length) {
                    while(mb_strlen($input) < $pad_length) {
                        $input .= '　';
                    }
                    return $input;
                }



                $queries = array();
                parse_str($_SERVER['QUERY_STRING'], $queries);
                $ids = explode(",", $queries["ids"]);  

                $arr = [];

                $inClause = substr(str_repeat(',?', count($ids)), 1);
                // foreach($ids as $index => $id){
                    $pdo = new PDO('mysql:host=localhost;dbname=kindergarden','root','');
                    $sql = sprintf('SELECT * FROM facility A LEFT JOIN availability B ON A.id = B.kindergarden_id  WHERE A.id in (%s)', $inClause);

                    $stmt = $pdo->prepare($sql);
                    // $stmt->bindParam("ids", $ids);
                    
                    //print_r($ids);
                    $stmt->execute($ids);
                    

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        array_push($arr, $row);
                    }
                // }
                
                //echo $arr[""]["facility_name"];
            ?>
            <?php
            foreach($arr as $arrHoiku){
                echo 
            '
            <h1 id="h1" class="text-2xl font-bold">'
                .$arrHoiku["facility_name"].
            '</h1>
            <button onclick="jump()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">検索</button>
        </h1>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">施設情報</legend>
                    ';
                    
                    
                        echo mbStrPad("住所:",1).$arrHoiku["address_prefecture"].$arrHoiku["address_district"].$arrHoiku["address_street"];
                        echo "</br>".mbStrPad("電話番号:",10).$arrHoiku["phone"];
                    
                    
                echo '</fieldset>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">営業日時</legend>
                    '
                    
                        .mbStrPad("営業日",10).$arrHoiku["business_day"].
                        "</br>".mbStrPad("平日営業時間",10).$arrHoiku["weekday_opening_time"]."~".$arrHoiku["weekday_closing_time"].
                        "</br>".mbStrPad("週末営業時間",10).$arrHoiku["weekend_opening_time"]."~".$arrHoiku["weekend_closing_time"].
                        "</br>".mbStrPad("休日営業時間",10);
                        if($arrHoiku["holiday_opening_time"] == $arrHoiku["holiday_closing_time"]){
                            echo "営業していません";
                        }else{
                            echo $arrHoiku["holiday_opening_time"]."~".$arrHoiku["holiday_closing_time"];
                        }
                    
                echo '</fieldset>
            </div>
            <div>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">従業員情報</legend>
                    '
                        ."各歳の従業員数</br>";
                        for($i = 0;$i <= 5;$i++){
                            echo "</br>".mbStrPad($i."歳",10).$arrHoiku["quota_".$i]."人";
                        }
                        echo "</br>".mbStrPad("合計従業員数",10).$arrHoiku["quota_total"]."人";
                    
                    
                echo '</fieldset>
            </div>
            <div>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">入所空き状況</legend>';
                    
                    for($i = 0;$i <= 5;$i++){
                        echo "</br>".mbStrPad($i."歳",10).$arrHoiku["age_".$i]."人";
                    }
                    echo "</br>".mbStrPad("合計空き人数",10).$arrHoiku["total"]."人";
            
                    
                echo '</fieldset>
            </div>
            
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">その他</legend>';
                    
                    echo mbStrPad("方針",10).$arrHoiku["operation_method"];
                    echo "</br>".mbStrPad("保育内容",10).$arrHoiku["hoiku_naiyou"];
                    echo "</br>".mbStrPad("給食",10).$arrHoiku["kyuushoku"];
                    echo "</br>";
                    //給食の有無
                    if($arrHoiku["kyuushoku_day"] == null){
                    }else{
                        echo mbStrPad("給食の曜日",10).$arrHoiku["kyuushoku_day"];
                    }
                      
                        
                    echo
                    '</br>

                    
                    
                </fieldset>
            </div>
        </div>';
        }
        ?>
        

        </script>
	</body>
</html>
