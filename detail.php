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
        <nav class="bg-white py-2 md:py-4">
			<div class="container px-4 mx-auto md:flex md:items-center">

			<div class="flex justify-between items-center">
				<a href="#" class="font-bold text-xl text-indigo-600">保育所検索システム</a>
				<button class="border border-solid border-gray-600 px-3 py-1 rounded text-gray-600 opacity-50 hover:opacity-75 md:hidden" id="navbar-toggle">
				<i class="fas fa-bars"></i>
				</button>
			</div>

			<div class="hidden md:flex flex-col md:flex-row md:ml-auto mt-3 md:mt-0" id="navbar-collapse">
				<a href="hoiku.php" class="p-2 lg:px-4 md:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300">ホーム</a>
				<a href="#" class="p-2 lg:px-4 md:mx-2 text-indigo-600 text-center border border-solid border-indigo-600 rounded hover:bg-indigo-600 hover:text-white transition-colors duration-300 mt-1 md:mt-0 md:ml-1">比較</a>
			</div>
			</div>
		</nav>
        <h1 id="h1" class="text-2xl font-bold">
            <?php 
                function mbStrPad($input, $pad_length) {
                    while(mb_strlen($input) < $pad_length) {
                        $input .= '　';
                    }
                    return $input;
                }



                $queries = array();
                parse_str($_SERVER['QUERY_STRING'], $queries);

                $pdo = new PDO('mysql:host=localhost;dbname=kindergarden','root','');
                $sql = 'SELECT * FROM facility A inner JOIN availability B ON A.id = ? and B.id = A.id;                ;';

                $stmt = $pdo->prepare($sql);
                $stmt->bindvalue(1,$queries["id"],PDO::PARAM_INT);

                $stmt->execute();

                $arrHoiku = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    array_push($arrHoiku, $row);
                }
                //print_r($arrHoiku);
                echo $arrHoiku[0]["facility_name"];
            ?>
            
            <button onclick="jump()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">検索</button>
        </h1>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">施設情報</legend>
                    <?php
                        echo mbStrPad("住所:",1).$arrHoiku[0]["address_prefecture"],$arrHoiku[0]["address_district"],$arrHoiku[0]["address_street"];
                        echo "</br>".mbStrPad("電話番号:",10).$arrHoiku[0]["phone"];
                    ?>
                    
                </fieldset>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">営業日時</legend>
                    <?php
                        echo mbStrPad("営業日",10).$arrHoiku[0]["business_day"];
                        echo "</br>".mbStrPad("平日営業時間",10).$arrHoiku[0]["weekday_opening_time"]."~".$arrHoiku[0]["weekday_closing_time"];
                        echo "</br>".mbStrPad("週末営業時間",10).$arrHoiku[0]["weekend_opening_time"]."~".$arrHoiku[0]["weekend_closing_time"];
                        echo "</br>".mbStrPad("休日営業時間",10);
                        if($arrHoiku[0]["holiday_opening_time"] == $arrHoiku[0]["holiday_closing_time"]){
                            echo "営業していません";
                        }else{
                            echo $arrHoiku[0]["holiday_opening_time"]."~".$arrHoiku[0]["holiday_closing_time"];
                        }
                    ?>
                </fieldset>
            </div>
            <div>
                <div id="mapid"></div>
                <script>
                //自動検索
                function jump(){
                    window.open("https://www.google.com/search?q="+ "<?php echo $arrHoiku[0]['facility_name']; ?>","_blank");
                }
                //OSM,leaflet
                var markers = [];
                document.getElementById('mapid').setAttribute("style","height:300px"); 
                var map = L.map('mapid',{
                    center:["<?php echo $arrHoiku[0]["latitude"] ?>","<?php echo $arrHoiku[0]["longitude"] ?>"],
                    zoom: 17,
                });
                var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
                    attribution: '©<a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                });
                tileLayer.addTo(map);
                var marker = L.marker(["<?php echo $arrHoiku[0]["latitude"] ?>","<?php echo $arrHoiku[0]["longitude"] ?>"]).addTo(map);
            </script>
            </div>
            <div>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">従業員情報</legend>
                    <?php
                        echo "各歳の従業員数</br>";
                        for($i = 0;$i <= 5;$i++){
                            echo "</br>".mbStrPad($i."歳",10).$arrHoiku[0]["quota_".$i]."人";
                        }
                        echo "</br>".mbStrPad("合計従業員数",10).$arrHoiku[0]["quota_total"]."人";
                    ?>
                    
                </fieldset>
            </div>
            <div>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">入所空き状況</legend>
                    <?php
                        for($i = 0;$i <= 5;$i++){
                            echo "</br>".mbStrPad($i."歳",10).$arrHoiku[0]["age_".$i]."人";
                        }
                        echo "</br>".mbStrPad("合計空き人数",10).$arrHoiku[0]["total"]."人";
                    ?>
                    
                </fieldset>
            </div>
            
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <fieldset class="border border-solid border-gray-300 p-3">
                    <legend class="text-sm">その他</legend>
                    <?php
                        echo mbStrPad("方針",10).$arrHoiku[0]["operation_method"];
                        echo "</br>".mbStrPad("保育内容",10).$arrHoiku[0]["hoiku_naiyou"];
                        echo "</br>".mbStrPad("給食",10).$arrHoiku[0]["kyuushoku"];
                        echo "</br>";
                        //給食の有無
                        if($arrHoiku[0]["kyuushoku_day"] == null){
                        }else{
                            echo mbStrPad("給食の曜日",10).$arrHoiku[0]["kyuushoku_day"];
                        }
                        
                    ?>
                    </br>

                    
                    
                </fieldset>
            </div>
        </div>
        <script>

        </script>
	</body>
</html>
