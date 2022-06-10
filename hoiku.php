<html lang="jp">
	<head>
		<title>保育所</title>

		<link href="./dist/output.css" rel="stylesheet">

		<link rel="stylesheet" href="./leaflet/leaflet.css">
		<script src="./leaflet/leaflet.js"></script>

	</head>
	<body>
		<div class="container">
			<div class="grid grid-cols-3 gap-4">
				<div class="col-span-2">
					<div id="mapid"></div>
					</div>
				<div>
				<div class="py-12">
					<h2 class="text-2xl font-bold">保育所検索</h2>
					<div class="mt-8 max-w-md">
						<div class="grid grid-cols-1 gap-6">
							<div class="block">
								<div class="mt-2">
								<div>
									<label class="inline-flex items-center">
									<input type="checkbox" class="
										rounded
										bg-gray-200
										border-transparent
										focus:border-transparent focus:bg-gray-200
										text-gray-700
										focus:ring-1 focus:ring-offset-2 focus:ring-gray-500
										">
									<span class="ml-2">認定保育所</span>
									</label>
								</div>
								</div>
							</div>

							<div class="block">
								<div class="mt-2">
								<div>
									<label class="inline-flex items-center">
									<input type="checkbox" class="
										rounded
										bg-gray-200
										border-transparent
										focus:border-transparent focus:bg-gray-200
										text-gray-700
										focus:ring-1 focus:ring-offset-2 focus:ring-gray-500
										">
									<span class="ml-2">入所可能</span>
									</label>
								</div>
								</div>
							</div>

							<label class="block">
								<span class="text-gray-700">保育所名</span>
								<input type="text" class="
									mt-1
									block
									w-full
									rounded-md
									bg-gray-100
									border-transparent
									focus:border-gray-500 focus:bg-white focus:ring-0
								" placeholder="">
							</label>
							
							<label class="block">
								<span class="text-gray-700">区名</span>
								<select class="
									block
									w-full
									mt-1
									rounded-md
									bg-gray-100
									border-transparent
									focus:border-gray-500 focus:bg-white focus:ring-0
								">
								<option>西区</option>
								<option>中区</option>
								<option>鶴見区</option>
								<option>Other</option>
								</select>
							</label>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	<script>

		const getHoikuList = async () => {
			const response = await fetch('http://localhost/hoiku/index.php/hoiku/list');
			const hoikuList = await response.json(); //extract JSON from the http response
			return hoikuList;
		}

		var markers = [];
		document.getElementById('mapid').setAttribute("style","height:" + screen.height +"px"); 
		var map = L.map('mapid',{
			center:[35.5423607,139.6395105],
			zoom: 17,
		});
		var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
			attribution: '©<a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
		});
		tileLayer.addTo(map);


		getHoikuList().then((hoikuList) => {
			console.log(hoikuList)
			for(var i = 0; i < hoikuList.length; i++) {
				markers.push(L.marker([hoikuList[i]['latitude'],hoikuList[i]['longitude']]));
				markers[i].addTo(map);
				markers[i].on('click', function(e){

					var i = 0;
					for(i; i < markers.length; i++) {
						if(markers[i] == e.sourceTarget)
							break;
					}

					popup
					.setLatLng(e.latlng)
					.setContent("<p>"+ hoikuList[i]["facility_name"] + "</p><p>電話番号:" + hoikuList[i]["phone"] + "</p>" + "<p> ０歳入所可能人数: " + hoikuList[i]["age_0"] +"</p>")
					.openOn(map);		
				});
			} 

		});
		var popup = L.popup();
		function onMarker2Click(e) {
			popup
				.setLatLng(e.latlng)
				.setContent("<p>"+ facilityName + "</p><p>clickで表示されます。</p>" + e.latlng.toString())
				.openOn(map);
		}
		
		// //markers.push(L.marker(['.$row['latitude'].','.$row['longitude'].']));
		
		// for(var i = 0; i < markers.length; i++) {
		// 	markers[i].addTo(map);
		// }

		
	</script>


	</body>
</html>


