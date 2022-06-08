# csvモジュールを使ってCSVファイルから1行ずつ読み込む
import csv
from itertools import islice

import mysql.connector

filename = 'yokohama-kanou.csv'

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
    next(csvreader)
    next(csvreader)

    for row in csvreader:
        mycursor = mydb.cursor()

        #法人等のIDを取得する
        sql = "SELECT id FROM facility WHERE facility_id = %s"
        val = (row[3], ) 
        mycursor.execute(sql, val)
        myresult = mycursor.fetchall()

        if len(myresult) > 0:

          #区域,施設名,施設番号,0才,1才,2才,3才,4才,5才,合計
          sql = "INSERT INTO availability (kindergarden_id, district,facility_name,facility_id,age_0,age_1,age_2,age_3,age_4,age_5,total) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
          val = (myresult[0][0], row[0],row[2],row[3],row[4],row[5],row[6],row[7],row[8],row[9],row[10])

          mycursor.execute(sql, val)
          mydb.commit()

        
        