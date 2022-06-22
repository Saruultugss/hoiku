<html lang="jp">
	<head>
		<title>保育所</title>

		<link href="./dist/output.css" rel="stylesheet">

		<link rel="stylesheet" href="./leaflet/leaflet.css">
		<script src="./leaflet/leaflet.js"></script>

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
				<a href="#" onclick="jumpCompare(); return false;" class="p-2 lg:px-4 md:mx-2 text-indigo-600 text-center border border-solid border-indigo-600 rounded hover:bg-indigo-600 hover:text-white transition-colors duration-300 mt-1 md:mt-0 md:ml-1">比較<i id="compareCount"></i></a>
			</div>
			</div>
		</nav>
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

							<label class="block">
								<span class="text-gray-700">区名</span>
								<select id="districtSelect" class="
									block
									w-full
									mt-1
									rounded-md
									bg-gray-100
									border-transparent
									focus:border-gray-500 focus:bg-white focus:ring-0
								">
									<option value="">選択</option>
								</select>
							</label>

							<div class="block">
								<div class="mt-2">
								<div>
									<label class="inline-flex items-center">
									<input type="checkbox" id="available" class="
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
								<input type="text" id="hoikuName" class="
									mt-1
									block
									w-full
									rounded-md
									bg-gray-100
									border-transparent
									focus:border-gray-500 focus:bg-white focus:ring-0
								" placeholder="">
							</label>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	<script>
		let toggleBtn = document.querySelector("#navbar-toggle");
		let collapse = document.querySelector("#navbar-collapse");

		toggleBtn.onclick = () => {
			collapse.classList.toggle("hidden");
			collapse.classList.toggle("flex");
		};


		serialize = function(obj) {
			var str = [];
			for (var p in obj)
				if (obj.hasOwnProperty(p)) {
				str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
				}
			return str.join("&");
		}


		const getHoikuList = async (params) => {
			const response = await fetch('http://localhost/hoiku/index.php/hoiku/list?' + serialize(params));
			const hoikuList = await response.json(); //extract JSON from the http response
			return hoikuList;
		}

		const getDistrictList = async () => {
			const response = await fetch('http://localhost/hoiku/index.php/hoiku/district');
			const districtList = await response.json(); //extract JSON from the http response
			return districtList;
		}

		const postCompareId = async (params) => {
			const response = await fetch('http://localhost/hoiku/index.php/hoiku/compareadd?' + serialize(params));
			return response;
		}

		const getCompareId = async () => {
			const response = await fetch('http://localhost/hoiku/index.php/hoiku/compareget');
			const compareId = await response.json();
			return compareId;
		}

		var markers = [];
		//set map container height
		var mapHeight = screen.height - 250;
		document.getElementById('mapid').setAttribute("style","height:" + mapHeight +"px");

		var map = L.map('mapid',{
			center:[35.5423607,139.6395105],
			zoom: 17,
		});
		var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
			attribution: '©<a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
		});
		tileLayer.addTo(map);
		var pinPoint = null;
		var pinPointCircle = null;

		var compareIds = null;
		
		const removeMarkers = () => {
			for(var i = 0; i < markers.length; i++) {
				map.removeLayer(markers[i]);
			}
			markers = [];
		}

		//get filter districts from server
		getDistrictList().then((districtList) => {
			var select = document.getElementById('districtSelect');
			for(var i = 0; i < districtList.length; i++) {
				var opt = document.createElement('option');
				opt.value = districtList[i].address_district;
				opt.innerHTML = districtList[i].address_district.replace('横浜市', '');
				select.appendChild(opt);
			}
			document.getElementById('districtSelect').value = '横浜市西区';
			params = collectParams();
			removeMarkers();
			fetchHoikuList(params);
		})
		// get compare ids from sessions
		getCompareId().then((compareId) => {
			compareIds = compareId;
			if(compareIds.length != 0) {
				document.getElementById("compareCount").innerHTML = "(" + compareIds.length + ")";
			} else {
				document.getElementById("compareCount").innerHTML = "";
			}
		});

		const addCompare = (params) => {
			postCompareId({"compareId": params}).then(() => {
				getCompareId().then((compareId) => {
					compareIds = compareId;
					if(compareIds.length != 0) {
						document.getElementById("compareCount").innerHTML = "(" + compareIds.length + ")";
					} else {
						document.getElementById("compareCount").innerHTML = "";
					}
				});
			});
		}

		const jumpCompare = () => {
			window.open(
				'compare.php?' + serialize({"ids" : compareIds}),
				'_blank' // <- This is what makes it open in a new window.
			);
		} 

		const fetchHoikuList = (params) => { 
				getHoikuList(params).then((hoikuList) => {
				var lat = 0, long = 0;
				for(var i = 0; i < hoikuList.length; i++) {
					lat += parseFloat(hoikuList[i]['latitude']);
					long += parseFloat(hoikuList[i]['longitude']);
					var marker = null;
					//change marker icon depends on availability
					if(hoikuList[i]['total'] > 0) {
					marker = L.marker(
							[hoikuList[i]['latitude'],hoikuList[i]['longitude']],
							{
								icon: L.icon({
									iconUrl: 'leaflet/images/marker-icon-2x-green.png',
									iconSize:    [25, 41],
									iconAnchor:  [12, 41],
									popupAnchor: [1, -34],
									tooltipAnchor: [16, -28],
									shadowSize:  [41, 41]
								})
							}
						);
					} else {
						marker = L.marker(
							[hoikuList[i]['latitude'],hoikuList[i]['longitude']]
						);
					}

					markers.push(marker);
					markers[i].addTo(map);
					markers[i].on('click', function(e){
						var i = 0;
						for(i; i < markers.length; i++) {
							if(markers[i] == e.sourceTarget)
								break;
						}
						popup
						.setLatLng(e.latlng)
						.setContent(
							"<p>"+ hoikuList[i]["facility_name"] + "</p>" 
							+ "<p>電話番号:" + hoikuList[i]["phone"] + "</p>" 
							+ "<p>入所可能人数: " + hoikuList[i]["total"] +"</p>"
							+ "<a href='detail.php?id=" + encodeURIComponent(hoikuList[i]["id"]) + "' target='_blank'><p>詳細</p></a>"
							+ "<a href='#' onclick='addCompare(" + hoikuList[i]["id"] + "); return false;'><p>比較バスケに追加</p></a>")
						.openOn(map);

					});
				}
				map.setView([lat/hoikuList.length,long/hoikuList.length], 13); 
			});
		}
		//fetchHoikuList({"address_district":"横浜市西区"});
		var popup = L.popup();
		function onMarker2Click(e) {
			popup
				.setLatLng(e.latlng)
				.setContent("<p>"+ facilityName + "</p><p>clickで表示されます。</p>" + e.latlng.toString())
				.openOn(map);
		}
		const collectParams = () => {
			var params = {};
			var district = document.getElementById('districtSelect').value;
			if(district && district !== '') {
				params["address_district"] = district; 
			}

			var available = document.getElementById('available').checked;
			if(available) 
				params["available"] = available;

			var name = document.getElementById('hoikuName').value;
			if(name) {
				params["facility_name"] = name;
			}
			if(pinPoint) {
				params = { ...pinPoint.getLatLng(), ...params};
			}

			return params;
		}

		//district filter listener
		document.getElementById('districtSelect').addEventListener('change', function() {
			if(pinPoint) {
				map.removeLayer(pinPoint);
				map.removeLayer(pinPointCircle);
			}
			pinPoint = null;
			pinPointCircle = null;
			params = collectParams();
			removeMarkers();
			fetchHoikuList(params);
		});
		//availability filter listener
		document.getElementById('available').addEventListener('change', function() {
			params = collectParams();
			removeMarkers();
			fetchHoikuList(params);
		});
		//name filter listener
		document.getElementById('hoikuName').addEventListener('focusout', function() {
			params = collectParams();
			removeMarkers();
			fetchHoikuList(params);
		});

		const pinPointData = (latlng) => {
			document.getElementById('districtSelect').value = "";
			document.getElementById('hoikuName').value = "";
			params = collectParams();
			removeMarkers();
			fetchHoikuList(params);
		}
		
		function onMapClick(e) {
			if(pinPoint){
				pinPoint.setLatLng(e.latlng);
			} else {
				pinPoint = new L.marker(e.latlng, {
					draggable:'true',
					icon: L.icon({
						iconUrl: 'leaflet/images/marker-icon-man.png',
						iconSize:    [25, 41],
						iconAnchor:  [12, 41],
						popupAnchor: [1, -34],
						tooltipAnchor: [16, -28],
						shadowSize:  [41, 41]
					})
				});
				pinPoint.on('dragend', function(event){
					var marker = event.target;
					var position = marker.getLatLng();
					marker.setLatLng(new L.LatLng(position.lat, position.lng),{draggable:'true'});
					map.panTo(new L.LatLng(position.lat, position.lng))
					pinPointCircle.setLatLng(position);
					pinPointData(position);
				});
				map.addLayer(pinPoint);
			}
				
			if(pinPointCircle) {
				pinPointCircle.setLatLng(e.latlng);
			} else {
				pinPointCircle = L.circle(e.latlng, {
					color: "red",
					fillColor: "#f03",
					fillOpacity: 0.1,
					radius: 2400.0
				}).addTo(map);
			}
			pinPointData();
		};

		    

		map.on('click', onMapClick);
		
	</script>


	</body>
</html>


