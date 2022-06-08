# csvモジュールを使ってCSVファイルから1行ずつ読み込む
import csv
from itertools import islice

import mysql.connector

filename = 'kindergarden_data.csv'

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="kindergarden"
)


with open(filename, encoding='utf8', newline='') as f:
    csvreader = csv.reader(f)
    print(type(csvreader))

    next(csvreader)

    for row in csvreader:
        mycursor = mydb.cursor()

        #法人等のIDを取得する
        sql = "SELECT id FROM corporate WHERE business_id = %s"
        val = (row[10], ) 
        mycursor.execute(sql, val)
        myresult = mycursor.fetchall()

        if len(myresult) > 0:
          sql = "INSERT INTO facility (corporate_id, facility_type, facility_name, facility_name_hiragana, facility_id, postal_code, address_prefecture, address_district, address_street, address_building, licensed_date, opening_date, phone, hoikushi_fulltime, hoikushi_parttime, hoikushi_working_hour, hoikushi_avg_exp_fulltime, hoikushi_avg_exp_parttime, assistant_fulltime, assistant_parttime, assistant_working_hour, assistant_avg_exp_fulltime, assistant_avg_exp_parttime, kyouyu_fulltime, kyouyu_parttime, kyouyu_working_hour, kyouyu_avg_exp_fulltime, kyouyu_avg_exp_parttime, kateiteki_fulltime, kateiteki_parttime, kateiteki_working_hour, kateiteki_avg_exp_fulltime, kateiteki_avg_exp_parttime, total_fulltime, total_parttime, child_for_each_teacher, certification, certification_other, business_day, weekday_opening_time, weekday_closing_time, weekend_opening_time, weekend_closing_time, holiday_opening_time, holiday_closing_time, quota_0, quota_1, quota_2, quota_3, quota_4, quota_5, quota_total, operation_method, hoiku_naiyou, kyuushoku, kyuushoku_day, disabled_child_receiving, temporary_caring, sick_child_receiving, tetuduki, tetuduki_other, claim_window, compensation, tokushoku, jippi_choushuu, jippi_riyuu, jippi_amount) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
          #「myresult[0][0]」は法人等のIDです。
          val = (myresult[0][0], row[12], row[14], row[13], row[15], row[16], row[17], row[18], row[19], row[20], row[23], row[24], row[21], row[234], row[235], row[236], row[237], row[238], row[239], row[240], row[241], row[242], row[243], row[244], row[245], row[246], row[247], row[248], row[249], row[250], row[251], row[252], row[253], row[254], row[255], row[256], row[257], row[258], row[259], row[260], row[261], row[262], row[263], row[264], row[265], row[280], row[283], row[286], row[289], row[292], row[295], row[298], row[302], row[303], row[304], row[305], row[306], row[307], row[308], row[309], row[311], row[312], row[313], row[314], row[315], row[316], row[317])

          mycursor.execute(sql, val)
          mydb.commit()

        
        