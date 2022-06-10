## プロジェクトの説明

[![Product Name Screen Shot][product-screenshot]](https://example.com)

[横浜市オープンデータポータル](https://data.city.yokohama.lg.jp/)に掲載されている保育園と保育園の入所状況データを利用し、保育園を検索するシステムを開発しています。グーグルマップで検索すればいいのにどうしてこんなシステムを作成するんですかと思う人いるかもしれませんが、入所状況など様々なグーグルマップにはないデータがありますので特別な保育園検索システムを作成することにしました。

### 活用した技術

* [Leaflet.js](https://leafletjs.com/)
* [tailwindcss](https://tailwindcss.com/)
* [PHP](https://www.php.net/)
* [MySQL](https://www.mysql.com/)
* [JQuery](https://jquery.com)


### 導入手順

導入する手順は以下の通りです。

1. リポジトリをクローンする
   ```sh
   git clone https://github.com/Saruultugss/hoiku.git
   ```

2. データベース作成

    `data-import/facility_database.sql`ファイルをインポートし、データベースを作成します。
    データベース名は(`kindergarden`)と作成されます。


3. データ挿入

    横浜市にある保育園のデータや入所状況のデータはそれぞれ`data-import/kindergarden_data.csv`,`data-import/yokohama-kanou.csv`
    ファイルに記載されています。尚、保育園の経度と緯度のデータは`data-import/kindergarden_location.csv`ファイルにあります。

    データを挿入するパイソンスクリプトを作成しましたので、スクリプトを実行することでデータが挿入されます。
    まずは`data-import`フォルダーへ移動します。


   ```sh
   cd data-import
   ```

   ```sh
   python insert_corporate.py
   python insert_kindergarden.py
   python insert_availability.py
   python insert_facility_location.py
   ```

4. NPMパッケージをインストールする
    ```sh
    npm install
    ```

5. Tailwindcssを利用しているのでパースする
    ```sh
    npx tailwindcss -i ./src/input.css -o ./dist/output.css --watch    
    ```

(`http://localhost/hoiku/hoiku.php`)にアクセスします。