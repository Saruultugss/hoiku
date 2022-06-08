# csvモジュールを使ってCSVファイルから1行ずつ読み込む
import csv
from itertools import islice

import mysql.connector

filename = 'kindergarden_location.csv'

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

        #区域,施設名,施設番号,0才,1才,2才,3才,4才,5才,合計
        sql = "UPDATE facility SET longitude = %s, latitude = %s WHERE facility_id = %s"
        val = (row[3],row[2],row[0])

        mycursor.execute(sql, val)
        mydb.commit()

        
        